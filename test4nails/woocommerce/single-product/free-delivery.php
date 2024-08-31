<?php
$disconnect_free_delivery = true;
if (get_field('free_delivery')=='yes' || !$$disconnect_free_delivery):

?>

<div class="product__status free-delivery"><?= __('FREE DELIVERY','4nails'); ?></div>

<?php ;endif; ?>

