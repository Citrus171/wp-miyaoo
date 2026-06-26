<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<!-- ─── 記事ヘッダー ─── -->
<div class="pt-32 pb-16 border-b border-[#262626]">
    <div class="max-w-3xl mx-auto px-6">

        <!-- メタ -->
        <div class="fade-up flex items-center gap-3 mb-8">
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="text-xs text-[#52525b] hover:text-[#a1a1aa] transition-colors">ブログ</a>
            <span class="text-[#3f3f46]">/</span>
            <?php
            $cats = get_the_category();
            if ($cats) : ?>
            <span class="text-xs border border-[#262626] text-[#71717a] px-2 py-0.5 rounded-full"><?php echo esc_html($cats[0]->name); ?></span>
            <?php endif; ?>
        </div>

        <!-- タイトル -->
        <h1 class="fade-up text-3xl md:text-5xl font-bold text-[#fafafa] leading-tight tracking-tight mb-6">
            <?php the_title(); ?>
        </h1>

        <!-- 日付 + 著者 -->
        <div class="fade-up flex items-center gap-4 text-sm text-[#52525b]">
            <time><?php echo get_the_date('Y年m月d日'); ?></time>
            <span>·</span>
            <span><?php the_author(); ?></span>
            <span>·</span>
            <span><?php echo ceil(mb_strlen(strip_tags(get_the_content())) / 400); ?> 分で読めます</span>
        </div>
    </div>
</div>

<!-- ─── サムネイル ─── -->
<?php if (has_post_thumbnail()) : ?>
<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="fade-up rounded-xl overflow-hidden border border-[#262626]">
        <?php the_post_thumbnail('large', ['class' => 'w-full h-auto']); ?>
    </div>
</div>
<?php endif; ?>

<!-- ─── 本文 ─── -->
<article class="max-w-3xl mx-auto px-6 py-12">
    <div class="fade-up prose-dark">
        <?php the_content(); ?>
    </div>
</article>

<!-- ─── タグ ─── -->
<?php
$tags = get_the_tags();
if ($tags) : ?>
<div class="max-w-3xl mx-auto px-6 pb-12">
    <div class="fade-up flex flex-wrap gap-2 border-t border-[#262626] pt-8">
        <?php foreach ($tags as $tag) : ?>
        <a href="<?php echo get_tag_link($tag->term_id); ?>"
           class="text-xs border border-[#262626] text-[#71717a] px-3 py-1 rounded-full hover:border-[#3f3f46] hover:text-[#a1a1aa] transition-colors">
            #<?php echo esc_html($tag->name); ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ─── 前後の記事 ─── -->
<nav class="max-w-3xl mx-auto px-6 pb-24 border-t border-[#262626] pt-12">
    <div class="fade-up grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php $prev = get_previous_post(); if ($prev) : ?>
        <a href="<?php echo get_permalink($prev); ?>" class="group border border-[#262626] rounded-xl p-5 hover:border-[#3f3f46] hover:bg-[#111111] transition-all duration-200">
            <p class="text-xs text-[#52525b] mb-2">← 前の記事</p>
            <p class="text-sm text-[#a1a1aa] group-hover:text-[#fafafa] transition-colors leading-snug line-clamp-2"><?php echo esc_html($prev->post_title); ?></p>
        </a>
        <?php else : ?><div></div><?php endif; ?>

        <?php $next = get_next_post(); if ($next) : ?>
        <a href="<?php echo get_permalink($next); ?>" class="group border border-[#262626] rounded-xl p-5 hover:border-[#3f3f46] hover:bg-[#111111] transition-all duration-200 text-right">
            <p class="text-xs text-[#52525b] mb-2">次の記事 →</p>
            <p class="text-sm text-[#a1a1aa] group-hover:text-[#fafafa] transition-colors leading-snug line-clamp-2"><?php echo esc_html($next->post_title); ?></p>
        </a>
        <?php endif; ?>
    </div>
</nav>

<?php endwhile; ?>

<?php get_footer(); ?>
