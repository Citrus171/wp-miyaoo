<?php get_header(); ?>

<!-- ヒーローセクション -->
<section class="relative bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-300 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-6xl mx-auto px-4 py-28 text-center">
        <p class="text-indigo-200 text-sm font-semibold tracking-widest uppercase mb-4">Welcome</p>
        <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">
            アイデアを、<br class="md:hidden">世界へ届けよう
        </h1>
        <p class="text-indigo-100 text-lg md:text-xl max-w-xl mx-auto mb-10">
            思考を整理し、知識を共有する。<br>あなたの言葉がだれかの力になる。
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="bg-white text-indigo-600 font-semibold px-8 py-3 rounded-full hover:bg-indigo-50 transition-colors shadow-lg">
                記事を読む
            </a>
            <a href="<?php echo esc_url(home_url('/about')); ?>" class="border border-white/50 text-white font-semibold px-8 py-3 rounded-full hover:bg-white/10 transition-colors">
                About
            </a>
        </div>
    </div>
</section>

<!-- 最新投稿カード -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <p class="text-indigo-600 text-sm font-semibold tracking-widest uppercase mb-2">Latest Posts</p>
            <h2 class="text-3xl font-bold text-gray-900">最新の記事</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php
            $recent_posts = new WP_Query([
                'posts_per_page' => 3,
                'post_status'    => 'publish',
            ]);
            if ($recent_posts->have_posts()) :
                while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                <article class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow overflow-hidden group">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="block overflow-hidden h-48">
                            <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300']); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php the_permalink(); ?>" class="block h-48 bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                            <span class="text-indigo-300 text-5xl">✦</span>
                        </a>
                    <?php endif; ?>
                    <div class="p-6">
                        <p class="text-xs text-gray-400 mb-2"><?php echo get_the_date('Y.m.d'); ?></p>
                        <h3 class="font-bold text-gray-900 mb-3 leading-snug line-clamp-2">
                            <a href="<?php the_permalink(); ?>" class="hover:text-indigo-600 transition-colors">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500 line-clamp-3"><?php echo wp_trim_words(get_the_excerpt(), 40); ?></p>
                        <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-1 mt-4 text-sm font-medium text-indigo-600 hover:gap-2 transition-all">
                            続きを読む <span>→</span>
                        </a>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata();
            endif; ?>
        </div>

        <div class="text-center mt-12">
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="inline-flex items-center gap-2 border border-indigo-600 text-indigo-600 font-semibold px-8 py-3 rounded-full hover:bg-indigo-600 hover:text-white transition-colors">
                記事をもっと見る <span>→</span>
            </a>
        </div>
    </div>
</section>

<!-- FAQアコーディオン -->
<section class="py-20 bg-white">
    <div class="max-w-3xl mx-auto px-4">
        <div class="text-center mb-12">
            <p class="text-indigo-600 text-sm font-semibold tracking-widest uppercase mb-2">FAQ</p>
            <h2 class="text-3xl font-bold text-gray-900">よくある質問</h2>
        </div>

        <div x-data="{ active: null }" class="space-y-3">
            <?php
            $faqs = [
                ['q' => 'このブログはどんなテーマで書いていますか？', 'a' => 'テクノロジー・デザイン・日々の思考など、興味の赴くままに書いています。特定のジャンルに縛られず、学んだこと・考えたことを自由に発信しています。'],
                ['q' => '更新頻度はどのくらいですか？', 'a' => '週に1〜2本を目安に更新しています。質を重視しているため、じっくり時間をかけて書いた記事をお届けしています。'],
                ['q' => '記事への感想や質問はどこから送れますか？', 'a' => 'お問い合わせページのフォームからいつでもご連絡ください。すべてのメッセージに目を通し、できる限りお返事しています。'],
                ['q' => 'RSSフィードはありますか？', 'a' => 'はい、あります。ブラウザのRSSリーダーやFeedlyなどに「' . esc_url(home_url('/feed')) . '」を登録してください。'],
            ];
            foreach ($faqs as $i => $faq) : ?>
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button
                    @click="active = active === <?php echo $i; ?> ? null : <?php echo $i; ?>"
                    class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-gray-50 transition-colors"
                >
                    <span class="font-medium text-gray-900 pr-4"><?php echo esc_html($faq['q']); ?></span>
                    <span class="text-indigo-600 text-xl transition-transform duration-300 shrink-0" :class="active === <?php echo $i; ?> ? 'rotate-45' : ''">+</span>
                </button>
                <div
                    x-show="active === <?php echo $i; ?>"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4"
                >
                    <?php echo esc_html($faq['a']); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTAバナー -->
<section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">気になることがあれば<br>お気軽にどうぞ</h2>
        <p class="text-indigo-200 mb-8">フィードバックや質問、なんでも歓迎します。</p>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="bg-white text-indigo-600 font-semibold px-10 py-4 rounded-full hover:bg-indigo-50 transition-colors shadow-lg inline-block">
            お問い合わせ
        </a>
    </div>
</section>

<?php get_footer(); ?>
