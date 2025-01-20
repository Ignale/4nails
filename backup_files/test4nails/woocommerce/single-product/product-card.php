<?php $product = wc_get_product($args['product-id']) ?>





<div class="catalog__info">

  <div class="catalog__name">

    <?php if (has_excerpt()): ?>

      <?php the_excerpt() ?>

    <?php endif; ?>

  </div>



</div>
</div>
<div class="catalog__details">
  <?php woocommerce_template_single_price() ?>

  <div class="products__marker">

    <div
    class="products__sale <?= ifPersonalDiscount($product) && $GLOBALS['showPersonalDiscount'] ? 'product-cart__personal-discount' : '' ?>"
    > <?php get_template_part('widgets/product/sale-discount') ?></div>

    <?php /*<div class="products__delivery"> <?php get_template_part('widgets/product/free-delivery') ?></div>*/ ; ?>

  </div>

  <div class="catalog__btn">
    <?php if (!is_wishlist())
      echo show_wishlist_button() ?>


      <a
      rel="nofollow"
      href="<?= $product->add_to_cart_url() ?>"
    data-id="<?php the_ID() ?>"
    data-quantity="1"
    data-product_id="<?php the_ID() ?>"
    data-product_sku="<?php the_sku() ?>"
    class="cart-btn button add-to-cart add_to_cart_button ajax_add_to_cart"
    ><?= esc_html($product->single_add_to_cart_text()); ?></a>

    <?php if (is_wishlist()): ?>
      <button
      type="submit"
      class="icon delete-wishlist"
      name="tinvwl-remove"
      value="<?= esc_attr($args['wl_product']['ID']); ?>"
      title="<?php _e('Remove', 'ti-woocommerce-wishlist') ?>"
      >
        <img
        src="<?= path() ?>assets/img/icons/delete_b.svg"
        alt="<?php _e('Remove', 'ti-woocommerce-wishlist') ?>"
        >

      </button>
    <?php endif; ?>

  </div>
</div>