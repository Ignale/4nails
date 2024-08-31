<?php $trouble=$args['have_trouble'];?>
<div style="display: none; width: 500px;" class="modal fade" id="login-form" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <div class="modal__form-login">
                    <div class="modal__form-wrap">
                        <a id='goToLogin' class="modal__form-button red-btn checkout-button button btn-cyan w-100 alt wc-forward"
                           href="<?= get_permalink(get_option('woocommerce_myaccount_page_id')) ?>"><?= __('Create or log into your account','4nails')?></a>
                        <a class="modal__form-button red-btn checkout-button button btn-cyan w-100 alt wc-forward"
                           href="<?= $trouble?'': esc_url( wc_get_checkout_url() );?>"
                           id="<?= $trouble?>"
                        >
                            <?= __( 'Continue checkout as a guest', '4nails' );?></a>
                    </div>
                    <div class="modal-header__delete">
                        <img src="<?= path() ?>assets/img/icons/delete_b.svg"
                             alt="<?php _e('Remove', 'ti-woocommerce-wishlist') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>