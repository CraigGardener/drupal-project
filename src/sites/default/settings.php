<?php

/**
 * @file
 * Drupal site-specific configuration file.
 */

$site_name = basename(conf_path());
$config_dir = DRUPAL_ROOT . '/../config/drupal/' . $site_name . '/';
$files_dir = DRUPAL_ROOT . '/../files/drupal/' . $site_name . '/';

if (isset($_ENV["DRUPAL_ENVIRONMENT"])) {
  $env = $_ENV["DRUPAL_ENVIRONMENT"];
}

/**
 * Require default configuration files.
 */
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
 * Salt for one-time login links, cancel links, form tokens, etc.
 */
$settings['hash_salt'] = file_get_contents($files_dir . 'salt.txt');
