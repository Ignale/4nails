<div class="checkout__item-right checkout__shipping">
  <div class="woocommerce-shipping-fields">
    <div class="checkout__shipping-adress shipping_address">
      <?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>
      <div class="woocommerce-shipping-fields__field-wrapper">
        <?php
        $fields = $checkout->get_checkout_fields('shipping');
        foreach ($fields as $key => $field) {
          $field['class'][] = 'form-group';
          $field['input_class'][] = 'control-form';
          $value = $checkout->get_value($key);

          if ($field['label'] == 'First name')
            $value = $value == 'Default name' ? '' : $value;
          if ($key === 'shipping_email') {
            $value = $checkout->get_value('billing_email');
          }
          if ($field['label'] == 'Last name')
            $value = $value == 'Default lastname' ? '' : $value;
          woocommerce_form_field($key, $field, $value);
        }
        ?>
        <!-- <input
        type="hidden"
        name="shipping_country"
        value="US"
        /> -->
      </div>
      <?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>
    </div>
  </div>
</div>