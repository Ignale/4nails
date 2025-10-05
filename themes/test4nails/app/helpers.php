<?php

/* Give default url path*/
function path()
{
  return get_template_directory_uri() . '/';
}
/* Give default path*/
function theme_path()
{
  return get_template_directory() . '/';
}
/* Write svg  in html*/
function the_icon($name, $echo = true)
{
  /* LOMATKOD
          $icon = file_get_contents(path() . "assets/img/icons/$name.svg");
          if ($echo) {
            echo $icon;
            return true;
          }
          return file_get_contents(path() . "assets/img/icons/$name.svg");
          */
  //Obtaining an internal address and not Url
  $icon_path = get_stylesheet_directory() . "/assets/img/icons/{$name}.svg";

  if (!file_exists($icon_path)) {
    return false; // If the file is not found, return the empty line
  }

  // Get the contents of the SVG file
  $icon = file_get_contents($icon_path);

  // Remove the line <? XML Version = "1.0"
  // We convert <? XML Version = "1.0 ...> in the comment <!-? XML Version =" 1.0 "?->
  if (strpos($icon, '<?xml') !== false) {
    $icon = preg_replace([
      '/<\?xml (.*?)\?>/',
      '/
<!DOCTYPE (.*?)>/'
    ], [
      '
<!-- ?xml $1  -->',
      '
<!-- !DOCTYPE $1 -->'
    ], $icon);
  }

  //print_r('icon='.json_encode( [$icon]));

  if ($echo) {
    echo $icon;
    return true;
  }

  return $icon;
}

/**
 * Gets category image by id || Получить изображение категории по id
 * @param mixed $termId - id of the category || id категории
 * @return mixed
 */
function categoryImage($termId)
{
  return get_term_meta($termId, 'thumbnail_id', true);
}

/**
 * Получает название таксономии по id || Get taxonomy name by id
 * @param string $id - id of the taxonomy || id таксономии
 * @param string $taxonomy - name of the taxonomy || имя таксономии
 * @return string - title of the taxonomy || название таксономии
 */
function get_taxonomy_name($id, $taxonomy, )
{
  $dynamic_id = apply_filters('wpml_object_id', $id, $taxonomy);
  echo get_cat_name($dynamic_id);
}
/**
 * Get the image by name || Получить изображение по имени
 * @param mixed $name - name of the field || имя поля
 * @param mixed $class - class for image || класс для изображения
 * @param mixed $post - post id || id поста
 * @param mixed $size - size of image || размер изображения
 * @return void
 */
function the_image($name, $class = '', $post = null, $size = 'full')
{
  if ($post == null) {
    global $post;
  }

  $image = get_field($name, $post);

  if ($post == 'option') {
    $src = $image['url'];
    $alt = $image['alt'];
    echo "<img
  width='1'
  height='1'
  style='width: 100%; height: auto;'
  src='$src'
  alt='$alt'
  class='$class'
/>";
  } else {

    echo wp_get_attachment_image($image, $size, false, ['class' => $class]);
  }
}

/**
 * Get parent categories || Получить родительские категории
 * @return mixed
 */
function parentCategories()
{
  return get_terms('product_cat', [
    'parent' => 0
  ]);
}

/**
 * Gets account_url || Получить url аккаунта
 * @return void
 */
function account_url()
{
  echo get_permalink(wc_get_page_id('myaccount'));
}

/**
 * Gets wishlist_url || Получить url списка желаний
 * @return void
 */
function wishlist_url()
{
  echo tinv_url_wishlist_default();
}
//get the cart count
function cart_content()
{
  echo WC()->cart->get_cart_contents_count() ?: '';
}

/**
 * Gets the page url by id and language || Получить url страницы по id и языку
 * @param mixed $page_id
 * @return string - url of the page || url страницы
 */
function page_url($page_id)
{
  echo apply_filters('wpml_permalink', get_permalink($page_id));
  ;
}
;

function cart_url()
{
  echo apply_filters('wpml_permalink', wc_get_cart_url());
}

function cart_active()
{
  echo WC()->cart->get_cart_contents_count() && !is_cart() ? 'active-cart' : '';
}

/**
 * Получить id youtube видео из ссылки || Get youtube video id from url
 * @param $url
 * @return mixed
 */
