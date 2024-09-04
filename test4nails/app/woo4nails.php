<?php

add_action('after_setup_theme', 'woocommerce_support');

function woocommerce_support()
{
  add_theme_support('woocommerce');
}

/* Вывести карточку товара || Show product card  */

/**
 * @param $type - тип товара(top_sellers, just_arrived итд) || type of product(top_sellers, just_arrived etc)
 * @param $count_of_product - количество отображаемого товара || count of the displaying products
 * @param false $new_products - являются ли выводимые товары новыми || are the products that being displayed new
 */

function show_products($type, $count_of_product, $new_products = false)
{
  $post_ids = [];
  $posts = empty(get_field($type)) ? [] : get_field($type);
  $latest = $new_products ? get_latest_products($count_of_product) : get_popular_products($count_of_product);
  $posts = array_merge($posts, $latest->posts);
  if (!empty($posts)) {
    $posts = array_merge($posts, $latest->posts);
  } else {
    $posts = $latest->posts;
  }
  foreach ($posts as $post) {
    global $product;
    $product = wc_get_product($post->ID);
    $product->backorders_allowed();
    if ($product->backorders_allowed() || $product->get_stock_quantity() > 0) {
      if (in_array($post->ID, $post_ids) || get_field('attached_product', $post->ID)) {
        continue;
      }

      $post_ids[] = $post->ID;
      setup_postdata($post);
      wc_get_template_part('content', 'product');
    }
    wp_reset_postdata();
  }
}

function get_popular_products($count)
{
  $query = new WP_Query([
    'post_type' => 'product',
    'posts_per_page' => $count,
    'post_status' => 'publish',
    'meta_key' => 'total_sales',
    'orderby' => [
      'meta_value_num' => 'DESC',
    ],
  ]);
  return $query;
}

function get_viewed($limit)
{
  $rvps = new Rvps();
  $viewed = $rvps->rvps_get_products();
  $query = new WP_Query([
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => $limit,
    'post__in' => $viewed,
  ]);
  return $query;
}

function get_latest_products($count)
{
  $query = new WP_Query([
    'post_type' => 'product',
    'posts_per_page' => $count,
    'post_status' => 'publish',
    'orderby' => 'date',
  ]);
  return $query;
}

/* Save new first and last names*/
add_action('woocommerce_save_account_details', function ($user_id) {
  if (!empty($_POST['account_first_name']) || !empty($_POST['account_last_name'])) {
    $first = esc_attr(wp_unslash($_POST['account_first_name']));
    $last = esc_attr(wp_unslash($_POST['account_last_name']));
    wp_update_user([
      'ID' => $user_id,
      'display_name' => "$first $last",
    ]);
  }

}, 12, 1);

add_filter('request', 'register_request', 9999, 1);

/* Request on registration page */
function register_request($query)
{
  $url = urldecode($_SERVER['REQUEST_URI']);
  if (($url == '/my-account/registration' || $url == '/my-account/registration/') && !is_user_logged_in()) {
    $query['pagename'] = 'my-account';
    $_GET['registration'] = '';
    unset($query['category_name']);
    unset($query['name']);
  } elseif (($url == '/ru/my-account/registration' || $url == '/ru/my-account/registration/') && !is_user_logged_in()) {
    $query['pagename'] = 'my-account';
    $_GET['registration'] = '';
    unset($query['category_name']);
    unset($query['name']);
  } elseif (($url == '/es/mi-cuenta/registro' || $url == '/es/mi-cuenta/registro/') && !is_user_logged_in()) {
    $query['pagename'] = 'mi-cuenta';
    $_GET['registration'] = '';
    unset($query['category_name']);
    unset($query['name']);
  }
  return $query;
}

/* get order status */
function nails_status($word)
{
  $statuses = [
    'wc-pending' => __('Pending payment', '4nails'),
    'wc-processing' => __('Processing', '4nails'),
    'wc-on-hold' => __('On hold', '4nails'),
    'wc-completed' => __('Completed', '4nails'),
    'wc-cancelled' => __('Cancelled', '4nails'),
    'wc-refunded' => __('Refunded', '4nails'),
    'wc-failed' => __('Failed', '4nails'),
    'wc-shipped' => __('Shipped', '4nails'),
    'wc-cancel-request' => __('Cancel Request', '4nails'),
  ];
  return $statuses['wc-' . strtolower($word)];
}

/* Cancel order if it possible*/
function cancelOrder(WC_Order $order)
{
  $order_id = $order->get_id();

  if ($order->has_status(['on-hold', 'pending', 'processing'])) {

    $url = wp_nonce_url(admin_url('admin-ajax.php?action=nails_mark_order_as_cancel_request&order_id=' . $order_id), 'woocommerce-mark-order-cancell-request-myaccount');
    return $url;
  }
  return false;
}

/* Show notification:
    1) If customer allow free shipping, display it
    2) If free shipping is not available to the customer, displays how much he needs to achieve it
*/
function freeShipping()
{
  $amounts = [];
  $amount = null;
  $zone = new WC_Shipping_Zone(0);
  $methods = $zone->get_shipping_methods();
  foreach ($methods as $key => $value) {
    if ($value->id === "free_shipping") {
      if ($value->min_amount > 0) {
        $amounts[] = $value->min_amount;
      }
    }
  }
  $zones = WC_Shipping_Zones::get_zones();
  foreach ($zones as $key => $zone) {
    foreach ($zone['shipping_methods'] as $key => $value) {
      if ($value->id === "free_shipping") {
        if ($value->min_amount > 0) {
          $amounts[] = $value->min_amount;
        }
      }
    }
  }
  if (is_array($amounts)) {
    $amount = min($amounts);
  }
  $amount -= WC()->cart->get_cart_contents_total();
  return $amount > 0 ? sprintf(__("You're&nbsp;%s&nbsp;away from FREE shipping!", '4nails'), wc_price($amount)) : __('You have free shipping!', '4nails');
}

function productStatus($manage_stock, $backorders, $stock_status, $backorder)
{
  if ($manage_stock && $backorders === 'yes') {
    return "<span>" . esc_html__('In stock', '4nails') . "</span>";
  }
  if ($stock_status === 'onbackorder') {
    return "<span>" . esc_html__('On backorder', '4nails') . "</span>";
  } elseif ($stock_status === 'instock') {
    return "<span>" . esc_html__('In stock', '4nails') . "</span>";
  } else {
    return "<span>" . esc_html__('Out of stock', '4nails') . "</span>";
  }
}

/* Change wishlist plugin default image on product card*/
function show_wishlist_button()
{
  return str_replace('></a>', '><svg id="heart-icon" viewBox="0 0 100 100" > <use xlink:href="#heart"> <path id="heart" d="M100 34.976c0 8.434-3.635 16.019-9.423 21.274h0.048l-31.25 31.25c-3.125 3.125-6.25 6.25-9.375 6.25s-6.25-3.125-9.375-6.25l-31.202-31.25c-5.788-5.255-9.423-12.84-9.423-21.274 0-15.865 12.861-28.726 28.726-28.726 8.434 0 16.019 3.635 21.274 9.423 5.255-5.788 12.84-9.423 21.274-9.423 15.865 0 28.726 12.861 28.726 28.726z" transform="translate(2, 2) scale(.95)" style=" /* stroke: rgba(0, 0, 0, 0.5); */ /* stroke-width: 2; */ "></path> </use></svg></a>', do_shortcode('[ti_wishlists_addtowishlist]'));
}

