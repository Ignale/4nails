<?php

if (apply_filters('woocommerce_checkout_show_terms', true) && function_exists('wc_terms_and_conditions_checkbox_enabled')) {
  do_action('woocommerce_checkout_before_terms_and_conditions');

  ?>


  <input
  type="hidden"
  class="custom-control-input woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
  name="terms"
  required
  checked
  id="terms"
  />
  <div class="woocommerce-privacy-policy-text">

    <p>
      <?= __('By placing an order on our website 4nails.us, you agree to our:', '4nails') ?> <a
      style="text-decoration: underline;"
      href="<?= get_permalink(apply_filters('wpml_object_id', 3, 'page')) ?>"
      target='_blank'
      ><?= __('Privacy Policy,', '4nails') ?></a> <a
      style="text-decoration: underline;"
      href="<?= get_permalink(apply_filters('wpml_object_id', 2, 'page')) ?>"
      target='_blank'
      ><?= __('Shipping Policy', '4nails') ?></a>, <a
      style="text-decoration: underline;"
      href="<?= get_permalink(apply_filters('wpml_object_id', 11693, 'page')) ?>"
      target='blank'
      ><?= __('Return Policy', '4nails') ?></a> <?= __('and', '4nails') ?> <a
      style="text-decoration: underline;"
      href="<?= get_permalink(apply_filters('wpml_object_id', 12688, 'page')) ?>"
      target='_blank'
      ><?= __('Warranty Policy', '4nails') ?></a>.
      <?= __('After clicking "Pay," you will receive a confirmation email with the details of your order.', '4nails') ?>
    </p>
  </div>
  <input
  type="hidden"
  name="terms-field"
  value="1"
  />

  <?php

}