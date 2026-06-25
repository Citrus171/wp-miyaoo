<?php

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

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    load_theme_textdomain('my-themepro', get_template_directory() . '/languages');
});