/* Change wishlist plugin default image on cart*/
function show_wishlist_button_on_cart($id)
{
  return str_replace('></a>', '><svg id="heart-icon" viewBox="0 0 100 100" > <use xlink:href="#heart"> <path id="heart" d="M100 34.976c0 8.434-3.635 16.019-9.423 21.274h0.048l-31.25 31.25c-3.125 3.125-6.25 6.25-9.375 6.25s-6.25-3.125-9.375-6.25l-31.202-31.25c-5.788-5.255-9.423-12.84-9.423-21.274 0-15.865 12.861-28.726 28.726-28.726 8.434 0 16.019 3.635 21.274 9.423 5.255-5.788 12.84-9.423 21.274-9.423 15.865 0 28.726 12.861 28.726 28.726z" transform="translate(2, 2) scale(.95)" style=" /* stroke: rgba(0, 0, 0, 0.5); */ /* stroke-width: 2; */ "></path> </use></svg></a>', do_shortcode('[ti_wishlists_addtowishlist product_id="' . $id . '"]'));
}

/* Checkbox billing and shipping the same by defalult */
add_filter('woocommerce_ship_to_different_address_checked', '__return_true');


function add_parent_product_sku($description, $item_id, $item)
{

  $product = $item->get_product();

  if ($product) {

    $product_id = apply_filters('wpml_object_id', $product->get_id(), 'product', false, 'en');
    $english_product = wc_get_product($product_id);
    $description = $english_product->get_name();

  }


  return $description;
}

add_filter('wpi_item_description_data', 'add_parent_product_sku', 10, 3, 98);


function add_invoice_information_meta($info, $invoice)
{
  $order = wc_get_order($info['order_number']['value']);
  $user_id = $order->get_user_id();
  global $locale;
  $locale = "en_US";

  $current_lang = $info['shipping_method']['value'];
  if ($current_lang === "Самовывоз" || $current_lang === 'Recogida local') {
    $info['shipping_method']['value'] = 'Local pickup';
  }
  $sale_total = 0;
  $regular_total = 0;

  $personal = $GLOBALS['showPersonalDiscount'] ? get_individual_discount_order($order) : 0;
  foreach ($order->get_items() as $item) {

    $product = $item->get_product();
    $quantity = $item['quantity'];


    $regular_total += $quantity * $product->regular_price;

    if ($product->sale_price) {
      $sale_total += ($product->regular_price - $product->sale_price) * $quantity;
    }

  }
  $total = $regular_total - $sale_total - $personal;
  $info['subtotal'] = number_format($total, 2);
  $info['sale_discount'] = number_format($sale_total, 2);

  $personal_discount = is_user_logged_in() ? get_field('individual_discount', 'user_' . $user_id) : 0;
  $info['personal_discount'] = $personal_discount . '%';
  if ($personal > 0) {
    $info['personal_total'] = number_format($personal, 2);
  } else {
    $info['personal_total'] = number_format($personal, 2);
  }

  return $info;
}

add_filter('wpi_invoice_information_meta', 'add_invoice_information_meta', 10, 2);
/* Удалям надпись "без налога"*/
function sv_change_email_tax_label($label)
{
  $label = '';
  return $label;
}

add_filter('woocommerce_countries_ex_tax_or_vat', 'sv_change_email_tax_label');


/* Добавляем в обьект order поля скидки и тотал, что бы не считать каждый раз*/
add_action('woocommerce_checkout_update_order_meta', 'saving_checkout_cf_data');
function saving_checkout_cf_data($order_id)
{
  $nails_get_totals = nails_get_totals($order_id);
  update_post_meta($order_id, '4nails__total', $nails_get_totals['subtotal']);
  update_post_meta($order_id, '4nails__sale', $nails_get_totals['sale']);
}

function nails_get_totals($order_id = 0)
{
  $sale_total = 0;
  $subtotal = 0;
  $total = 0;
  $order = wc_get_order($order_id);
  $personal = 0;
  /* Если сообщение отправляется админу*/

  if (is_admin()) {
    $personal = $GLOBALS['showPersonalDiscount'] ? get_individual_discount_order($order) : 0;
    ;
    $order = wc_get_order($order_id);
    foreach ($order->get_items() as $item) {
      $product = $item->get_product();
      $regular = $product->get_regular_price();
      $quantity = $item['quantity'];
      $subtotal += $regular * $item['quantity'];
      $sale_total += ($product->regular_price - $product->sale_price) * $quantity;
    }
    $total = $subtotal - $sale_total - $personal;
    return ['sale' => $sale_total, 'subtotal' => $total];
  }
  /* если вызов идёт на сайте или если письмо идёт покупателю*/
  foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    $personal = $GLOBALS['showPersonalDiscount'] ? get_individual_discount_order($order) : 0;
    ;
    $regular = $cart_item['data']->regular_price;
    $sale = $cart_item['data']->sale_price;
    $subtotal += $regular * $cart_item['quantity'];
    if ($sale <= 0) {
      continue;
    }
    $sale_total += ($regular - $sale) * $cart_item['quantity'];
  }
  $total = $subtotal - $sale_total - $personal;
  return ['sale' => $sale_total, 'subtotal' => $total];
}

function get_subtotal($order_id = 0)
{
  $subtotal = 0;

  foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    $subtotal += get_product_price($cart_item['data']->get_id()) * $cart_item['quantity'];
  }
  return $subtotal;
}

//посчитать индивидуальную скидку

function get_individual_duscount($cart)
{
  if (!$GLOBALS['showPersonalDiscount']) {
    return 0;
  }
  global $woocommerce;
  $total_individual_discount = 0;
  if (is_user_logged_in()) {
    $userField = 'user_' . get_current_user_id();
    $total_individual_discount = 0;
    if ($discount = get_field('individual_discount', $userField)) {

      // применять индивидуальную скидку только на товары которые без Sale
      foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['data']->sale_price == '' && $cart_item['data']->sale_price == 0) {
          $total_individual_discount += $cart_item['line_subtotal'] * ((float) $discount / 100);
        }
      }
      $total_individual_discount;
    }
  }
  return $total_individual_discount;
}

/* персональная скидка*/
add_filter('woocommerce_calculated_total', function ($total, WC_Cart $cart) {
  if (is_user_logged_in()) {
    if (!$GLOBALS['showPersonalDiscount']) {
      return $total;
    }
    $total -= get_individual_duscount($cart);
  }
  return $total;
}, 10, 2);


/* Меняем вывод методов доставки */

