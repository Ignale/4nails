<?php
$customer = new WC_Customer($current_user->data->ID);

$firstname = $customer->first_name == 'Default name' ? '' : $customer->first_name;
$lasttname = $customer->last_name == 'Default lastname' ? '' : $customer->last_name;
$display_name = trim($firstname.' '.$lasttname);

if($display_name == '') $display_name = __('Dear customer', '4nails') ;
?>
<div class="account__hello">

    <p class="account__hello-text">

        <?php if($display_name == __('Dear customer', '4nails')){
            _e('Hello, <strong>'.$display_name.'</strong>');
        }else{
         echo  sprintf(__('Hello %s <br>(not %1$s? <a href="%s" class="link">Sign Out</a>)', 'woocommerce'), '<strong>' . $display_name . '</strong>',
             esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ));
        } ?>
    </p>
    <div class="account__hello-info">

        <a href="https://t.me/+Q3aRRHOmbJg4Zjlh" class="redister__tg-subscribe" target="_blank"><?= __('Subscribe to our Telegram channel','4nails');?></a>
        <?php
        printf(
        __( '<p>From your account dashboard you can:</p><ul><li>- view your <a href="%1$s">recent orders</a></li><li>- manage your <a href="%2$s">shipping and billing addresses</a></li><li>- edit your <a href="%3$s">password</a> and <a href="%4$s">account details</a>.</li></ul>',
            'woocommerce' ),
        esc_url( wc_get_endpoint_url( 'orders' ) ),
        esc_url( wc_get_endpoint_url( 'edit-address' ) ),
            get_lang_url().'my-account/edit-account/?password_edit=1',
        esc_url( wc_get_endpoint_url( 'edit-account' ) )
        );
        ?>
    </div>
</div>

