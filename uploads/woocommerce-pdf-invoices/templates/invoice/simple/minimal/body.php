<?php
/**
 * PDF invoice template body.
 *
 * This template can be overridden by copying it to youruploadsfolder/woocommerce-pdf-invoices/templates/invoice/simple/yourtemplatename/body.php.
 *
 * HOWEVER, on occasion WooCommerce PDF Invoices will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @author  Bas Elbers
 * @package WooCommerce_PDF_Invoices/Templates
 * @version 0.0.1
 */

$templater = WPI()->templater();

$order = $templater->order;
$invoice = $templater->invoice;
$line_items = $order->get_items('line_item');
$formatted_shipping_address = $order->get_formatted_shipping_address();
$formatted_billing_address = $order->get_formatted_billing_address();
$columns = $invoice->get_columns();
$color = $templater->get_option('bewpi_color_theme');
$terms = $templater->get_option('bewpi_terms');

$data_info = $invoice->get_invoice_info();

?>

<div class="title">
  <div>
    <h2><?php echo esc_html(WPI()->get_option('template', 'title')); ?></h2>
  </div>
  <div class="watermark">
    <?php
    if (WPI()->get_option('template', 'show_payment_status') && $order->is_paid()) {
      printf('<h2 class="green">%s</h2>', esc_html__('Paid', 'woocommerce-pdf-invoices'));
    }

    do_action('wpi_watermark_end', $order, $invoice);
    ?>
  </div>
</div>
<table
cellpadding="0"
cellspacing="0"
>
  <tr class="information">
    <td width="50%">
      <?php
      /**
       * Invoice object.
       *
       * @var BEWPI_Invoice $invoice.
       */
      foreach ($invoice->get_invoice_info() as $info_id => $info) {
        if (empty($info['value'])) {
          continue;
        }

        printf('<span class="%1$s">%2$s %3$s</span>', esc_attr($info_id), esc_html($info['title']), esc_html($info['value']));
        echo '<br>';
      }
      ?>
    </td>

    <td>
      <?php
      printf('<strong>%s</strong><br />', esc_html__('Bill to:', 'woocommerce-pdf-invoices'));
      echo $formatted_billing_address;

      do_action('wpi_after_formatted_billing_address', $invoice);
      ?>
    </td>

    <td>
      <?php
      if (WPI()->get_option('template', 'show_ship_to') && !WPI()->has_only_virtual_products($order) && !empty($formatted_shipping_address)) {
        printf('<strong>%s</strong><br />', esc_html__('Ship to:', 'woocommerce-pdf-invoices'));
        echo $formatted_shipping_address;

        do_action('wpi_after_formatted_shipping_address', $invoice);
      }
      ?>
    </td>
  </tr>
</table>
<table
cellpadding="0"
cellspacing="0"
>
  <thead>
    <tr
    class="heading"
    bgcolor="<?php echo esc_attr($color); ?>;"
    >
      <?php
      foreach ($columns as $key => $data) {
        $templater->display_header_recursive($key, $data);

      }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($invoice->get_columns_data() as $index => $row) {
      echo '<tr class="item">';

      // Display row data.
      foreach ($row as $column_key => $data) {
        $templater->display_data_recursive($column_key, $data);
      }

      echo '</tr>';
    }
    ?>

    <tr class="spacer">
      <td></td>
    </tr>

  </tbody>
</table>

<table
cellpadding="0"
cellspacing="0"
>
  <tbody>
    <tr class="total">
      <td width="50%">&nbsp;</td>
      <td
      width="25%"
      align="left"
      class="border <?php echo esc_attr($class); ?>"
      >Subtotal:</td>
      <td
      width="25%"
      align="right"
      class="border <?php echo esc_attr($class); ?>"
      >$<?= $data_info['subtotal']; ?></td>
    </tr>
    <tr class="total">
      <td width="50%">&nbsp;</td>
      <td
      width="25%"
      align="left"
      class="border <?php echo esc_attr($class); ?>"
      >Money saved:</td>
      <td
      width="25%"
      align="right"
      class="border <?php echo esc_attr($class); ?>"
      ><?= wc_price(get_individual_discount_order($order)); ?></td>
    </tr>
    <!--
        <tr class="total">
            <td width="50%">&nbsp;</td>
            <td width="25%" align="left" class="border <?php echo esc_attr($class); ?>">Sale discount:</td>
            <td width="25%" align="right" class="border <?php echo esc_attr($class); ?>">$<?= $data_info['sale_discount']; ?></td>
        </tr>
    <?php if (is_user_logged_in()): ?>
        <tr class="total">
            <td width="50%">&nbsp;</td>
            <td width="25%" align="left" class="border <?php echo esc_attr($class); ?>">Personal discount (<?= $data_info['personal_discount']; ?>):</td>
            <td width="25%" align="right" class="border <?php echo esc_attr($class); ?>">$<?= $data_info['personal_total']; ?></td>
        </tr>
    <?php endif; ?>
    -->

    <?php
    foreach ($invoice->get_order_item_totals() as $key => $total) {
      $class = str_replace('_', '-', $key);
      if ($total['label'] == 'Subtotal:')
        continue;
      ?>

      <tr class="total">
        <td width="50%">
          <?php do_action('wpi_order_item_totals_left', $key, $invoice); ?>
        </td>

        <td
        width="25%"
        align="left"
        class="border <?php echo esc_attr($class); ?>"
        >
          <?php echo $total['label']; ?>
        </td>

        <td
        width="25%"
        align="right"
        class="border <?php echo esc_attr($class); ?>"
        >
          <?php echo str_replace('&nbsp;', '', $total['value']); ?>
        </td>
      </tr>


    <?php } ?>
  </tbody>
</table>

<div style="display: flex; margin-bottom: 15px">
  <table
  class="notes"
  cellpadding="0"
  cellspacing="0"
  >
    <tr>
      <td>
        <?php
        // Customer notes.
        if (WPI()->get_option('template', 'show_customer_notes')) {
          // Note added by customer.
          $customer_note = BEWPI_WC_Order_Compatibility::get_customer_note($order);
          if ($customer_note) {
            printf('<strong>' . __('Note from customer: %s', 'woocommerce-pdf-invoices') . '</strong><br>', nl2br($customer_note));
          }

          // Notes added by administrator on 'Edit Order' page.
          foreach ($order->get_customer_order_notes() as $custom_order_note) {
            printf('<strong>' . __('Note to customer: %s', 'woocommerce-pdf-invoices') . '</strong><br>', nl2br($custom_order_note->comment_content));
          }
        }
        ?>
      </td>
    </tr>

    <tr>
      <td>
        <?php
        // Zero Rated VAT message.
        if ('true' === WPI()->get_meta($order, '_vat_number_is_valid') && count($order->get_tax_totals()) === 0) {
          echo esc_html__('Zero rated for VAT as customer has supplied EU VAT number', 'woocommerce-pdf-invoices') . '<br>';
        }
        ?>
      </td>
    </tr>
  </table>
</div>

<?php if ($terms) { ?>
  <!-- Using div to position absolute the block. -->
  <div
  class="terms"
  style="display: flex; margin-top: 15px"
  >
    <table>
      <tr>
        <td style="border: 1px solid #000;">
          <?php echo nl2br($terms); ?>
        </td>
      </tr>
    </table>
  </div>
<?php } ?>