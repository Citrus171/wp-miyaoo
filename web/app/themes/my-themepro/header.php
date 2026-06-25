<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white text-gray-800'); ?>>
<?php wp_body_open(); ?>

<header
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
    :class="scrolled ? 'shadow-md bg-white/95 backdrop-blur-sm' : 'bg-white'"
    class="sticky top-0 z-50 transition-all duration-300"
>
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">

        <!-- ロゴ -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl font-bold text-indigo-600 tracking-tight">
            <?php bloginfo('name'); ?>
        </a>

        <!-- デスクトップナビ -->
        <nav class="hidden md:flex items-center gap-8">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">ホーム</a>
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">ブログ</a>
            <a href="<?php echo esc_url(home_url('/about')); ?>" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors">About</a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="text-sm font-medium bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition-colors">お問い合わせ</a>
        </nav>

        <!-- ハンバーガーボタン -->
        <button @click="open = !open" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors" aria-label="メニュー">
            <span class="block w-6 h-0.5 bg-gray-700 transition-all duration-300" :class="open ? 'rotate-45 translate-y-1.5' : ''"></span>
            <span class="block w-6 h-0.5 bg-gray-700 mt-1.5 transition-all duration-300" :class="open ? 'opacity-0' : ''"></span>
            <span class="block w-6 h-0.5 bg-gray-700 mt-1.5 transition-all duration-300" :class="open ? '-rotate-45 -translate-y-1.5' : ''"></span>
        </button>
    </div>

    <!-- モバイルドロワー -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden border-t border-gray-100"
    >
        <nav class="flex flex-col px-4 py-4 gap-4 bg-white">
            <a href="<?php echo esc_url(home_url('/')); ?>" @click="open = false" class="text-gray-700 font-medium hover:text-indigo-600 transition-colors">ホーム</a>
            <a href="<?php echo esc_url(home_url('/blog')); ?>" @click="open = false" class="text-gray-700 font-medium hover:text-indigo-600 transition-colors">ブログ</a>
            <a href="<?php echo esc_url(home_url('/about')); ?>" @click="open = false" class="text-gray-700 font-medium hover:text-indigo-600 transition-colors">About</a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" @click="open = false" class="w-full text-center bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition-colors">お問い合わせ</a>
        </nav>
    </div>
</header>
