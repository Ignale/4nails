<div class="checkout__item-left checkout__order shop_table woocommerce-checkout-review-order-table table second-step">
  <div class="step__container">
    <?php $chosen_payment_method = WC()->session->get('chosen_payment_method'); ?>
    <div
      class="<?= $chosen_payment_method ?>"
      id="asideSumm"
    >

      <div
        class="checkout-aside__container"
        style="display: none"
      >
        <div class="checkout-aside__totals totals">

          <div
            class="totals__title"
            style="display: none"
          ><?= __('Order summary', '4nails'); ?></div>
          <div
            class="totals__item totals__item--subtotal"
            data-subtotal="<?= get_subtotal() ?>"
          >
            <div class="totals__name"><?php _e('Subtotal', 'woocommerce'); ?>
              <div class="totals__total-items">
                (<?php cart_content();
                cart_items() ?>)
              </div>
            </div>
            <div class="totals__price"><?= wc_price(get_subtotal()); ?></div>
          </div>

          <?php if (!((float) WC()->cart->get_taxes_total() === 0.0)): ?>
          <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()): ?>
          <?php if ('itemized' === get_option('woocommerce_tax_total_display')): ?>
          <?php foreach (WC()->cart->get_tax_totals() as $code => $tax): ?>
          <div
            class="totals__item totals__item--tax"
            data-tax="<?= WC()->cart->get_taxes_total() ?>"
          >
            <div class="totals__name"><?= __('California sales tax', '4nails') ?></div>
            <div
              data-title=<?php echo esc_attr($tax->label); ?>
              class="totals__price"
            ><?php echo wp_kses_post($tax->formatted_amount); ?>
            </div>
          </div>
          <?php endforeach; ?>
          <?php else: ?>
          <div
            class="totals__item totals__item--tax"
            data-tax="<?= WC()->cart->get_taxes_total() ?>"
          >
            <div class="totals__name"><?= __('California sales tax', '4nails') ?></div>
            <div class="totals__price"><?php wc_cart_totals_taxes_total_html(); ?>
            </div>
          </div>
          <?php endif; ?>
          <?php endif; ?>
          <?php endif; ?>
          <div
            class="totals__item totals__item--shipping"
            data-shipping="<?= WC()->cart->get_shipping_total() ?>"
          >
            <div class="totals__name"><?= __('Shipping', '4nails') ?></div>
            <div class="totals__price"><?= wc_price(WC()->cart->get_shipping_total()); ?></div>
          </div>
          <?php do_action('woocommerce_review_order_before_order_total'); ?>

          <?php foreach (WC()->cart->get_fees() as $fee): ?>
          <div
            class="totals__item totals__item--fee"
            data-fee="<?= calcTotalFee() ?>"
          >
            <div class="totals__name"><?php echo esc_html($fee->name); ?></div>
            <div class="totals__price"><?php wc_cart_totals_fee_html($fee); ?>
            </div>
          </div>
          <?php endforeach; ?>
          <div class="totals__item totals__item--total">
            <div class="totals__name"><?php _e('Total', 'woocommerce'); ?></div>
            <div
              id="totalPrice"
              class="totals__price"
            ><?php wc_cart_totals_order_total_html(); ?></div>
          </div>
          <?php do_action('woocommerce_review_order_after_order_total'); ?>
        </div>
        <div class="totals__price-text"><?= __('Prices are in US dollars.', '4nails') ?></div>
        <?php wc_get_template('checkout/terms.php'); ?>

        <div class="checkout-aside__button">
          <?php
          /*delete after fix*/

          $chosen_payment_method = WC()->session->get('chosen_payment_method');

          //$test_button = !empty($order_button_text) ? $test_button = esc_html($order_button_text) : __('Place an order without payment', '4nails');
          if ($chosen_payment_method !== 'ppcp-gateway') {
            echo apply_filters('woocommerce_order_button_html', '<button disabled type="submit" class="pay-btn red-btn submit-checkout-btn" name="woocommerce_checkout_place_order" id="place_order" value="' . __('PLACE ORDER', '4nails') . '" data-value="' . __('PLACE ORDER', '4nails') . '">' . __('PLACE ORDER', '4nails') . '</button>');
          }
          ?>
          <?php
          $chosen_payment_method = WC()->session->get('chosen_payment_method');

          if ($chosen_payment_method === 'ppcp-gateway'):
            ?>
          <div class="paypalIframe">
            <?php do_action('woocommerce_review_order_after_submit'); ?>
          </div>
          <?php endif; ?>

        </div>

        <div class="address-next-step btn-next-step">
          <p class="btn-next-step__text">
            <?= __('In the next step, you will need to choose a shipping method.', '4nails') ?>
          </p>
          <div
            class="btn-next-step__btn"
            onclick="validateCheckout(firstStep)"
          >
            <?= __('CONTINUE', '4nails') ?>
          </div>
        </div>
        <div class="shipping-next-step btn-next-step">
          <p class="btn-next-step__text">
            <?= __('In the next step, you will be able to choose a payment method and place your order.', '4nails') ?>
          </p>
          <div
            class="btn-next-step__btn"
            onclick="secondStep()"
          >
            <?= __('CONTINUE', '4nails') ?>
          </div>
        </div>

      </div>
    </div>


    <h2 class="step__title delivery-title"><?= __('SELECT SHIPPING METHOD', '4nails') ?></h2>
    <div
      class="step__button step__button--save"
      onclick="secondStep()"
    >
      <?= __('Save', '4nails') ?>
    </div>
    <div class="shipp-info">
      <div class="shipp-info__container">
        <h2 class="step__title"><?= __('SHIPPING METHOD', '4nails') ?></h2>
        <div class="shipp-info__data">
          <div class="shipp-info__name"></div>
          <div class="shipp-info__desc"></div>
          <div class="shipp-info__price"></div>
        </div>
        <div
          class="step__button"
          onclick="changeShippingData()"
        >
          <?= __('Change', '4nails') ?>
        </div>
      </div>
    </div>
    <?php if (WC()->cart->show_shipping()): ?>

    <?php do_action('woocommerce_review_order_before_shipping'); ?>

    <?php wc_cart_totals_shipping_html(); ?>

    <?php
      $cart_items = WC()->cart->get_cart_contents();
      $cart_item = WC()->cart->get_cart_contents();
      $product = reset($cart_item);

      $all_virtual = true;

      foreach ($cart_items as $cart_item) {
        $product = $cart_item['data'];

        if (!$product->is_virtual()) {
          $all_virtual = false;
          break;
        }
      }

      if ($all_virtual) { ?>
    <div class="checkout__order-item">

      <div class="checkout__order-right">
        <ul class=" p-0">
          <li>

            <div class="custom-control custom-radio">
              <input
                type="radio"
                class="shipping_method custom-control-input"
                checked
              />
              <label class="custom-control-label shipp-for-training-text"><?= __('Free shipping', '4nails') ?></label>
            </div>

          </li>
        </ul>
      </div>

    </div>
    <?php
      }
      ?>

    <?php do_action('woocommerce_review_order_after_shipping'); ?>

    <?php endif; ?>

  </div>


</div>