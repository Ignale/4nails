
<?php

if ( apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) {
    do_action( 'woocommerce_checkout_before_terms_and_conditions' );

    ?>


    <input type="hidden" class="custom-control-input woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" required checked id="terms" />
    <div class="woocommerce-privacy-policy-text">

        <p><?= __('By placing an order you agree to all terms and conditions of our website.', '4nails'); ?></p></div>
    <input type="hidden" name="terms-field" value="1" />

    <?php

}
