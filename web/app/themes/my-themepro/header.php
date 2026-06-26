<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40 })"
    :class="scrolled ? 'border-b border-[#262626] bg-[#0a0a0a]/90 backdrop-blur-md' : 'border-b border-transparent'"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-500"
>
    <div class="max-w-6xl mx-auto px-6 h-14 flex items-center justify-between">

        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-sm font-semibold text-[#fafafa] tracking-tight">
            <?php bloginfo('name'); ?>
        </a>

        <!-- デスクトップナビ -->
        <nav class="hidden md:flex items-center gap-7">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-sm text-[#a1a1aa] hover:text-[#fafafa] transition-colors duration-200">ホーム</a>
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="text-sm text-[#a1a1aa] hover:text-[#fafafa] transition-colors duration-200">ブログ</a>
            <a href="<?php echo esc_url(home_url('/about')); ?>" class="text-sm text-[#a1a1aa] hover:text-[#fafafa] transition-colors duration-200">About</a>
        </nav>

        <div class="hidden md:flex items-center gap-3">
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="text-sm text-[#a1a1aa] hover:text-[#fafafa] transition-colors duration-200">お問い合わせ</a>
            <a href="<?php echo esc_url(home_url('/blog')); ?>" class="text-sm bg-[#fafafa] text-[#0a0a0a] font-medium px-4 py-1.5 rounded-full hover:bg-white transition-colors duration-200">
                記事を読む
            </a>
        </div>

        <!-- ハンバーガー -->
        <button @click="open = !open" class="md:hidden p-1.5 text-[#a1a1aa] hover:text-[#fafafa] transition-colors" aria-label="メニュー">
            <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- モバイルメニュー -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="md:hidden border-t border-[#262626] bg-[#0a0a0a]"
    >
        <nav class="flex flex-col px-6 py-5 gap-5">
            <a href="<?php echo esc_url(home_url('/')); ?>" @click="open=false" class="text-sm text-[#a1a1aa] hover:text-[#fafafa] transition-colors">ホーム</a>
            <a href="<?php echo esc_url(home_url('/blog')); ?>" @click="open=false" class="text-sm text-[#a1a1aa] hover:text-[#fafafa] transition-colors">ブログ</a>
            <a href="<?php echo esc_url(home_url('/about')); ?>" @click="open=false" class="text-sm text-[#a1a1aa] hover:text-[#fafafa] transition-colors">About</a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" @click="open=false" class="text-sm text-[#a1a1aa] hover:text-[#fafafa] transition-colors">お問い合わせ</a>
        </nav>
    </div>
</header>
