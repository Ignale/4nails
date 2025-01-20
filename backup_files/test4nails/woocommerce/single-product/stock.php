<?php
global $product;
$availability = $product->get_availability();
$class = esc_attr($availability['class']);
$availability = $availability['availability'] ?: __('In stock', '4nails');
?>
<div class="product__status <?= $class ?>"><?= $availability ?></div>