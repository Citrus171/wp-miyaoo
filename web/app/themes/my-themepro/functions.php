<?php

// ─── アセット読み込み ───────────────────────────────────────
add_action('wp_enqueue_scripts', function () {
    $build_dir = get_template_directory() . '/build';
    $build_uri = get_template_directory_uri() . '/build';

    $css_file = $build_dir . '/assets/css/main.css';
    if (file_exists($css_file)) {
        wp_enqueue_style('my-themepro-style', $build_uri . '/assets/css/main.css', [], filemtime($css_file));
    }

    $js_file = $build_dir . '/assets/js/main.js';
    if (file_exists($js_file)) {
        wp_enqueue_script('my-themepro-script', $build_uri . '/assets/js/main.js', [], filemtime($js_file), true);
    }
});

// ─── ページ別JS（React） ───────────────────────────────────
add_action('wp_enqueue_scripts', function () {
    if (!is_page_template('page-react.php')) return;
    $build_dir = get_template_directory() . '/build';
    $build_uri = get_template_directory_uri() . '/build';
    $js = $build_dir . '/assets/js/react.js';
    if (file_exists($js)) {
        wp_enqueue_script('react-demo', $build_uri . '/assets/js/react.js', [], filemtime($js), true);
    }
});

// Vite の ES module バンドルを type="module" で読み込む（スコープ分離）
add_filter('script_loader_tag', function (string $tag, string $handle): string {
    if (in_array($handle, ['my-themepro-script', 'react-demo'], true)) {
        return str_replace('<script ', '<script type="module" ', $tag);
    }
    return $tag;
}, 10, 2);

// ─── テーマサポート ────────────────────────────────────────
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    load_theme_textdomain('my-themepro', get_template_directory() . '/languages');
});

// ─── 1. X-Pingback ヘッダーを削除 ────────────────────────
add_filter('wp_headers', function ($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

// ─── 2. Contact Form 7 のJS/CSSをお問い合わせページのみに限定 ──
add_filter('wpcf7_load_js', '__return_false');
add_filter('wpcf7_load_css', '__return_false');

add_action('wp_enqueue_scripts', function () {
    if (is_page('contact')) {
        wpcf7_enqueue_scripts();
        wpcf7_enqueue_styles();
    }
});

// ─── 4. OGP / meta description ────────────────────────────
add_action('wp_head', function () {
    global $post;

    $site_name  = get_bloginfo('name');
    $site_url   = home_url('/');

    // タイトル
    if (is_singular() && isset($post)) {
        $title = get_the_title($post->ID) . ' - ' . $site_name;
    } elseif (is_home() || is_front_page()) {
        $title = $site_name . ' - ' . get_bloginfo('description');
    } else {
        $title = wp_title('', false) . ' - ' . $site_name;
    }

    // description
    if (is_singular() && isset($post)) {
        $desc = mb_strimwidth(strip_tags(get_the_excerpt() ?: $post->post_content), 0, 120, '…');
    } else {
        $desc = mb_strimwidth(get_bloginfo('description'), 0, 120, '…');
    }

    // OGP画像（アイキャッチ → デフォルト）
    if (is_singular() && isset($post) && has_post_thumbnail($post->ID)) {
        $img = get_the_post_thumbnail_url($post->ID, 'large');
    } else {
        $img = '';
    }

    // OGP type
    $type = is_singular() ? 'article' : 'website';

    // 現在のURL
    $url = is_singular() ? get_permalink() : (is_home() ? $site_url : get_pagenum_link());

    echo '<meta name="description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($type) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";
    if ($img) {
        echo '<meta property="og:image" content="' . esc_url($img) . '">' . "\n";
    }
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($desc) . '">' . "\n";
    if ($img) {
        echo '<meta name="twitter:image" content="' . esc_url($img) . '">' . "\n";
    }
}, 1);
