# WordPress 既存機能のカスタマイズ方法（ビジネスロジック）

WordPressで既存機能をカスタマイズする方法は主に4つです。

---

## 1. Filter Hook（最も使う）

既存の値や処理結果を**書き換える**。

```php
// WordPress が返す値を横取りして変更
add_filter('the_content', function (string $content): string {
    // 本文の末尾に追加
    return $content . '<p>お問い合わせはこちら</p>';
});

// メール送信先を変更
add_filter('wp_mail_from', function (string $email): string {
    return 'noreply@example.com';
});

// 投稿クエリを変更
add_filter('pre_get_posts', function (WP_Query $query): void {
    if ($query->is_main_query() && is_home()) {
        $query->set('posts_per_page', 5);
        $query->set('post_type', ['post', 'event']);
    }
});
```

---

## 2. Action Hook（処理を割り込ませる）

既存の処理の**前後に自分の処理を追加**する。

```php
// 投稿が公開されたときにSlack通知
add_action('publish_post', function (int $postId): void {
    $post = get_post($postId);
    (new SlackClient())->notify("記事公開: {$post->post_title}");
});

// ユーザー登録後にCRM登録
add_action('user_register', function (int $userId): void {
    $user = get_userdata($userId);
    (new HubspotService())->createContact($user->user_email);
});

// ログイン時に独自バリデーション
add_action('wp_login', function (string $login, WP_User $user): void {
    if (! (new MembershipService())->isActive($user->ID)) {
        wp_logout();
        wp_redirect('/membership-expired');
        exit;
    }
}, 10, 2);
```

---

## 3. Pluggable Functions（WordPress関数の完全置き換え）

`wp_mail()` など一部の関数はオーバーライドできる。

```php
// functions.phpやMU Pluginで定義
if (! function_exists('wp_mail')) {
    function wp_mail($to, $subject, $message, $headers = '', $attachments = [])
    {
        // SendGridなど独自実装に差し替え
        return (new SendGridMailer())->send($to, $subject, $message);
    }
}
```

⚠️ Pluggable関数は限られた数しかない。乱用しない。

---

## 4. クラスの拡張（WooCommerceなど）

プラグインがフィルターでクラスを差し替えられる設計なら有効。

```php
// WooCommerceの送料計算を独自クラスで置き換え
add_filter('woocommerce_shipping_methods', function (array $methods): array {
    $methods['my_shipping'] = MyCustomShipping::class;
    return $methods;
});

class MyCustomShipping extends WC_Shipping_Method
{
    public function calculate_shipping($package = []): void
    {
        // 独自ロジック
        $this->add_rate([
            'label' => '独自送料',
            'cost'  => $this->calculateCost($package),
        ]);
    }
}
```

---

## MU Pluginでの整理方法

```
web/app/mu-plugins/company-core/
├── company-core.php        # エントリポイント
└── src/
    ├── Hooks/
    │   └── RegisterHooks.php   # フック登録をまとめる
    ├── Services/
    │   ├── SlackService.php
    │   └── MembershipService.php
    └── Filters/
        └── MailFilter.php
```

```php
// RegisterHooks.php
class RegisterHooks
{
    public function register(): void
    {
        add_filter('wp_mail_from', [$this, 'setMailFrom']);
        add_action('publish_post', [$this, 'notifySlack']);
        add_action('user_register', [$this, 'syncToCrm']);
    }
}

// company-core.php
(new RegisterHooks())->register();
```

---

## どれを使うか判断基準

| やりたいこと | 方法 |
|---|---|
| 値を変えたい | `add_filter` |
| 処理を追加したい | `add_action` |
| 関数ごと差し替えたい | Pluggable（慎重に） |
| プラグインの挙動を変えたい | そのプラグインのフック |
| WordPress本体を直接編集 | **絶対NG** |

基本は **Filter → Action → その他** の順で検討するのが正解です。

---

## テーマのアップデート方法

Bedrockでは、テーマはComposerで管理するため**管理画面からのアップデートは行わない**。

### 手順

```bash
# 1. 現在のバージョン確認
docker compose exec wordpress composer show wpackagist-theme/twentytwentyfive

# 2. アップデート可能か確認（実行はしない）
docker compose exec wordpress composer outdated wpackagist-theme/twentytwentyfive

# 3. アップデート実行
docker compose exec wordpress composer update wpackagist-theme/twentytwentyfive

# 4. 全テーマをまとめてアップデート
docker compose exec wordpress composer update --with-dependencies
```

