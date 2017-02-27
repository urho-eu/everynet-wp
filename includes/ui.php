<?php
/**
 * UI functions
 *
 * Licensed under Expat License
 * See LICENSE in the root of the source tree
 *
 * Copyright (c) Ferenc Szekely <ferenc.szekely@urho.eu>
 *
 */
function add_styles()
{
  $filepath = plugins_url('../assets/css/everynet.css', __FILE__);
  wp_enqueue_style('everynet', $filepath, false);
}
add_action('init', 'add_styles');

function add_scripts()
{
  //$filepath = '/socket.io/socket.io.js';
  //wp_enqueue_script('socketio', $filepath, false);
}
add_action('wp_enqueue_scripts', 'add_scripts');

function custom_logout_url($default)
{
  $url = esc_html(site_url('logout/' . wp_create_nonce('log-out'), 'logout'));
  return $url;
}
add_filter('logout_url', 'custom_logout_url');
