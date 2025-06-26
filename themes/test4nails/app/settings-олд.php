<?php

/*
 * filters and settings
 */


/* ACF option page*/
if (function_exists('acf_add_options_page')) {
  $main = acf_add_options_page([
    'page_title' => 'Settings',
    'menu_title' => 'Settings',
    'menu_slug' => 'theme-general-settings',
    'capability' => 'edit_posts',
    'redirect' => false,
    'position' => 2,
    'icon_url' => 'dashicons-hammer',
  ]);
}
$path = get_template_directory() . '/assets/acf-json';
add_filter('acf/settings/save_json', function () use ($path) {
  return $path;
});
add_filter('acf/settings/load_json', function () use ($path) {
  return [$path];
});


add_theme_support('menus');

/* Add active to current menu*/
add_filter('nav_menu_css_class', function ($classes, $item) {
  if (in_array('current-menu-item', $classes)) {
    $classes[] = 'active ';
  }
  return $classes;
}, 10, 2);

/* Images sizes */
add_image_size('4nails_category_product', 258, 258, true);
add_image_size('product_mobile', 360, 161, true);
add_image_size('product_cat', 88, 88);
add_image_size('blog_image', 364, 180);

add_action('after_setup_theme', 'true_add_image_size');

function true_add_image_size()
{
  add_image_size('blog-size', 870, 400, true);
}
add_filter('image_size_names_choose', 'true_new_image_sizes');

function true_new_image_sizes($sizes)
{

  $addsizes = array(
    'blog-size' => 'Blog image'
  );
  return array_merge($sizes, $addsizes);

}
/*Количество товара на странице || Count of products on page*/
add_filter('loop_shop_per_page', function ($cols) {
  return 300;
}, 20);

/* Menu items on the account page */
add_filter('woocommerce_account_menu_items', function ($items) {
  unset($items['dashboard']);
  unset($items['payment-methods']);
  $items['edit-account'] = 'Account Info';
  $items['edit-address'] = 'Address Book';
  $items['customer-logout'] = 'Exit';
  $items = moveKeyBefore($items, 'edit-address', 'edit-account');
  return $items;
}, 10, 1);

/* Edit endpoint names */
function my_account_menu_order()
{
  $menuOrder = array(
    'edit-account' => __('PROFILE DETAILS', 'woocommerce'),
    'edit-address' => __('ADDRESS BOOK', 'woocommerce'),
    'orders' => __('ORDER HISTORY', 'woocommerce'),
    'wishlist' => __('WISHLIST', 'woocommerce')
  );
  return $menuOrder;
}

add_filter('woocommerce_account_menu_items', 'my_account_menu_order');

/* Add to cart action on the product page */
add_action('wp_ajax_add_to_cart', 'addToCart');
add_action('wp_ajax_nopriv_add_to_cart', 'addToCart');


/* Delete standard woocommerce styles */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/* Add to cart action on the category page */
add_filter('woocommerce_add_to_cart_fragments', function ($array) {
  ob_start();
  woocommerce_mini_cart();
  get_template_part('widgets/modal');
  $array['modal'] = ob_get_contents();
  ob_end_clean();
  return $array;
}, 10, 1);

/* Remove some standard WP settings for optimization */
add_action('after_setup_theme', function () {
  remove_action('wp_head', 'wp_print_scripts');
  remove_action('wp_head', 'wp_print_head_scripts', 9);
  remove_action('wp_head', 'wp_enqueue_scripts', 1);
  add_action('wp_footer', 'wp_print_scripts', 5);
  add_action('wp_footer', 'wp_enqueue_scripts', 5);
  add_action('wp_footer', 'wp_print_head_scripts', 5);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wp_shortlink_wp_head');
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
  add_filter('the_generator', '__return_false');
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
});

remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');

/*Registration*/
add_filter('woocommerce_registration_errors', function ($errors) {
  if (!empty($_POST['first_name']) && trim($_POST['first_name']) == '') {
    $errors->add('first_name_error', __('Please provide a valid first name.', '4nails'));
  }
  if (!empty($_POST['last_name']) && trim($_POST['first_name']) == '') {
    $errors->add('last_name_error', __(' Please provide a valid last name.', '4nails'));
  }
  if (empty($_POST['conf_password']) || !empty($_POST['conf_password']) && trim($_POST['conf_password']) !== trim($_POST['password'])) {
    $errors->add('last_name_error', __(' Please confirm password.', '4nails'));
  }
  return $errors;
}, 10, 3);

add_action('user_register', function ($user_id) {
  if (!empty($_POST['first_name']) && !empty($_POST['last_name'])) {
    $first = esc_attr(wp_unslash($_POST['first_name']));
    $last = esc_attr(wp_unslash($_POST['last_name']));
    wp_update_user([
      'ID' => $user_id,
      'display_name' => "$first $last"
    ]);
  }


}, 10, 1);

