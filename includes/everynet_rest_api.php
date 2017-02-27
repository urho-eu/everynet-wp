<?php
/**
 * everynet Rest API
 *
 * Licensed under Expat License
 * See LICENSE in the root of the source tree
 *
 * Copyright (c) Ferenc Szekely <ferenc.szekely@urho.eu>
 *
 */

/**
 * Rest API URL for GETs / POSTs
 */
function sanitize_rest_api_url()
{
  $api_url = 'https://api.everynet.com/1.0.2/';
  $preset = esc_url_raw(get_option('everynet_rest_url'));

  if (filter_var($preset, FILTER_VALIDATE_URL) === FALSE)
  {
    $preset = $api_url;
  }

  return $preset;
}

/**
 * Rest API keys
 */
function sanitize_rest_api_keys()
{
  $keys = ["0" => ["key" => "", "comment" => ""]];
  $preset = get_option('everynet_api_keys');
  $decoded = json_decode(base64_decode($preset), true);

  if ($decoded !== NULL && $decoded !== FALSE)
  {
    $keys = $decoded;
  }

  return $keys;
}
