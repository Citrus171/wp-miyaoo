<?php
ob_start();
define('WP_USE_THEMES', true);
require __DIR__ . '/wp/wp-blog-header.php';
ob_end_flush();
