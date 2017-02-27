<?php
/**
 * Plugin settings page
 *
 * Licensed under Expat License
 * See LICENSE in the root of the source tree
 *
 * Copyright (c) Ferenc Szekely <ferenc.szekely@urho.eu>
 *
 */
function settings_page()
{
  function add_page_scripts()
  {
    $filepath = plugins_url('../assets/js/settings_page.js', __FILE__);
    wp_enqueue_script('settings_page_js', $filepath, false);
  }
  /* load the JS */
  add_action('admin_enqueue_scripts', 'add_page_scripts');

  /**
   *
   */
  function everynet_api_settings()
  {
    $email = null;
    $feedback = ['status' => 'hidden', 'message' => ''];
    $core_url = null;
    $current_user = wp_get_current_user();

    // sanitize POSTs
    if (isset($_POST, $_POST['plugin_settings']))
    {
      // sanitize and validate core api_url
      // 1. it must be a valid URL
      // 2. length: max 255 bytes
      if (isset($_POST['plugin_settings']['everynet_core_url']))
      {
        $raw = esc_url_raw($_POST['plugin_settings']['everynet_core_url']);

        $sanitized = filter_var($raw, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
        if ($sanitized !== FALSE && strlen($sanitized) <= 255)
        {
          $core_url = $sanitized;
          update_option('everynet_core_url', $core_url);
        }
      }

      // sanitize and validate rest api_url
      // 1. it must be a valid URL
      // 2. length: max 255 bytes
      if (isset($_POST['plugin_settings']['everynet_rest_url']))
      {
        $raw = esc_url_raw($_POST['plugin_settings']['everynet_rest_url']);

        $sanitized = filter_var($raw, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
        if ($sanitized !== FALSE && strlen($sanitized) <= 255)
        {
          $rest_url = $sanitized;
          update_option('everynet_rest_url', $rest_url);
        }
      }

      // sanitize and validate rest api keys array
      // an example key
      // 1234-123456-ABC5ERT2FSX9-ABC8NH65DGBM-ABCFF9QFN1SN-000ABC128000-12345
      // 1. preflight: check key length == 69; comment <= 20
      // 2. json encode
      // 3. base64 encode
      if (is_array($_POST['plugin_settings']['everynet_api_keys']))
      {
        $clean = true;
        $preflight = [];
        $feedback = ['status' => 'ok', 'message' => __('keys ok', L10N_DOMAIN)];

        foreach ($_POST['plugin_settings']['everynet_api_keys'] as $index => $value)
        {
          $pattern = '/^[A-Z0-9]{4}-[A-Z0-9]{6}-([A-Z0-9]{12}-){4}[A-Z0-9]{5}$/';

          if (preg_match($pattern, $value["key"]) === 1)
          {
            // cut the comment to 20 bytes max
            $preflight[] = ["key" => $value["key"], "comment" => substr(trim($value["comment"]), 0, 20)];
          }
          else
          {
            $clean = false;
          }
        }

        if ($clean == false)
        {
          $feedback = ['status' => 'nok', 'message' => __('wrong key format', L10N_DOMAIN)];
        }

        if (count($preflight) > 0)
        {
          $raw = json_encode($preflight, JSON_FORCE_OBJECT);
          $encoded = base64_encode($raw);
          update_option('everynet_api_keys', $encoded);
        }
      }
    }

    // display values for GETs
    $settings = array(
      'everynet_core_url' => sanitize_core_api_url(),
      'everynet_rest_url' => sanitize_rest_api_url(),
      'everynet_api_keys' => sanitize_rest_api_keys(),
      'feedback' => $feedback
    );

    include plugin_dir_path(__FILE__) . '../templates/settings.php';
  }

  add_options_page(
    'everynet API',
    'everynet API',
    'manage_options',
    'everynet_api_settings',
    'everynet_api_settings'
  );
}
add_action('admin_menu', 'settings_page');

?>
