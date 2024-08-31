<?php
$pdf = invoice($order);
$tracking_info = get_tracking_order($order);
$nails_get_totals = nails_order_info($order->get_id());
?>
<?php if ($order->get_status() == 'cancel-request' && !is_account_page()): ?>
  <div class="thanks__container">
    <h1 class="title thanks__title cancel-title">
      <?= __('The order has been successfully canceled. Your funds will be returned to you within 7 days.', 'woocommerce') ?>
    </h1>
  </div>
  </div>
<?php else: ?>
  <div class="order">
    <div class="order__title">

      <a href="<?= is_user_logged_in() ? wc_get_account_endpoint_url('orders') : home_url(); ?>">
        <svg
        version="1.1"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        x="0px"
        y="0px"
        width="22px"
        height="17px"
        viewBox="-164.5 181.5 22 17"
        enable-background="new -164.5 181.5 22 17"
        xml:space="preserve"
        >
          <polygon
          fill="#09CCB4"
          points="-162.586,189.5 -156.015,182.928 -156.722,182.221 -164.5,190 -156.722,197.779 -156.015,197.072 	-162.586,190.5 -142.5,190.5 -142.5,189.5 "
          ></polygon>
        </svg>
      </a>
      <?= __("Details for Order #", '4nails') ?>  <?= $order->get_order_number() ?>
    </div>
    <div class="order__date"><?= __("Date:", '4nails') ?>   <?= $order->get_date_created()->date('d.m.Y'); ?></div>
    <?php if (!empty($tracking_info)): ?>
      <?= __(" Tracking #:", '4nails') ?>
      <a
      class="order__tracking-info"
      href="<?= $tracking_info['url']; ?>"
      target="_blank"
      >
        <b><?= $tracking_info['number']; ?></b>
        <svg
        class="gridicon gridicons-external"
        height="12"
        width="12"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        >
          <g>
            <path
            d="M19 13v6c0 1.105-.895 2-2 2H5c-1.105 0-2-.895-2-2V7c0-1.105.895-2 2-2h6v2H5v12h12v-6h2zM13 3v2h4.586l-7.793 7.793 1.414 1.414L19 6.414V11h2V3h-8z"
            ></path>
          </g>
        </svg>
      </a>
    <?php endif; ?>
    <?php if ($pdf !== false && is_user_logged_in()): ?>
      <a
      href="<?= $pdf ?>"
      class="order__invoice"
      target="_blank"
      >
        <div class="cyan-link"><?= __("Print Invoice", '4nails') ?></div>
        <svg
        version="1.1"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        x="0px"
        y="0px"
        width="17px"
        height="22px"
        viewBox="-164.5 181.5 17 22"
        enable-background="new -164.5 181.5 17 22"
        xml:space="preserve"
        >
          <path
          fill="#17CFB9"
          d="M-147.708,186.123l-0.291-0.293l-3.813-3.829l-0.292-0.292c-0.131-0.133-0.314-0.209-0.501-0.209h-10.964	c-0.448,0-0.931,0.348-0.931,1.11v13.683v6.272v0.176c0,0.317,0.318,0.627,0.694,0.725c0.019,0.005,0.037,0.012,0.057,0.016	c0.058,0.012,0.119,0.019,0.18,0.019h15.139c0.06,0,0.121-0.007,0.18-0.019c0.02-0.004,0.038-0.011,0.057-0.016	c0.376-0.098,0.694-0.407,0.694-0.725v-0.176v-6.272v-9.491C-147.5,186.512-147.535,186.297-147.708,186.123z M-149.7,185.5h-1.8	v-1.8L-149.7,185.5z M-163.325,202.501c-0.027,0-0.051-0.01-0.075-0.019c-0.06-0.028-0.1-0.088-0.1-0.157V197.5h15v4.825	c0,0.069-0.02,0.129-0.079,0.157c-0.023,0.009-0.048,0.019-0.075,0.019H-163.325z M-163.5,196.5v-13.656	c0-0.083,0.017-0.344,0.18-0.344h10.82v4h4v10H-163.5z M-158.629,198.472c-0.125-0.104-0.268-0.182-0.426-0.233	c-0.158-0.052-0.318-0.078-0.479-0.078h-1.095v3.822h0.62v-1.379h0.46c0.2,0,0.382-0.029,0.548-0.089	c0.165-0.059,0.306-0.142,0.423-0.249c0.118-0.106,0.208-0.238,0.274-0.396c0.065-0.157,0.098-0.332,0.098-0.526	c0-0.183-0.039-0.349-0.117-0.495C-158.4,198.7-158.502,198.576-158.629,198.472z M-158.863,199.734	c-0.039,0.105-0.088,0.188-0.15,0.246c-0.063,0.059-0.13,0.102-0.205,0.127c-0.074,0.025-0.148,0.039-0.225,0.039h-0.568v-1.514	h0.465c0.158,0,0.285,0.025,0.382,0.074c0.096,0.051,0.171,0.113,0.225,0.188c0.054,0.074,0.088,0.151,0.106,0.232	c0.017,0.082,0.025,0.153,0.025,0.215C-158.807,199.498-158.826,199.629-158.863,199.734z M-154.884,198.721	c-0.16-0.17-0.362-0.306-0.604-0.407c-0.243-0.102-0.524-0.153-0.844-0.153h-1.147v3.822h1.44c0.049,0,0.123-0.006,0.223-0.018	c0.1-0.013,0.21-0.04,0.33-0.084c0.121-0.043,0.246-0.107,0.375-0.194c0.129-0.087,0.245-0.205,0.349-0.355	c0.103-0.15,0.188-0.337,0.256-0.56c0.067-0.224,0.101-0.492,0.101-0.807c0-0.229-0.04-0.451-0.119-0.667	C-154.604,199.082-154.724,198.891-154.884,198.721z M-155.335,201.121c-0.186,0.27-0.489,0.404-0.91,0.404h-0.615v-2.894h0.362	c0.296,0,0.537,0.04,0.723,0.117c0.186,0.077,0.333,0.18,0.442,0.306c0.109,0.127,0.182,0.268,0.22,0.423	c0.038,0.155,0.056,0.313,0.056,0.472C-155.058,200.461-155.15,200.852-155.335,201.121z M-153.507,201.982h0.629v-1.722h1.591	v-0.425h-1.591v-1.203h1.751v-0.473h-2.38V201.982z M-152.438,190.209c-0.347,0-0.773,0.046-1.27,0.137	c-0.69-0.737-1.412-1.813-1.922-2.869c0.506-2.135,0.253-2.438,0.141-2.58c-0.119-0.151-0.286-0.397-0.477-0.397	c-0.08,0-0.297,0.036-0.383,0.065c-0.218,0.072-0.334,0.241-0.429,0.461c-0.266,0.627,0.101,1.695,0.477,2.52	c-0.322,1.287-0.862,2.827-1.431,4.077c-1.432,0.659-2.192,1.306-2.261,1.923c-0.024,0.225,0.028,0.554,0.421,0.85	c0.108,0.081,0.234,0.124,0.366,0.124l0,0c0.331,0,0.665-0.254,1.051-0.799c0.282-0.397,0.584-0.94,0.9-1.612	c1.012-0.444,2.264-0.846,3.335-1.07c0.596,0.575,1.131,0.866,1.59,0.866c0.338,0,0.629-0.156,0.839-0.452	c0.219-0.307,0.269-0.583,0.147-0.818C-151.489,190.348-151.847,190.209-152.438,190.209z M-159.198,193.879	c-0.176-0.137-0.166-0.229-0.162-0.264c0.023-0.211,0.352-0.584,1.159-1.04C-158.813,193.71-159.142,193.86-159.198,193.879z	 M-156.1,185.184c0.017-0.005,0.395,0.418,0.037,1.221C-156.602,185.851-156.137,185.196-156.1,185.184z M-156.881,191.263	c0.384-0.917,0.74-1.931,1.011-2.869c0.424,0.766,0.934,1.508,1.444,2.103C-155.232,190.687-156.091,190.955-156.881,191.263z	 M-152.007,191.081c-0.116,0.163-0.369,0.167-0.457,0.167c-0.201,0-0.276-0.12-0.584-0.357c0.254-0.033,0.494-0.041,0.685-0.041	c0.335,0,0.398,0.049,0.443,0.074C-151.929,190.951-151.951,191.002-152.007,191.081z"
          ></path>
        </svg>
      </a>
    <?php endif; ?>
    <div class="order__table">
      <div class="history__top">
        <div class="order__list">#</div>
        <div class="order__data">
          <div class="order__description"><?= __("Description", '4nails') ?></div>
          <div class="order__qty"><?= __("Qty", '4nails') ?></div>
          <div class="order__rate"><?= __("Rate", '4nails') ?></div>
          <div class="order__amount"><?= __("Amount", '4nails') ?></div>
        </div>
      </div>
      <div class="history__content">
        <?php
        $i = 0;
        foreach ($order->get_items() as $item):
          $i++;
          $itemData = $item->get_data();
          $link = get_permalink($itemData['product_id']);
          $price = get_product_price($item->get_product_id(), $order->get_id());
          $product = $item->get_product();
          if (!$product) {
            continue;
          }
          ?>
          <div class="history__item">
            <div class="order__list"><?= $i ?></div>
            <div class="order__data">
              <div class="order__description">
                <?php if ($link): ?><a href="<?= $link ?>"><?php endif; ?>
                  <?= getProductTranslatedName($item->get_product_id(), $order->get_id(), true);
                  ?>

                  <?php if ($link): ?> </a><?php endif; ?>
              </div>
              <div class="order__qty"><?= $item->get_quantity() ?></div>
              <div class="order__rate"><?= wc_price($price) ?></div>
              <div class="order__amount"><?= wc_price($price * $item->get_quantity()) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="order__bottom">
        <div class="order__item">
          <div class="order__item-text"><?= __("Subtotal", '4nails') ?> (<?php
              $count_items = 0;
              foreach ($order->get_items() as $item) {
                $count_items += $item->get_quantity();

              }
              echo $count_items == 1 ? $count_items . ' ' . __('item', '4nails') : $count_items . ' ' . __('items', '4nails');
              ?>):
          </div>
          <div class="order__item-figure"><?= wc_price($nails_get_totals['subtotal']) ?></div>
        </div>
        <div class="order__item">
          <div class="order__item-text"><?= __("Shipping:", '4nails') ?></div>
          <div class="order__item-figure"><?= nails_show_shipping_method($order) ?></div>
        </div>
        <div class="order__item">
          <div class="order__item-text"><?= __("Tax:", '4nails') ?></div>
          <div class="order__item-figure"><?= wc_price($order->get_total_tax()); ?></div>
        </div>
        <div class="order__item order__item-total">
          <div class="order__item-text"><?= __("Total ($):", '4nails') ?></div>
          <div class="order__item-figure"><?= $order->get_formatted_order_total() ?></div>
        </div>
        <?php if ($order->get_status() == 'on-hold' || $order->get_status() == 'processing'): ?>
          <?php if (is_user_logged_in()): ?>
            <div class="order__item">
              <a
              class="modal__form-button red-btn checkout-button button w-100 alt wc-forward cancel-btn"
              href="<?= cancelOrder($order) ?>"
              ><?= __('Cancel order', '4nails') ?> </a>
            </div>
          <?php else: ?>
            <div class="order__item">
              <div
              class="modal__form-button red-btn checkout-button button w-100 alt wc-forward cancel-btn"
              id="goToLoginBtn"
              ><?= __('Cancel order', '4nails') ?> </div>
            </div>
            <?php get_template_part('widgets/cart/account', 'login'); ?>

          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>


  </div>
<?php endif; ?>