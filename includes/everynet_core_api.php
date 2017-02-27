<?php
/**
 * everynet Core API
 *
 * Licensed under Expat License
 * See LICENSE in the root of the source tree
 *
 * Copyright (c) Ferenc Szekely <ferenc.szekely@urho.eu>
 *
 */

/**
 * Core API URL for GETs / POSTs
 */
function sanitize_core_api_url()
{
  $api_url = 'https://core.eu-west-1.everynet.io/v1/rpc';
  $preset = esc_url_raw(get_option('everynet_core_url'));

  if (filter_var($preset, FILTER_VALIDATE_URL) === FALSE)
  {
    $preset = $api_url;
  }

  return $preset;
}

