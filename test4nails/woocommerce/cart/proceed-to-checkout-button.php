<?php
$loggedUser = is_user_logged_in();

$diffWarehouses = if_different_warehouses(WC()->cart);

$overweight = if_overweight(WC()->cart);

$free_delivery = if_free_delivery(WC()->cart);

//Ignore overweight in cart if free delivery and diffWarehouses are checked in any product  
$ignore_overweight = $free_delivery['free_delivery'] && $diffWarehouses['different'];

/* If cart have overweight or if cart items have different warehouses or if user isnt logged in and we are not ignoring overwheight*/
$haveTrouble = !$loggedUser || ($overweight && !$ignore_overweight) ? true : false;

/* If have overweight and we are not ignoring overwheight*/
$changePopupLink = 0;
if (!$overweight && !$ignore_overweight) {
  $changePopupLink = 'login-error';
} elseif ($overweight && !$ignore_overweight) {
  $changePopupLink = 'overweight';
}
$href = $haveTrouble ? '' : esc_url(wc_get_checkout_url());

$id = 0;
/* If user logged in, and dont have overweight and we are not ignoring overwheight*/
if ($loggedUser && !($overweight && !$ignore_overweight)) {
  $id = 'goToCheckoutBtn';
} elseif (!$loggedUser) { // if user dont logged in but have no troubles
  $id = 'login-btn';
} elseif (!$overweight && !$ignore_overweight) { // if logged in but have other warehouses
  $id = 'login-error';
} elseif ($overweight && !$ignore_overweight) { // if logged in but have overweight
  $id = 'overweight';
}
?>
<a
href="<?= $href ?>"
class="red-btn checkout-button button btn-cyan w-100 alt wc-forward"
id="<?= $id ?>"
>
  <?= __('CONTINUE', '4nails');
  ?>
</a>


<?php
if (!$loggedUser) {
  get_template_part('widgets/cart/cart', 'login', ['have_trouble' => $diffWarehouses['different'] || $overweight ? $changePopupLink : 0]);
}
if ($diffWarehouses['different'] && !$free_delivery['free_delivery']) {
  get_template_part('widgets/cart/cart', 'notAllow', ['products_id' => $diffWarehouses['ids']]);
}
if ($overweight && !$ignore_overweight) {

  get_template_part('widgets/cart/cart', 'overweight', ['cart' => WC()->cart]);
}
?>