### composer.json のバージョン指定

```json
// ^ は「メジャーバージョン内の最新」
"wpackagist-theme/twentytwentyfive": "^1.5"

// 固定したい場合（本番で慎重に運用するケース）
"wpackagist-theme/twentytwentyfive": "1.5.0"
```

### カスタムテーマのアップデート

`web/app/themes/my-theme/` に直接配置したカスタムテーマはComposer管理外。
Git でコード変更 → デプロイで反映する。

```bash
# カスタムテーマはGitで管理
git add web/app/themes/my-theme/
git commit -m "テーマ: ヘッダーデザイン変更"
git push
```

### アップデート後の確認

```bash
# WP-CLIでテーマ一覧とステータス確認
docker compose exec wordpress wp --allow-root \
  --path=/var/www/html/web/wp \
  theme list
```

⚠️ **管理画面の「テーマを更新」ボタンは使わない。**
`DISALLOW_FILE_MODS` が staging/production では `true` に設定されているため、
管理画面からのファイル変更はブロックされる。

---

## WordPress本体のアップデート方法

WordPressコアもComposerで管理するため、**管理画面の「今すぐ更新」は使わない**。

### 手順

```bash
# 1. 現在のバージョン確認
docker compose exec wordpress wp --allow-root \
  --path=/var/www/html/web/wp \
  core version

# 2. アップデート可能か確認
docker compose exec wordpress composer outdated roots/wordpress

# 3. composer.json のバージョン指定を変更
#    例: ^6.7 → ^7.0
vi composer.json

# 4. アップデート実行
docker compose exec wordpress composer update roots/wordpress

# 5. データベースのマイグレーション実行（必須）
docker compose exec wordpress wp --allow-root \
  --path=/var/www/html/web/wp \
  core update-db
```

### composer.json のバージョン指定例

```json
// マイナーアップデートを自動で受け取る（推奨）
"roots/wordpress": "^6.7"

// メジャーバージョンを上げる場合は明示的に変更
"roots/wordpress": "^7.0"
```

### アップデート前の確認フロー

```
1. composer.json のバージョン指定を変更
      ↓
2. ローカル環境でアップデート実行
      ↓
3. サイト動作確認（管理画面・フロント・プラグイン）
      ↓
4. composer.lock をコミット
      ↓
5. ステージング環境で確認
      ↓
6. 本番デプロイ
```

### アップデート後の確認コマンド

```bash
# WordPressコアのバージョン確認
docker compose exec wordpress wp --allow-root \
  --path=/var/www/html/web/wp \
  core version

# DBマイグレーションが必要か確認
docker compose exec wordpress wp --allow-root \
  --path=/var/www/html/web/wp \
  core update-db --dry-run

# プラグインの互換性確認
docker compose exec wordpress wp --allow-root \
  --path=/var/www/html/web/wp \
  plugin list
```

### composer.lock の扱い

```bash
# アップデート後は必ずcommit
git add composer.json composer.lock
git commit -m "WordPress 6.9.4 → 7.0.0 アップデート"
```

`composer.lock` をコミットしておくことで、チーム全員・本番環境が
同じバージョンで動作することが保証される。

⚠️ **`wp core update`（WP-CLIのコアアップデートコマンド）は使わない。**
Composerの管理外でファイルが書き換わり、`composer.lock` と実態が乖離する。

---

## ステージング・本番の構成

### 環境ごとのファイル構成

```
project/
├── docker-compose.yml          # 共通定義
├── docker-compose.staging.yml  # ステージング上書き
├── docker-compose.prod.yml     # 本番上書き
├── .env                        # ローカル用（git管理外）
├── .env.staging                # ステージング用（git管理外）
└── .env.prod                   # 本番用（git管理外）
```

### docker-compose.yml（共通）

```yaml
services:
  db:
    image: mysql:8.0
    volumes:
      - db_data:/var/lib/mysql

  wordpress:
    build: .
    depends_on:
      db:
        condition: service_healthy
    volumes:
      - uploads:/var/www/html/web/app/uploads

  phpmyadmin:
    image: phpmyadmin:latest

volumes:
  db_data:
  uploads:
```

### docker-compose.staging.yml

