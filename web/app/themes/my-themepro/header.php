<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white text-[#09090b]'); ?>>
<?php wp_body_open(); ?>

<header
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 }, { passive: true })"
    :class="scrolled ? 'border-b border-[#e4e4e7]' : 'border-b border-transparent'"
    class="fixed inset-x-0 top-0 z-50 bg-white/90 backdrop-blur-md transition-all duration-300"
>
    <div class="max-w-6xl mx-auto px-6 h-14 flex items-center justify-between">

        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-sm font-semibold text-[#09090b] tracking-tight">
            <?php bloginfo('name'); ?>
        </a>

        <nav class="hidden md:flex items-center gap-8">
            <a href="<?php echo esc_url(home_url('/')); ?>"      class="nav-link text-sm">ホーム</a>
            <a href="<?php echo esc_url(home_url('/blog')); ?>"  class="nav-link text-sm">ブログ</a>
            <a href="<?php echo esc_url(home_url('/about')); ?>" class="nav-link text-sm">About</a>
        </nav>

        <div class="hidden md:block">
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary">
                お問い合わせ
            </a>
        </div>

        <button @click="open = !open" class="md:hidden w-8 h-8 flex flex-col items-center justify-center gap-1.5" aria-label="メニュー">
            <span class="block w-5 h-px bg-[#09090b] transition-all duration-300 origin-center"
                  :class="open ? 'rotate-45 translate-y-[3px]' : ''"></span>
            <span class="block w-5 h-px bg-[#09090b] transition-all duration-300"
                  :class="open ? 'opacity-0' : ''"></span>
            <span class="block w-5 h-px bg-[#09090b] transition-all duration-300 origin-center"
                  :class="open ? '-rotate-45 -translate-y-[3px]' : ''"></span>
        </button>
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="md:hidden border-t border-[#e4e4e7] bg-white">
        <nav class="flex flex-col px-6 py-5 gap-4">
            <a href="<?php echo esc_url(home_url('/')); ?>"      @click="open=false" class="text-sm text-[#52525b] hover:text-[#09090b] transition-colors">ホーム</a>
            <a href="<?php echo esc_url(home_url('/blog')); ?>"  @click="open=false" class="text-sm text-[#52525b] hover:text-[#09090b] transition-colors">ブログ</a>
            <a href="<?php echo esc_url(home_url('/about')); ?>" @click="open=false" class="text-sm text-[#52525b] hover:text-[#09090b] transition-colors">About</a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" @click="open=false" class="text-sm text-[#52525b] hover:text-[#09090b] transition-colors">お問い合わせ</a>
        </nav>
    </div>
</header>
