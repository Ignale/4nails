<?php

global $product;

if (getSalePrice($product) && !ifPersonalDiscount($product)): ?>

  <div class="product__sale"> <span> <?= __('Sale', '4nails') ?>   <?= getSalePrice($product) ?>% </span></div>

<?php endif;