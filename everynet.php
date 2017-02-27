<?php
/**
 * @package everynet API Plugin for Wordpress
 * @version 0.1
 *
 * Licensed under Expat License
 * See LICENSE in the root of the source tree
 *
 * Copyright (c) Ferenc Szekely <ferenc.szekely@urho.eu>
 *
 */
/*
Plugin Name: everynet API
Plugin URI: http://wordpress.org/plugins/everynet_api/
Description: everynet API Plugin for Wordpress
Version: 0.1
Author: Ferenc Szekely (ferenc.szekely@gmail.com)
*/

include plugin_dir_path(__FILE__) . 'includes/wp_bindings.php';
include plugin_dir_path(__FILE__) . 'includes/everynet_core_api.php';
include plugin_dir_path(__FILE__) . 'includes/everynet_rest_api.php';

/**
 * Language files
 */
function load_locales()
{
  $locale = apply_filters('plugin_locale', get_locale(), L10N_DOMAIN);
  load_plugin_textdomain(L10N_DOMAIN, FALSE, plugin_basename(dirname(__FILE__)) . '/languages/');
}
add_action('init', 'load_locales');

/**
 * Hook this to the activation phase
 */
function plugin_activate()
{
}
register_activation_hook(__FILE__, 'plugin_activate');

/**
 * Redirect to the Settings page upon succesful activation
 */
function plugin_redirect()
{
  if (get_option('plugin_do_activation_redirect', false))
  {
    delete_option('plugin_do_activation_redirect');
    if( ! isset($_GET['activate-multi']))
    {
      wp_redirect('/wp-admin/options-general.php?page=everynet_api_settings');
    }
  }
}
add_action('admin_init', 'plugin_redirect');

/**
 * Links to the Settings menu
 */
function plugin_add_setup_link($links, $file)
{
  static $plugin = null;

  if (is_null ($plugin))
  {
    $plugin = plugin_basename(__FILE__);
  }

  if ($file == $plugin)
  {
    $settings_link = '<a href="options-general.php?page=everynet_api_settings">' . __('Setup', L10N_DOMAIN) . '</a>';
    $links[] = $settings_link;
  }
  return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'plugin_add_setup_link', 10, 2);

include __DIR__ . '/includes/settings_page.php';

/**
 * Where it all begins; hooked to the init phase
 */
function start()
{
  $token = $current_user = false;

  if (session_status() != PHP_SESSION_ACTIVE)
  {
    session_start();
  }

  if (is_user_logged_in())
  {
    $current_user = wp_get_current_user();
  }

  if ($current_user)
  {
    if (! is_super_admin($current_user->ID))
    {
      //logout from Wordpress
      wp_logout();
      header('Location: /exit');
      exit;
    }
  }

  return;
}
add_action('init', 'start');

/**
 * Internal method for auto reloading pages in certain cases
 */
function redirect_if_needed()
{
  // check if redirect is requested
  $url = '';

  if (isset($_COOKIE['redirect']))
  {
    $url = $_COOKIE['redirect'];
    setcookie('redirect', '', time() - 3600); /* delete */
  }
  else
  {
    if (isset($_GET['redirect_to']))
    {
      $url = $_GET['redirect_to'];
    }
  }

  if (strlen($url) > 1)
  {
    wp_safe_redirect(admin_url($url), 301);
    exit;
  }
}

include plugin_dir_path(__FILE__) . 'includes/ui.php';