function get_youtube_id_from_url($url)
{
  preg_match('/(http(s|):|)\/\/(www\.|)yout(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $results);
  return $results[6];
}

/**
 * Получить % скидки || Get sale %
 * @param $product
 * @return false|int
 */
function getSalePrice($product)
{
  $isVariable = $product->is_type('variable');
  if ($product->is_on_sale()) {
    $sale = $isVariable ? $product->get_variation_sale_price('min', true) : $product->get_sale_price();
    $regular = $isVariable ? $product->get_variation_regular_price('min', true) : $product->get_regular_price();
    $sale_amount = 100 - intval(($sale / $regular) * 100);
    return $sale_amount;
    ;
  }
  return false;
}
function the_sku($product = null)
{
  if ($product == null) {
    global $product;
  }
  echo $product->get_sku();
}

function the_post_content()
{
  global $id;
  echo apply_filters('the_content', wpautop(get_post_field('post_content', $id), true));
}

function moveKeyBefore($arr, $find, $move)
{
  if (!isset($arr[$find], $arr[$move])) {
    return $arr;
  }

  $elem = [$move => $arr[$move]]; // cache the element to be moved
  $start = array_splice($arr, 0, array_search($find, array_keys($arr)));
  unset($start[$move]); // only important if $move is in $start
  return $start + $elem + $arr;
}
function the_checkbox($field, $print, $post = null)
{
  if ($post == null) {
    global $post;
  }
  echo get_field($field, $post) ? $print : null;
}

/* Get link in correct language*/
function get_registration_link()
{
  global $current_language;
  switch ($current_language) {
    case 'ru-RU':
      return '/ru/my-account/registration';
    case 'es':
      return '/es/my-account/?registration=1';
    default:
      return '/my-account/registration';
  }
}
function get_lang_url()
{
  global $current_language;
  switch ($current_language) {
    case 'ru-RU':
      return '/ru/';
    case 'es':
      return '/es/';
    default:
      return '/';
  }

  return '/';
}

function get_order_total($orders)
{
  $total_orders = 0;
  foreach ($orders as $order) {
    $total_orders += $order->total;
  }
  return $total_orders;
}
function cart_items()
{
  echo WC()->cart->get_cart_contents_count() == 1 ? ' ' . __('item', '4nails') : ' ' . __('items', '4nails');
}

/**
 * Insert array into another array at specific position || Вставить массив в другой массив на определенную позицию
 * @param array $array
 * @param int $position
 * @param array $insert_array
 * @return array
 */
function array_insert($array, $position, $insert_array)
{
  $first_array = array_splice($array, 0, $position);
  $second_array = array_splice($array, $position);
  return array_merge($first_array, $insert_array, $second_array);
}

function get_wishlist()
{
  $wlp = TInvWL_Public_Wishlist_View::instance();
  $wishlist = $wlp->get_current_wishlist();
  $products = $wlp->get_current_products($wishlist);
  $ids = array_map(function ($product) {
    return $product['product_id'];
  }, $products);
  if (!empty($products)) {
    $query = new WP_Query([
      'post_type' => 'product',
      'post_status' => 'publish',
      'post__in' => $ids,
      'posts_per_page' => -1
    ]);
    return $query;
  }
}

function if_gel_category($cate)
{
  $cateID = $cate->term_id;
  if ($cateID == 20 || $cateID == 87 || $cateID == 126) {
    return 1;
  }
  return 0;
}
/* Check if it blog page*/

function is_blog()
{
  return (is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' ==
    get_post_type();
}
function if_international()
{
  $chosen_methods = WC()->session->get('chosen_shipping_methods');
  if ('jem_table_rate_20_international-shipping' == $chosen_methods[0]) {
    return 'international-shipping';
  }
}

function if_free_delivery_type($product)
{
  return get_field('free_delivery', $product->get_id());
}

function if_sunflower($product)
{

  return get_field('another_warehouse', $product->get_id());
}

function getProductTranslatedName($product_id, $order_id, $langOfSite = false)
{
  $lang = $langOfSite ? ICL_LANGUAGE_CODE : get_post_meta($order_id, 'wpml_language', true);
  $id = apply_filters('wpml_object_id', $product_id, 'product', true, $lang);
  if ($id) {
    return get_the_title($id);
  } else {
    return get_the_title($product_id);
  }
}

function check_product_in_cart($id, $qty)
{
  $product = wc_get_product($id);
  if (!$product) {
    return false;
  }
  $product_stock = $product->get_stock_quantity();

  foreach (WC()->cart->get_cart() as $item => $values) {
    if ($id == $values['variaton_id'] || $id == $values['product_id']) {
      if (
        $product_stock <
        ($qty
          +
          $values['quantity'])
      ) {
        return
          true;
      }
    }
  }
  return
    false;
}
function
  send_add_to_cart_success_message(
  $product,
  $is_product_in_cart = null
) {
  $response = [];
  $response['status'] = 'ok'
  ;
  $response['is_product_in_cart'] = $is_product_in_cart;
  ob_start();
  ?>

  <!-- <div class="woocommerce-message">
    <?php
    // echo wc_add_to_cart_message($product['id'], false, true); 
    ?>
  </div> -->
  <?php
  $response['notice'] = ob_get_clean();

  ob_start();
  woocommerce_mini_cart();
  $response['cart'] = ob_get_clean();


  ob_start();
  get_template_part('widgets/modal');
  $response['modal'] = ob_get_clean();

  echo json_encode($response);
  die();
}

function get_shipping_label_id($label) {
return strtolower(str_replace(' ', '_', preg_replace('/[\(\)]/', '', $label)));
}

function write_log_info($data) {
  $logger  = wc_get_logger();
  $context = ['source' => 'woo4nails'];
  if( is_array($data)) {
    $data = json_encode($data);
  }
  if( is_object($data)) {
    $data = json_encode($data, JSON_PRETTY_PRINT);
  }
  if( is_string($data)) {
    $data = str_replace("\n", ' ', $data);
  }
  if( is_bool($data)) {
    $data = $data ? 'true' : 'false';
  }   
  if( is_null($data)) {
    $data = 'null';
  }
  // Write the log
  $logger->info(
    $data,
    $context
  );  

}

function get_sale_amount($price_without_sale, $price_with_sale)
{
  if ($price_without_sale == 0) {
    return 0;
  }
  $sale_amount = 100 - round(($price_with_sale / $price_without_sale) * 100, 0);
  return $sale_amount;
}

function send_add_to_cart_error_message($product, $is_product_in_cart = null)
{
  $response = [];
  $response['status'] = 'error';

  $response['is_product_in_cart'] = $is_product_in_cart;

  $response['data'] = $product;

  ob_start();

  get_template_part('widgets/product/quantity', 'modal', ['product' => $product]);

  $response['notice'] = ob_get_contents();

  ob_clean();

  echo json_encode($response);
  die();
}