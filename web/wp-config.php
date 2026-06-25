<?php
ob_start();
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/application.php';

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
