<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */


defined('ABSPATH') || exit;

$text_align = is_rtl() ? 'right' : 'left';

do_action('woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email);

$nails_get_totals = get_order_info($order->get_id());


$fee_name = 0;
$fee_total = 0;
// Iterating through order fee items ONLY
foreach ($order->get_items('fee') as $item_id => $item_fee) {


  $fee_name = $item_fee->get_name();


  $fee_total = $item_fee->get_total();


}


?>

<h2>
  <?php

  if ($sent_to_admin) {
    $before = '<a class="link" href="' . esc_url($order->get_edit_order_url()) . '">';
    $after = '</a>';
  } else {
    $before = '';
    $after = '';
  }
  /* translators: %s: Order ID. */
  echo wp_kses_post($before . sprintf(__('[Order #%s]', 'woocommerce') . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format('c'), wc_format_datetime($order->get_date_created())));
  ?>
</h2>
<?php
$active = get_field('news_line_are_active', 'options');

if ($active) {

  $now = strtotime(date('d.m.Y 00:00:00'));

  if (get_field('news_line_display_message_in_email', 'options')) {


    $begin_date = strtotime(get_field('news_line_date_begin', 'options'));
    $end_date = strtotime(get_field('news_line_date_end', 'options'));

    if ($now >= $begin_date && $now <= $end_date) {
      echo '<b>' . get_field('news_line_content', 'options') . '</b>';
    }
  }

}
?>
<div style="margin-bottom: 40px; margin-top: 10px;">
  <table
    class="td"
    cellspacing="0"
    cellpadding="6"
    style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;"
    border="1"
  >
    <thead>
      <tr>
        <th
          class="td"
          scope="col"
          style="text-align: <?php echo esc_attr($text_align); ?>;"
        ><?php esc_html_e('Product', 'woocommerce'); ?></th>
        <th
          class="td"
          scope="col"
          style="text-align: <?php echo esc_attr($text_align); ?>;"
        ><?php esc_html_e('Qty', '4nails'); ?></th>
        <th
          class="td"
          scope="col"
          style="text-align: <?php echo esc_attr($text_align); ?>;"
        ><?php esc_html_e('Price', 'woocommerce'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php
      echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        $order,
        array(
          'show_sku' => $sent_to_admin,
          'show_image' => false,
          'image_size' => array(32, 32),
          'plain_text' => $plain_text,
          'sent_to_admin' => $sent_to_admin,
        )
      );
      ?>
    </tbody>
    <tfoot>
      <?php

      $discount_total = $order->cart_discount;

      $item_totals = $order->get_order_item_totals();

      $shipping_value = 0;
      $shipping_items = $order->get_items('shipping');
      if ($shipping_items) {
        $method_name = reset($order->get_items('shipping'))->get_method_id();
        $method_id = reset($order->get_items('shipping'))->get_instance_id();
        if ($method_name == 'local_pickup' || $method_name == 'free_shipping') {
          $shipping_value = $item_totals['shipping']['value'];
        } elseif ($method_name == 'jem_table_rate' && $method_id == 20) {
          $shipping_value = __('The amount is approximate and a final sum will need to be determined.', '4nails');
        } else {
          $shipping_value = '<span >+&nbsp;</span>' . $item_totals['shipping']['value'];
        }
      } else {
        $shipping_value = __('Free shipping', '4nails');
      }
      /* switch (reset($order->get_items('shipping'))->get_method_id()){
           case 'local_pickup':
               $shipping_value=$item_totals['shipping']['value'];
               break;
           case 'jem_table_rate':
               $shipping_value='<span >+&nbsp;</span>'.$item_totals['shipping']['value'].' '.__('The amount is approximate and a final sum will need to be determined.','4nails');
               break;
           default:
               $shipping_value='<span >+&nbsp;</span>'.$item_totals['shipping']['value'];

       }*/
      if ($item_totals['shipping']['label'] == 'Local pickup') {
        $shipping_value = $item_totals['shipping']['value'];
      }
      $changed_item_totals = [

        'cart_subtotal' => [
          'label' => __('Subtotal', '4nails') . ":",
          'value' => wc_price($nails_get_totals['subtotal']),
        ],
        'discount' => [
          'label' => __('Discount', '4nails') . ":",
          'value' => wc_price($discount_total),
        ],
        'shipping' => [
          'label' => $item_totals['shipping']['label'],
          'value' => $shipping_value
        ],
        'payment_method' => [
          'label' => $item_totals['payment_method']['label'],
          'value' => $item_totals['payment_method']['value'],
        ],
        'fee' => [
          'label' => $fee_name,
          'value' => wc_price($fee_total),
        ],
        'tax' => [
          'label' => $item_totals['tax']['label'],
          'value' => '<span >+&nbsp;</span>' . $item_totals['tax']['value'],
        ],
        'order_total' => [
          'label' => $item_totals['order_total']['label'],
          'value' => $item_totals['order_total']['value'],
        ],


      ];
      if ($changed_item_totals['fee']['label'] === 0 || $changed_item_totals['fee']['label'] == '') {
        unset($changed_item_totals['fee']);
      }

      if ($discount_total == 0) {
        unset($changed_item_totals['discount']);
      }

      if ($changed_item_totals) {
        $i = 0;
        foreach ($changed_item_totals as $total) {
          $i++;
          ?>
      <tr>
        <th
          class="td"
          scope="row"
          colspan="2"
          style="text-align:<?php echo esc_attr($text_align); ?>; <?php echo (1 === $i) ? 'border-top-width: 4px;' : ''; ?>"
        ><?php echo wp_kses_post($total['label']); ?></th>
        <td
          class="td"
          style="text-align:<?php echo esc_attr($text_align); ?>; <?php echo (1 === $i) ? 'border-top-width: 4px;' : ''; ?>"
        ><?php echo wp_kses_post($total['value']); ?></td>
      </tr>
      <?php
        }

        ?>


      <?php
      }
      if ($order->get_customer_note()) {
        ?>
      <tr>
        <th
          class="td"
          scope="row"
          colspan="2"
          style="text-align:<?php echo esc_attr($text_align); ?>;"
        ><?php esc_html_e('Note:', 'woocommerce'); ?></th>
        <td
          class="td"
          style="text-align:<?php echo esc_attr($text_align); ?>;"
        ><?php echo wp_kses_post(nl2br(wptexturize($order->get_customer_note()))); ?></td>
      </tr>
      <?php
      }
      ?>
    </tfoot>
  </table>
</div>

<?php do_action('woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email); ?>