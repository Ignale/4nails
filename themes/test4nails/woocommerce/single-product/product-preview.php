<?php

global $product;

$main_id= get_post_thumbnail_id();


if ($product->get_image_id()):?>

    <div class="products__img copyright">
        <a href="<?= $product->get_permalink() ?>">
            <img width="1"  height="1" style="width: 100%; height: auto;pointer-events:none" src="<?= wp_get_attachment_image_url($product->get_image_id(), '4nails_category_product') ?>" alt='<?= esc_html($product->get_name()) ?>'>
        </a>
    </div>


<?php endif; ?>