function add_shipping_info($method, $chosen_method)
{

  /*if ($method->id == $chosen_method) {*/
  $current = strtolower(str_replace(' ', '_', preg_replace('/[\(\)]/', '', $method->label))) . '_info';
  $mark = '';
  $mark .= "<div data-temp='" . strtolower(str_replace(' ', '_', preg_replace('/[\(\)]/', '', $method->label))) . '_info' . "'>";
  $mark .= "<div class='delivery__info-text' >" . get_field(strtolower(str_replace(' ', '_', preg_replace('/[\(\)]/', '', $method->id))) . '_info', 'options');

  if (strtolower(str_replace(' ', '_', preg_replace('/[\(\)]/', '', $method->label))) == 'express_mail') {
    if (date('w') == 6) {
      $d = strtotime("+2 day");
    } else {
      $d = strtotime("+1 day");
    }
    $mark .= date("F d", $d);
  }

  $mark .= '</div>' . '</div>';
  /* }*/

  $label = '<div class="delivery-method">';
  if ($method->cost > 0) {
    if (WC()->cart->tax_display_cart == 'excl') {
      $label .= wc_price($method->cost) . ' 一 ';
      if ($method->get_shipping_tax() > 0 && WC()->cart->prices_include_tax) {
        $label .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
      }

    } else {
      $label .= wc_price($method->cost + $method->get_shipping_tax()) . ' 一 ';

      if ($method->get_shipping_tax() > 0 && !WC()->cart->prices_include_tax) {
        $label .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
      }

    }

  }

  $label .= $method->get_label() . '</div>' . $mark;
  return $label;
}

// Код отключения других методов оплаты

add_filter('woocommerce_available_payment_gateways', 'truemisha_payments_on_shipping');

function truemisha_payments_on_shipping($available_gateways)
{

  if (is_admin()) {
    return $available_gateways;
  }

  if (is_wc_endpoint_url('order-pay')) {
    return $available_gateways;
  }

  if (is_object(WC()->customer) && method_exists(WC()->customer, 'get_billing_country')) {

    $customer_country = WC()->customer->get_billing_country();

    if ($customer_country !== 'US') {

      return $available_gateways;

    }
  }

  unset($available_gateways['alg_custom_gateway_1']); // Remove Stripe payment method
  return $available_gateways;

}


add_action('wp_head', 'custom_ajax_spinner', 1000);
function custom_ajax_spinner()
{
  ?>
<style>
.current-step--first .woocommerce-checkout .blockUI.blockOverlay {
  display: none !important;
}

.current-step--first .woocommerce-checkout .blockUI.blockOverlay.firstStepShow {
  display: flex !important;
}

.blockUI.blockOverlay:before,
.woocommerce .loader:before {
  height: auto;
  width: fit-content;
  z-index: 1000000 !important;
  opacity: 1 !important;
  margin-left: 0;
  margin-top: 0;
  display: block;
  content: "<?= __('Please Wait', '4nails') ?> ...";
  -webkit-animation: none;
  -moz-animation: none;
  animation: none;
  background: none;
  background-size: cover;
  line-height: 1;
  text-align: center;
  font-size: 2em;
  color: rgba(0, 0, 0, 1) !important;
  -webkit-animation: pulsate-fwd 1s ease-in-out infinite both;
  animation: pulsate-fwd 1s ease-in-out infinite both;
}

@media only screen and (max-width: 767px) {

  html[lang=ru-RU] .blockUI.blockOverlay:before,
  .woocommerce .loader:before {
    font-size: 1.5em;
  }
}

.popup-feedback.blockOverlay:before,
.woocommerce .loader:before {
  content: "<?= __('Thank you for the answers', '4nails') ?> ...";
}

.blockUI.blockOverlay {
  position: fixed !important;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: unset !important;
  background: rgba(255, 255, 255, 0.6) !important;
}

@keyframes pulsate-fwd {
  0% {
    transform: scale(1);
  }

  50% {
    transform: scale(1.1);
  }

  100% {
    transform: scale(1);
  }
}
</style>
<?php

}

/* Reload after payment method change*/

add_action('init', 'fg_init');

function fg_init()
{
  add_action('woocommerce_cart_calculate_fees', 'fg_add_fee');
}

/* Добавление Fee в зависимости от метода оплаты */

function apply_fee($acf_option, $fee_percent, $total_price, $fee_name)
{
  global $woocommerce;

  $acf_fee = floatval(get_field($acf_option, 'options'));
  $fee_percent = $acf_fee ? ($acf_fee / 100) : $fee_percent;
  $fee = $acf_fee == 0 ? 0 : ($total_price * $fee_percent) + 0.3;

  $woocommerce->cart->add_fee(__($fee_name, '4nails'), $fee);
}

function fg_add_fee()
{
  if (is_admin() && !defined('DOING_AJAX')) {
    return;
  }
  global $woocommerce;

  $total_price = WC()->cart->get_cart_contents_total() + $woocommerce->cart->tax_total + WC()->cart->shipping_total;
  $payment_method = $woocommerce->session->chosen_payment_method;
  $customer_billing_address = WC()->cart->get_customer()->get_billing_country();
  $customer_shipping_address = WC()->cart->get_customer()->get_shipping_country();

  if ($customer_billing_address !== "US" || $customer_shipping_address !== "US") {

    switch ($payment_method) {
      case "paypal":
        apply_fee('international_shipping_paypal', 0.06, $total_price, 'PayPal fee');
        break;
      case "stripe":
        apply_fee('international_shipping_stripe', 0.05, $total_price, 'Stripe fee');
        break;
      case "affirm":
        apply_fee('affirm_fee', 0.06, $total_price, 'Fee');
        break;
    }
    return;
  }

  switch ($payment_method) {
    case "paypal":
      apply_fee('usa_shipping_paypal', 0.033, $total_price, 'PayPal fee');
      break;
    case "stripe":
      apply_fee('usa_shipping_stripe', 0.03, $total_price, 'Stripe fee');
      break;
    case "affirm":
      apply_fee('affirm_fee', 0.06, $total_price, 'Fee');
      break;
  }

}

/* Меняем иконку paypal */
function my_new_paypal_icon()
{
  return path() . '/assets/img/paypal-logo.png';
}

add_filter('woocommerce_paypal_icon', 'my_new_paypal_icon');

add_filter('woocommerce_gateway_icon', 'custom_payment_gateway_icons', 10, 2);
function custom_payment_gateway_icons($icon, $gateway_id)
{

  foreach (WC()->payment_gateways->get_available_payment_gateways() as $gateway)
    if ($gateway->id == $gateway_id) {
      $title = $gateway->get_title();
      break;
    }

  // The path (subfolder name(s) in the active theme)
  $path = get_stylesheet_directory_uri() . '/assets';

  // Setting (or not) a custom icon to the payment IDs

  if ($gateway_id == 'paypal')
    $icon = file_get_contents(path() . '/assets/img/PayPal_logo.svg');

  if ($gateway_id == 'zelle')
    $icon = file_get_contents(path() . '/assets/img/zelle-logo.svg');


  return $icon;
}


function subscription($id, $new = true, $promotion = true, $info = true)
{
  $user = "user_$id";
  update_field('new_items', $new, $user);
  update_field('promotions_and_discounts', $promotion, $user);
  update_field('useful_information', $info, $user);

  if ($new == true || $promotion == true || $info == true) {
    send_notification_about_sub($id);
  }
}

