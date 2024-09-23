<?php


add_action('init', 'css_js_versioning');

function set_custom_ver_css_js($src)
{
  $changed_files = array('/assets/js/checkout.js', '/assets/css/checkout.css', '/assets/js/main.js', '/assets/css/cart.css');

  foreach ($changed_files as $file) {
    if (strpos($src, $file)) {
      $version = filemtime(get_stylesheet_directory() . $file);

      $src = add_query_arg('ver', $version, $src);
      return esc_url($src);
    }
  }
  return esc_url($src);

}
function add_asyncdefer_attribute($tag, $handle)
{
  if (strpos($handle, 'preload') !== false) {
    return str_replace('<link', '<link rel="preload"', $tag);
  }
  // if the unique handle/name of the registered script has 'async' in it
  if (strpos($handle, 'async') !== false) {
    // return the tag with the async attribute
    return str_replace('<script ', '<script async ', $tag);
  }
  // if the unique handle/name of the registered script has 'defer' in it
  else if (strpos($handle, 'defer') !== false) {
    // return the tag with the defer attribute
    return str_replace('<script ', '<script defer ', $tag);
  }
  // otherwise skip
  else {
    return $tag;
  }
}
add_filter('script_loader_tag', 'add_asyncdefer_attribute', 10, 2);

function css_js_versioning()
{
  add_filter('style_loader_src', 'set_custom_ver_css_js', 9999);   // css files versioning
  add_filter('script_loader_src', 'set_custom_ver_css_js', 9999); // js files versioning
}

