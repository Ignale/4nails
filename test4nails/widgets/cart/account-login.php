<div style="display: none; width: 500px;" class="modal fade" id="goToLoginForm" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered cancel-order-modal" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <div class="modal__form-login">
                    <h2 class="cancel-order-modal-header"><?= __('To cancel order you must log into your account', '4nails') ?></h2>

                    <div class="modal__form-wrap">
                        <a id='accountLogIn' class="cancel-order-modal-btn modal__form-button red-btn button checkout-button button w-100 alt wc-forward"
                           href="<?= get_permalink(get_option('woocommerce_myaccount_page_id')) ?>"><?= __('Log into your account','4nails')?></a>
                    </div>
                    <div class="modal-header__delete">
                        <img src="<?= path() ?>assets/img/icons/delete_b.svg"
                             alt="<?php _e('Remove', 'ti-woocommerce-wishlist') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php
