# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## 概要

WordPress + Bedrock + Nginx + PHP-FPM + MySQL + phpMyAdmin の Docker 開発環境。
Bedrock により Composer でプラグイン・テーマ・WordPressコアをバージョン管理。

## コンテナ構成

| コンテナ | イメージ | 役割 |
|---|---|---|
| wordpress | php:8.3-fpm（カスタム） | PHP-FPM |
| nginx | nginx:alpine | Webサーバー（ポート8082） |
| db | mysql:8.0 | データベース |
| phpmyadmin | phpmyadmin:latest | DB管理画面 |

## コマンド

```bash
# 起動（初回は composer install が自動実行される）
docker compose up -d

# 停止
docker compose down

# ログ確認
docker compose logs -f wordpress
docker compose logs -f nginx

# データも含めて完全削除（DBデータも消えるので注意）
docker compose down -v
```

## アクセス先

| サービス | URL |
|---|---|
| WordPress サイト | http://localhost:8082 |
| WordPress 管理画面 | http://localhost:8082/wp/wp-admin |
| phpMyAdmin | http://localhost:8081 |

> 管理画面のURLが `/wp/wp-admin` になることに注意（Bedrock仕様）

## ディレクトリ構成

```
├── composer.json       # プラグイン・テーマ・WPコアの依存管理
├── composer.lock       # バージョン固定（git管理対象）
├── Dockerfile          # PHP-FPM + Composer + WP-CLI
├── nginx.conf          # Nginx設定
├── docker-compose.yml
├── entrypoint.sh       # 起動時にcomposer installを自動実行
├── config/
│   ├── application.php          # WordPress設定（wp-config.php相当）
│   └── environments/
│       ├── development.php      # デバッグON
│       ├── staging.php
│       └── production.php
└── web/                         # ドキュメントルート
    ├── index.php
    ├── wp-config.php
    ├── wp/                      # WordPressコア（Composerが管理・gitignore対象）
    └── app/                     # wp-content 相当
        ├── mu-plugins/          # 必須プラグイン（管理画面から無効化不可）
        ├── plugins/             # Composerで管理するプラグイン
        ├── themes/              # テーマ（カスタムテーマはgit管理）
        └── uploads/             # メディア（gitignore対象）
```

## Composer（プラグイン・テーマ管理）

```bash
# プラグイン追加（wpackagist経由）
docker compose exec wordpress composer require wpackagist-plugin/contact-form-7

# テーマ追加
docker compose exec wordpress composer require wpackagist-theme/twentytwentyfive

# アップデート確認
docker compose exec wordpress composer outdated

# アップデート実行
docker compose exec wordpress composer update

# カスタムテーマ・プラグインは web/app/themes/ や web/app/plugins/ に直接配置してgit管理
```

## WP-CLI

```bash
# WordPress バージョン確認
docker compose exec wordpress wp --allow-root --path=/var/www/html/web/wp core version

# ユーザーのパスワードリセット
docker compose exec wordpress wp --allow-root --path=/var/www/html/web/wp user update admin --user_pass=新パスワード

# プラグイン一覧
docker compose exec wordpress wp --allow-root --path=/var/www/html/web/wp plugin list

# プラグイン有効化
docker compose exec wordpress wp --allow-root --path=/var/www/html/web/wp plugin activate contact-form-7

# データベース更新（WPコアアップデート後に必須）
docker compose exec wordpress wp --allow-root --path=/var/www/html/web/wp core update-db
```

## 環境変数

`.env` に DB 認証情報・WP設定・セキュリティキーを記載（git 管理外）。
セキュリティキーは https://roots.io/salts/ で生成。

## 初回セットアップ

```bash
cp .env.example .env
# .env のパスワードとセキュリティキーを設定
docker compose up -d
# http://localhost:8082 でWordPressのインストール画面が表示される
```

## ドキュメント

| ドキュメント | 内容 |
|---|---|
| [docs/wordpress-customization.md](docs/wordpress-customization.md) | フック・カスタマイズ方法・テーマとWP本体のアップデート手順 |
| [docs/deployment.md](docs/deployment.md) | ステージング・本番構成・GitHub Actions・デプロイフロー |
| [docs/editable-files.md](docs/editable-files.md) | ファイル編集可否一覧（ツリー構造） |
| [docs/common-features.md](docs/common-features.md) | MU Plugin・カスタムプラグインによく作る機能一覧 |
| [docs/theme-kadence.md](docs/theme-kadence.md) | Kadenceテーマのメモ・比較・Composerコマンド |
