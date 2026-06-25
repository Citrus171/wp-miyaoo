<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'my-themepro-style',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        '1.0.0'
    );

    wp_enqueue_script(
        'my-themepro-script',
        get_template_directory_uri() . '/assets/js/main.js',
        ['jquery'],
        '1.0.0',
        true
    );
});

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    load_theme_textdomain('my-themepro', get_template_directory() . '/languages');
});
