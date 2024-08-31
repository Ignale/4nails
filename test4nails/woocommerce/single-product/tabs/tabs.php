<div class="product__info">
    <ul class="product__tabs">
        <li class="active-tab"><?= __("Description", '4nails')?></li>
        <li><?= __("Feedback", '4nails')?></li>
    </ul>
    <div class="product__tabs-content">
        <div class="product__tabs-item product__description text">
            <?php woocommerce_product_description_tab() ?>
        </div>
        <div class="product__tabs-item product__reviews">

            <?php wc_get_template('single-product-reviews.php') ?>
        </div>
    </div>
</div>