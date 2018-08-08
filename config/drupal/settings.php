<?php

/**
 * @file
 * Drupal site-specific configuration file.
 */

$site_name = basename($site_path);
$config_dir = $app_root . '/../config/drupal/' . $site_name . '/';

if (isset($_ENV["DRUPAL_ENVIRONMENT"])) {
  $env = $_ENV["DRUPAL_ENVIRONMENT"];
}

/**
 * Require default configuration files.
 */
require_once $config_dir . 'settings.database.default.php';
require_once $config_dir . 'settings.default.php';

/**
 * Require environment-specific configuration files.
 */
if (isset($env)) {
  if (file_exists($config_dir . 'settings.database.' . $env . '.php')) {
    require_once $config_dir . 'settings.database.' . $env . '.php';
  }
  if (file_exists($config_dir . 'settings.' . $env . '.php')) {
    require_once $config_dir . 'settings.' . $env . '.php';
  }
}

/**
 * Load services definition files.
 */
if (file_exists($config_dir . 'services.default.yml')) {
  $settings['container_yamls'][] = $config_dir . 'services.default.yml';
}
if (file_exists($config_dir . 'services.' . $env . 'yml')) {
  $settings['container_yamls'][] = $config_dir . 'services.' . $env . 'yml';
}

/**
 * Salt for one-time login links, cancel links, form tokens, etc.
 */
$settings['hash_salt'] = file_get_contents($config_dir . 'salt.txt');
