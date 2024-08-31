<?php $products_id=$args['products_id'] ?>

<div style="display: none; width: 500px;" class="modal fade" id="login-error-massage" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-body">



                <div class="modal-error">
                    <div class="modal-header__delete">
                        <img src="<?= path() ?>assets/img/icons/delete_b.svg"
                             alt="<?php _e('Remove', 'ti-woocommerce-wishlist') ?>">
                    </div>
                    <div cl
                    <div class="modal-error__header"><?= __("The first items must be ordered separately. The remaining items on the list can be combined into one order.", '4nails') ?></div>

                    <div class="modal-error__wrap">

                        <div class="modal-error__first">

                            <?php
                            $temp=1;
                            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):

                                $product = $cart_item['data'];
                                if(if_sunflower($product) &&!get_field('attached_product',$product->get_id()) ):

                                    ?>

                                    <div <?= $temp==1?"id='firstItem'":""; ?> class="modal-error__item">

                                        <div class="modal-error__item-img"><?= $product->get_image() ?></div>

                                        <div class="modal-error__item-text"><?= $product->get_name() ?></div>

                                    </div>

                                <?php
                                $temp++;
                                endif;

                            endforeach;

                            ?>

                        </div>



                        <div class="modal-error__second">

                            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):

                                $product = $cart_item['data'];

                                if(if_sunflower($product)==0&&!get_field('attached_product',$product->get_id())):

                                    ?>

                                    <div class="modal-error__item">

                                        <div class="modal-error__item-img"><?= $product->get_image() ?></div>

                                        <div class="modal-error__item-text"><?= $product->get_name() ?></div>

                                    </div>

                                <?php endif;

                            endforeach;

                            ?>
                            <div class="show-more">
                                <div class="show-more__btn" onclick="window.location.href='#firstItem'">
                                    <div class="show-more__text"><div id="showMore"><?= __('Show more', '4nails'); ?></div><div id="hideMore"><?= __('Hide', '4nails'); ?></div></div>
                                    <div class="show-more-arrow show"></div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-error__buttons">



                            <div class="modal-error__go-shop red-btn" id="backToCart"><?= __( 'Back to cart', '4nails' ); ?></div>



                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>