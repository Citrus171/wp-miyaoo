<?php get_header(); ?>

<!-- ─── Hero ─── -->
<section class="relative grid-bg min-h-screen flex items-center justify-center overflow-hidden">
    <!-- ラジアルグロー -->
    <div class="pointer-events-none absolute inset-0 flex items-center justify-center">
        <div class="w-[600px] h-[600px] rounded-full" style="background: radial-gradient(circle, rgba(139,92,246,0.12) 0%, transparent 70%);"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-6 pt-32 pb-24 text-center">
        <div class="fade-up inline-flex items-center gap-2 border border-[#262626] bg-[#111111] text-[#a1a1aa] text-xs px-3 py-1.5 rounded-full mb-8">
            <span class="w-1.5 h-1.5 rounded-full bg-[#8b5cf6]"></span>
            新しい記事を公開しました
        </div>

        <h1 class="fade-up text-5xl md:text-7xl font-bold text-[#fafafa] leading-[1.1] tracking-tight mb-6">
            思考を整理し、<br>知識を届ける。
        </h1>

        <p class="fade-up text-lg md:text-xl text-[#71717a] max-w-xl mx-auto mb-10 leading-relaxed">
            テクノロジー・デザイン・日々の発見を<br class="hidden md:block">丁寧に言語化するブログ。
        </p>

        <div class="fade-up flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="bg-[#fafafa] text-[#0a0a0a] font-semibold text-sm px-6 py-2.5 rounded-full hover:bg-white transition-all duration-200 hover:-translate-y-px">
                記事を読む
            </a>
            <a href="<?php echo esc_url(home_url('/about')); ?>" class="border border-[#262626] text-[#a1a1aa] font-medium text-sm px-6 py-2.5 rounded-full hover:border-[#3f3f46] hover:text-[#fafafa] transition-all duration-200">
                About →
            </a>
        </div>
    </div>

    <!-- 下グラデーション -->
    <div class="absolute inset-x-0 bottom-0 h-32 pointer-events-none" style="background: linear-gradient(to bottom, transparent, #0a0a0a);"></div>
</section>

<!-- ─── Features ─── -->
<section class="py-32 bg-[#0a0a0a]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="fade-up text-center mb-20">
            <p class="text-xs font-semibold tracking-widest uppercase text-[#52525b] mb-3">Features</p>
            <h2 class="text-3xl md:text-4xl font-bold text-[#fafafa] tracking-tight">このブログについて</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-[#262626]">
            <?php
            $features = [
                ['icon' => '◈', 'title' => 'Deep Dive', 'desc' => '表面だけでなく、背景にある考え方や設計思想まで掘り下げて書いています。'],
                ['icon' => '◇', 'title' => 'Minimal Writing', 'desc' => '余分な言葉を削ぎ落とし、伝えたいことだけを簡潔に。読む時間を大切にします。'],
                ['icon' => '◎', 'title' => 'Practical', 'desc' => '実際に試した・使ったものだけを書く。再現性のある情報をお届けします。'],
            ];
            foreach ($features as $f) : ?>
            <div class="fade-up bg-[#0a0a0a] p-8 hover:bg-[#111111] transition-colors duration-300 group">
                <div class="text-2xl text-[#52525b] group-hover:text-[#8b5cf6] transition-colors duration-300 mb-5"><?php echo $f['icon']; ?></div>
                <h3 class="text-[#fafafa] font-semibold text-sm mb-3"><?php echo $f['title']; ?></h3>
                <p class="text-[#71717a] text-sm leading-relaxed"><?php echo $f['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ─── Latest Posts ─── -->
<section class="py-32 border-t border-[#262626]">
    <div class="max-w-6xl mx-auto px-6">
        <div class="fade-up flex items-end justify-between mb-16">
            <div>
                <p class="text-xs font-semibold tracking-widest uppercase text-[#52525b] mb-3">Latest</p>
                <h2 class="text-3xl md:text-4xl font-bold text-[#fafafa] tracking-tight">最新の記事</h2>
            </div>
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="hidden md:inline-flex text-sm text-[#a1a1aa] hover:text-[#fafafa] transition-colors items-center gap-1">
                すべて見る <span>→</span>
            </a>
        </div>

        <div class="space-y-px bg-[#262626]">
            <?php
            $posts = new WP_Query(['posts_per_page' => 5, 'post_status' => 'publish']);
            if ($posts->have_posts()) :
                while ($posts->have_posts()) : $posts->the_post(); ?>
                <article class="fade-up bg-[#0a0a0a] hover:bg-[#111111] transition-colors duration-200 group">
                    <a href="<?php the_permalink(); ?>" class="flex items-start md:items-center justify-between gap-6 px-6 py-6">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <time class="text-xs text-[#52525b]"><?php echo get_the_date('Y.m.d'); ?></time>
                                <?php
                                $cats = get_the_category();
                                if ($cats) : ?>
                                <span class="text-xs border border-[#262626] text-[#71717a] px-2 py-0.5 rounded-full"><?php echo esc_html($cats[0]->name); ?></span>
                                <?php endif; ?>
                            </div>
                            <h3 class="text-[#fafafa] font-medium text-base leading-snug group-hover:text-white truncate">
                                <?php the_title(); ?>
                            </h3>
                        </div>
                        <span class="text-[#3f3f46] group-hover:text-[#a1a1aa] transition-colors shrink-0 text-lg">→</span>
                    </a>
                </article>
                <?php endwhile; wp_reset_postdata();
            endif; ?>
        </div>

        <div class="fade-up text-center mt-12 md:hidden">
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="text-sm text-[#a1a1aa] hover:text-[#fafafa] transition-colors">すべての記事 →</a>
        </div>
    </div>
</section>

<!-- ─── CTA ─── -->
<section class="py-32 border-t border-[#262626]">
    <div class="max-w-3xl mx-auto px-6 text-center">
        <div class="fade-up">
            <h2 class="text-4xl md:text-5xl font-bold text-[#fafafa] tracking-tight mb-5 leading-tight">
                何かあれば<br>気軽にどうぞ。
            </h2>
            <p class="text-[#71717a] text-lg mb-10">
                フィードバック・質問・コラボ相談、なんでも歓迎します。
            </p>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="inline-flex items-center gap-2 bg-[#fafafa] text-[#0a0a0a] font-semibold text-sm px-8 py-3 rounded-full hover:bg-white transition-all duration-200 hover:-translate-y-px">
                お問い合わせ <span>→</span>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
