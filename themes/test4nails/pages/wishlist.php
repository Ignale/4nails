<?php /* Template Name: Wishlist */
$isLogged = is_user_logged_in();

?>
<?php get_header(); ?>
    <main class="content">
        <section class="account">
            <div class="wrapper">
                <div class="account__container">
                    <div class="account__top title">
                        <h1 class="account__title"><?= $isLogged ? __('My Account   ', '4nails') : __('Your wishlist', '4nails') ?></h1>
                        <?php if ($isLogged): ?>
                            <a href="<?= esc_url(wc_get_account_endpoint_url('customer-logout')); ?>" class="sign-out">
                                <img alt="sign out" class="sign-out__normal" src="<?= path() ?>assets/img/sign_out.png">
                                <img alt="sign out" class="sign-out__hover"
                                     src="<?= path() ?>assets/img/sign_out-hover.png">
                                <span><?= __('Sign Out', '4nails'); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="account__content">
                        <?php do_action('woocommerce_account_navigation'); ?>
                        <?php if ($isLogged): ?>
                            <div class="account__info">

                                <?php the_post_content() ?>


                            </div>
                        <?php else: ?>
                        <div class="account__info">
                            <?php the_post_content() ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php get_footer() ?>