<div class="history">
  <?php wc_print_notices(); ?>
  <?php if ($has_orders):
    $orders = wc_get_orders(['customer_id' => get_current_user_id(), 'limit' => -1]);
    $total_orders = 0;
    ?>
  <div class="account__discount">
    <?php if ($GLOBALS['showPersonalDiscount']): ?>
    <span><?= __('Personal discount: ', '4nails'); ?></span>
    <?= get_field('individual_discount', 'user_' . get_current_user_id()); ?>
    %
    <?php endif; ?>
  </div>

  <div class="history__total">
    <div><?= __('Total expenses for all orders:', '4nails'); ?></div>
    <div><?= wc_price(get_order_total($orders)) ?></div>
  </div>
  <form method="post">
    <div class="history__table cabinet-orders">

      <div class="history__top">
        <div class="history__order-details">
          <div class="history__order-date"><?= __("Date", '4nails') ?></div>
          <div class="history__order-number"><?= __("Order", '4nails') ?> #</div>
        </div>
        <div class="history__order-status"><?= __("Status", '4nails') ?></div>
        <div class="history__order-total"><?= __("Total   ", '4nails') ?></div>
      </div>
      <div class="history__content">
        <?php foreach ($orders as $order):
            $date = $order->get_date_created()->date('d.m.Y');
            $url = $order->get_view_order_url();
            $number = $order->get_order_number();
            $status = $order->get_status();
            $cancel = cancelOrder($order);
            ?>
        <div class="history__item">
          <div class="history__order-details">
            <div class="history__order-date"><?= $date ?></div>
            <div class="history__order-number"><a href="<?= $url ?>">#<?= $number ?></a></div>
          </div>
          <div class="history__order-status status-box">
            <div>
              <span class="status order-status order-<?= $status ?>"></span> <?= nails_status(ucwords($status)); ?>
            </div>
            <?php if ($cancel !== false): ?>
            <span
              class="cancel-order red-btn button"
              id="cancel-order-btn"
              data-cancel-url=<?= esc_url($cancel) ?>
            ><?= __("Cancel", '4nails') ?></span>
            <?php endif; ?>
          </div>
          <div class="history__order-total"><?= $order->get_formatted_order_total() ?></div>
        </div>

        <?php endforeach; ?>
      </div>
    </div>
  </form>
  <?php else: ?>
  <div
    class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info"
  >
    <a
      class="woocommerce-Button button"
      href="<?= esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>"
    >
      <?php _e('Go shop', 'woocommerce') ?>
    </a>
    <?php _e('No order has been made yet.', 'woocommerce'); ?>
  </div>
  <?php endif; ?>
</div>

<div
  style="display: none; width: 300px;"
  class="modal fade count-error"
  id="cancel-order-modal"
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
            <h2 class="cancel-order-modal__text"><?= __('Are you sure you want to cancel the order?', '4nails') ?></h2>

            <div class="cancel-order__btn">
              <div
                class="view-cart red-btn cancel-order cancel-order__button"
                onclick="Fancybox.close()"
              ><?= __('No', '4nails') ?></div>
              <a
                class="view-cart red-btn cancel-order__button"
                href="<?= $cancel ?>"
              ><?= __('Yes', '4nails') ?></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>