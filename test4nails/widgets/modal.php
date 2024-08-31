<?php $post = get_post($_POST['product_id']) ?>
<div class="modal-body">
    <div id="qweqwe" class="add-product ">
        <div class="add-product__content">
            <div class="add-product__title"><?= __('Item successfully added to cart', '4nails') ?></div>
        </div>
        <div class="add-product__item">
            <div class="add-product__img"><img src="<?php the_post_thumbnail_url() ?>"></div>
            <?php if (has_excerpt()): ?>
                <div class="add-product__text"><?php the_excerpt() ?></div>
            <?php endif; ?>
        </div>
        <div class="add-product__btn">
            <a href="<?php cart_url() ?>" class="view-cart red-btn"><?= __('View Cart', '4nails') ?></a>
            <div class="continue" onclick="Fancybox.close()"><?= __('Continue shopping ', '4nails') ?></div>
        </div>

    </div>

</div>