<div
  class="checkout__item-left checkout__billing"
  style="display: none"
>

  <div class="checkout__title-description">
    <?= __( "What is a billing address? This is the address associated with your credit card's account or PayPal account with which you will be making the payment.", '4nails'); ?>
  </div>

  <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

  <div class="woocommerce-billing-fields__field-wrapper woocommerce-billing-fields">
    <?php
        $fields = $checkout->get_checkout_fields('billing');

        foreach ($fields as $key => $field) {
            if (isset($field['country_field'], $fields[$field['country_field']])) {
                $field['country'] = $checkout->get_value($field['country_field']);
            }
            $field['class'][] = 'form-group';
            if (in_array($key, ['billing_email_field'])) {
                $field['class'][] = 'box-tooltip';
            }
            $field['input_class'][] = 'control-form';
            woocommerce_form_field($key, $field, $checkout->get_value($key));
        }
        do_action( 'woocommerce_before_checkout_process' );
        ?>
    <!-- <input
      type="hidden"
      name="billing_country"
      value="US"
    /> -->
  </div>
  <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>

</div>

<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) :
    ?>
<div class="woocommerce-account-fields">
  <?php if (!$checkout->is_registration_required()) : ?>

  <p class="form-row form-row-wide create-account">
  <div class="custom-control custom-checkbox woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
    <input
      class="custom-control-input woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
      id="createaccount"
      <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true) ?>
      type="checkbox"
      name="createaccount"
      value="1"
    />
    <label
      class="custom-control-label"
      for="createaccount"
    ><?php _e('Create an account?', 'woocommerce'); ?></label>
  </div>
  </p>

  <?php endif; ?>

  <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

  <?php if ($checkout->get_checkout_fields('account')) : ?>

  <div class="create-account">
    <?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
    <?php
                    $field['class'][] = 'form-group';
                    if (in_array($key, ['billing_email_field'])) {
                        $field['class'][] = 'box-tooltip';
                    }
                    $field['input_class'][] = 'control-form';
                    woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
    <?php endforeach; ?>
    <div class="clear"></div>
  </div>

  <?php endif; ?>

  <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
</div>
<?php endif; ?>