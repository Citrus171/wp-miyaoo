<?php
/**
 * Template Name: Alpine Components
 */
get_header();
?>

<div class="pt-36 pb-32 max-w-5xl mx-auto px-6 space-y-24">

    <!-- ページタイトル -->
    <div class="fade-up">
        <p class="section-label">Alpine.js</p>
        <h1 class="text-4xl font-bold tracking-tight text-[#09090b]">インタラクティブコンポーネント</h1>
        <p class="mt-3 text-[#71717a]">Alpine.js のよく使うパターン一覧</p>
    </div>

    <!-- ─── 1. カウンター ─────────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-2">Counter</h2>
        <p class="text-xs text-[#a1a1aa] mb-6 font-mono">x-data / x-text / @click</p>

        <div x-data="{ count: 0 }" class="flex items-center gap-4">
            <button @click="count--"
                class="w-10 h-10 rounded-full border border-[#e4e4e7] text-[#52525b] hover:border-[#09090b] hover:text-[#09090b] transition text-lg font-light">
                −
            </button>
            <span x-text="count" class="text-3xl font-semibold text-[#09090b] w-12 text-center tabular-nums"></span>
            <button @click="count++"
                class="w-10 h-10 rounded-full border border-[#e4e4e7] text-[#52525b] hover:border-[#09090b] hover:text-[#09090b] transition text-lg font-light">
                ＋
            </button>
            <button @click="count = 0"
                class="text-xs text-[#a1a1aa] hover:text-[#52525b] transition ml-2">
                リセット
            </button>
        </div>
    </section>

    <!-- ─── 2. トグルスイッチ ────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-2">Toggle</h2>
        <p class="text-xs text-[#a1a1aa] mb-6 font-mono">x-data / x-model / :class</p>

        <div x-data="{ enabled: false }" class="flex items-center gap-4">
            <button
                @click="enabled = !enabled"
                :class="enabled ? 'bg-[#09090b]' : 'bg-[#e4e4e7]'"
                class="relative w-12 h-6 rounded-full transition-colors duration-200">
                <span
                    :class="enabled ? 'translate-x-6' : 'translate-x-1'"
                    class="absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-transform duration-200 block">
                </span>
            </button>
            <span x-text="enabled ? 'ON' : 'OFF'"
                :class="enabled ? 'text-[#09090b]' : 'text-[#a1a1aa]'"
                class="text-sm font-medium transition-colors">
            </span>
        </div>
    </section>

    <!-- ─── 3. タブ ──────────────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-2">Tabs</h2>
        <p class="text-xs text-[#a1a1aa] mb-6 font-mono">x-data / :class / x-show</p>

        <div x-data="{ tab: 'html' }">
            <!-- タブバー -->
            <div class="flex gap-1 border-b border-[#e4e4e7] mb-6">
                <template x-for="t in ['html', 'css', 'js']" :key="t">
                    <button
                        @click="tab = t"
                        :class="tab === t
                            ? 'border-b-2 border-[#09090b] text-[#09090b]'
                            : 'text-[#a1a1aa] hover:text-[#52525b]'"
                        class="px-4 py-2 text-sm font-medium capitalize transition-colors -mb-px"
                        x-text="t.toUpperCase()">
                    </button>
                </template>
            </div>
            <!-- コンテンツ -->
            <div x-show="tab === 'html'" class="text-sm text-[#52525b] leading-relaxed">
                HTML はウェブページの構造を定義するマークアップ言語です。セマンティックなタグを使いましょう。
            </div>
            <div x-show="tab === 'css'" class="text-sm text-[#52525b] leading-relaxed">
                CSS はウェブページの見た目を整えるスタイルシート言語です。Tailwind CSS を使うと効率的です。
            </div>
            <div x-show="tab === 'js'" class="text-sm text-[#52525b] leading-relaxed">
                JavaScript はウェブページに動きをつけるプログラミング言語です。Alpine.js で簡単に書けます。
            </div>
        </div>
    </section>

    <!-- ─── 4. アコーディオン ────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-2">Accordion</h2>
        <p class="text-xs text-[#a1a1aa] mb-6 font-mono">x-data / x-show / x-transition</p>

        <div class="border border-[#e4e4e7] rounded-xl overflow-hidden divide-y divide-[#e4e4e7]">
            <?php
            $items = [
                ['Alpine.js とは何ですか？', 'Alpine.js は軽量なJavaScriptフレームワークです。HTMLにディレクティブを追加するだけでインタラクティブな動作が実現できます。'],
                ['Tailwind CSS との相性は？', 'とても良いです。Tailwindはスタイルをクラスで管理し、AlpineはJSをHTMLで管理する思想が共通しているため、セットで使われることが多いです。'],
                ['Vue や React との違いは？', 'ビルドステップが不要で、既存のHTMLに後付けできます。小〜中規模のインタラクションに最適です。'],
            ];
            foreach ($items as $i => $item) :
            ?>
            <div x-data="{ open: <?php echo $i === 0 ? 'true' : 'false'; ?> }">
                <button @click="open = !open"
                    class="flex items-center justify-between w-full px-5 py-4 text-left hover:bg-[#fafafa] transition-colors">
                    <span class="text-sm font-medium text-[#09090b]"><?php echo esc_html($item[0]); ?></span>
                    <span :class="open ? 'rotate-180' : ''"
                        class="text-[#a1a1aa] transition-transform duration-200 text-xs">▼</span>
                </button>
                <div x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    <p class="px-5 pb-5 text-sm text-[#71717a] leading-relaxed"><?php echo esc_html($item[1]); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ─── 5. ドロップダウン ────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-2">Dropdown</h2>
        <p class="text-xs text-[#a1a1aa] mb-6 font-mono">x-data / x-show / @click.outside / x-transition</p>

        <div x-data="{ open: false }" class="relative inline-block">
            <button @click="open = !open" class="btn-ghost flex items-center gap-2">
                メニュー
                <span :class="open ? 'rotate-180' : ''" class="transition-transform duration-150 text-xs">▼</span>
            </button>

            <div x-show="open"
                @click.outside="open = false"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute top-full left-0 mt-2 w-48 bg-white border border-[#e4e4e7] rounded-xl shadow-lg overflow-hidden z-10">
                <?php
                $menu = ['プロフィール', '設定', 'ダッシュボード', 'ログアウト'];
                foreach ($menu as $label) :
                ?>
                <a href="#" @click="open = false"
                    class="block px-4 py-2.5 text-sm text-[#52525b] hover:bg-[#fafafa] hover:text-[#09090b] transition-colors">
                    <?php echo esc_html($label); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ─── 6. モーダル ──────────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-2">Modal</h2>
        <p class="text-xs text-[#a1a1aa] mb-6 font-mono">x-data / x-show / @keydown.escape / x-transition</p>

        <div x-data="{ open: false }" @keydown.escape.window="open = false">
            <button @click="open = true" class="btn-primary">モーダルを開く</button>

            <!-- オーバーレイ -->
            <div x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click.self="open = false"
                class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">

                <!-- ダイアログ -->
                <div x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8">
                    <h3 class="text-lg font-semibold text-[#09090b] mb-2">確認</h3>
                    <p class="text-sm text-[#71717a] leading-relaxed mb-6">
                        この操作を実行してよいですか？<br>ESCキーまたは背景クリックで閉じます。
                    </p>
                    <div class="flex gap-3 justify-end">
                        <button @click="open = false" class="btn-ghost">キャンセル</button>
                        <button @click="open = false" class="btn-primary">実行する</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── 7. フォームバリデーション ──────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-2">Form Validation</h2>
        <p class="text-xs text-[#a1a1aa] mb-6 font-mono">x-data / x-model / x-show / :class</p>

        <div x-data="{
            email: '',
            submitted: false,
            get isValid() { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email) },
            submit() { this.submitted = true; }
        }" class="max-w-sm">
            <label class="block text-sm font-medium text-[#09090b] mb-1.5">メールアドレス</label>
            <input
                x-model="email"
                type="email"
                placeholder="hello@example.com"
                :class="submitted && !isValid
                    ? 'border-red-400 ring-2 ring-red-100'
                    : 'border-[#e4e4e7] focus:border-[#a1a1aa] focus:ring-2 focus:ring-[#09090b]/5'"
                class="w-full rounded-lg px-3.5 py-2.5 text-sm text-[#09090b] placeholder-[#a1a1aa] border outline-none transition">

            <p x-show="submitted && !isValid"
                x-transition
                class="mt-1.5 text-xs text-red-500">
                正しいメールアドレスを入力してください
            </p>
            <p x-show="submitted && isValid"
                x-transition
                class="mt-1.5 text-xs text-green-600">
                ✓ 正しい形式です
            </p>

            <button @click="submit()" class="btn-primary mt-4">送信</button>
        </div>
    </section>

    <!-- ─── 8. トースト通知 ──────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-2">Toast</h2>
        <p class="text-xs text-[#a1a1aa] mb-6 font-mono">x-data / x-show / x-transition / setTimeout</p>

        <div x-data="{
            show: false,
            type: 'success',
            message: '',
            toast(msg, t = 'success') {
                this.message = msg; this.type = t; this.show = true;
                setTimeout(() => this.show = false, 3000);
            }
        }">
            <div class="flex flex-wrap gap-3">
                <button @click="toast('保存しました', 'success')" class="btn-primary">成功</button>
                <button @click="toast('エラーが発生しました', 'error')"
                    class="inline-flex items-center bg-red-600 text-white text-sm font-medium px-5 py-2.5 rounded-full hover:bg-red-700 transition">
                    エラー
                </button>
                <button @click="toast('処理中です...', 'info')" class="btn-ghost">情報</button>
            </div>

            <!-- トースト本体（画面右下固定） -->
            <div
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                :class="{
                    'bg-[#09090b] text-white': type === 'success',
                    'bg-red-600 text-white':   type === 'error',
                    'bg-white border border-[#e4e4e7] text-[#09090b]': type === 'info'
                }"
                class="fixed bottom-6 right-6 px-5 py-3 rounded-xl shadow-lg text-sm font-medium z-50 flex items-center gap-2">
                <span x-text="type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ'"></span>
                <span x-text="message"></span>
            </div>
        </div>
    </section>

</div>

<?php get_footer(); ?>