// переопределим функцию с Отменой заказа
add_action('wp_ajax_nails_mark_order_as_cancel_request', 'action_mark_order_as_cancel_request');
function action_mark_order_as_cancel_request()
{

  if (!is_user_logged_in()) {
    wp_die(__('You do not have sufficient permissions to access this page.', 'wc-cancel-order'), '', array('response' => 403));
  }

  if (!check_admin_referer('woocommerce-mark-order-cancell-request-myaccount')) {
    wp_die(__('You have taken too long. Please go back and retry.', 'wc-cancel-order'), '', array('response' => 403));
  }

  $order_id = isset($_GET['order_id']) && (int) $_GET['order_id'] ? (int) $_GET['order_id'] : '';

  if (!$order_id) {
    die();
  }

  $order = wc_get_order($order_id);
  $order->update_status('cancel-request');
  $mails = WC()->mailer()->get_emails();

  $mails['WC_Email_Cancelled_Order']->trigger($order_id);
  wc_add_notice(__('The order has been successfully canceled. Your funds will be returned to you within 7 days.', 'woocommerce'), 'success');
  wp_safe_redirect(wp_get_referer() ? wp_get_referer() : get_permalink(get_option('woocommerce_myaccount_page_id')));
}

function invoice(WC_Order $order)
{
  $instance = BE_WooCommerce_PDF_Invoices::instance();
  $invoice = $instance->add_my_account_pdf([], $order);
  if (!empty($invoice)) {
    return $invoice['invoice']['url'];
  }
  return false;
}

function get_tracking_order($order)
{
  $labels = get_post_meta($order->get_order_number(), 'wc_connect_labels', true);

  if (!empty($labels)) {
    $tracking_url = array();
    foreach ($labels as $label) {
      $carrier = $label['carrier_id'];
      $carrier_label = strtoupper($carrier);
      $tracking = $label['tracking'];
      $error = array_key_exists('error', $label);
      $refunded = array_key_exists('refund', $label);

      if ($error || $refunded) {
        continue;
      }

      switch ($carrier) {
        case 'fedex':
          $tracking_url = 'https://www.fedex.com/apps/fedextrack/?action=track&tracknumbers=' . $tracking;
          break;
        case 'usps':
          $tracking_url = 'https://tools.usps.com/go/TrackConfirmAction.action?tLabels=' . $tracking;
          break;
      }

      break;
    }

    return array('url' => $tracking_url, 'number' => $tracking);
  }
}

function nails_order_info($order_id)
{


  return get_order_info($order_id);

}

function nails_show_shipping_method($order)
{
  $item_totals = $order->get_order_item_totals();
  $shipping_value = 0;
  $method_name = reset($order->get_items('shipping'))->get_method_id();
  $method_id = reset($order->get_items('shipping'))->get_instance_id();
  if ($method_name == 'local_pickup' || $method_name == 'free_shipping') {
    return $item_totals['shipping']['value'];
  } elseif ($method_name == 'jem_table_rate' && $method_id == 20) {
    return $item_totals['shipping']['value'];
  } else {
    return $item_totals['shipping']['value'];
  }
}

function get_order_info($order_id = 0)
{
  $subtotal = 0;

  $sale_total = 0;


  $order = wc_get_order($order_id);
  $total = 0;
  foreach ($order->get_items() as $item) {

    $product = $item->get_product();

    if (!$product) {
      continue;
    }

    $regular_prce = $product->get_regular_price();

    $product_quantity = (int) $item->get_quantity();

    $subtotal += $regular_prce * $product_quantity;

    $price = get_product_price($product);

    $total += $price * $product_quantity;


  }

  $sale_total = $subtotal - $total;
  return ['sale' => $sale_total, 'subtotal' => $total];

}

function addToCart()
{
  $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
  $qty = absint($_POST['qty']);
  $response = [];

  $product = wc_get_product($product_id)->get_data();

  

  $is_product_in_cart = [
    'product_en' => check_product_in_cart(apply_filters('wpml_object_id', $product_id, 'product', false, 'en'), $qty),
    'product_es' => check_product_in_cart(apply_filters('wpml_object_id', $product_id, 'product', false, 'es'), $qty),
    'product_ru' => check_product_in_cart(apply_filters('wpml_object_id', $product_id, 'product', false, 'ru'), $qty),
  ];

  if (in_array(true, $is_product_in_cart)) {
    send_add_to_cart_error_message($product, $is_product_in_cart);
  }

  $result = WC()->cart->add_to_cart($product_id, $qty);
  if ($result) {
    send_add_to_cart_success_message($product, $is_product_in_cart);
  } else {
    send_add_to_cart_error_message($product, $is_product_in_cart);
  }
}


// Удаление из хлебных крошек пункта Shop
add_filter('woocommerce_get_breadcrumb', 'remove_shop_crumb', 20, 2);
function remove_shop_crumb($crumbs, $breadcrumb)
{
  $new_crumbs = array();
  foreach ($crumbs as $key => $crumb) {
    if ($crumb[0] !== __('Shop', 'Woocommerce')) {
      $new_crumbs[] = $crumb;
    }
  }
  return $new_crumbs;
}

//Массовое изменение скидок при сохранении данных на странице настроек
add_action('acf/options_page/save', 'my_acf_save_options_page', 10, 2);
function my_acf_save_options_page($post_id, $menu_slug)
{

  if ('theme-general-settings' !== $menu_slug) {
    return;
  }
  // Get newly saved values for the theme settings page.
  $values = get_fields($post_id);



  // Check the new value of a specific field.
  $discount_categories = get_field('discount_categories', $post_id);

  $logger = wc_get_logger();


  /**
   * Получает предков главных категорий и объединяет все в 1 массив, если предок не найден добавляет в массив родителя  
   * @param array $parent_categories родительские категории
   * @param bool $id_only (Optional) Возвратить только массив id?
   * @return array
   */
  function get_children_categories($parent_categories, $id_only = true)
  {
    $children_cats = [];

    foreach ($parent_categories as $parent_category => $value) {
      $cat_args = array(
        'taxonomy' => "product_cat",
        'hide_empty' => true,
        'limit' => 100,
        'fields' => 'ids',
        'parent' => $value['discount_category'],
      );
      $child_categories_ids = get_terms($cat_args);

      if (!sizeof($child_categories_ids)) {
        if (!$id_only) {
          array_push($children_cats, ['discount_category' => $value['discount_category'], 'category_discount' => $value['category_discount']]);

        } else {
          array_push($children_cats, $value['discount_category']);
        }

        continue;
      }
      if (!$id_only) {
        $child_categories = array_map(function ($item) use ($value) {

          return ['discount_category' => $item, 'category_discount' => $value['category_discount']];

        }, $child_categories_ids);

        $children_cats = array_merge($children_cats, $child_categories);

      } else {
        $children_cats = array_merge($children_cats, $child_categories_ids);
      }

    }

    return $children_cats;

  }

  $args = [
    'product_category_id' => get_children_categories($discount_categories),
    'limit' => 1000,
  ];


  $logger->debug('args', array('source' => 'woo4nails', 'args' => get_children_categories($discount_categories, false)));

  $logger->debug('args', array('source' => 'woo4nails', 'args' => get_children_categories($discount_categories)));

  $products = wc_get_products($args);

  /**
   * Retrievs the biggest discount amount among the categories in the settings page and categories of the product  
   * @param array $discount_cats categories with discount from setting page
   * @param array $cats array of the categories of the product 
   * @return string 
   */
  function get_discount_amount_by_cat_id($discount_cats, $cats)
  {
    $discount = 0;

    foreach ($cats as $cat) {
      foreach ($discount_cats as $discount_cat => $value) {
        if ($value['discount_category'] === $cat) {
          if ($value['category_discount'] > $discount) {
            $discount = $value['category_discount'];
          }
        }
      }
    }

    return $discount;
  }

  foreach ($products as $product) {
    $regular_price = $product->get_regular_price();

    $categories = $product->get_category_ids();

    $discount_amount = get_discount_amount_by_cat_id(get_children_categories($discount_categories, false), $categories);

    $new_sale_price = $regular_price - $regular_price / 100 * $discount_amount;

    if ($product->is_on_sale()) {
      $sale_price = $product->get_sale_price();
      if ($sale_price == $new_sale_price) {
        continue;
      }
    }

    $product->set_sale_price($new_sale_price);

    $product->save();

  }
}

