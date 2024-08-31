<?php

/* @var $product WC_Product */
global $product; ?>
<div class="box-variation">
    <?php
    $default_attributes = $product->get_default_attributes();
    if (!empty($default_attributes)) {
        foreach ($product->get_available_variations() as $variation_values) {
            foreach ($variation_values['attributes'] as $key => $attribute_value) {
                $attribute_name = str_replace('attribute_', '', $key);
                $default_value = $product->get_variation_default_attribute($attribute_name);
                if ($default_value == $attribute_value) {
                    $is_default_variation = true;
                } else {
                    $is_default_variation = false;
                    break;
                }
            }
            if ($is_default_variation) {
                $variation_id = $variation_values['variation_id'];
                break;
            }
        }
    }
    $default_attribute = ucfirst(array_shift($variation_values['attributes']));
    ?>
    <div class="variations__title"><?= __("Variation:", '4nails')?>
        <span class="cyan-color variation-name"><?= $default_attribute ?></span>
    </div>
    <div class="variation-items">
        <?php

        $was_checked = false;

        foreach ($product->get_available_variations() as $variation):
            $attr = ucfirst(array_shift($variation['attributes']));
            $id = $variation['variation_id'];
            $disabled = $variation['is_in_stock'] == false ? 'disabled' : '';
            $checked = '';
            if (!$was_checked && !$disabled) {
                if ($is_default_variation && ($id == $variation_id)) {
                    $checked = 'checked';
                    $was_checked = true;
                } else if ($variation_values == null || !$variation_values['is_in_stock']) {
                    $checked = 'checked';
                    $was_checked = true;
                }
            }
            ?>
            <div class="item <?= $disabled ?> <?= $checked ?>">
                <input type="radio"
                       name="variation<?php /*= array_key_first($variation['attributes']) */
                       ?>" id="<?= $id ?>" value="<?= $id ?>" <?= $disabled ?> <?= $checked ?>
                       data-name="<?= $attr ?>"
                       data-gallery="<?= $variation['image']['src'] ?>"
                       data-price="<?= htmlspecialchars(wc_price($variation['display_price'])) ?>"
                       data-old-price="<?= htmlspecialchars(wc_price($variation['display_regular_price'])) ?>"
                       data-sku="<?= $variation['sku'] ?>">
                <label class="item" for="<?= $id ?>"
                       style="background-image: url('<?= $variation['image']['gallery_thumbnail_src'] ?>')"></label>
            </div>
        <?php endforeach;
        wp_reset_query(); ?>
    </div>
</div>
