<footer class="border-t border-[#e4e4e7] bg-white">
    <div class="max-w-6xl mx-auto px-6 py-16">

        <div class="flex flex-col md:flex-row items-start justify-between gap-12 mb-16">
            <div class="max-w-xs">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-sm font-semibold text-[#09090b] block mb-2">
                    <?php bloginfo('name'); ?>
                </a>
                <p class="text-xs text-[#a1a1aa] leading-relaxed"><?php bloginfo('description'); ?></p>
            </div>

            <div class="flex gap-16 text-sm">
                <div>
                    <p class="text-xs font-semibold tracking-widest uppercase text-[#d4d4d8] mb-4">Pages</p>
                    <ul class="space-y-3">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"      class="text-xs text-[#71717a] hover:text-[#09090b] transition-colors">ホーム</a></li>
                        <li><a href="<?php echo esc_url(home_url('/blog')); ?>"  class="text-xs text-[#71717a] hover:text-[#09090b] transition-colors">ブログ</a></li>
                        <li><a href="<?php echo esc_url(home_url('/about')); ?>" class="text-xs text-[#71717a] hover:text-[#09090b] transition-colors">概要</a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="text-xs text-[#71717a] hover:text-[#09090b] transition-colors">お問い合わせ</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-xs font-semibold tracking-widest uppercase text-[#d4d4d8] mb-4">More</p>
                    <ul class="space-y-3">
                        <li><a href="<?php echo esc_url(home_url('/feed')); ?>"           class="text-xs text-[#71717a] hover:text-[#09090b] transition-colors">RSS</a></li>
                        <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="text-xs text-[#71717a] hover:text-[#09090b] transition-colors">プライバシー</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-[#f4f4f5]">
            <p class="text-xs text-[#d4d4d8]">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
