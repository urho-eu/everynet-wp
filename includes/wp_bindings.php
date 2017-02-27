<?php
/**
 * Wordpress bindings
 *
 * Licensed under Expat License
 * See LICENSE in the root of the source tree
 *
 * Copyright (c) Ferenc Szekely <ferenc.szekely@urho.eu>
 *
 */
define("L10N_DOMAIN", "everynet");

function mywp_random_string($length)
{
  $result = '';
  $list = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

  for ($i = 0; $i < $length; $i++)
  {
    $result .= $list[rand(0, strlen($list) - 1)];
  }

  return $result;
}

function mywp_user_exists($id)
{
  $user = get_user_by('login', $id);
  return $user !== false;
}

