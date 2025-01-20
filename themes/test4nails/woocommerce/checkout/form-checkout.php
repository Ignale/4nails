<?php

$is_form_login = (is_user_logged_in() || 'no' === get_option('woocommerce_enable_checkout_login_reminder'));


$customer = new WC_Customer(get_current_user_id());

$countries = new WC_Countries;

$chosen_payment_method = WC()->session->get('chosen_payment_method');
// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
  echo '<div class="wrapper checkout-message">' . esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce'))) . '</div>';
  return;
}
?>
<section class="checkout">

  <div
  class="checkout__container current-step--first hide-second-step hide-third-step <?= $chosen_payment_method ?>"
  <?= is_user_logged_in() ? 'data-user="true"' : '' ?>
  >
    <form
    name="checkout"
    class="checkout__form checkout woocommerce-checkout"
    method="post"
    action="<?php echo esc_url(wc_get_checkout_url()); ?>"
    enctype="multipart/form-data"
    >

      <div class="checkout__container-additional">
        <div class="checkout__content">
          <div class="checkout__main">
            <div class="first-step step">
              <?php if ($checkout->get_checkout_fields()): ?>
                <?php do_action('woocommerce_checkout_before_customer_details'); ?>
                <div class="step__container">

                  <div class="step__container">
                    <h2
                    class="checkout__title title shipping-title"
                    <?= is_user_logged_in() ? 'style="display: none"' : '' ?>
                    >
                      <?= __('ENTER YOUR ADDRESSES', '4nails') ?>
                    </h2>
                  </div>
                  <div
                  class="step__data <?= $customer && (!empty($customer->get_billing_first_name()) && !empty($customer->get_billing_country()) && !empty($customer->get_billing_postcode())) ? 'have-data' : '' ?> <?= is_user_logged_in() && (!empty($customer->get_billing_first_name()) && !empty($customer->get_billing_country()) && !empty($customer->get_billing_postcode())) ? '' : 'step__info--hide' ?>"
                  >
                    <h2 class="checkout__title title"><?= __('YOUR ADDRESS', '4nails') ?></h2>
                    <div class="step__wrapper">
                      <div class="step__info">
                        <div class="step__info-item shipping-info">
                          <p><?= __('Shipping address', '4nails') ?></p>
                          <p class="shipping-info__name">
                            <?= ($customer->get_shipping_first_name() === 'Default name' ? ' ' : $customer->get_shipping_first_name()) . ' ' . ($customer->get_shipping_last_name() === 'Default lastname' ? ' ' : $customer->get_shipping_last_name()) ?>
                          </p>
                          <p class="shipping-info__street">
                            <?=
                              $countries->get_formatted_address(
                                array(
                                  'address_1' => $customer->get_shipping_address_1(),
                                  'address_2' => $customer->get_shipping_address_2(),
                                )
                              );
                            ?>
                          </p>
                          <p class="shipping-info__location <?= wp_is_mobile() ? 'shipping-info--hide' : '' ?>">
                            <?= $countries->get_formatted_address(
                              array(

                                'city' => $customer->get_shipping_city(),
                                'state' => $customer->get_shipping_state(),
                                'postcode' => $customer->get_shipping_postcode(),
                                'country' => $customer->get_shipping_country(),
                              )
                            )

                              ?>
                          </p>
                        </div>
                        <div class="step__info-item billing-info">
                          <p><?= __('Billing address', '4nails') ?></p>

                          <p class="billing-info__name">
                            <?= ($customer->get_billing_first_name() === 'Default name' ? ' ' : $customer->get_billing_first_name()) . ' ' . ($customer->get_billing_last_name() === 'Default lastname' ? ' ' : $customer->get_billing_last_name()) ?>

                          </p>
                          <p class="billing-info__street">
                            <?= $customer->get_billing_address_1() .
                              " " . $customer->get_billing_address_2()
                              ?>
                          </p>
                          <p class="billing-info__location <?= wp_is_mobile() ? 'shipping-info--hide' : '' ?>">
                            <?= $countries->get_formatted_address(
                              array(
                                'city' => $customer->get_billing_city(),
                                'state' => $customer->get_billing_state(),
                                'postcode' => $customer->get_billing_postcode(),
                                'country' => $customer->get_billing_country(),
                              )
                            )

                              ?>
                          </p>
                        </div>
                      </div>

                      <div
                      class="step__button"
                      onclick="changeAddressData()"
                      >
                        <?= __('Change', '4nails') ?>
                      </div>

                    </div>
                  </div>
                  <div
                  class="step__fields
                  <?= is_user_logged_in() && (!empty($customer->get_shipping_first_name()) && !empty($customer->get_shipping_country()) && !empty($customer->get_shipping_postcode())) ? 'have-data' : '' ?>
                  <?= is_user_logged_in() && (!empty($customer->get_shipping_first_name()) && !empty($customer->get_shipping_country()) && !empty($customer->get_shipping_postcode())) ? 'style="display: none"' : '' ?>"
                  >
                    <div class="
                  step__fields-shipping">
                      <h2 class="step__title"><?= __('Shipping address', '4nails'); ?></h2>
                      <?php do_action('woocommerce_checkout_shipping'); ?>
                    </div>
                    <div class="step__fields-payment">
                      <h2 class="step__title"><?= __('Billing address', '4nails'); ?></h2>
                      <div class="step__diff-addres ">
                        <div
                        id="ship-to-different-address"
                        class="mb-3 pt-3"
                        >
                          <label
                          class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox custom-control custom-checkbox"
                          >
                            <input
                            id="ship-to-different-address-checkbox"
                            class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox custom-control-input"
                            <?php checked(apply_filters('woocommerce_ship_to_different_address_checked', 'shipping' === get_option('woocommerce_ship_to_destination') ? 0 : 1), 0) ?>
                            type="checkbox"
                            name="ship_to_different_address"
                            />

                            <label
                            class="custom-control-label"
                            for="ship-to-different-address-checkbox"
                            ><?php _e('Shipping address matches billing address?', 'woocommerce'); ?></label>
                          </label>
                        </div>
                      </div>
                      <?php do_action('woocommerce_checkout_billing'); ?>
                    </div>
                    <div class="checkout__order-notes">

                      <?php do_action('woocommerce_before_order_notes', $checkout); ?>

                      <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))): ?>

                        <?php if (!WC()->cart->needs_shipping() || wc_ship_to_billing_address_only()): ?>

                          <h3><?php _e('Additional information', 'woocommerce'); ?></h3>

                        <?php endif; ?>

                        <div class="woocommerce-additional-fields__field-wrapper">
                          <?php foreach ($checkout->get_checkout_fields('order') as $key => $field): ?>
                            <?php
                            $field['class'][] = 'form-group';
                            $field['input_class'][] = 'control-form';
                            woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                          <?php endforeach; ?>
                        </div>

                      <?php endif; ?>

                      <?php do_action('woocommerce_after_order_notes', $checkout); ?>
                    </div>
                  </div>
                </div>
                <?php do_action('woocommerce_checkout_after_customer_details'); ?>
              <?php endif; ?>
            </div>
          </div>

          <?php do_action('woocommerce_checkout_before_order_review'); ?>
          <div
          class="woocommerce-checkout-review-order"
          id="order_review"
          >
            <?php do_action('woocommerce_checkout_order_review'); ?>

          </div>
          <?php do_action('woocommerce_checkout_after_order_review'); ?>

          <div class="checkout-total">
            <div class="checkout-total__container">
              <div class="checkout-total__header">
                <div class="checkout-total__title"><?= __('CHECK YOUR ORDER', '4nails') ?></div>
                <a
                href="<?= cart_url() ?>"
                class="checkout-total__back-to-cart"
                ><?= __('Change', '4nails') ?></a>
              </div>

              <div class="checkout-total__wrapper">
                <div class="checkout-total__top">
                  <div class="checkout-total__name"><?= __('Item', '4nails') ?></div>
                  <div class="checkout-total__price"><?= __('Price', '4nails') ?></div>
                  <div class="checkout-total__qty"> <?= __('Qty', '4nails') ?></div>
                  <div class="checkout-total__subtotal"><?= __('Amount', '4nails') ?></div>
                </div>
                <div class="checkout-total__content">
                  <?php
                  do_action('woocommerce_review_order_before_cart_contents');

                  foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
                      ?>

                      <div class="checkout-total__item">
                        <div class="checkout-total__name">
                          <div class="checkout-total__product-title checkout-total__product-title--hide">
                            <?= __('Product', '4nails') ?>
                          </div>
                          <div class="checkout-total__info">
                            <div class="checkout-total__img">
                              <img
                              src="<?= wp_get_attachment_image_url($_product->get_image_id(), 'product_cat') ?>"
                              loading="lazy"
                              >
                            </div>
                            <div class="checkout-total-mobile">
                              <div class="checkout-total__title"> <?= $_product->get_name(); ?></div>
                              <div class="checkout-total__price">
                                <div class="checkout-total__product-title checkout-total__product-title--hide">
                                  <?= __('Price', '4nails'); ?>
                                </div>
                                <?php echo wc_price(get_product_price($_product->get_id())); ?>
                              </div>
                              <div class="checkout-total__qty">
                                <div class="checkout-total__product-title checkout-total__product-title--hide">
                                  <?= __('Qty', '4nails'); ?>
                                </div>
                                <?= $cart_item['quantity'] ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="checkout-total__price">
                          <div class="checkout-total__product-title checkout-total__product-title--hide">
                            <?= __('Price', '4nails'); ?>
                          </div>
                          <?php echo wc_price(get_product_price($_product->get_id())); ?>
                        </div>
                        <div class="checkout-total__qty">
                          <div class="checkout-total__product-title checkout-total__product-title--hide">
                            <?= __('Qty', '4nails'); ?>
                          </div>
                          <?= $cart_item['quantity'] ?>
                        </div>
                        <div class="checkout-total__subtotal">
                          <div class="checkout-total__product-title checkout-total__product-title--hide">
                            <?= __('Subtotal', '4nails'); ?>
                          </div>
                          <?php
                          $price = get_product_price($product_id);
                          $quantity = $cart_item['quantity'];
                          $total_price = $price * $quantity;
                          echo wc_price($total_price);
                          ?>

                        </div>
                      </div>
                      <?php
                    }
                  }
                  do_action('woocommerce_review_order_after_cart_contents');
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
            </div>
          </div>

        </div>

        <aside>
          <div class="aside__content">
            <div class="checkout-aside">

            </div>
          </div>
        </aside>
      </div>
    </form>
  </div>


</section>