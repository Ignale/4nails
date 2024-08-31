<?php


global $product;



if ($product->is_on_sale() && !ifPersonalDiscount($product)):
  $discount = 100 - intval(($product->get_sale_price() / $product->get_regular_price()) * 100);
  echo sprintf(__('Sale %s', '4nails'), $discount . '%');
endif;
if (ifPersonalDiscount($product) && $GLOBALS['showPersonalDiscount']) {
  echo sprintf(__('Personal discount %s', '4nails'), get_field('individual_discount', 'user_' . get_current_user_id()) . '%');
}