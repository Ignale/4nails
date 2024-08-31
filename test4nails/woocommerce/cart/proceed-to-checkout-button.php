<?php
$loggedUser = is_user_logged_in();
$diffWarehouses = if_different_warehouses(WC()->cart);
$overweight = if_overweight(WC()->cart);
/* If cart have overweight or if cart items have different warehouses or if user isnt logged in*/
$haveTrouble= !$loggedUser||$diffWarehouses['different']||$overweight ? true : false;
/* If have overweight or if cart items have different warehouses*/
$changePopupLink=0;
if($diffWarehouses['different']){
    $changePopupLink='login-error';
}elseif ($overweight){
    $changePopupLink='overweight';
}
$href= $haveTrouble?'':esc_url(wc_get_checkout_url());

$id=0;
/* If user logged in, and dont have overweight and diff warehouses*/
if($loggedUser&&!$diffWarehouses['different']&&!$overweight ){
    $id='goToCheckoutBtn';
}elseif (!$loggedUser){ // if user dont logged in but have no troubles
    $id='login-btn';
}elseif ($diffWarehouses['different']){ // if logged in but have other warehouses
    $id='login-error';
}elseif ($overweight){ // if logged in but have overweight
    $id='overweight';
}
?>
<a href="<?= $href?>"
   class="red-btn checkout-button button btn-cyan w-100 alt wc-forward"
   id="<?= $id?>"> <?= __('CONTINUE', '4nails');
    ?>
</a>


<?php
if (!$loggedUser) {
    get_template_part('widgets/cart/cart', 'login',['have_trouble'=>$diffWarehouses['different']||$overweight?$changePopupLink:0]);
}
if ($diffWarehouses['different']){

    get_template_part('widgets/cart/cart', 'notAllow', ['products_id' => $diffWarehouses['ids']]);
}
if ($overweight){
    get_template_part('widgets/cart/cart', 'overweight', ['cart' => WC()->cart]);
}
?>

