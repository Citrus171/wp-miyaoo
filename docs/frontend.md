# フロントエンド構成メモ

## 採用した技術スタック

| 技術 | 用途 | 採用理由 |
|---|---|---|
| Tailwind CSS v4 | スタイリング | 最も普及・軽量・設定ファイル不要 |
| TypeScript | スクリプト | 型チェックでバグ早期発見 |
| Vite v6 | ビルドツール | 現在の主流・設定がシンプル |
| Alpine.js | インタラクション | WordPress との相性が良く軽量 |
| Vanilla JS | 基本操作 | シンプルな処理はこれで十分 |
| React | カスタムブロック | 必要になった時のみ追加 |

---

## 構成パターンの位置づけ

2026年時点の WordPress フロントエンドは大きく3パターン。

| パターン | 比率（体感） | 今の構成 |
|---|---|---|
| Gutenberg 中心（PHP Hybrid Theme） | 50% | ✅ |
| ACF + 独自テーマ | 35% | |
| Headless（Next.js など） | 15% | |

**PHP Hybrid Theme + Vite + Tailwind + ACF** が2026年の王道に最も近い。

---

## なぜ SPA（ヘッドレス）にしないのか

| 観点 | 今の構成（MPA） | SPA（Headless） |
|---|---|---|
| SEO | 強い（HTML がそのまま返る） | SSR 必須で複雑 |
| 初期表示 | 速い | JS 読み込み後に描画 |
| 保守コスト | 低い | WordPress + Next.js + API と増える |
| WordPress との相性 | 最高 | 管理画面・プラグインと分断される |

コーポレート・採用・メディアサイトなら MPA で十分。

---

## PHP と TypeScript の関係

直接つながっているわけではない。レイヤーが分かれている。

```
① Vite がビルド（開発時）
  src/ts/main.ts  → build/assets/js/main.js
  src/css/main.css → build/assets/css/main.css

② ブラウザがページを開く
  ブラウザ → nginx → PHP（WordPress）→ HTML を生成
  functions.php の wp_enqueue_script() が
  <script src="build/assets/js/main.js"> タグを HTML に出力

③ ブラウザが JS/CSS を読み込んで実行
```

| | 処理場所 |
|---|---|
| PHP | サーバーサイド（ブラウザには届かない） |
| JS（TS のビルド出力） | クライアントサイド（ブラウザで動く） |
| CSS（Tailwind のビルド出力） | クライアントサイド（ブラウザで適用） |

---

## ディレクトリ構成

```
web/app/themes/my-themepro/
├── src/
│   ├── ts/
│   │   ├── main.ts        # エントリポイント（CSS import + Alpine 初期化）
│   │   └── global.d.ts    # window.Alpine の型定義
│   └── css/
│       └── main.css       # Tailwind エントリ（@import "tailwindcss"）
├── build/                 # Vite 出力（.gitignore 対象）
│   ├── assets/js/main.js
│   └── assets/css/main.css
├── vite.config.ts
├── tsconfig.json
├── package.json
├── package-lock.json
├── style.css              # テーマ登録（WordPress が読む）
├── functions.php          # build/ のアセットを wp_enqueue
├── index.php
├── header.php
└── footer.php
```

---

## コマンド

```bash
# 開発（ファイル変更を監視してリビルド）
docker compose --profile frontend up node

# 本番ビルド
docker compose --profile frontend run --rm node npm run build
```

> `build/` は `.gitignore` 対象。CI/CD でビルドすること。

---

## Alpine.js の使い方

`main.ts` で初期化済みなので、HTML に属性を追加するだけで使える。

```html
<!-- ドロワーメニューの例 -->
<div x-data="{ open: false }">
  <button @click="open = !open">メニュー</button>
  <nav x-show="open">...</nav>
</div>

<!-- タブの例 -->
<div x-data="{ tab: 'a' }">
  <button @click="tab = 'a'">A</button>
  <button @click="tab = 'b'">B</button>
  <div x-show="tab === 'a'">A の内容</div>
  <div x-show="tab === 'b'">B の内容</div>
</div>
```

JS ファイルを書かずに HTML だけでインタラクションが実装できる。

---

## jQuery を使う場合

WordPress が jQuery を内包しているため追加インストール不要。

```php
// functions.php
wp_enqueue_script('my-script', $url, ['jquery'], $ver, true);
```

```typescript
// main.ts
declare const jQuery: JQueryStatic
jQuery(function ($) {
    $('.my-class').on('click', function () { ... })
})
```

WordPress の noConflict モードのため `$` は使えない。`jQuery` か即時関数でラップする。

---

## 将来の拡張ポイント

```
現在
  Vanilla JS + Alpine.js
        ↓ UI が複雑になったら
  Alpine.js のコンポーネント化（x-data を関数で定義）
        ↓ カスタムブロックが必要になったら
  React + @wordpress/scripts（ブロック開発専用）
        ↓ フロントを完全分離したい要件が出たら
  Headless（Next.js + WPGraphQL）
```

最初から全部入れず、必要になった段階で追加する。
