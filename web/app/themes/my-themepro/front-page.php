<?php get_header(); ?>

<!-- ══════════════════════════════════════
     Hero
══════════════════════════════════════ -->
<section class="pt-40 pb-32 max-w-6xl mx-auto px-6">
    <div class="fade-up max-w-3xl">
        <p class="section-label">Blog</p>
        <h1 class="text-5xl md:text-7xl font-bold tracking-tight leading-[1.08] text-[#09090b] mb-6">
            書くことは、<br>考えることだ。
        </h1>
        <p class="text-[#71717a] text-lg md:text-xl max-w-lg leading-relaxed mb-10">
            テクノロジー・デザイン・思考の記録。<br>
            読んで何かが動けばそれでいい。
        </p>
        <div class="flex items-center gap-3 flex-wrap">
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="btn-primary">
                記事を読む <span class="opacity-60">→</span>
            </a>
            <a href="<?php echo esc_url(home_url('/feed')); ?>" class="btn-ghost">
                RSS を購読
            </a>
        </div>
    </div>

    <!-- 統計ライン -->
    <div class="fade-up mt-20 pt-8 border-t border-[#e4e4e7] grid grid-cols-3 gap-8 max-w-xs">
        <?php
        $post_count = wp_count_posts()->publish;
        $stats = [
            ['n' => $post_count,  'l' => '記事'],
            ['n' => date('Y') - 2023, 'l' => '年目'],
            ['n' => '∞', 'l' => 'カップのコーヒー'],
        ];
        foreach ($stats as $s) : ?>
        <div>
            <p class="text-2xl font-bold text-[#09090b] tracking-tight"><?php echo $s['n']; ?></p>
            <p class="text-xs text-[#a1a1aa] mt-0.5"><?php echo $s['l']; ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ══════════════════════════════════════
     Latest Posts
