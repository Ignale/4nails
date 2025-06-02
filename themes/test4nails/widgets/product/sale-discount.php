<?php


global $product;

if ($product->is_on_sale() && !ifPersonalDiscount($product) && $product->get_stock_status() !== 'outofstock'):
  $discount = get_sale_amount($product->get_regular_price(), $product->get_sale_price());
  echo sprintf(__('Sale %s', '4nails'), $discount . '%');
endif;
if (ifPersonalDiscount($product) && $GLOBALS['showPersonalDiscount'] && $product->get_stock_status() != 'outofstock') {
  echo sprintf(__('Personal discount %s', '4nails'), get_sale_amount($product->get_regular_price(), get_product_price($product->get_id())) . '%');
}