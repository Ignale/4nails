<?php
$product = $args['product']
  ?>


<div
  style="display: none; width: 600px;"
  class="modal fade count-error"
  id="quantity-modal"
  tabindex="-1"
>
  <div
    class="modal-dialog modal-dialog-centered"
    role="document"
  >
    <div class="modal-content">
      <div class="modal-body">

        <div class="modal__form-login">
          <div class="modal__form-wrap quantity-modal__wrap">

            <?php if ($product['sold_individually']) { ?>
            <h2 class="quantity-modal__text">
              <?= __(' Due to its size and weight, this item can only be ordered in quantities of 1. If you need more than 1 then you will need to place a new order for each unit.', '4nails') ?>
            </h2>

            <?php } else { ?>

            <h2 class="quantity-modal__text">
              <?= sprintf(__('Sorry, we do not have enough "%s" in stock to fulfill your order (%s available). We apologize for any inconvenience caused.', '4nails'), $product['name'], $product['stock_quantity']) ?>
            </h2>
            <?php } ?>


            <div class="add-product__btn">
              <div
                class="view-cart red-btn quantity-modal__button"
                onclick="Fancybox.close()"
              ><?= __('Continue shopping ', '4nails') ?></div>
            </div>
          </div>
          <div
            onclick="Fancybox.close()"
            class="modal-header__delete"
          >
            <img
              src="<?= path() ?>assets/img/icons/delete_b.svg"
              alt="<?php _e('Remove', 'ti-woocommerce-wishlist') ?>"
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</div>