<?php $cart = $args['cart'] ?>


<div style="display: none; width: 500px;" class="modal fade" id="overweight-massage" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-body">


                <div class="modal-error">
                    <div class="modal-header__delete" onclick="Fancybox.close()">
                        <img src="<?= path() ?>assets/img/icons/delete_b.svg"
                             alt="<?php _e('Remove', 'ti-woocommerce-wishlist') ?>">
                    </div>
                    <div class="modal-error__header">
                            <?= __('Unfortunately, due to the size of the items in your cart, we cannot deliver all of the products in one shipment. Please place 2 separate orders for these items. To do this, return to the cart and delete some items or reduce the quantity.', '4nails') ?>
                        <div class="modal-error__header-details">
                        <p><?= __('Total weight of cart items:', '4nails'); ?> <b><?= get_cart_weight($cart) ?> lbs</b>  <?= __(' (25 lbs maximum)','4nails'); ?></p>
                        </div>
                    </div>
                    <div class="modal-error__wrap">

                        <div class="modal-error__first">

                            <?php
                            $temp=1;
                            foreach ($cart->get_cart() as $cart_item_key => $cart_item):

                                $product = $cart_item['data'];
                            if(!get_field('attached_product',$product->get_id())):
                            ?>

                                <div <?= $temp==1?"id='firstItem'":""; ?> class="modal-error__item">

                                    <div class="modal-error__item-img"><?= $product->get_image() ?></div>

                                    <div class="modal-error__item-text"><a href="<?= get_permalink( $product->get_id() ) ?>"><?= $product->get_name() ?></a>
                                    <p><b><?= sprintf('Weight of one: %s lbs.',$product->get_weight())?></b></p>
                                    <p><b><?= sprintf('Count: %s',$cart_item['quantity'])?></b></p>
                                    </div>


                                </div>

                            <?php
                                $temp++;
                            endif;
                            endforeach;
                            ?>
                            <div class="show-more">
                                <div class="show-more__btn">
                                    <div class="show-more__text"><div id="showMore"><?= __('Show more', '4nails'); ?></div><div id="hideMore"><?= __('Hide', '4nails'); ?></div></div>
                                    <div class="show-more-arrow show"></div>
                                </div>
                            </div>
                        </div>


                        <div class="modal-error__buttons">



                            <div class="modal-error__go-shop red-btn" id="backToCart"><?= __( 'Return to the cart', '4nails' ); ?></div>



                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>