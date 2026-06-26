<footer class="border-t border-[#262626] bg-[#0a0a0a]">
    <div class="max-w-6xl mx-auto px-6 py-16">
        <div class="flex flex-col md:flex-row items-start justify-between gap-12 mb-16">

            <!-- ブランド -->
            <div class="max-w-xs">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-sm font-semibold text-[#fafafa] mb-3 block">
                    <?php bloginfo('name'); ?>
                </a>
                <p class="text-xs text-[#52525b] leading-relaxed"><?php bloginfo('description'); ?></p>
            </div>

            <!-- リンク -->
            <div class="flex gap-16">
                <div>
                    <p class="text-xs font-semibold tracking-widest uppercase text-[#3f3f46] mb-5">Pages</p>
                    <ul class="space-y-3">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>" class="text-xs text-[#71717a] hover:text-[#fafafa] transition-colors">ホーム</a></li>
                        <li><a href="<?php echo esc_url(home_url('/blog')); ?>" class="text-xs text-[#71717a] hover:text-[#fafafa] transition-colors">ブログ</a></li>
                        <li><a href="<?php echo esc_url(home_url('/about')); ?>" class="text-xs text-[#71717a] hover:text-[#fafafa] transition-colors">About</a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="text-xs text-[#71717a] hover:text-[#fafafa] transition-colors">お問い合わせ</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-xs font-semibold tracking-widest uppercase text-[#3f3f46] mb-5">More</p>
                    <ul class="space-y-3">
                        <li><a href="<?php echo esc_url(home_url('/feed')); ?>" class="text-xs text-[#71717a] hover:text-[#fafafa] transition-colors">RSS</a></li>
                        <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="text-xs text-[#71717a] hover:text-[#fafafa] transition-colors">プライバシー</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border-t border-[#171717] pt-8">
            <p class="text-xs text-[#3f3f46]">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
