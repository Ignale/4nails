
    <section class="account">



            <div class="account__container">

                <div class="account__top title">

                    <h1 class="account__title copyright"><?php the_title() ?></h1>

                    <a href="<?= esc_url(wc_get_account_endpoint_url('customer-logout')); ?>" class="sign-out">

                        <img alt="sign out" class="sign-out__normal" src="<?= path() ?>assets/img/sign_out.png">

                        <img alt="sign out"  class="sign-out__hover" src="<?= path() ?>assets/img/sign_out-hover.png">

                        <span><?= __('Sign Out', '4nails'); ?></span>

                    </a>

                </div>

                <div class="account__content">

                    <?php do_action('woocommerce_account_navigation'); ?>



                    <div class="account__info">



                        <?php do_action('woocommerce_account_content'); ?>

                    </div>

                </div>

            </div>



    </section>

