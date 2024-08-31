<?php



global $product, $wl_product, $saved;

$isLoop = in_the_loop();

$is_count_whishlist = !empty($saved) && count($saved->posts) > 4 ? false : true;









?>

<?php if (is_front_page()): ?>

    <div class="products__item swiper-slide">

        <?php wc_get_template_part('single-product/product-preview'); ?>





    </div>

<?php endif; ?>



<?php if (!is_front_page()): ?>

<div class="catalog__item <?= is_product()||is_cart()? 'swiper-slide ':''?>">
<div <?php wc_product_class('product-card'); ?>>
    <div class="catalog__preview ">



    <?php wc_get_template_part('single-product/product-preview'); ?>

    <?php get_template_part('woocommerce/single-product/product', 'card', ['product-id' => $product->get_id(),'wl_product'=>$wl_product]); ?>

</div>

</div>
    <?php endif; ?>

    <?php  if(is_wishlist()){




    }?>