```yaml
services:
  wordpress:
    environment:
      WP_ENV: staging
      WP_HOME: https://staging.example.com
      WP_SITEURL: https://staging.example.com/wp
    restart: always

  nginx:
    image: nginx:alpine
    ports:
      - "443:443"
      - "80:80"
    volumes:
      - ./nginx/staging.conf:/etc/nginx/conf.d/default.conf
      - /etc/letsencrypt:/etc/letsencrypt:ro
    depends_on:
      - wordpress

  phpmyadmin:
    # ステージングのみ許可（本番では削除）
    ports:
      - "127.0.0.1:8081:80"
```

### docker-compose.prod.yml

```yaml
services:
  wordpress:
    environment:
      WP_ENV: production
      WP_HOME: https://example.com
      WP_SITEURL: https://example.com/wp
    restart: always
    # 本番はコードをボリュームマウントせずイメージに含める
    volumes:
      - uploads:/var/www/html/web/app/uploads

  nginx:
    image: nginx:alpine
    ports:
      - "443:443"
      - "80:80"
    volumes:
      - ./nginx/prod.conf:/etc/nginx/conf.d/default.conf
      - /etc/letsencrypt:/etc/letsencrypt:ro
    restart: always

  # 本番ではphpMyAdminを起動しない
```

### .env の環境別設定

```bash
# .env.staging
MYSQL_ROOT_PASSWORD=xxxxxx
DB_NAME=wordpress
DB_USER=wpuser
DB_PASSWORD=xxxxxx
DB_HOST=db

WP_ENV=staging
WP_HOME=https://staging.example.com
WP_SITEURL=https://staging.example.com/wp

AUTH_KEY='本番用のランダムキー'
# ...他のソルト
```

```bash
# .env.prod
WP_ENV=production
WP_HOME=https://example.com
WP_SITEURL=https://example.com/wp
# ...
```

### 環境別の起動コマンド

```bash
# ローカル
docker compose up -d

# ステージング
docker compose -f docker-compose.yml -f docker-compose.staging.yml \
  --env-file .env.staging up -d

# 本番
docker compose -f docker-compose.yml -f docker-compose.prod.yml \
  --env-file .env.prod up -d
```

---

### 本番用 Dockerfile

本番ではコードをイメージに含め、ホストへのボリュームマウントをしない。

```dockerfile
FROM php:8.3-apache AS base
# ... PHP拡張インストール（開発用Dockerfileと同様）

# ステージング・本番用
FROM base AS production

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# コードをイメージに含める
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

# アップロードディレクトリだけボリュームで外出し
VOLUME ["/var/www/html/web/app/uploads"]
```

```bash
# 本番イメージのビルドとプッシュ
docker build --target production -t myapp/wordpress:v1.2.0 .
docker push myapp/wordpress:v1.2.0
```

---

### Nginx 設定（本番）

```nginx
# nginx/prod.conf
server {
    listen 80;
    server_name example.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl;
    server_name example.com;

    ssl_certificate     /etc/letsencrypt/live/example.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/example.com/privkey.pem;

    root /var/www/html/web;
    index index.php;

    # アップロードファイルの直接配信
    location /app/uploads/ {
        try_files $uri =404;
    }

    # WordPressへのルーティング
    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        fastcgi_pass wordpress:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    # セキュリティ
    location ~ /\. {
        deny all;
    }
}
```

> Nginxを使う場合、WordPressのイメージは `php:8.3-fpm` ベースに変更が必要。

---

### デプロイフロー（GitHub Actions）

```yaml
# .github/workflows/deploy.yml
name: Deploy

on:
  push:
    branches:
      - main      # 本番
      - staging   # ステージング

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4

      - name: Build image
        run: |
          docker build --target production \
            -t myapp/wordpress:${{ github.sha }} .

      - name: Push image
        run: docker push myapp/wordpress:${{ github.sha }}

      - name: Deploy to server
        run: |
          ssh user@server "
            docker compose -f docker-compose.yml -f docker-compose.prod.yml \
              --env-file .env.prod \
              up -d --pull always

            docker compose exec wordpress wp --allow-root \
              --path=/var/www/html/web/wp \
              core update-db
          "
```

---

### 環境ごとの設定まとめ

| 設定 | ローカル | ステージング | 本番 |
|---|---|---|---|
| `WP_ENV` | development | staging | production |
| `WP_DEBUG` | true | false | false |
| `DISALLOW_FILE_MODS` | false | true | true |
| コードのマウント | ボリューム | イメージに含める | イメージに含める |
| phpMyAdmin | 公開 | localhost限定 | 起動しない |
| Nginx | なし | あり（SSL） | あり（SSL） |
| Redis | なし | あり（推奨） | あり |
