<footer class="bg-gray-900 text-gray-400">
    <div class="max-w-6xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">

            <!-- ブランド -->
            <div>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl font-bold text-white mb-3 block">
                    <?php bloginfo('name'); ?>
                </a>
                <p class="text-sm leading-relaxed"><?php bloginfo('description'); ?></p>
            </div>

            <!-- ナビ -->
            <div>
                <h3 class="text-white font-semibold mb-4 text-sm tracking-widest uppercase">Navigation</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-white transition-colors">ホーム</a></li>
                    <li><a href="<?php echo esc_url(home_url('/blog')); ?>" class="hover:text-white transition-colors">ブログ</a></li>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>" class="hover:text-white transition-colors">About</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="hover:text-white transition-colors">お問い合わせ</a></li>
                </ul>
            </div>

            <!-- フィード -->
            <div>
                <h3 class="text-white font-semibold mb-4 text-sm tracking-widest uppercase">Subscribe</h3>
                <p class="text-sm mb-4">RSSフィードで最新記事を受け取る</p>
                <a href="<?php echo esc_url(home_url('/feed')); ?>" class="inline-flex items-center gap-2 text-sm bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <span>RSS</span> <span class="text-orange-400">●</span> フィード
                </a>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="hover:text-white transition-colors">プライバシーポリシー</a>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
