<?php

global $product;

if (!$product->is_purchasable()) return;
$disabled = !$product->is_in_stock() ? 'disabled="disabled"' : '';
?>

<?php do_action('woocommerce_before_add_to_cart_form'); ?>

<form class="cart <?= $disabled ? 'disabled' : '' ?>"
      action="<?= esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
      method="post" enctype='multipart/form-data'>
    <?php do_action('woocommerce_before_add_to_cart_button'); ?>

    <?php
    do_action('woocommerce_before_add_to_cart_quantity');

    woocommerce_quantity_input([
        'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
        'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
        'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
    ]);

    do_action('woocommerce_after_add_to_cart_quantity');
    ?>
    <?php woocommerce_template_single_price() ?>
    <div class="product__buttons">

        <?php woocommerce_template_single_sharing() ?>
        <?= show_wishlist_button() ?>
        <button type="submit" name="add-to-cart" value="<?= esc_attr($product->get_id()); ?>" <?= $disabled ?>
                class="cart-btn add-to-cart fancybox"><?= esc_html($product->single_add_to_cart_text()); ?></button>

    </div>
    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
</form>
<?php do_action('woocommerce_after_add_to_cart_form'); ?>