// add_action('woocommerce_order_status_changed', 'orderStatusChanged', 10, 4);
/**
 * Возникает при изменении заказа
 * @param int $order_id ИД заказа
 * @param string $old_status Предыдущий статус заказа
 * @param string $new_status Новый статус заказа
 * @param string $order объект класса WC_Order
 */

function orderStatusChanged($order_id, $old_status, $new_status, $order)
{
  if (!$GLOBALS['showPersonalDiscount']) {
    return;
  }

  $_billing_email = get_post_meta($order_id, '_billing_email', true);
  $user = get_user_by('email', $_billing_email);
  if (!is_user_logged_in() || $user == "" || !$user) {
    return;
  }

  if (is_admin()) {

    wc_update_order_item_meta($order_id, 'personal_discount', getUserIndividualDiscountByOrderId($order_id));
    $statuses = ['completed'];
    $customer_id = $order->get_user_id();
    $orders = wc_get_orders(['customer_id' => $customer_id, 'limit' => -1]);
    $total_complete_price = 0;
    $complete_order = [];
    foreach ($orders as $order_item) {
      $order_item = wc_get_order($order_item);
      $status = $order_item->get_status();
      $price = $order_item->get_total();
      $number = $order_item->get_order_number();
      if (in_array($status, $statuses)) {
        $complete_order[] = $number;
        $total_complete_price += $price;
      }
    }

    $email = get_user_meta($customer_id, 'billing_email')[0];

    $list_discount = get_field('personal_discount', 'options');

    $first_discount = isset($list_discount[0]) ? $list_discount[0]['total_price'] : 0;

    $personal_discount = get_field('individual_discount', 'user_' . $customer_id);

    $d = get_field('discount_for_first_complete_order', 'options');

    $send_new_discount = false;

    if (count($complete_order) > 0 && $total_complete_price < $first_discount && $personal_discount < $d) {

      update_field('individual_discount', $d, 'user_' . $customer_id);

      $message = "Congratulations! For the first purchase, you are assigned a personal discount of $d%";

      sendEmailDiscount($email, $message);

      $send_new_discount = true;

    } else {
      $d = 0;
      ksort($list_discount);
      print 'list: ';
      print_r($list_discount);
      print '<br>';
      print 'total complete price: ' . $total_complete_price . '<br>';
      print 'for first order complete: ' . $d . '<br>';

      for ($i = 0; $i < count($list_discount) - 1; $i++) {

        print_r($list_discount[$i]);
        print '<br>';
        if (count($list_discount) - 2 == $i && $total_complete_price > $list_discount[$i + 1]['total_price']) {
          $d = $list_discount[$i]['procent'];
          update_field('individual_discount', $list_discount[$i + 1]['procent'], 'user_' . $customer_id);
          $message = "Total for all orders: $" . number_format($list_discount[$i + 1]['total_price'], 2) . "\n" . "Your personal discount is now: " . $list_discount[$i + 1]['procent'] . " %";
          sendEmailDiscount($email, $message);
          $send_new_discount = true;
          break;
        }
        if ($list_discount[$i]['total_price'] < $total_complete_price && $list_discount[$i + 1]['total_price'] > $total_complete_price && $personal_discount < $list_discount[$i]['procent']) {
          $d = $list_discount[$i]['procent'];
          update_field('individual_discount', $list_discount[$i]['procent'], 'user_' . $customer_id);

          $message = "Total for all orders: $" . number_format($list_discount[$i]['total_price'], 2) . "\n" . "Your personal discount is now: $d%" . "\n";
          sendEmailDiscount($email, $message);
          $send_new_discount = true;
          break;
        }

      }

    }

    if (!$send_new_discount) {
      for ($i = 0; $i < count($list_discount) - 1; $i++) {
        if ($list_discount[$i]['total_price'] < $total_complete_price && $list_discount[$i + 1]['total_price'] > $total_complete_price) {
          update_field('individual_discount', $list_discount[$i]['procent'], 'user_' . $customer_id);
        }
      }
      $message = "Total for all orders: " . $total_complete_price . "$ \n" . " Personal Discount: " . get_field('individual_discount', 'user_' . $customer_id) . "%";
      sendEmailDiscount($email, $message);
    }
  } else {

    $first_name = get_user_meta($order->get_user_id(), 'first_name');
    $last_name = get_user_meta($order->get_user_id(), 'last_name');
    $billing_country = get_user_meta($order->get_user_id(), 'billing_country');
    $shipping_country = get_user_meta($order->get_user_id(), 'shipping_country');

    if (empty($first_name) || $first_name[0] == 'Default name') {
      update_user_meta($order->get_user_id(), 'first_name', $order->get_billing_first_name());
    }
    if (empty($last_name) || $last_name[0] == 'Default lastname') {
      update_user_meta($order->get_user_id(), 'last_name', $order->get_billing_last_name());
    }
    if (empty($billing_country) || $billing_country[0] == '') {
      update_user_meta($order->get_user_id(), 'billing_country', 'US');
    }
    if (empty($shipping_country) || $shipping_country[0] == '') {
      update_user_meta($order->get_user_id(), 'shipping_country', 'US');
    }
  }

  return $order_id;
}

function sendEmailDiscount($email, $message)
{
  $mails = WC()->mailer()->get_emails();

  $headers = $mails['WC_Email_Customer_Note']->get_headers();
  $subjects = wp_specialchars_decode('Personal discount ', get_option('blogname'));

  $mails['WC_Email_Customer_Note']->customer_note = $message;
  $mails['WC_Email_Customer_Note']->template_html = 'emails/discount-note.php';

  $content = $mails['WC_Email_Customer_Note']->get_content_html();

  $mails['WC_Email_Customer_Note']->send($email, $subjects, $content, $headers, '');
}


/* Translate shipping method*/
add_filter('woocommerce_package_rates', 'change_shipping_methods_label_names', 10, 2);
function change_shipping_methods_label_names($rates, $package)
{

  foreach ($rates as $rate_key => $rate) {

    $rates[$rate_key]->label = __($rates[$rate_key]->label, '4nails'); // New label name

  }
  return $rates;
}

/**
 * Получает сумму индивидуальной скидки для заказа
 * @param WC_Order $order 
 * @return float|int
 */
function get_individual_discount_order($order)
{
  $total_discount = 0;

  if (!$order)
    return 0;
  $discount = get_field('individual_discount', 'user_' . $order->get_user_id());
  if ($discount) {

    foreach ($order->get_items() as $item) {
      $product = $item->get_product();

      $quantity = $item['quantity'];

      $price = $product->get_regular_price();

      $personal_discount_price = get_product_price($product);

      $total_discount += ($price - $personal_discount_price) * $quantity;

    }
  }
  return $total_discount;
}

