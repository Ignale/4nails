<?php
$button_titles = [];
foreach(get_field('title_payment_buttton', 'option') as $item){
    $button_titles[$item['name_method']] = $item['title_button'];
}
$order_button_text = $button_titles[$gateway->id];

$chosen_payment_method = WC()->session->get('chosen_payment_method');

?>

<li class="wc_payment_method payment_method_<?php echo esc_attr($gateway->id); ?> <?= $gateway->id=== $chosen_payment_method?"wc_payment_method__choosen":''?>">
    <div class="custom-control custom-radio">
        <input id="payment_method_<?php echo esc_attr($gateway->id); ?>" type="radio" class="input-radio custom-control-input"
               name="payment_method"
               value="<?php echo esc_attr($gateway->id); ?>" <?php checked($gateway->chosen, true); ?>
               data-order_button_text="<?php echo esc_attr($order_button_text); ?>"/>

        <label class="custom-control-label" for="payment_method_<?php echo esc_attr($gateway->id); ?>">
            <span class="local-pickup"><?php echo $gateway->get_title();  ?></span>
            <span class="image"><?php echo $gateway->get_icon(); ?></span>
        </label>
    </div>
    <?php if ($gateway->has_fields() || $gateway->get_description()) : ?>
        <div class="payment_box payment_method_<?php echo esc_attr($gateway->id); ?>">
            <?php $gateway->payment_fields(); ?>
        </div>
    <?php endif; ?>
</li>