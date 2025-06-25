<?php

$formatted_destination = isset($formatted_destination) ? $formatted_destination : WC()->countries->get_formatted_address($package['destination'], ', ');
$has_calculated_shipping = !empty($has_calculated_shipping);
$show_shipping_calculator = !empty($show_shipping_calculator);
$calculator_text = '';
$cart = WC()->cart;
if ($has_calculated_shipping && if_overweight($cart)) {
  $cart->set_shipping_total(0);
}
?>

<div class="checkout__order-item">
  <div
  class="checkout__order-right"
  data-title="<?php echo esc_attr($package_name); ?>"
  >
    <?php if ($available_methods): ?>
      <ul
      id="shipping_method"
      class="woocommerce-shipping-methods p-0"
      >
        <?php foreach ($available_methods as $method):

          // Отобразить только 2 метода доставки, если в корзине перевес
          if (if_overweight(WC()->cart) && $method->id !== 'overweight_shipping' && $method->id !== 'local_pickup:7') {
            continue;
          }
          if (if_overweight($cart)) {
            $chosen_method = 'overweight_shipping';
          }
          ?>
          <li>
            <?php
            if (1 <= count($available_methods)) {
              printf('<div class="custom-control custom-radio"><input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method custom-control-input" %4$s />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id), checked($method->id, $chosen_method, false));
              printf('<label class="custom-control-label" for="shipping_method_%1$s_%2$s">%3$s</label></div>', $index, esc_attr(sanitize_title($method->id)), add_shipping_info($method, $chosen_method)); // WPCS: XSS ok.
            }
            do_action('woocommerce_after_shipping_rate', $method, $index);
            ?>

          </li>
        <?php endforeach; ?>

      </ul>
    <?php endif; ?>
  </div>

</div>