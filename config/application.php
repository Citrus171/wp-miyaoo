<?php

use Roots\WPConfig\Config;
use function Env\env;

$root_dir = dirname(__DIR__);
$webroot_dir = $root_dir . '/web';

if (file_exists($root_dir . '/.env')) {
    $env_files = file_exists($root_dir . '/.env.local')
        ? ['.env', '.env.local']
        : ['.env'];

    $dotenv = Dotenv\Dotenv::createUnsafeImmutable($root_dir, $env_files, false);
    $dotenv->safeLoad();
}

define('WP_ENV', env('WP_ENV') ?: 'production');

if (!env('WP_ENVIRONMENT_TYPE') && in_array(WP_ENV, ['development', 'staging', 'production'])) {
    Config::define('WP_ENVIRONMENT_TYPE', WP_ENV);
}

Config::define('WP_HOME', env('WP_HOME'));
Config::define('WP_SITEURL', env('WP_SITEURL') ?: env('WP_HOME') . '/wp');

Config::define('CONTENT_DIR', '/app');
Config::define('WP_CONTENT_DIR', $webroot_dir . '/app');
Config::define('WP_CONTENT_URL', Config::get('WP_HOME') . '/app');

if (env('DATABASE_URL')) {
    $dsn = (object) parse_url(env('DATABASE_URL'));
    Config::define('DB_NAME', ltrim($dsn->path, '/'));
    Config::define('DB_USER', $dsn->user);
    Config::define('DB_PASSWORD', $dsn->pass ?? null);
    Config::define('DB_HOST', isset($dsn->port) ? "{$dsn->host}:{$dsn->port}" : $dsn->host);
} else {
    Config::define('DB_NAME', env('DB_NAME'));
    Config::define('DB_USER', env('DB_USER'));
    Config::define('DB_PASSWORD', env('DB_PASSWORD'));
    Config::define('DB_HOST', env('DB_HOST') ?: 'localhost');
}
Config::define('DB_CHARSET', 'utf8mb4');
Config::define('DB_COLLATE', '');
$table_prefix = env('DB_PREFIX') ?: 'wp_';

Config::define('AUTH_KEY',         env('AUTH_KEY'));
Config::define('SECURE_AUTH_KEY',  env('SECURE_AUTH_KEY'));
Config::define('LOGGED_IN_KEY',    env('LOGGED_IN_KEY'));
Config::define('NONCE_KEY',        env('NONCE_KEY'));
Config::define('AUTH_SALT',        env('AUTH_SALT'));
Config::define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
Config::define('LOGGED_IN_SALT',   env('LOGGED_IN_SALT'));
Config::define('NONCE_SALT',       env('NONCE_SALT'));

Config::define('AUTOMATIC_UPDATER_DISABLED', true);
Config::define('DISABLE_WP_CRON', env('DISABLE_WP_CRON') ?: false);
Config::define('DISALLOW_FILE_EDIT', true);
Config::define('DISALLOW_FILE_MODS', false);

Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', env('WP_DEBUG_LOG') ?? false);
ini_set('display_errors', '0');

$env_config = $root_dir . '/config/environments/' . WP_ENV . '.php';
if (file_exists($env_config)) {
    require_once $env_config;
}

if (!defined('ABSPATH')) {
    define('ABSPATH', $webroot_dir . '/wp/');
}

Config::apply();