add_action('wp_enqueue_scripts', 'nails_scripts_styles', 1);
function nails_scripts_styles()
{

  /* --- Styles  --- */
  wp_register_style('main', path() . 'assets/css/main.css');
  wp_enqueue_style('main');

  wp_register_style('normalize', path() . 'assets/css/normalize.css');
  wp_enqueue_style('normalize');

  wp_register_style('fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css');
  wp_enqueue_style('fancybox-css');

  if (is_front_page() || is_product() || is_cart()) {
    wp_register_style('swiper', path() . 'assets/css/swiper.css');
    wp_enqueue_style('swiper');
  }

  if (is_product()) {
    wp_register_style('product', path() . 'assets/css/product.css');
    wp_enqueue_style('product');

  }

  if (is_archive()) {
    wp_register_style('catalog', path() . 'assets/css/catalog.css');
    wp_enqueue_style('catalog');
  }
  if (is_blog()) {
    wp_register_style('blog', path() . 'assets/css/blog.css');
    wp_enqueue_style('blog');
  }

  if (is_cart()) {
    wp_register_style('cart', path() . 'assets/css/cart.css');
    wp_enqueue_style('cart');
  }
  if (is_account_page() || is_checkout() || is_page('98') || is_page("4643") || is_page("8018") || is_page('8')) {
    wp_register_style('account', path() . 'assets/css/account.css');
    wp_enqueue_style('account');
  }
  if (is_checkout()) {
    wp_register_style('checkout', path() . 'assets/css/checkout.css');
    wp_enqueue_style('checkout');


  }
  /* For contact page */
  if (is_page('81') || is_page('4631') || is_page('8019')) {
    wp_register_style('contact', path() . 'assets/css/contact.css');
    wp_register_style('magnific', path() . 'assets/css/magnific-popup.css');

    wp_enqueue_style('contact');
    wp_enqueue_style('magnific');
  }
  /* For sitemap page*/
  if (is_page('9173') || is_page('9178') || is_page('9180')) {
    wp_register_style('sitemap', path() . 'assets/css/sitemap.css');
    wp_enqueue_style('sitemap');
  }
  if (is_page('-42')) {
    wp_register_style('cancel', path() . 'assets/css/cancel.css');
    wp_enqueue_style('cancel');
  }

  /* --- Scripts --- */
  wp_deregister_script('jquery');

  wp_register_script('jquery', path() . 'assets/js/libs/jquery.js');

  wp_enqueue_script('jquery');

  wp_register_script('fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js');

  wp_enqueue_script('fancybox-js');

  // add_action('wp_footer', 'nails_deregister_scripts', 11);
  // function nails_deregister_scripts()
  // {

  // }



  if (is_front_page() || is_product() || is_cart()) {
    wp_register_script('swiper', path() . 'assets/js/libs/swiper.js');
    wp_enqueue_script('swiper');
  }

  if (is_cart() || is_checkout()) {

    wp_enqueue_script('swiper-async', path() . 'assets/js/libs/swiper.js', array('jquery'), null, true);


  }

  wp_register_script('main', path() . 'assets/js/main.js');
  wp_enqueue_script('main');


  /* Select plugin */
  if (is_account_page() || is_edit_account_page()) {
    wp_register_script('select2', path() . '/assets/js/libs/select2/dist/js/select2.min.js');
    wp_enqueue_script('select2');

  }
  /* Home */
  if (is_front_page()) {
    wp_register_script('home', path() . 'assets/js/home.js');
    wp_enqueue_script('home');
  }
  /* Product page */
  if (is_product()) {
    wp_register_script('product', path() . 'assets/js/product.js');
    wp_enqueue_script('product');
  }

  /* Add to cart button */
  if (is_archive() || is_product() || is_cart() || is_checkout()) {
    wp_enqueue_script('add-to-cart-async', path() . 'assets/js/add-to-cart.js', array('jquery'), null, true);

    if (!is_archive()) {
      $wc_add_to_cart_params = array(
        'ajax_url' => WC()->ajax_url(),
        'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
        'i18n_view_cart' => esc_attr__('View cart', 'woocommerce'),
        'cart_url' => apply_filters('woocommerce_add_to_cart_redirect', wc_get_cart_url(), null),
        'is_cart' => is_cart(),
        'cart_redirect_after_add' => get_option('woocommerce_cart_redirect_after_add'),
      );
      wp_localize_script(
        'add-to-cart-async',
        'wc_add_to_cart_params',
        $wc_add_to_cart_params
      );
    }


  }
  /* Checkout page */
  if (is_checkout()) {

    wp_enqueue_script('checkout-async', path() . 'assets/js/checkout.js', array('jquery'), null, true);

    $session = WC()->session;

    $billing_country = $session->get('customer')['country'];

    $shipping_country = $session->get('customer')['shipping_country'];


    wp_localize_script('checkout-async', 'billing_country', $billing_country);
    wp_localize_script('checkout-async', 'shipping_country', $shipping_country);
    $country_params = array(
      'countries' => wp_json_encode(array_merge(WC()->countries->get_allowed_country_states(), WC()->countries->get_shipping_country_states())),
      'i18n_select_state_text' => esc_attr__('Select an option&hellip;', 'woocommerce'),
      'i18n_no_matches' => _x('No matches found', 'enhanced select', 'woocommerce'),
      'i18n_ajax_error' => _x('Loading failed', 'enhanced select', 'woocommerce'),
      'i18n_input_too_short_1' => _x('Please enter 1 or more characters', 'enhanced select', 'woocommerce'),
      'i18n_input_too_short_n' => _x('Please enter %qty% or more characters', 'enhanced select', 'woocommerce'),
      'i18n_input_too_long_1' => _x('Please delete 1 character', 'enhanced select', 'woocommerce'),
      'i18n_input_too_long_n' => _x('Please delete %qty% characters', 'enhanced select', 'woocommerce'),
      'i18n_selection_too_long_1' => _x('You can only select 1 item', 'enhanced select', 'woocommerce'),
      'i18n_selection_too_long_n' => _x('You can only select %qty% items', 'enhanced select', 'woocommerce'),
      'i18n_load_more' => _x('Loading more results&hellip;', 'enhanced select', 'woocommerce'),
      'i18n_searching' => _x('Searching&hellip;', 'enhanced select', 'woocommerce'),
    );

    $i18_params = array(
      'locale' => wp_json_encode(WC()->countries->get_country_locale()),
      'locale_fields' => wp_json_encode(WC()->countries->get_country_locale_field_selectors()),
      'i18n_required_text' => esc_attr__('required', 'woocommerce'),
      'i18n_optional_text' => esc_html__('optional', 'woocommerce'),
    );

    $checkout_params = array(
      'ajax_url' => WC()->ajax_url(),
      'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
      'update_order_review_nonce' => wp_create_nonce('update-order-review'),
      'apply_coupon_nonce' => wp_create_nonce('apply-coupon'),
      'remove_coupon_nonce' => wp_create_nonce('remove-coupon'),
      'option_guest_checkout' => get_option('woocommerce_enable_guest_checkout'),
      'checkout_url' => WC_AJAX::get_endpoint('checkout'),
      'is_checkout' => is_checkout() && empty($wp->query_vars['order-pay']) && !isset($wp->query_vars['order-received']) ? 1 : 0,
      'i18n_checkout_error' => esc_attr__('Error processing checkout. Please try again.', 'woocommerce'),
    );

    wp_localize_script(
      'checkout-async',
      'wc_checkout_params',
      $checkout_params
    );
    wp_localize_script(
      'checkout-async',
      'wc_address_i18n_params',
      $i18_params
    );

    wp_localize_script(
      'checkout-async',
      'wc_country_select_params',
      $country_params
    );

  }
  /* For contact page */
  if (is_page('81') || is_page('4631') || is_page('8019')) {
    wp_register_script('magnific', path() . 'assets/js/libs/magnific-popup.js');
    wp_register_script('contact-us', path() . 'assets/js/contact-us.min.js');
    wp_enqueue_script('magnific');
    wp_enqueue_script('contact-us');
  }

  /* Cart page */
  if (is_cart()) {
    wp_enqueue_script('cart', path() . 'assets/js/cart.js', array('jquery'), null, true);

    wp_localize_script('cart', 'wc_cart_params', array('ajax_url' => admin_url('admin-ajax.php'), 'wc_ajax_url' => '%%endpoint%%', 'update_shipping_method_nonce' => wp_create_nonce('update-shipping-method'), 'remove_coupon_nonce' => wp_create_nonce('remove-coupon')));
  }

  if (is_product_category()) {
    wp_register_script('category', path() . 'assets/js/category.js');
    wp_enqueue_script('category');
  }

  $my_variable_value = __('Shipping address matches billing address', '4nails');

  wp_localize_script(
    'main',
    'SharedData',
    [
      'link' => get_permalink(),
      'adminAjax' => admin_url('admin-ajax.php')
    ]
  );

}


function admin_style()
{
  wp_enqueue_style('admin-styles', path() . 'assets/css/admin.css');
}

add_action('admin_enqueue_scripts', 'admin_style');


function enqueue_remove_from_cart_script()
{
  // wp_enqueue_script('remove-from-cart-script', get_template_directory_uri() . '/js/remove-from-cart.js', array('jquery'), '1.0', true);

  // Pass the Ajax URL to script.js
  wp_localize_script('remove-from-cart-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));


}

add_action('wp_enqueue_scripts', 'enqueue_remove_from_cart_script');