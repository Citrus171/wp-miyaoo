<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<!-- ─── ヘッダー ─── -->
<div class="pt-36 pb-12 max-w-3xl mx-auto px-6">

    <div class="fade-up mb-8">
        <a href="<?php echo esc_url(home_url('/blog')); ?>"
           class="inline-flex items-center gap-1.5 text-xs text-[#a1a1aa] hover:text-[#09090b] transition-colors">
            <span>←</span> ブログ一覧
        </a>
    </div>

    <?php $cats = get_the_category(); if ($cats) : ?>
    <div class="fade-up mb-4">
        <span class="text-xs bg-[#f4f4f5] text-[#71717a] px-2.5 py-1 rounded-full">
            <?php echo esc_html($cats[0]->name); ?>
        </span>
    </div>
    <?php endif; ?>

    <h1 class="fade-up text-3xl md:text-5xl font-bold text-[#09090b] leading-tight tracking-tight mb-6">
        <?php the_title(); ?>
    </h1>

    <div class="fade-up flex items-center gap-3 text-xs text-[#a1a1aa] pb-8 border-b border-[#e4e4e7]">
        <time><?php echo get_the_date('Y年m月d日'); ?></time>
        <span>·</span>
        <span><?php the_author(); ?></span>
        <span>·</span>
        <span>約 <?php echo ceil(mb_strlen(strip_tags(get_the_content())) / 400); ?> 分</span>
    </div>
</div>

<!-- ─── サムネイル ─── -->
<?php if (has_post_thumbnail()) : ?>
<div class="max-w-3xl mx-auto px-6 mb-12">
    <div class="fade-up overflow-hidden rounded-xl border border-[#e4e4e7]">
        <?php the_post_thumbnail('large', ['class' => 'w-full h-auto']); ?>
    </div>
</div>
<?php endif; ?>

<!-- ─── 本文 ─── -->
<div class="max-w-3xl mx-auto px-6 pb-16">
    <div class="fade-up prose">
        <?php the_content(); ?>
    </div>
</div>

<!-- ─── タグ ─── -->
<?php $tags = get_the_tags(); if ($tags) : ?>
<div class="max-w-3xl mx-auto px-6 pb-12">
    <div class="fade-up pt-8 border-t border-[#e4e4e7] flex flex-wrap gap-2">
        <?php foreach ($tags as $tag) : ?>
        <a href="<?php echo get_tag_link($tag->term_id); ?>"
           class="text-xs border border-[#e4e4e7] text-[#71717a] px-3 py-1 rounded-full hover:border-[#d4d4d8] hover:text-[#09090b] transition-colors">
            #<?php echo esc_html($tag->name); ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ─── 前後ナビ ─── -->
<div class="max-w-3xl mx-auto px-6 pb-28 border-t border-[#e4e4e7] pt-12">
    <div class="fade-up grid grid-cols-1 md:grid-cols-2 gap-3">
        <?php $prev = get_previous_post(); if ($prev) : ?>
        <a href="<?php echo get_permalink($prev); ?>"
           class="group border border-[#e4e4e7] rounded-xl p-5 hover:border-[#d4d4d8] hover:bg-[#fafafa] transition-all duration-200">
            <p class="text-xs text-[#a1a1aa] mb-2">← 前の記事</p>
            <p class="text-sm font-medium text-[#52525b] group-hover:text-[#09090b] transition-colors leading-snug line-clamp-2">
                <?php echo esc_html($prev->post_title); ?>
            </p>
        </a>
        <?php else : ?><div></div><?php endif; ?>

        <?php $next = get_next_post(); if ($next) : ?>
        <a href="<?php echo get_permalink($next); ?>"
           class="group border border-[#e4e4e7] rounded-xl p-5 hover:border-[#d4d4d8] hover:bg-[#fafafa] transition-all duration-200 text-right">
            <p class="text-xs text-[#a1a1aa] mb-2">次の記事 →</p>
            <p class="text-sm font-medium text-[#52525b] group-hover:text-[#09090b] transition-colors leading-snug line-clamp-2">
                <?php echo esc_html($next->post_title); ?>
            </p>
        </a>
        <?php endif; ?>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
