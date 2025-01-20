<?php


$customer_id = get_current_user_id();

$customer = new WC_Customer($customer_id);


$addresses = [

    'billing' => __('Home (Primary Billing)', '4nails'),

    'shipping' => __('Home (Primary Shipping)', '4nails')

];


?>
<?php

?>


<div class="profile__description">
    <?= __("If you don't want to enter your addresses multiple times, just enter them once and save them to your Address Book here.",'4nails'); ?>
    <?= __("What is a billing address? This is the address associated with your credit card's account or PayPal account with which you will be making the payment.",'4nails'); ?></div>

<div class="address">

    <?php foreach ($addresses as $name => $title) :

        $url = esc_url(wc_get_endpoint_url('edit-address', $name));

        $address = wc_get_account_formatted_address($name);

        $address = $address ? wp_kses_post($address) : __('You have not set up this type of address yet.', '4nails');

        $address = trim(str_replace('Default lastname', '', str_replace('Default name', '', $address)));

        $address = $address == '' ? __('You have not set up this type of address yet.', '4nails') : $address;

        ?>


        <div class="address__item">


            <div class="profile__title"><?= $title; ?></div>
            <div class="address__text"><?= $address; ?></div>


            <a href="<?= $url ?>" class="edit-link cyan-link"><?= __("Edit", '4nails') ?></a>


        </div>

    <?php endforeach; ?>


</div>