/**
 * Получает сумму индивидуальной скидки для корзины
 * @param WC_Cart $order 
 * @return float|int
 */
function get_individual_discount_cart($cart)
{
  $personal_total = 0;
  $sale_total = 0;
  $regular_total = 0;
  if ($discount = get_field('individual_discount', 'user_' . get_current_user_id())) {
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
      $product = $cart_item['data'];
      $quantity = $cart_item['quantity'];

      $regular_total += $quantity * $product->regular_price;

      if ($product->sale_price) {
        $sale_total += ($product->regular_price - $product->sale_price) * $quantity;
      } else {
        $personal_total += ($quantity * $product->regular_price) * ($discount / 100);
      }

    }
  }
  return $personal_total;
}

/**
 * Вывод цены на продукт, учитывая возможную персональную скидку. При указании $order_id, функция берет пользователя из указанного заказа и расчитывает цену для него, иначе для текущего пользователя. 
 * 
 * @param int $product_id id продукта
 * @param int $order_id (optional) Номер заказа
 * @return int $product_price
 */
function get_product_price($product_id, $order_id = null)
{
  $user_discount = 0;

  if ($order_id) {
    $order = wc_get_order($order_id);
    if ($order->get_user_id()) {
      $user_discount = is_user_logged_in() ? get_field('individual_discount', 'user_' . $order->get_user_id()) : 0;
    }
  }

  if (!$user_discount) {
    $user_discount = is_user_logged_in() ? get_field('individual_discount', 'user_' . get_current_user_id()) : 0;
  }

  $product = get_product($product_id);

  if ($GLOBALS['showPersonalDiscount']) {

    $personal_price = $user_discount && $user_discount > 0 ? ($product->get_regular_price() - ($product->get_regular_price() * ((float) $user_discount / 100))) : $product->get_regular_price();

    if ($product->is_on_sale()) {

      $sale_price = $product->is_type('variable') ? $product->get_variation_sale_price('min', true) : $product->get_sale_price();
      if ($sale_price < $personal_price) {
        return $sale_price;
      }

    }
    return $personal_price;

  }
  if ($product->is_on_sale()) {
    return $product->is_type('variable') ? $product->get_variation_sale_price('min', true) : $product->get_sale_price();
  }

  return $product->get_regular_price();

}


function get_regular_or_variable_price($product, $user)
{
  if ($product->is_type('variable')) {
    return $product->get_variation_sale_price('min', true) - ($product->get_variation_sale_price('min', true) * ((float) $user / 100));
  }
  return $product->get_regular_price() - ($product->get_regular_price() * ((float) $user / 100));
}

function if_user_have_sale()
{
  return is_user_logged_in() ? get_field('individual_discount', 'user_' . get_current_user_id()) : 0;
}

function if_different_warehouses($cart)
{
  $items_delivery = [];
  $product_ids = [];
  foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
    $product = $cart_item['data'];
    array_push($items_delivery, !if_sunflower($product));
    array_push($product_ids, $cart_item['product_id']);
  }
  if ((count(array_unique($items_delivery)) === 1)) {
    return ['different' => false];
  }
  return ['different' => true, 'ids' => $product_ids];
}

add_action('init', 'woocommerce_clear_cart_url');
function woocommerce_clear_cart_url()
{
  global $woocommerce;

  if (isset($_GET['empty-cart'])) {
    $woocommerce->cart->empty_cart();
  }
}

function if_overweight($cart)
{
  return $cart->get_cart_contents_weight() > 30;
}

function get_over_overweight_list($cart)
{
  $products_list = [];
  $weight = 0;
  $temp = [];

  foreach ($cart->get_cart() as $cart_item_key => $cart_item) {


    $item_weight = $cart_item['data']->get_weight() * $cart_item['quantity'];
    $weight += $item_weight;
    $product = $cart_item['data'];
    if ($weight > 25) {
      array_push($products_list, $temp);
      $temp = [];
      array_push($temp, $product->get_id());
    } else {
      array_push($temp, $product->get_id());
    }
  }
  array_push($products_list, $temp);
  return $products_list;
}

function get_cart_weight($cart)
{
  return $cart->get_cart_contents_weight();
}

/*Remove attached product from invoice*/
function add_unit_of_measure_column_data($row, $item_id, $item, $invoice)
{
  $product = $item->get_product();
  if ($product) {
    if (get_field('attached_product', $item->get_product_id())) {
      $row = '';
    }

  }
  return $row;
}

add_filter('wpi_get_invoice_columns_data_row', 'add_unit_of_measure_column_data', 20, 4);


function ifPersonalDiscount($product)
{
  $product_price = get_product_price($product->id);
  $sale_price = $product->get_sale_price();

  return !$product->is_virtual() && if_user_have_sale() && ($product_price < $sale_price || !$product->is_on_sale());
}

add_action('woocommerce_admin_order_totals_after_discount', 'vp_add_sub_total', 10, 1);
function vp_add_sub_total($order_id)
{
  if (!$GLOBALS['showPersonalDiscount']) {
    return;
  }
  $order = wc_get_order($order_id);
  ?>
<tr>
  <td class="label">Personal discount:</td>
  <td width="1%"></td>
  <td class="total"><?php echo wc_price(get_individual_discount_order($order)) ?></td>
</tr>
<?php
}

add_action('woocommerce_admin_order_item_headers', 'my_woocommerce_admin_order_item_headers');
function my_woocommerce_admin_order_item_headers()
{

  echo '<th>' . 'Total price' . '</th>';
}

add_action('woocommerce_admin_order_item_values', 'my_woocommerce_admin_order_item_values', 10, 3);
function my_woocommerce_admin_order_item_values($_product, $item, $item_id = null)
{

  if (isset($_product) && isset($_product->id)) {

    if ($item['type'] == "line_item") {
      $meta = wc_get_order_item_meta($item_id, '_product_price', true);
      $actual = get_product_price($_product->get_id());
      echo '<td>' . wc_price($meta ? $meta : $actual) . '</td>';
    }
  }
}

function getUserIndividualDiscountByOrderId($orderId)
{
  $order = wc_get_order($orderId);
  if ($order->get_user_id()) {
    return get_field('individual_discount', 'user_' . $order->get_user_id());
  }
  return 0;
}

function add_unit_of_measure_column_data1($row, $item_id, $item, $invoice)
{
  $actualPrice = get_product_price($item['product_id'], $item['order_id']) * $item['quantity'];
  $metaPrice = floatval(wc_get_order_item_meta($item_id, '_product_price', true)) * $item['quantity'];

  $row['total'] = wc_price($metaPrice ? $metaPrice : $actualPrice);

  return $row;
}

add_filter('wpi_get_invoice_columns_data_row', 'add_unit_of_measure_column_data1', 20, 4);

add_action('wp_login', function () {
  if (isset($_COOKIE["returnToCart"])) {
    wp_redirect($_COOKIE["returnToCart"], 301);
    unset($_COOKIE['returnToCart']);
    exit;
  }
});

add_action('wp_login', function () {
  if (isset($_COOKIE["returnToCancelOrder"])) {
    wp_redirect($_COOKIE["returnToCancelOrder"], 301);
    unset($_COOKIE['returnToCancelOrder']);
    exit;
  }
});

