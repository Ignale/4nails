<?php


global $product;

$product = wc_get_product($post);

get_header(); ?>

<main>
  <section class="product <?=$product->is_type('variable') ? 'variable-product':'' ?>">
    <div class="wrapper">
      <div
        class="product__container product"
        data-id="<?php the_ID() ?>"
      >
        <div class="notices-area">
          <?php wc_print_notices() ?>
        </div>

        <div class="product__top title">
          <?php woocommerce_template_single_title() ?>
          <?php woocommerce_template_single_rating() ?>
        </div>
        <div class="product__item">
          <div
            class="product__img"
            style="visibility: hidden"
          >
            <div class="product__thumbs">
              <?php get_template_part('woocommerce/single-product/sale', 'icon') ?>
              <div class="swiper-container">
                <?php woocommerce_show_product_thumbnails() ?>
              </div>
              <div class="swiper-button-next-thumbs swiper-arrow">
                <svg
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  x="0px"
                  y="0px"
                  width="25px"
                  height="48px"
                  viewBox="-164.5 181.5 25 48"
                  enable-background="new -164.5 181.5 25 48"
                  xml:space="preserve"
                >
                  <polygon
                    fill="#BBCAC8"
                    points="-139.675,205.5 -163.618,181.558 -164.325,182.265 -141.089,205.5 -164.325,228.735 -163.618,229.442 "
                  ></polygon>
                </svg>
              </div>
              <div class="swiper-button-prev-thumbs swiper-arrow">
                <svg
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  x="0px"
                  y="0px"
                  width="25px"
                  height="48px"
                  viewBox="-164.5 181.5 25 48"
                  enable-background="new -164.5 181.5 25 48"
                  xml:space="preserve"
                >
                  <polygon
                    fill="#BBCAC8"
                    points="-164.325,205.5 -140.382,181.558 -139.675,182.265 -162.911,205.5 -139.675,228.735 -140.382,229.442 "
                  ></polygon>
                </svg>
              </div>
            </div>
            <div class="product__main">

              <?php woocommerce_show_product_images() ?>

            </div>
          </div>
          <div class="product__card product-info">
            <?php get_template_part('woocommerce/single-product/sale', 'icon') ?>
            <div class="product__number copyright"><?= __('Item: #', '4nails') ?>
              <span><?php the_sku() ?></span>
            </div>
            <?php //wc_get_template_part('single-product/free-delivery') ?>
            <?php wc_get_template_part('single-product/stock') ?>
            <?php if (!$product->is_virtual()): ?>
            <div class="product__delivery">
              <?= get_field('no_delivery') == 'yes' ? '<div class="no-delivery">' . __('No mail delivery', '4nails') . '!</div>' : get_field('delivery_text', 'options'); ?>
            </div>
            <?php endif; ?>
            <?php if (ifPersonalDiscount($product)&&$GLOBALS['showPersonalDiscount']): ?>
            <div class="single-product__personal-discount">
              <?=  sprintf(__('Personal discount %s', '4nails'),get_field('individual_discount', 'user_' . get_current_user_id()).'%' )?>
            </div>
            <?php endif; ?>
            <div class="product__form">
              <?php
                                    if ($product->is_type('variable')) :
                                        woocommerce_variable_add_to_cart();
                                    else :
                                       woocommerce_simple_add_to_cart();
                                    endif; ?>
            </div>

          </div>
          <?php
                        if ($product->is_type('variable')) wc_get_template_part('single-product/variations') ?>
        </div>
        <?php woocommerce_output_product_data_tabs() ?>
      </div>
    </div>
  </section>
  <?php woocommerce_output_related_products() ?>
  <?php get_template_part('widgets/product/quantity', 'modal', ['product' => $product]); ?>

</main>








<?php get_footer();