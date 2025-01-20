<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     7.0.1
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (is_user_logged_in()) {
    return;
}

?>
<div class="sign-in__container account__container">
    <div class="sign-in__content">

        <div class="sign-in__left">
            <form method="post"
                  class="sign-in__form woocommerce-form woocommerce-form-login  <?php echo ($hidden) ? 'style="display:none;"' : ''; ?>">
                <?php do_action('woocommerce_login_form_start'); ?>
                <div class="sign-in__item form-item">
                    <label for="email"><?= __('Email', '4nails') ?> <span class="required">*</span></label>
                    <input type="text" name="username" id="username" autocomplete="username"
                           placeholder="Email" value="<?= $username ?>" required>
                </div>
                <div class="sign-in__item form-item">
                    <a href="<?= esc_url(wc_lostpassword_url()); ?>"
                       class="forgot-password cyan-link"><?= __('Forgot your password?', '4nails') ?></a>
                    <label for="reg_password"><?= __('Password', '4nails') ?> <span class="required">*</span></label>
                    <div class="sign-in__password">
                        <input type="password" placeholder="Password" name="password" id="password"
                               autocomplete="current-password" required>
                        <button class="show-pass"></button>
                    </div>
                </div>
                <?php do_action('woocommerce_login_form'); ?>
                <div class="sign-in__buttons">
                    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                    <div class="sign-in__remember checkbox-item">
                        <label>
                            <input type="checkbox" name="rememberme" id="rememberme" value="forever">
                            <span for="rememberme"><?= __('Remember me', '4nails') ?></span>
                        </label>
                    </div>
                    <button class="sign-in__btn red-btn" type="submit" name="login"
                            value="Sign In"><?= __('Sign In', '4nails') ?></button>
                </div>
                <?php do_action('woocommerce_login_form_end'); ?>
            </form>
        </div>
        <div class="sign-in__right">
            <h4 class="sign-in__question"><?= __("Don`t have a personal account?", '4nails') ?></h4>
            <div class="sign-in__text"><?= __('Creating a new account is easy and takes less than a minute.', '4nails') ?></div>
            <a href="<?= get_registration_link(); ?>"
               class="sign-in__btn red-btn"><?= __('Create Account', '4nails') ?></a>

        </div>
    </div>
</div>

