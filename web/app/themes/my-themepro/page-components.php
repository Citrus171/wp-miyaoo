<?php
/**
 * Template Name: Components
 */
get_header();
?>

<div class="pt-36 pb-32 max-w-5xl mx-auto px-6 space-y-24">

    <!-- ページタイトル -->
    <div class="fade-up">
        <p class="section-label">Tailwind CSS v4</p>
        <h1 class="text-4xl font-bold tracking-tight text-[#09090b]">UIコンポーネント</h1>
        <p class="mt-3 text-[#71717a]">このプロジェクトで使えるパーツ一覧</p>
    </div>

    <!-- ─── Buttons ─────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-6">Buttons</h2>
        <div class="flex flex-wrap gap-3 items-center">
            <a href="#" class="btn-primary">Primary</a>
            <a href="#" class="btn-ghost">Ghost</a>
            <a href="#" class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 border border-red-200 text-sm font-medium px-5 py-2.5 rounded-full hover:bg-red-100 transition-colors">Danger</a>
            <a href="#" class="inline-flex items-center gap-1.5 text-sm font-medium text-[#52525b] hover:text-[#09090b] underline underline-offset-4 transition-colors">Link</a>
        </div>
        <!-- サイズバリエーション -->
        <div class="flex flex-wrap gap-3 items-center mt-4">
            <a href="#" class="inline-flex items-center bg-[#09090b] text-white text-xs font-medium px-3.5 py-1.5 rounded-full hover:bg-[#18181b] transition-colors">Small</a>
            <a href="#" class="btn-primary">Medium</a>
            <a href="#" class="inline-flex items-center bg-[#09090b] text-white text-base font-medium px-7 py-3 rounded-full hover:bg-[#18181b] transition-colors">Large</a>
        </div>
    </section>

    <!-- ─── Badges ────────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-6">Badges</h2>
        <div class="flex flex-wrap gap-2">
            <span class="text-xs font-medium bg-[#09090b] text-white px-2.5 py-1 rounded-full">New</span>
            <span class="text-xs font-medium bg-[#f4f4f5] text-[#52525b] px-2.5 py-1 rounded-full">Tech</span>
            <span class="text-xs font-medium bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">Design</span>
            <span class="text-xs font-medium bg-green-50 text-green-700 px-2.5 py-1 rounded-full">Done</span>
            <span class="text-xs font-medium bg-yellow-50 text-yellow-700 px-2.5 py-1 rounded-full">Draft</span>
            <span class="text-xs font-medium bg-red-50 text-red-700 px-2.5 py-1 rounded-full">Deprecated</span>
        </div>
    </section>

    <!-- ─── Cards ──────────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-6">Cards</h2>
        <div class="grid sm:grid-cols-3 gap-4">

            <!-- シンプルカード -->
            <div class="post-card p-6 bg-white">
                <span class="text-xs font-medium bg-[#f4f4f5] text-[#52525b] px-2.5 py-1 rounded-full">Design</span>
                <h3 class="text-base font-semibold text-[#09090b] mt-4 mb-2">シンプルカード</h3>
                <p class="text-sm text-[#71717a] leading-relaxed">ボーダー付きのベーシックなカードコンポーネント。ホバーで影が付きます。</p>
            </div>

            <!-- アイコン付きカード -->
            <div class="post-card p-6 bg-white">
                <div class="w-10 h-10 rounded-lg bg-[#f4f4f5] flex items-center justify-center text-lg mb-4">⚡</div>
                <h3 class="text-base font-semibold text-[#09090b] mb-2">アイコン付き</h3>
                <p class="text-sm text-[#71717a] leading-relaxed">アイコンや絵文字をカードに添えるとコンテンツの識別がしやすくなります。</p>
            </div>

            <!-- 強調カード -->
            <div class="border border-[#09090b] rounded-[10px] p-6 bg-white">
                <span class="text-xs font-semibold tracking-widest uppercase text-[#09090b]">Featured</span>
                <h3 class="text-base font-semibold text-[#09090b] mt-3 mb-2">強調カード</h3>
                <p class="text-sm text-[#71717a] leading-relaxed">ボーダーカラーを変えるだけで強調できます。</p>
                <a href="#" class="mt-4 inline-flex items-center text-sm font-medium text-[#09090b] gap-1 hover:gap-2 transition-all">詳しく見る →</a>
            </div>

        </div>
    </section>

    <!-- ─── Alerts ─────────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-6">Alerts</h2>
        <div class="space-y-3">
            <div class="flex gap-3 items-start p-4 rounded-xl bg-blue-50 border border-blue-100">
                <span class="text-blue-500 mt-0.5">ℹ</span>
                <div>
                    <p class="text-sm font-semibold text-blue-900">お知らせ</p>
                    <p class="text-sm text-blue-700 mt-0.5">情報を伝えるためのアラートです。</p>
                </div>
            </div>
            <div class="flex gap-3 items-start p-4 rounded-xl bg-green-50 border border-green-100">
                <span class="text-green-500 mt-0.5">✓</span>
                <div>
                    <p class="text-sm font-semibold text-green-900">成功</p>
                    <p class="text-sm text-green-700 mt-0.5">操作が正常に完了しました。</p>
                </div>
            </div>
            <div class="flex gap-3 items-start p-4 rounded-xl bg-red-50 border border-red-100">
                <span class="text-red-500 mt-0.5">✕</span>
                <div>
                    <p class="text-sm font-semibold text-red-900">エラー</p>
                    <p class="text-sm text-red-700 mt-0.5">問題が発生しました。再度お試しください。</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── Table ──────────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-6">Table</h2>
        <div class="border border-[#e4e4e7] rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-[#fafafa] border-b border-[#e4e4e7]">
                        <th class="text-left text-xs font-semibold text-[#71717a] px-5 py-3">名前</th>
                        <th class="text-left text-xs font-semibold text-[#71717a] px-5 py-3">カテゴリ</th>
                        <th class="text-left text-xs font-semibold text-[#71717a] px-5 py-3">ステータス</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f4f4f5]">
                    <?php
                    $rows = [
                        ['Tailwind CSS v4', 'CSS', 'Done'],
                        ['Alpine.js',       'JS',  'Done'],
                        ['Vite v6',         'Build', 'Done'],
                        ['TypeScript',      'JS',  'Draft'],
                    ];
                    foreach ($rows as $row) :
                    ?>
                    <tr class="hover:bg-[#fafafa] transition-colors">
                        <td class="px-5 py-3.5 font-medium text-[#09090b]"><?php echo esc_html($row[0]); ?></td>
                        <td class="px-5 py-3.5 text-[#71717a]"><?php echo esc_html($row[1]); ?></td>
                        <td class="px-5 py-3.5">
                            <span class="text-xs font-medium <?php echo $row[2] === 'Done' ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700'; ?> px-2.5 py-1 rounded-full">
                                <?php echo esc_html($row[2]); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- ─── Form ───────────────────────────────── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-6">Form</h2>
        <form class="max-w-md space-y-4">
            <div>
                <label class="block text-sm font-medium text-[#09090b] mb-1.5">名前</label>
                <input type="text" placeholder="例：山田 太郎"
                    class="w-full border border-[#e4e4e7] rounded-lg px-3.5 py-2.5 text-sm text-[#09090b] placeholder-[#a1a1aa]
                           focus:outline-none focus:border-[#a1a1aa] focus:ring-2 focus:ring-[#09090b]/5 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-[#09090b] mb-1.5">メール</label>
                <input type="email" placeholder="hello@example.com"
                    class="w-full border border-[#e4e4e7] rounded-lg px-3.5 py-2.5 text-sm text-[#09090b] placeholder-[#a1a1aa]
                           focus:outline-none focus:border-[#a1a1aa] focus:ring-2 focus:ring-[#09090b]/5 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-[#09090b] mb-1.5">メッセージ</label>
                <textarea rows="3" placeholder="お気軽にどうぞ"
                    class="w-full border border-[#e4e4e7] rounded-lg px-3.5 py-2.5 text-sm text-[#09090b] placeholder-[#a1a1aa]
                           focus:outline-none focus:border-[#a1a1aa] focus:ring-2 focus:ring-[#09090b]/5 transition resize-none"></textarea>
            </div>
            <button type="submit" class="btn-primary w-full justify-center">送信する</button>
        </form>
    </section>

</div>

<?php get_footer(); ?>
