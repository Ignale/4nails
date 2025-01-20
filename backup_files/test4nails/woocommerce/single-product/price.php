<?php



global $product;



$classPrefix = 'product-';



$isVariable = $product->is_type('variable');

$sale = $isVariable ? $product->get_variation_sale_price('min', true) : $product->get_sale_price();

$regular = $isVariable ? $product->get_variation_regular_price('min', true) : $product->get_regular_price();



if ((in_the_loop() || is_main_query()) && !is_single()) $classPrefix = 'card-'; ?>

<div class="product__price">


  <?php

    if ($product->is_on_sale()||(if_user_have_sale()&&$GLOBALS['showPersonalDiscount'])): ?>



  <div class="<?= $classPrefix ?>old-price"><?= wc_price($regular) ?></div>

  <?php endif; ?>

  <div class="<?= $classPrefix ?>price">

    <?= wc_price(get_product_price($product->get_id())); ?>

  </div>


</div>