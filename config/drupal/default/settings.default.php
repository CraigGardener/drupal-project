<?php

/**
 * @file
 * Drupal site-specific configuration file for all environments.
 */


$databases['default']['default'] = array(
  'database' => isset($_ENV["DB_NAME"]) ? $_ENV["DB_NAME"] : 'drupal',
  'username' => isset($_ENV["DB_USER"]) ? $_ENV["DB_USER"] : 'drupal',
  'password' => isset($_ENV["DB_PASSWORD"]) ? $_ENV["DB_PASSWORD"] : 'drupal',
  'prefix' => isset($_ENV["DB_PREFIX"]) ? $_ENV["DB_PREFIX"] : '',
  'host' => isset($_ENV["DB_HOST"]) ? $_ENV["DB_HOST"] : 'mariadb',
  'port' => isset($_ENV["DB_PORT"]) ? $_ENV["DB_PORT"] : '3306',
  'driver' => isset($_ENV["DB_DRIVER"]) ? $_ENV["DB_DRIVER"] : 'mysql',
);

/**
 * Pantheon redirect
 */
if (isset($_ENV['PANTHEON_ENVIRONMENT']) && php_sapi_name() != 'cli') {
  // Redirect to https://$primary_domain in the Live environment
  if ($_ENV['PANTHEON_ENVIRONMENT'] === 'live') {
    /** Replace www.example.com with your registered domain name */
    $primary_domain = 'developer.navico.com';
  }
  else {
    // Redirect to HTTPS on every Pantheon environment.
    $primary_domain = $_SERVER['HTTP_HOST'];
  }

  if ($_SERVER['HTTP_HOST'] != $primary_domain || !isset($_SERVER['HTTP_USER_AGENT_HTTPS']) || $_SERVER['HTTP_USER_AGENT_HTTPS'] != 'ON' ) {

    # Name transaction "redirect" in New Relic for improved reporting (optional)
    if (extension_loaded('newrelic')) {
      newrelic_name_transaction("redirect");
    }

    header('HTTP/1.0 301 Moved Permanently');
    header('Location: https://'. $primary_domain . $_SERVER['REQUEST_URI']);
    exit();
  }
}

/**
 * Access control for update.php script.
 *
 * If you are updating your Drupal installation using the update.php script but
 * are not logged in using either an account with the "Administer software
 * updates" permission or the site maintenance account (the account that was
 * created during installation), you will need to modify the access check
 * statement below. Change the FALSE to a TRUE to disable the access check.
 * After finishing the upgrade, be sure to open this file again and change the
 * TRUE back to a FALSE!
 */
$settings['update_free_access'] = TRUE;

/**
 * Public file path:
 *
 * A local file system path where public files will be stored. This directory
 * must exist and be writable by Drupal. This directory must be relative to
 * the Drupal installation directory and be accessible over the web.
 */

$settings['file_public_path'] = 'sites/' . $site_name . '/files';

/**
 * Private file path:
 *
 * A local file system path where private files will be stored. This directory
 * must be absolute, outside of the Drupal installation directory and not
 * accessible over the web.
 *
 * Note: Caches need to be cleared when this value is changed to make the
 * private:// stream wrapper available to the system.
 *
 * See https://www.drupal.org/documentation/modules/file for more information
 * about securing private files.
 */

$settings['file_private_path'] = '../data/drupal/' . $site_name . '/private';