function mysite_woocommerce_order_status_completed()
{
  if (!current_user_can('manage_options'))
    return false;
  if (!is_admin())
    return false;
  if ($_REQUEST['post_type'] != 'shop_order')
    return false;
  if ($_REQUEST['post_ID'] != '') {
    $orderId = $_REQUEST['post_ID'];
    $order = new WC_Order($orderId);
    $currentStatus = $order->status;
    $requestedStautus = $_REQUEST['order_status'];
    if ($currentStatus == 'completed') {
      $order = wc_get_order($orderId);
      $personal = get_individual_discount_order($order);
      $total = $order->get_total() - $personal;
      $order->set_total($total);
      $order->save();
    }
  }
}

add_action('save_post', 'mysite_woocommerce_order_status_completed', 10, 1);

function store_mall_wc_empty_cart_redirect_url()
{
  return esc_url(home_url());
}

add_filter('woocommerce_return_to_shop_redirect', 'store_mall_wc_empty_cart_redirect_url');

function kia_display_order_data_in_admin($order)
{
  if (!$GLOBALS['showPersonalDiscount']) {
    return;
  }
  if ($order->get_user_id()) {
    $discount = empty(get_post_meta($order->id, 'personal_discount', true)) ? getUserIndividualDiscountByOrderId($order->id) : get_post_meta($order->id, 'personal_discount', true);

    echo '<p style="margin-top: 15px; display: inline-block"><strong>Personal discount: </strong>' . $discount . '%</p>';
  }
}

add_action('woocommerce_admin_order_data_after_order_details', 'kia_display_order_data_in_admin');

wp_enqueue_script('wc-add-to-cart-variation');

function custom_wc_ajax_variation_threshold($qty, $product)
{
  return 100;
}

add_filter('woocommerce_ajax_variation_threshold', 'custom_wc_ajax_variation_threshold', 100, 2);


add_filter('woocommerce_gateway_icon', 'gt_change_my_icons', 10, 2);

function gt_change_my_icons($icon_string, $id)
{

  if ('stripe' === $id) {
    $icon_string .= file_get_contents(path() . '/assets/img/Stripe_Logo,.svg');

  }


  return $icon_string;
}

function lp_free_shipping_label($label, $object)
{

  $temp = explode(')', $label);

  if ($temp[1]) {

    $label = $temp[0] . ')<div class="shipping_method-description">' . $temp[1] . '</div>';

  }
  return $label;
}

add_filter('woocommerce_shipping_rate_label', 'lp_free_shipping_label', 10, 2);


function print_order_line_item_meta($items, $order)
{
  $order_number = $order->get_order_number();
  $items = $order->get_items();
  foreach ($items as $item) {
    $price = get_product_price($item->get_product_id());
    $item->update_meta_data('_product_price', $price);
    $item->save_meta_data();
  }
}

add_action('woocommerce_order_status_on-hold', 'print_order_line_item_meta', 10, 2);


add_filter('woocommerce_package_rates', 'hide_shipping_method_based_on_shipping_class', 10, 2);
function hide_shipping_method_based_on_shipping_class($rates, $package)
{
  if (is_admin() && !defined('DOING_AJAX'))
    return;

  foreach ($package['contents'] as $item) {

    if ($item['data']->get_shipping_class_id() == '208' || $item['data']->get_shipping_class_id() == '209' || $item['data']->get_shipping_class_id() == '207' || $item['data']->get_shipping_class_id() == '205') {

      unset($rates['local_pickup:7']);
      unset($rates['flat_rate:14']);

    }
  }
  return $rates;
}


add_filter('woocommerce_product_add_to_cart_text', 'my_woocommerce_variable_text_button', 1000, 2);

function my_woocommerce_variable_text_button($text, $product)
{
  echo '<!-- ' . $product->product_type . ' rom -->';
  if ($product->product_type == 'variable') {
    $text = 'ADD TO CART';
  }
  return $text;
}

function show_summ_all_products($cat)
{
  $count = 0;
  $screen = get_current_screen();
  $post_type = get_post_type();

  if (is_admin() && $screen->action == '' && $screen->base == 'edit' && $post_type == 'product') {
    $full_product_price = 0;
    $price_with_sale = 0;
    $args = array(
      'post_type' => 'product',
      'product_cat' => $cat,
      'posts_per_page' => -1
    );

    $loop = new WP_Query($args);

    while ($loop->have_posts()) {
      $loop->the_post();
      global $product;
      $count += (int) $product->get_stock_quantity();
      $full_product_price += ((int) $product->get_price() * (int) $product->get_stock_quantity());

    }

    wp_reset_query();

    return $full_product_price . ' $. <br>Count: ' . $count;

  }
}

add_action('admin_bar_menu', 'show_total_price_in_admin_menu');
function show_total_price_in_admin_menu()
{
  $screen = get_current_screen();
  $post_type = get_post_type();
  if (is_admin() && $screen->action == '' && $screen->base == 'edit' && $post_type == 'product') {

    echo "<div id='goods-info' style=' position: absolute;top: 55px;left: 543px;'>" . "<h2 style='color: red'>" . 'Total price of products: ' . show_summ_all_products($_GET['product_cat']) . '</h2>' . '</div>';
  }

}

function warp_ajax_product_remove()
{
  // Get mini cart
  ob_start();

  foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    if ($cart_item['product_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key']) {
      WC()->cart->remove_cart_item($cart_item_key);
    }
  }

  WC()->cart->calculate_totals();
  WC()->cart->maybe_set_cart_cookies();

  woocommerce_mini_cart();

  $mini_cart = ob_get_clean();

  // Fragments and mini cart are returned
  $data = array(
    'fragments' => apply_filters(
      'woocommerce_add_to_cart_fragments',
      array(
        'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
      )
    ),
    'cart_hash' => apply_filters('woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5(json_encode(WC()->cart->get_cart_for_session())) : '', WC()->cart->get_cart_for_session())
  );

  wp_send_json($data);

  die();
}

add_action('wp_ajax_product_remove', 'warp_ajax_product_remove');
add_action('wp_ajax_nopriv_product_remove', 'warp_ajax_product_remove');


add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts()
{
  echo '<style>
    .is-dismissible{
    display: none;
}
  </style>';
}


function is_different_shipping_address($customer)
{
  $billing_address = $customer->get_billing();
  $shipping_address = $customer->get_shipping();
  if (!empty($billing_address) && !empty($shipping_address)) {
    foreach ($billing_address as $billing_address_key => $billing_address_value) {
      if (isset($shipping_address[$billing_address_key])) {
        $shipping_address_value = $shipping_address[$billing_address_key];

        if (!empty($billing_address_value) && !empty($shipping_address_value) && strcmp($billing_address_value, $shipping_address_value) !== 0) {
          return true;
        }
      }
    }
  }
  return false;
}

add_filter('woocommerce_paypal_payments_checkout_button_renderer_hook', function () {
  return 'woocommerce_review_order_after_submit';
});


//add_action( 'woocommerce_after_checkout_validation', 'validate_credit_card', 10, 2 );
function validate($data, $errors)
{
  print_r($data);
  $bin = '45717360'; // <-- you need to find a way to get your credit card infos and take the first part with substr()
  $response = wp_safe_remote_get('https://lookup.binlist.net/' . $bin);

  if (isset($response['body'])) {
    $response_body = json_decode($response['body']);

    if ($response_body->country->alpha2 !== 'US') {
      $errors->add('credit_card_error', 'Your credit card is not from a US country.');
    }
  } else {
    $errors->add('credit_card_error', 'Unable to check your credit card.');
  }
}


