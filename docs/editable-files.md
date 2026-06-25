# ファイル編集可否一覧

## 凡例

| 記号 | 意味 |
|---|---|
| ✅ 編集可 | 自由に編集してよい |
| ⚠️ 原則触らない | 編集可能だが通常は不要 |
| ❌ 編集不可 | Composerが管理。編集しても更新時に上書きされる |

---

## ツリー構造

```
wp/
│
├── ✅ composer.json              # プラグイン・テーマ・WPコアの依存定義
├── ⚠️ composer.lock              # 自動生成。直接編集せずcomposerコマンドで更新
├── ✅ Dockerfile
├── ✅ apache.conf
├── ✅ entrypoint.sh
├── ✅ docker-compose.yml
├── ✅ docker-compose.staging.yml
├── ✅ docker-compose.prod.yml
├── ✅ .env                       # git管理外。各環境でサーバーに配置
├── ✅ .env.example
├── ✅ .gitignore
├── ✅ CLAUDE.md
│
├── config/                       # WordPress設定
│   ├── ✅ application.php        # wp-config.php相当。定数定義
│   └── environments/
│       ├── ✅ development.php    # デバッグ設定など
│       ├── ✅ staging.php
│       └── ✅ production.php
│
├── web/                          # ドキュメントルート
│   ├── ⚠️ index.php              # WordPressブートストラップ。通常触らない
│   ├── ⚠️ wp-config.php          # Bedrockの設定ローダー。通常触らない
│   ├── ✅ .htaccess              # リライトルール
│   │
│   ├── wp/                       # WordPressコア（Composerが管理）
│   │   ├── ❌ wp-admin/          # WP管理画面本体
│   │   ├── ❌ wp-includes/       # WPコアライブラリ
│   │   ├── ❌ wp-login.php
│   │   ├── ❌ wp-load.php
│   │   └── ❌ ...
│   │
│   └── app/                      # wp-content相当
│       │
│       ├── mu-plugins/           # 必須プラグイン
│       │   ├── ✅ bedrock-autoloader.php        # Composerのautoloaderを呼ぶ薄いラッパー
│       │   ├── ❌ bedrock-autoloader/           # Composerが管理
│       │   ├── ❌ bedrock-disallow-indexing/    # Composerが管理
│       │   └── ✅ company-core/                 # 自社開発MU Plugin（ここに書く）
│       │       ├── ✅ company-core.php
│       │       └── ✅ src/
│       │
│       ├── plugins/              # プラグイン
│       │   ├── ❌ contact-form-7/               # Composerが管理
│       │   └── ✅ my-custom-plugin/             # 自社開発プラグイン（ここに書く）
│       │
│       ├── themes/               # テーマ
│       │   ├── ❌ twentytwentyfive/             # Composerが管理
│       │   └── ✅ my-theme/                     # 自社開発テーマ（ここに書く）
│       │       ├── ✅ style.css
│       │       ├── ✅ functions.php
│       │       ├── ✅ templates/
│       │       └── ✅ assets/
│       │
│       └── uploads/              # メディアファイル（git管理外）
│           └── ⚠️ *             # WordPressが自動生成。直接編集しない
│
├── vendor/                       # Composerが管理するライブラリ
│   ├── ❌ roots/
│   ├── ❌ vlucas/
│   └── ❌ ...
│
└── docs/                         # プロジェクトドキュメント
    └── ✅ *.md
```

---

## まとめ

### 自分で書くコードはここだけ

```
web/app/mu-plugins/company-core/   # ビジネスロジック
web/app/plugins/my-custom-plugin/  # 独自プラグイン
web/app/themes/my-theme/           # テーマ
config/                            # 環境設定
```

### Composerが管理するので触らない

```
web/wp/             # WordPressコア
web/app/mu-plugins/bedrock-*/      # Bedrockのmu-plugins
web/app/plugins/contact-form-7/    # wpackagistプラグイン
web/app/themes/twentytwentyfive/   # wpackagistテーマ
vendor/             # PHPライブラリ
composer.lock       # 直接編集せずcomposerコマンドで更新
```
