<?php

if (!is_ajax()) {
    do_action('woocommerce_review_order_before_payment');
}
?>


    <div class="checkout__item-right checkout__pay woocommerce-checkout-payment third-step" id="payment">
        <div class="step__container">
            <div class="step__title step__title-payment"><?= __('SELECT A PAYMENT METHOD','4nails') ?></div>
            <?php if (WC()->cart->needs_payment()) : ?>
                <div class="checkout__pay-methods wc_payment_methods payment_methods methods <?= if_international() ?>">

                    <?php
                    if (!empty($available_gateways)) {
                        foreach ($available_gateways as $gateway) {
                            wc_get_template('checkout/payment-method.php', array('gateway' => $gateway));
                        }
                    } else {
                        echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce') : esc_html__('Please fill in your details above to see available payment methods.', 'woocommerce')) . '</li>'; // @codingStandardsIgnoreLine
                    }
                    ?>


                </div>
            <?php endif; ?>


            <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>

        </div>
    </div>

<?php
if (!is_ajax()) {
    do_action('woocommerce_review_order_after_payment');
}