<?php

defined( 'ABSPATH' ) || exit;

$is_form_login = ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) );
?>
<div class="wrapper">
    <?php

    woocommerce_login_form(
        array(
            'redirect' => wc_get_page_permalink( 'checkout' ),
            'hidden'   => false,
        )
    ); ?>
</div>