add_action('insert_user_meta', function ($meta, $user, $update) {
  if (!$update && !empty($_POST['first_name']) && !empty($_POST['last_name'])) {
    $meta['first_name'] = trim($_POST['first_name']);
    $meta['last_name'] = trim($_POST['last_name']);
    /* copy info to shipping */
    $meta['shipping_first_name'] = $meta['first_name'];
    $meta['shipping_last_name'] = $meta['last_name'];
    /* check subscribe */

    if (isset($_POST['subscribe']) && $_POST['subscribe'] == true)
      subscription($user->ID);
  }
  return $meta;
}, 10, 3);

add_filter('woocommerce_min_password_strength', function ($strength) {
  return 1;
});

add_action('woocommerce_registration_redirect', function () {
  return get_permalink(102); //congratulations page
}, 2);

add_action('template_redirect', function () {
  if (is_page(102) && !is_user_logged_in()) {
    wp_redirect(get_permalink(wc_get_page_id('myaccount')));
    exit();
  }
});

add_action('insert_user_meta', function ($meta, WP_User $user, $update) {
  if ($update && isset($_POST['subscribe']) && is_array($_POST['subscribe']) && !empty($_POST['subscribe'])) {
    $subscribe = $_POST['subscribe'];
    subscription($user->ID, $subscribe['new'], $subscribe['promotion'], $subscribe['information']);

    $link = get_edit_user_link($user->ID);
    $message = sprintf(__('User %s changed his/her subscription settings. See: %s', '4nails'), array($user->nickname, $link));
    wp_mail(get_bloginfo('admin_email'), __('Subscription changes', '4nails'), $message);
  }
  return $meta;
}, 10, 3);

add_filter('woocommerce_save_account_details_required_fields', function ($fields) {
  unset($fields['account_display_name']);
  return $fields;

});
/* Delete dashicons for nonadmin*/
function wpdocs_dequeue_dashicon()
{
  if (current_user_can('update_core')) {
    return;
  }
  wp_dequeue_style('dashicons');
  wp_deregister_style('dashicons');
}

add_action('wp_enqueue_scripts', 'wpdocs_dequeue_dashicon');

// Оптимизация работы админки, удаление heartbeat

// add_action('init', 'stop_heartbeat', 1);
// function stop_heartbeat()
// {
//     wp_deregister_script('heartbeat');
// }

/*Удалем type="text/javascript" для валидатора w3*/
add_filter('style_loader_tag', 'sj_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'sj_remove_type_attr', 10, 2);
add_filter('wp_print_footer_scripts ', 'sj_remove_type_attr', 10, 2);
function sj_remove_type_attr($tag)
{
  return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
}


// Remove styles plugins
function custom_dequeue()
{
  if (is_home()) {
    wp_dequeue_style('tinvwl');
    wp_deregister_style('tinvwl');

    wp_dequeue_style('tinvwl-webfont');
    wp_deregister_style('tinvwl-webfont');

    wp_dequeue_style('tinvwl-webfont');
    wp_deregister_style('tinvwl-webfont');
  }
  wp_dequeue_style('wpml-legacy-horizontal-list-0');
  wp_deregister_style('wpml-legacy-horizontal-list-0');

  wp_dequeue_style('wpml-tm-admin-bar');
  wp_deregister_style('wpml-tm-admin-bar');

  if (!is_checkout()) {
    wp_dequeue_style('wc_pv_intl-phones-lib');
    wp_deregister_style('wc_pv_intl-phones-lib');

    wp_dequeue_style('wc_pv_css-style-css');
    wp_deregister_style('wc_pv_css-style-css');
  }

  wp_dequeue_style('dashicons');
  wp_deregister_style('dashicons');

  wp_dequeue_style('admin-bar');
  wp_deregister_style('admin-bar');

  wp_dequeue_style('wpcom-notes-admin-bar');
  wp_deregister_style('wpcom-notes-admin-bar');

  wp_dequeue_style('noticons');
  wp_deregister_style('noticons');

  wp_dequeue_style('wp-block-library');
  wp_deregister_style('wp-block-library');

  wp_dequeue_style('wp-block-library-inline');
  wp_deregister_style('wp-block-library-inline');

  wp_dequeue_style('wc-block-vendors-style');
  wp_deregister_style('wc-block-vendors-style');

  wp_dequeue_style('woocommerce-inline-inline');
  wp_deregister_style('woocommerce-inline-inline');

  wp_dequeue_style('comparision-style');
  wp_deregister_style('comparision-style');

  wp_dequeue_style('jetpack_css');
  wp_deregister_style('jetpack_css');
}

if (!is_admin()) {
  add_action('wp_enqueue_scripts', 'custom_dequeue', 9999);
  add_action('wp_head', 'custom_dequeue', 9999);
}


function pekky_cx_default_country($value)
{
  $value = 'US'; // Nigeria 🇳🇬
  return $value;
}
add_filter('wc_pv_set_default_country', 'pekky_cx_default_country');

add_filter('woocommerce_order_needs_shipping_address', '__return_true');


wp_register_style('fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap', false, null);
wp_enqueue_style('fonts');

$showPersonalDiscount = true;

add_filter('woocommerce_checkout_update_customer_data', '__return_true');

//Adding additional fields to register form


// add_filter('woocommerce_states', 'change_states_format', 10, 2);

// function change_states_format($states)
// {
//   var_dump($states);
//   return $states;
// }