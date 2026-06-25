# デプロイ・CI/CD 構成

## ブランチ戦略

Gitリポジトリは1つ。ブランチで環境を分ける。

```
feature/xxx
    ↓ Pull Request
staging          → ステージング自動デプロイ
    ↓ Pull Request（動作確認後）
main             → 本番自動デプロイ
```

### ブランチの役割

| ブランチ | 環境 | 用途 |
|---|---|---|
| `main` | 本番 | リリース済みコード |
| `staging` | ステージング | 本番前の最終確認 |
| `feature/*` | ローカルのみ | 機能開発 |

---

## ファイル構成

```
project/
├── .github/
│   └── workflows/
│       └── deploy.yml          # CI/CD（1ファイルで両環境）
├── docker-compose.yml          # 共通
├── docker-compose.staging.yml  # ステージング上書き
├── docker-compose.prod.yml     # 本番上書き
├── nginx/
│   ├── staging.conf
│   └── prod.conf
├── .env.example
├── .env                        # ローカル用（git管理外）
├── .env.staging                # ステージング用（git管理外・サーバーに配置）
└── .env.prod                   # 本番用（git管理外・サーバーに配置）
```

---

## docker-compose 構成

### docker-compose.yml（共通）

```yaml
services:
  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
      MYSQL_DATABASE: ${DB_NAME}
      MYSQL_USER: ${DB_USER}
      MYSQL_PASSWORD: ${DB_PASSWORD}
    volumes:
      - db_data:/var/lib/mysql
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost"]
      interval: 10s
      timeout: 5s
      retries: 5

  wordpress:
    image: ${IMAGE_NAME:-wp-wordpress}:${IMAGE_TAG:-latest}
    depends_on:
      db:
        condition: service_healthy
    volumes:
      - uploads:/var/www/html/web/app/uploads

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
      - "80:80"
      - "443:443"
    volumes:
      - ./nginx/staging.conf:/etc/nginx/conf.d/default.conf
      - /etc/letsencrypt:/etc/letsencrypt:ro
    depends_on:
      - wordpress
    restart: always

  phpmyadmin:
    image: phpmyadmin:latest
    ports:
      - "127.0.0.1:8081:80"   # localhost限定
    environment:
      PMA_HOST: db
      PMA_USER: ${DB_USER}
      PMA_PASSWORD: ${DB_PASSWORD}
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

  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./nginx/prod.conf:/etc/nginx/conf.d/default.conf
      - /etc/letsencrypt:/etc/letsencrypt:ro
    depends_on:
      - wordpress
    restart: always

  # phpMyAdminは本番では起動しない
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

## 本番用 Dockerfile

本番ではコードをイメージに含め、ホストへのボリュームマウントをしない。

```dockerfile
FROM php:8.3-fpm AS base

RUN apt-get update && apt-get install -y \
        libpng-dev libjpeg-dev libwebp-dev \
        libzip-dev libicu-dev unzip git \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install \
        gd mysqli pdo pdo_mysql zip exif intl opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sO https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp

WORKDIR /var/www/html

# --- 本番ビルド ---
FROM base AS production

# 依存関係のみ先にインストール（キャッシュ活用）
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# コードをイメージに含める
COPY . .

RUN chmod -R o+rX /var/www/html

VOLUME ["/var/www/html/web/app/uploads"]
```

```bash
# 本番イメージのビルド
docker build --target production \
  -t ghcr.io/your-org/wordpress:${{ github.sha }} .
```

> ローカル開発用は既存の `Dockerfile`（Apache + マウント方式）をそのまま使う。

---

## Nginx 設定

### nginx/prod.conf

```nginx
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

    location /app/uploads/ {
        try_files $uri =404;
    }

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        fastcgi_pass wordpress:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\. {
        deny all;
    }
}
```

> `staging.conf` は `server_name` と証明書パスをステージングドメインに変更するだけ。

---

## GitHub Actions（1ファイルで両環境）

```yaml
# .github/workflows/deploy.yml
name: Deploy

on:
  push:
    branches:
      - main
      - staging

jobs:
  deploy:
    runs-on: ubuntu-latest

    steps:
      - uses: actions/checkout@v4

      - name: 環境の決定
        id: env
        run: |
          if [ "${{ github.ref_name }}" = "main" ]; then
            echo "target=production" >> $GITHUB_OUTPUT
            echo "compose_file=docker-compose.prod.yml" >> $GITHUB_OUTPUT
            echo "env_file=.env.prod" >> $GITHUB_OUTPUT
            echo "server=${{ secrets.PROD_SERVER }}" >> $GITHUB_OUTPUT
          else
            echo "target=staging" >> $GITHUB_OUTPUT
            echo "compose_file=docker-compose.staging.yml" >> $GITHUB_OUTPUT
            echo "env_file=.env.staging" >> $GITHUB_OUTPUT
            echo "server=${{ secrets.STAGING_SERVER }}" >> $GITHUB_OUTPUT
          fi

      - name: Docker イメージのビルド・プッシュ
        run: |
          echo "${{ secrets.GITHUB_TOKEN }}" | \
            docker login ghcr.io -u ${{ github.actor }} --password-stdin

          docker build --target production \
            -t ghcr.io/${{ github.repository }}:${{ github.sha }} .

          docker push ghcr.io/${{ github.repository }}:${{ github.sha }}

      - name: サーバーへデプロイ
        run: |
          ssh ${{ secrets.DEPLOY_USER }}@${{ steps.env.outputs.server }} << 'EOF'
            cd /var/www/project

            # イメージタグを更新
            export IMAGE_TAG=${{ github.sha }}

            # コンテナ更新
            docker compose -f docker-compose.yml \
              -f ${{ steps.env.outputs.compose_file }} \
              --env-file ${{ steps.env.outputs.env_file }} \
              up -d --pull always

            # DBマイグレーション
            docker compose exec wordpress \
              wp --allow-root \
              --path=/var/www/html/web/wp \
              core update-db

            # 古いイメージの削除
            docker image prune -f
          EOF
```

### GitHub Secrets の設定

| Secret名 | 内容 |
|---|---|
| `PROD_SERVER` | 本番サーバーのIPまたはホスト名 |
| `STAGING_SERVER` | ステージングサーバーのIPまたはホスト名 |
| `DEPLOY_USER` | SSHユーザー名 |
| `SSH_PRIVATE_KEY` | デプロイ用SSH秘密鍵 |

---

## 環境ごとの設定まとめ

| 設定 | ローカル | ステージング | 本番 |
|---|---|---|---|
| `WP_ENV` | development | staging | production |
| `WP_DEBUG` | true | false | false |
| `DISALLOW_FILE_MODS` | false | true | true |
| コードの配置 | ボリュームマウント | イメージに含める | イメージに含める |
| Webサーバー | Apache（内蔵） | Nginx | Nginx |
| phpMyAdmin | 公開 | localhost限定 | なし |
| SSL | なし | あり | あり |
| Redis | なし | 推奨 | あり |