══════════════════════════════════════ -->
<section class="py-24 border-t border-[#e4e4e7]">
    <div class="max-w-6xl mx-auto px-6">

        <div class="fade-up flex items-end justify-between mb-12">
            <div>
                <p class="section-label">Latest posts</p>
                <h2 class="text-3xl font-bold tracking-tight text-[#09090b]">最新の記事</h2>
            </div>
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="hidden md:inline-flex text-sm text-[#a1a1aa] hover:text-[#09090b] transition-colors items-center gap-1">
                すべて見る <span>→</span>
            </a>
        </div>

        <?php
        $posts = new WP_Query(['posts_per_page' => 5, 'post_status' => 'publish']);
        if ($posts->have_posts()) :
            $i = 0;
            while ($posts->have_posts()) : $posts->the_post();
                $i++;
        ?>

        <?php if ($i === 1) : /* 1件目：大カード */ ?>
        <article class="fade-up post-card mb-4 group">
            <a href="<?php the_permalink(); ?>" class="flex flex-col md:flex-row">
                <div class="md:w-1/2 h-56 md:h-72 overflow-hidden">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
                    <?php else : ?>
                        <div class="w-full h-full thumb-placeholder">◇</div>
                    <?php endif; ?>
                </div>
                <div class="md:w-1/2 p-8 flex flex-col justify-center">
                    <div class="flex items-center gap-3 mb-4">
                        <time class="text-xs text-[#a1a1aa]"><?php echo get_the_date('Y.m.d'); ?></time>
                        <?php $cats = get_the_category(); if ($cats) : ?>
                        <span class="text-xs bg-[#f4f4f5] text-[#71717a] px-2.5 py-0.5 rounded-full"><?php echo esc_html($cats[0]->name); ?></span>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-[#09090b] leading-snug mb-3 group-hover:text-[#18181b]">
                        <?php the_title(); ?>
                    </h3>
                    <p class="text-sm text-[#71717a] leading-relaxed line-clamp-3">
                        <?php echo wp_trim_words(get_the_excerpt(), 60); ?>
                    </p>
                    <span class="mt-6 text-sm font-medium text-[#09090b] flex items-center gap-1">
                        続きを読む <span class="transition-transform group-hover:translate-x-1">→</span>
                    </span>
                </div>
            </a>
        </article>

        <?php elseif ($i === 2) : /* 2件目から：2カラムグリッド開始 */ ?>
        <div class="fade-up grid grid-cols-1 md:grid-cols-2 gap-4">
        <article class="post-card group">
            <a href="<?php the_permalink(); ?>" class="block">
                <div class="h-44 overflow-hidden">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
                    <?php else : ?>
                        <div class="w-full h-full thumb-placeholder">◇</div>
                    <?php endif; ?>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <time class="text-xs text-[#a1a1aa]"><?php echo get_the_date('Y.m.d'); ?></time>
                    </div>
                    <h3 class="text-base font-semibold text-[#09090b] leading-snug line-clamp-2 group-hover:text-[#18181b]">
                        <?php the_title(); ?>
                    </h3>
                </div>
            </a>
        </article>

        <?php elseif ($i >= 3 && $i <= 5) : /* 3〜5件目 */ ?>
        <article class="post-card group">
            <a href="<?php the_permalink(); ?>" class="block">
                <div class="h-44 overflow-hidden">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium_large', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
                    <?php else : ?>
                        <div class="w-full h-full thumb-placeholder">◇</div>
                    <?php endif; ?>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <time class="text-xs text-[#a1a1aa]"><?php echo get_the_date('Y.m.d'); ?></time>
                    </div>
                    <h3 class="text-base font-semibold text-[#09090b] leading-snug line-clamp-2 group-hover:text-[#18181b]">
                        <?php the_title(); ?>
                    </h3>
                </div>
            </a>
        </article>
        <?php if ($i === 5) : ?></div><?php endif; ?>

        <?php endif; ?>

        <?php endwhile; wp_reset_postdata(); ?>

        <?php if ($i === 2) : ?></div><?php endif; /* 2件しかなかった場合 */ ?>
        <?php endif; ?>

        <div class="fade-up text-center mt-10 md:hidden">
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="btn-ghost">すべての記事を見る</a>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════
     Philosophy
══════════════════════════════════════ -->
<section class="py-32 border-t border-[#e4e4e7] bg-[#fafafa]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">
            <div class="fade-up">
                <p class="section-label">Philosophy</p>
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-[#09090b] leading-tight">
                    余白こそが<br>メッセージになる。
                </h2>
            </div>
            <div class="fade-up space-y-8">
                <?php
                $items = [
                    ['t' => 'ひとつのことを深く', 'd' => '広く浅くではなく、ひとつのテーマを徹底的に掘り下げます。読んで「わかった」と感じてもらうことを最優先に。'],
                    ['t' => '言葉を削る', 'd' => '書いてから半分に削る。それでも伝わるなら、もう半分。読者の時間は有限です。'],
                    ['t' => '自分で試した話だけ', 'd' => '実際に手を動かしたこと、試したこと、失敗したことだけを書きます。再現性のある情報を。'],
                ];
                foreach ($items as $item) : ?>
                <div class="flex gap-5">
                    <div class="w-px bg-[#e4e4e7] shrink-0 mt-1"></div>
                    <div>
                        <h3 class="text-sm font-semibold text-[#09090b] mb-1"><?php echo $item['t']; ?></h3>
                        <p class="text-sm text-[#71717a] leading-relaxed"><?php echo $item['d']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════
     CTA
══════════════════════════════════════ -->
<section class="py-32 border-t border-[#e4e4e7]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="fade-up max-w-2xl">
            <p class="section-label">Contact</p>
            <h2 class="text-4xl md:text-5xl font-bold tracking-tight text-[#09090b] leading-tight mb-5">
                話しかけてください。
            </h2>
            <p class="text-[#71717a] text-lg mb-8 max-w-md">
                感想・質問・フィードバック、なんでも歓迎します。<br>できる限り返事します。
            </p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary text-base px-8 py-3">
                お問い合わせ <span class="opacity-60">→</span>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
