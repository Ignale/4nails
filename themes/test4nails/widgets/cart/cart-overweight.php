<?php
$cart = WC()->cart;
$weight = $args['weight'];
$quantity = $args['qty'];
$button_text = $args['button_text'];
$is_cart = $args['is_cart'];
$show_cart_button = $args['show_cart_button'];
$weight = $weight ?: get_cart_weight($cart);
?>

<div
style="display: none; width: 500px;"
class="modal fade"
data-message-type = "overweight"
id="overweight-massage"
tabindex="-1"
>
  <div
  class="modal-dialog modal-dialog-centered"
  role="document"
  >

    <div class="modal-content">

      <div class="modal-body">


        <div class="modal-error">
          <div
          class="modal-header__delete"
          onclick="Fancybox.close()"
          >
            <img
            src="<?= path() ?>assets/img/icons/delete_b.svg"
            alt="<?php _e('Remove', 'ti-woocommerce-wishlist') ?>"
            >
          </div>
          <div data-max-weight = '30' data-weight = '<?= $weight?>' class="modal-error__header">
            <?= $weight > 30 ? sprintf('The weight of items in your cart exceeds the allowed limit for a single shipment!
              Maximum weight per order: <b>30 lbs</b>
              Total weight of your order: <b>%s lbs</b> .
              To complete your order:<br/>
              1. Remove some items from your cart to reduce the weight.<br/>
              2. Place a second order for the remaining items.', $weight) :
              sprintf('Thank you! Right now the weight of the item is <b>%s lbs</b> . this is the allowable weight for one order (30 lbs)', $weight)
              ?>
              

          </div>
          <div class="modal-error__wrap">

            <div class="modal-error__first">

              <?php
              $temp = 1;

              foreach ($cart->get_cart() as $cart_item_key => $cart_item):

                $product = $cart_item['data'];
                $max_value = $product->get_stock_quantity();
                $value = $cart_item['quantity'];
                $is_avialble = $value >= $max_value ? false : true;

                if (!get_field('attached_product', $product->get_id())):
                  ?>

                  <div
                  <?= $temp == 1 ? "id='firstItem'" : ""; ?>
                  class="modal-error__item"
                   data-product-id = <?= $product->get_id() ?> 
                   data-item-key = '<?= $cart_item_key ?>'
                   data-qty = '<?= $cart_item['quantity'] ?>'
                  >

                    <div class="modal-error__item-img"><?= $product->get_image() ?></div>

                    <div class="modal-error__item-text"><a
                      href="<?= get_permalink($product->get_id()) ?>"><?= $product->get_name() ?></a>
                      <p><b><?= sprintf('Weight: %s lbs.', $product->get_weight()) ?></b></p>
                      <p><b><?= sprintf('Count: %s', $cart_item['quantity']) ?></b></p>
                    </div>
                  <?php if (!$is_cart) { ?>
                    <div class="modal-error__item-change">
                      <?php if ($cart_item['quantity'] > 1) { ?>
                        <button id = 'decrease_qty' 
                        class="red-btn minus"
                        data-action="updateProduct"
                        >
                        <img class="cart_action_img" src="<?= path() ?>assets/img/icons/minus.svg"
                        alt="rolling"
                        >
                      <img style="display: none" class="cart_action_img__loading" src="<?= path() ?>assets/img/icons/rolling.svg"
                      alt="rolling"
                      ></button>
                    <?php } ?>
                    <button id = 'increase_qty' 
                    class="red-btn plus <?= !$is_avialble ?  esc_attr( 'disabled' ) : ''?>"
                     data-action="updateProduct"
                    >
                    <img class="cart_action_img" src="<?= path() ?>assets/img/icons/plus.svg"
                    alt="rolling"
                    >
                  <img style="display: none" class="cart_action_img__loading" src="<?= path() ?>assets/img/icons/rolling.svg"
                  alt="rolling"
                  ></button>
                    </div>
                    <div class="modal-error__item-remove">
                      <button id = 'remove_from_cart' data-action="removeFromCart" class="red-btn remove_btn">
                      <img class="cart_action_img" src="<?= path() ?>assets/img/icons/trash.svg" alt="trash">
                      <img style="display: none" class="cart_action_img__loading" src="<?= path() ?>assets/img/icons/rolling.svg" alt="rolling">
                    
                    </button>
                    </div>
                    <?php } ?>
                    


                  </div>

                  <?php
                  $temp++;
                endif;
              endforeach;
              ?>
            </div>


            <div class="add-product__btn">
              <?php if ($show_cart_button) { ?>
              

            <a href="<?php cart_url() ?>"
            class="view-cart red-btn"
            ><?= __('View Cart', '4nails') ?></a>

            <?php } ?>
            

            <div class="continue modal-error__go-shop red-btn" 
            id="backToCart"
            onclick="Fancybox.close()"><?= __($button_text ?: 'back to cart', '4nails'); ?></div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>