# Kadence テーマ メモ

## 基本情報

| 項目 | 内容 |
|---|---|
| バージョン | 1.5.1 |
| インストール方法 | `composer require wpackagist-theme/kadence` |
| 種別 | ハイブリッド（FSE + ブロック対応） |
| 有効化 | `wp theme activate kadence` |

---

## 特徴

- FSEとハイブリッド両対応。将来のWordPress方向性にも追従しやすい
- 日本語サイト実績が多い
- 機能豊富でカスタマイズ性が高い
- 実案件のベーステーマとして使いやすいバランス

---

## 向いている用途

- 汎用（コーポレート・ブログ・メディアなど）
- 将来的にFSEへ移行を見据えた案件

---

## 関連テーマ候補（比較用）

| テーマ | 種別 | 特徴 |
|---|---|---|
| Twenty Twenty-Five | FSE | WP公式・学習・プロトタイプ向け |
| Ollie | FSE | デザイン洗練・コーポレート向け |
| Blocksy | FSE / ハイブリッド | WooCommerce相性良い |
| Astra | ハイブリッド | 最も普及・軽量・スターターテンプレート豊富 |
| GeneratePress | ハイブリッド | 軽量・Core Web Vitals最強クラス |

---

## Composerでの管理

```bash
# インストール
docker compose exec wordpress composer require wpackagist-theme/kadence

# 有効化
docker compose exec wordpress wp --allow-root \
  --path=/var/www/html/web/wp \
  theme activate kadence

# アップデート確認
docker compose exec wordpress composer outdated wpackagist-theme/kadence

# アップデート
docker compose exec wordpress composer update wpackagist-theme/kadence
```
