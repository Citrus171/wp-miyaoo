<?php get_header(); ?>

<div class="pt-36 pb-32 max-w-6xl mx-auto px-6">

    <!-- ページタイトル -->
    <div class="fade-up mb-16 pb-8 border-b border-[#e4e4e7]">
        <p class="section-label">
            <?php if (is_category()) : ?>
                Category
            <?php elseif (is_tag()) : ?>
                Tag
            <?php elseif (is_search()) : ?>
                Search
            <?php else : ?>
                Blog
            <?php endif; ?>
        </p>
        <h1 class="text-4xl font-bold tracking-tight text-[#09090b]">
            <?php
            if (is_category())      single_cat_title();
            elseif (is_tag())       single_tag_title();
            elseif (is_search())    echo '「' . get_search_query() . '」の検索結果';
            else                    echo '記事一覧';
            ?>
        </h1>
        <?php if (is_search()) : ?>
        <p class="text-sm text-[#a1a1aa] mt-2"><?php global $wp_query; echo $wp_query->found_posts; ?> 件見つかりました</p>
        <?php endif; ?>
    </div>

    <?php if (have_posts()) : ?>

    <!-- 記事リスト -->
    <div class="space-y-px bg-[#e4e4e7] border border-[#e4e4e7] rounded-xl overflow-hidden">
        <?php while (have_posts()) : the_post(); ?>
        <article class="fade-up bg-white hover:bg-[#fafafa] transition-colors duration-150 group">
            <a href="<?php the_permalink(); ?>" class="flex items-start md:items-center justify-between gap-6 px-6 py-5">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-1.5">
                        <time class="text-xs text-[#a1a1aa]"><?php echo get_the_date('Y.m.d'); ?></time>
                        <?php $cats = get_the_category(); if ($cats) : ?>
                        <span class="text-xs bg-[#f4f4f5] text-[#71717a] px-2.5 py-0.5 rounded-full">
                            <?php echo esc_html($cats[0]->name); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    <h2 class="text-base font-semibold text-[#09090b] group-hover:text-[#18181b] leading-snug">
                        <?php the_title(); ?>
                    </h2>
                    <p class="text-sm text-[#a1a1aa] mt-1 line-clamp-1 hidden md:block">
                        <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                    </p>
                </div>
                <span class="text-[#d4d4d8] group-hover:text-[#a1a1aa] transition-colors shrink-0 text-lg">→</span>
            </a>
        </article>
        <?php endwhile; ?>
    </div>

    <!-- ページネーション -->
    <div class="fade-up mt-12 flex items-center justify-center gap-2">
        <?php
        the_posts_pagination([
            'mid_size'           => 2,
            'prev_text'          => '← 前',
            'next_text'          => '次 →',
            'before_page_number' => '',
            'class'              => 'pagination',
        ]);
        ?>
    </div>

    <?php else : ?>
    <div class="fade-up text-center py-24 text-[#a1a1aa]">
        <p class="text-5xl mb-4">◇</p>
        <p class="text-sm">記事がまだありません。</p>
    </div>
    <?php endif; ?>

</div>

<?php get_footer(); ?>
