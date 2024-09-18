<?php

add_filter('wpacu_critical_css', function ($args) {
  global $post;

  $account_css_content = '';

  if (isset($post->ID) && $post->ID == 8) {
    $account_css_content = path() . 'assets/css/account-critical.min.css';
    $args['content'] = file_get_contents($account_css_content);
    $args['minify'] = false; // if possible, have it already minified to save resources
  }
  if (isset($post->ID) && ($post->ID == 6 || $post->ID == 4639 || $post->ID == 8014)) {
    $account_css_content = path() . 'assets/css/cart-critical.min.css';
    $args['content'] = file_get_contents($account_css_content);
    $args['minify'] = false; // if possible, have it already minified to save resources
  }
  if (isset($post->ID) && $post->ID == 98) {
    $account_css_content = path() . 'assets/css/wishlist-critical.min.css';
    $args['content'] = file_get_contents($account_css_content);
    $args['minify'] = false; // if possible, have it already minified to save resources
  }
  if (isset($post->ID) && $post->ID == 81) {
    $account_css_content = path() . 'assets/css/contact-us-critical.min.css';
    $args['content'] = file_get_contents($account_css_content);
    $args['minify'] = false; // if possible, have it already minified to save resources
  }
  if (isset($post->ID) && is_front_page()) {
    $account_css_content = path() . 'assets/css/homepage-critical.min.css';
    $args['content'] = file_get_contents($account_css_content);
    $args['minify'] = false; // if possible, have it already minified to save resources
  }
  if (function_exists('is_product') && is_product()) {
    $account_css_content = path() . 'assets/css/product-critical.min.css';
    $args['content'] = file_get_contents($account_css_content);
    return $args;
  }

  return $args;
}, 11);