function calcTotalFee()
{
  $cart_totals_fee_html = 0;
  foreach (WC()->cart->get_fees() as $fee) {
    $cart_totals_fee_html = WC()->cart->display_prices_including_tax() ? $fee->total + $fee->tax : $fee->total;
  }
  return $cart_totals_fee_html;
}


add_action('wp_ajax_checkoutState', 'updateUserData'); // wp_ajax_{ЗНАЧЕНИЕ ПАРАМЕТРА ACTION!!}
add_action('wp_ajax_nopriv_checkoutState', 'updateUserData');
function updateUserData()
{

  $data = json_decode(stripslashes($_POST['userData']));


  update_user_meta(get_current_user_id(), 'billing_country', $data->billing_country);
  update_user_meta(get_current_user_id(), 'billing_first_name', $data->billing_first_name);
  update_user_meta(get_current_user_id(), 'billing_last_name', $data->billing_last_name);
  update_user_meta(get_current_user_id(), 'billing_company', $data->billing_company);
  update_user_meta(get_current_user_id(), 'billing_address_1', $data->billing_address_1);
  update_user_meta(get_current_user_id(), 'billing_address_2', $data->billing_address_2);
  update_user_meta(get_current_user_id(), 'billing_city', $data->billing_city);
  update_user_meta(get_current_user_id(), 'billing_state', $data->billing_state);
  update_user_meta(get_current_user_id(), 'billing_postcode', $data->billing_postcode);
  update_user_meta(get_current_user_id(), 'billing_phone', $data->billing_phone);
  update_user_meta(get_current_user_id(), 'billing_email', $data->billing_email);

  if (isset($data->shipping_country)) {
    update_user_meta(get_current_user_id(), 'shipping_country', $data->shipping_country);
    update_user_meta(get_current_user_id(), 'shipping_first_name', $data->shipping_first_name);
    update_user_meta(get_current_user_id(), 'shipping_last_name', $data->shipping_last_name);
    update_user_meta(get_current_user_id(), 'shipping_company', $data->shipping_company);
    update_user_meta(get_current_user_id(), 'shipping_address_1', $data->shipping_address_1);
    update_user_meta(get_current_user_id(), 'shipping_address_2', $data->shipping_address_2);
    update_user_meta(get_current_user_id(), 'shipping_city', $data->shipping_city);
    update_user_meta(get_current_user_id(), 'shipping_state', $data->shipping_state);
    update_user_meta(get_current_user_id(), 'shipping_postcode', $data->shipping_postcode);
    update_user_meta(get_current_user_id(), 'shipping_phone', $data->shipping_phone);
  }

  wp_die();
}


function has_product_with_free_delivery()
{
  foreach (WC()->cart->get_cart() as $cart_item) {
    $product = $cart_item['data'];

    $product_id = $product->get_id();

    $free_delivery = get_field('free_delivery1', $product_id);

    if ($free_delivery === 'true') {

      return true;
    }
  }

  return false;
}


function modify_shipping_methods($rates, $package)
{

  if (has_product_with_free_delivery()) {
    foreach ($rates as $rate_key => $rate) {
      // Remove all shipping methods except 'free_shipping'
      if ($rate->method_id !== 'free_shipping') {
        unset($rates[$rate_key]);
      }
    }
    return $rates;
  } else {
    foreach ($rates as $rate_key => $rate) {
      if ($rate->method_id === 'free_shipping') {

        unset($rates[$rate_key]);
      }
    }
    return $rates;
  }
}

add_filter('woocommerce_package_rates', 'modify_shipping_methods', 10, 2);

add_filter('woocommerce_paypal_payments_basic_checkout_validation_enabled', '__return_true');

// update customer address on checkout before payment method is chosen
add_action('woocommerce_checkout_process', 'nails_update_customer_data');

function nails_update_customer_data()
{
  if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    $checkout = WC()->checkout;
    $posted_data = $checkout->get_posted_data();

    foreach ($posted_data as $meta_key => $meta_value) {
      update_user_meta($user_id, $meta_key, $meta_value);
    }

  }

}

add_action('woocommerce_checkout_order_processed', 'apply_personal_discount_on_order_nails', 10, 3);

/**
 * Применяет возможную персональную скидку к заказу и меняет итоговую сумму в заказе. Функция применяется с хуком "woocommerce_checkout_order_processed".
 * @param mixed $order_id Номер заказа
 * @param mixed $posted_data, не используется
 * @param WC_Order $order Заказ

 */
function apply_personal_discount_on_order_nails($order_id, $posted_data, $order)
{
  // woocommerce_checkout_order_processed

  if ($GLOBALS['showPersonalDiscount']) {
    $order_items = $order->get_items();
    $user_id = $order->get_user_id();
    $personal_discount = is_user_logged_in() ? get_field('individual_discount', 'user_' . $user_id) : 0;
    if ($personal_discount) {
      foreach ($order_items as $item_id => $item) {
        $product = $item->get_product();
        $price = get_product_price($product->get_id());

        $product_quantity = (int) $item->get_quantity(); // product Quantity

        // The new line item price
        $new_line_item_price = $price * $product_quantity;

        // Set the new price
        $item->set_subtotal($new_line_item_price);
        $item->set_total($new_line_item_price);

        // Make new taxes calculations
        $item->calculate_taxes();

        $item->save();

      }

      $order->calculate_totals();

      $order->save();
    }

  }
}

add_filter('woocommerce_cart_taxes_total', 'change_cart_taxes_for_personal_discount', 10, 4);

/**
 * Исправляет taxes total в корзине при включенной персональной скидке. Функция применяется с фильтром 'woocommerce_cart_taxes_total'. 
 * @param float | int $total
 * @param mixed $compound
 * @param mixed $display
 * @param WC_Cart $cart
 * @return float | int $total
 */
function change_cart_taxes_for_personal_discount($total, $compound, $display, $cart)
{
  $rate = reset(WC_Tax::get_rates())['rate'];

  if (!$GLOBALS['showPersonalDiscount'] || !$rate) {
    return $total;
  }

  $new_tax_total = 0;
  $items = $cart->get_cart();

  foreach ($items as $item => $values) {

    $pesonal_price = $values['variaion_id'] != 0 ? get_product_price(wc_get_product($values['variaion_id'])) : get_product_price(wc_get_product($values['product_id']));

    $product_quantity = $values['quantity'];

    $new_tax_total += round($pesonal_price * $product_quantity * $rate / 100, 2);

  }


  return $new_tax_total;
}

add_action('4nail_after_archive_product', 'show_quantity_modal');

function show_quantity_modal()
{
  return get_template_part('widgets/product/quantity-modal');
}
add_filter('woocommerce_quantity_input_classes', function ($elemetns) {
  // var_dump($elemetns);
  return array('text');
}, 2, 20);
//function pekky_cx_preferred_countries( $countries ){
//    $countries = array('us','mx','ca');
//    return $countries;
//}
//add_filter( 'wc_pv_preferred_countries', 'pekky_cx_preferred_countries' );
//
//add_filter( 'wc_pv_use_wc_default_store_country', '__return_true' );