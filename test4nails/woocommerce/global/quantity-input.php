<?php

$max='';

if ($max_value && $min_value === $max_value) {
    ?>
    <div class="quantity hidden"style="display: none" >
        <input type="hidden" id="<?= esc_attr($input_id); ?>" class="qty"
               name="<?= esc_attr($input_name); ?>" value="<?= esc_attr($min_value); ?>"/>
    </div>
    <?php
} else {
    /* translators: %s: Quantity. */
    $labelledby = !empty($args['product_name']) ? sprintf(__('%s quantity', 'woocommerce'), strip_tags($args['product_name'])) : '';
    ?>
    <div class="product__quantity quantity">
        <button class="product__minus qty-btn" type="button">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                 y="0px"
                 width="22px" height="22px" viewBox="-164.5 181.5 22 22" enable-background="new -164.5 181.5 22 22"
                 xml:space="preserve">
<path fill="#17CFB9" d="M-153.5,181.5c-6.075,0-11,4.925-11,11c0,6.074,4.925,11,11,11c6.075,0,11-4.926,11-11
	C-142.5,186.425-147.425,181.5-153.5,181.5z M-153.5,202.5c-5.514,0-10-4.486-10-10s4.486-10,10-10c5.514,0,10,4.486,10,10
	S-147.986,202.5-153.5,202.5z M-159.5,191.5h12v2h-12V191.5z"/>
</svg>

        </button>
        <input
                type="text"
                id="<?= esc_attr($input_id); ?>"
                class="product__value qty"
                step="<?= esc_attr($step); ?>"
                min="<?= esc_attr($min_value); ?>"
                max="<?= $max_value>1?$max_value:1000?>"
                name="<?= esc_attr($input_name); ?>"
                value="<?= esc_attr($input_value); ?>"
                title="<?= esc_attr_x('Qty', 'Product quantity input tooltip', 'woocommerce'); ?>"
                size="4" <?php echo esc_attr( join( ' ', (array) $classes ) ); ?> />
        <button class="product__plus qty-btn" type="button" <?php echo esc_attr( join( ' ', (array) $classes ) ); ?>>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                 y="0px"
                 width="22px" height="22px" viewBox="-164.5 181.5 22 22" enable-background="new -164.5 181.5 22 22"
                 xml:space="preserve">
<path fill-rule="evenodd" clip-rule="evenodd" fill="#17CFB9" d="M-153.5,181.5c-6.075,0-11,4.925-11,11c0,6.074,4.925,11,11,11
	c6.075,0,11-4.926,11-11C-142.5,186.425-147.425,181.5-153.5,181.5z M-153.5,202.5c-5.514,0-10-4.486-10-10s4.486-10,10-10
	c5.514,0,10,4.486,10,10S-147.986,202.5-153.5,202.5z M-152.5,191.5h5v2h-5v5h-2v-5h-5v-2h5v-5h2V191.5z"/>
</svg>
        </button>
    </div>
    <?php
}