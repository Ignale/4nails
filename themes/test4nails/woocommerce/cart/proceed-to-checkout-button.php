<?php
$loggedUser = is_user_logged_in();

// $diffWarehouses = if_different_warehouses(WC()->cart);

$overweight = if_overweight(WC()->cart);

$free_delivery = if_free_delivery(WC()->cart);

// Checking that in the basket all goods are only only_free_delivery
$only_free_delivery = $free_delivery['free_delivery'] && $free_delivery['only_free_delivery'];

/* If cart have overweight or if cart items have different warehouses or if user isnt logged in and we are not ignoring overwheight*/
$haveTrouble = !$loggedUser || ($overweight && !$free_delivery['free_delivery']) ? true : false;

/* If have overweight and we are not ignoring overwheight*/
$changePopupLink = 0;
if (!$overweight && !$free_delivery['free_delivery']) {
  $changePopupLink = 'login-error';
} elseif ($overweight && !$free_delivery['free_delivery']) {
  $changePopupLink = 'overweight';
}
$href = $haveTrouble ? '' : esc_url(wc_get_checkout_url());
/*
  VwLogger::log([
        '$loggedUser'=>$loggedUser,
        '$ignore_overweight'=>$ignore_overweight,
        '$diffWarehouses '=>$diffWarehouses ,
        '$overweight'=>$overweight,
        '$free_delivery'=>$free_delivery
      ], 'info', __FILE__);
*/
$id = '';
/* If user logged in, and dont have overweight and we are not ignoring overwheight*/
if (!$only_free_delivery && $free_delivery['free_delivery']) { // проверка на наличие товара с свободной доставкой
  $id = 'overweight';
} elseif ($loggedUser && !($overweight && !$free_delivery['free_delivery'])) {
  $id = 'goToCheckoutBtn';
} elseif (!$loggedUser) { // if user is not logged in but has no troubles
  $id = 'login-btn';
} elseif (!$overweight && !$free_delivery['free_delivery']) { // if logged in but has items from different warehouses
  $id = 'login-error';
} elseif ($overweight && !$free_delivery['free_delivery']) { // if logged in but has overweight items
  $id = 'overweight';
}
?>
<a
href="<?php echo esc_url(wc_get_checkout_url()); ?>"
class="red-btn checkout-button button btn-cyan w-100 alt wc-forward"
id="<?= $id ?>"
>
  <?= __('CONTINUE', '4nails');
  ?>
</a>

<?php
if (!$loggedUser) {
  get_template_part('widgets/cart/cart', 'login', ['have_trouble' => $free_delivery['free_delivery'] || $overweight ? $changePopupLink : 0]);
}
if (!$only_free_delivery && $free_delivery['free_delivery']) {
  get_template_part('widgets/cart/cart', 'notAllow', ['products_id' => $free_delivery['ids']]);
}
if ($overweight && !$free_delivery['free_delivery']) {
  get_template_part('widgets/cart/cart', 'overweight', ['cart' => WC()->cart]);
}
?>