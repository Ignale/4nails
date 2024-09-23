<form
action="<?= esc_url(wc_get_cart_url()); ?>"
method="post"
class="cart__content woocommerce-cart-form"
>
  <div class="notices-area"><?php wc_print_notices() ?></div>

  <div class="cart__gifts">

    <?php
    if ($GLOBALS['showPersonalDiscount']):
      if (is_user_logged_in() && $discount = get_field('individual_discount', 'user_' . get_current_user_id())): ?>
        <div class="cart__gifts-item">
          <svg
          class='discount'
          version="1.1"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          x="0px"
          y="0px"
          width="25px"
          height="22px"
          viewBox="-164.5 181.5 25 22"
          enable-background="new -164.5 181.5 25 22"
          xml:space="preserve"
          >
            <path
            fill="#17CFB9"
            d="M-146.438,182.5c0.176,0,0.347,0.011,0.503,0.026c2.109,0.225,3.57,0.901,4.465,2.07 c0.888,1.157,1.167,2.774,0.832,4.805c-0.494,3.013-4.86,7.129-8.061,10.146c-0.845,0.791-1.895,1.775-2.555,2.489 c-0.185,0.214-0.529,0.463-0.698,0.463c-0.177,0-0.534-0.254-0.752-0.498c-0.578-0.619-1.435-1.419-2.418-2.338l-0.098-0.094 c-3.227-3.015-7.646-7.143-8.145-10.168c-0.333-2.031-0.052-3.648,0.835-4.807c0.896-1.168,2.356-1.845,4.459-2.068 c0.165-0.018,0.334-0.027,0.509-0.027c1.816,0,3.653,0.846,4.794,2.207l0.767,0.915l0.767-0.916 C-150.094,183.346-148.257,182.5-146.438,182.5 M-146.438,181.5c-2.126,0-4.245,0.99-5.562,2.564 c-1.319-1.574-3.436-2.564-5.561-2.564c-0.211,0-0.414,0.012-0.612,0.032c-2.394,0.255-4.078,1.058-5.15,2.455 c-1.062,1.386-1.408,3.261-1.028,5.577c0.555,3.364,4.938,7.456,8.458,10.745l0.081,0.077c0.98,0.916,1.828,1.708,2.379,2.298 c0.075,0.084,0.747,0.815,1.483,0.815c0.741,0,1.398-0.743,1.459-0.814c0.586-0.633,1.537-1.527,2.477-2.408 c3.48-3.281,7.814-7.363,8.364-10.714c0.382-2.314,0.037-4.189-1.025-5.575c-1.071-1.398-2.756-2.201-5.153-2.456 C-146.022,181.513-146.227,181.5-146.438,181.5L-146.438,181.5z"
            />
          </svg>
          <?= sprintf(__('You have a %s personal discount', '4nails'), $discount . '%') ?>
        </div>
      <?php endif;
    endif;
    ?>
  </div>
  <div class="cart__form">
    <div class="cart__new-container">
      <div class="cart__top">

        <div class="cart__product-img"><?= __('Item', '4nails') ?>

        </div>

        <div class="cart__product-info">

          <div class="card__product-data">

          </div>

          <div class="cart__price"><?php esc_html_e('Price', 'woocommerce'); ?></div>

          <div class="cart__quantity"><?= __('Qty', '4nails'); ?></div>

          <div class="cart__amount"><?php esc_html_e('Amount', 'woocommerce'); ?></div>

          <div class="cart__actions"></div>

        </div>

      </div>
      <div class="cart__product-wrapper woocommerce-cart-form__contents">
        <?php
        $cart = WC()->cart;
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
          $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
          $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
          global $product, $wl_product, $saved;
          if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)):
            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
            ?>

            <div class="cart__product woocommerce-cart-form__cart-item">
              <div class="cart__product-img">
                <a href="<?= $product_permalink ?>">
                  <img
                  src="<?= wp_get_attachment_image_url($_product->get_image_id(), 'product_cat') ?>"
                  loading="lazy"
                  >
                </a>
                <div class="item__mob-number">#<?= $_product->get_sku() ?></div>

              </div>

              <div class="cart__product-info">

                <div class="card__product-data">

                  <a
                  class="cart__product-name"
                  href="<?= $product_permalink ?>"
                  > <?= $_product->get_name() ?></a>

                  <div class="cart__product-details">

                    <div class="item__number"><?= $_product->get_sku(); ?>
                      |
                    </div>

                    <div>
                      <?= productStatus($cart_item['data']->manage_stock, $cart_item['data']->backorders, $cart_item['data']->stock_status, $cart_item['data']->backorders_allowed()); ?>
                    </div>

                  </div>

                </div>

                <div class="cart__price">
                  <?php $price = get_product_price($product_id); ?>
                  <div class="catalog__old-price"><?= wc_price($price) ?></div>


                </div>

                <div
                class="cart__quantity"
                data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>"
                data-is-individual="<?= $_product->is_sold_individually() ? '1' : 0 ?>"
                >

                  <?php
                  $disabled = $_product->is_sold_individually() ? 'disabled' : '';
                  $name = "cart[{$cart_item_key}][qty]";

                  // if ($_POST["cart[{$cart_item_key}][qty]"] && $_POST["cart[{$cart_item_key}][qty]"] > $_product->get_max_purchase_quantity()) {
                  //   $cart->set_quantity($cart_item_key, $_product->get_max_purchase_quantity(), true);
                  // }
                  // ;
                  $product_quantity = woocommerce_quantity_input([
                    'input_name' => $name,
                    'input_value' => $cart_item['quantity'],
                    'max_value' => $_product->get_max_purchase_quantity(),
                    'min_value' => '0',
                    'product_name' => $_product->get_name(),
                    'classes' => $disabled,
                  ], $_product, false);
                  echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                  if ($disabled === 'disabled') { ?>
                    <div
                    style="display: none;"
                    class="tooltip"
                    >
                      <?= __(' Due to its size and weight, this item can only be ordered in quantities of 1. If you need more than 1 then you will need to place a new order for each unit.', '4nails') ?>
                    </div>
                  <?php } ?>
                </div>


                <div
                class="cart__amount"
                data-title="<?php esc_attr_e('Total', 'woocommerce'); ?>"
                >
                  <?php $price = get_product_price($product_id) * $cart_item['quantity']; ?>
                  <div class="catalog__old-price">
                    <?= wc_price($price); ?>
                  </div>


                </div>

                <div class="cart__actions product-remove">

                  <?= apply_filters('woocommerce_cart_item_remove_link', sprintf(
                    '<a data-cart_item_key="%s" title="%s" href="%s" class="cart__product-delete remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><img src="%s" alt=""></a>',
                    esc_attr($cart_item_key),
                    __("Delete", "4nails"),
                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                    __('Remove this item', 'woocommerce'),
                    esc_attr($product_id),
                    esc_attr($_product->get_sku()),
                    path() . 'assets/img/icons/delete_b.svg'
                  ), $cart_item_key); ?>

                  <?php echo show_wishlist_button_on_cart($cart_item['product_id']) ?>
                </div>

              </div>

            </div>

          <?php endif;
        endforeach;
        $nails_get_totals = nails_get_totals();
        $subtotal = WC()->cart->get_cart_subtotal();
        ?>
        <div class="show-more">
          <div
          class="show-more__btn"
          style="display: none"
          >
            <div class="show-more__text">
              <div id="showMore"><?= __('Show more', '4nails'); ?></div>
              <div id="hideMore"><?= __('Hide', '4nails'); ?></div>
            </div>
            <div class="show-more-arrow show"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="cart__wrappper-aside">
      <div class="cart__aside">
        <div class="cart__total">

          <div class="cart__total-item">

            <div class="cart__total-text"> <?php esc_attr_e('Subtotal ', 'woocommerce'); ?>
              <div class="cart__total-items">
                (<?php cart_content();
                cart_items() ?>)
              </div>
            </div>

            <div class="cart__total-sum">
              <div class="cart__total-price"> <?= wc_price(get_subtotal()); ?></div>
              <div class="cart__total-description"><?= __('(Prices are in USD)', '4nails'); ?></div>
            </div>

          </div>


          <?php //if (WC()->cart->total > 100): ?>
          <!-- <div class="cart__total-item">

                        <div class="cart__total-text"><?php /*= __('Shipping', '4nails') */ ?></div>

                        <div class="cart__total-sum"><?php /*= __('Calculated at next step', '4nails'); */ ?></div>

                    </div>
                    <?php /*//endif; */ ?>

                    <div class="cart__total-item">

                        <div class="cart__total-text"><?php /*= __('Total', '4nails'); */ ?></div>

                        <div class="cart__total-sum"><?php /*wc_cart_totals_order_total_html(); */ ?></div>

                    </div>-->

        </div>

        <div class="cart__checkout">
          <div class="cart--checkout__massage">
            <?= __('In the next step, you will need to enter your billing and shipping address.', '4nails'); ?>
          </div>
          <?php woocommerce_button_proceed_to_checkout() ?>

        </div>
      </div>
    </div>

  </div>

  <button
  type="submit"
  name="update_cart"
  hidden
  ></button>
  <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
</form>