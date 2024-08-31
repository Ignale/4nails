<section class="register">

  <div class="register__container account__container">
    <?php wc_print_notices(); ?>

    <h1 class="title register__title copyright"><?= __("Create an account", '4nails') ?></h1>

    <?php wc_print_notices(); ?>

    <?php do_action('woocommerce_before_customer_login_form'); ?>

    <div class="sign-in__content">
      <div class="sign-in__left registration-form">
        <form
          method="post"
          class="woocommerce-form woocommerce-form-register register register__form"
        >
          <div class="form-group profile__item form-item ">
            <label for="first_name"><?= __('Name    ', '4nails') ?> <span class="required">*</span></label>
            <input
              type="text"
              name="first_name"
              id="first_name"
              class="control-form"
              size="25"
              required
            >
          </div>
          <div class="form-group profile__item form-item ">
            <label for="last_name"><?= __('Last name    ', '4nails') ?> <span class="required">*</span></label>
            <input
              type="text"
              name="last_name"
              id="last_name"
              class="control-form"
              size="25"
              required
            >
          </div>
          <input
            type="hidden"
            name="username"
            id="username"
            value=""
          />
          <?php if ($_SERVER["HTTP_REFERER"] == 'https://4nails.us/checkout/'): ?>
          <input
            type="hidden"
            name="_wp_http_referer"
            value="/checkout/"
          >
          <input
            type="hidden"
            name="redirect"
            value="https://test.4nails.us/checkout/"
          >
          <?php endif; ?>

          <div class="form-group profile__item form-item ">
            <label for="email"><?= __('Email    ', '4nails') ?> <span class="required">*</span></label>
            <input
              type="email"
              class="control-form"
              name="email"
              id="email"
              value="<?= $email ?>"
              onkeyup="$('#username').val($(this).val());"
              required
            >
          </div>
          <div class="form-group profile__item form-item form-group">
            <label for="reg_password"><?= __('Password ', '4nails') ?> <span class="required">*</span></label>

            <div
              class="control-icon pass__item" ">
                        <input type="
              password"
              class="control-form"
              name="password"
              id="reg_password"
              required
            >
              <button class="icon show-pass"></button>
            </div>
            <?php get_template_part('widgets/tip-button') ?>
          </div>

          <div class="form-group profile__item form-item form-group">
            <label for="conf_password"><?= __('Confirm Password   ', '4nails') ?><span class="required">*</span></label>

            <div class="control-icon pass__item">
              <input
                type="
            password"
                class="control-form"
                id="conf_password"
                name="conf_password"
                required
              >
              <button class="icon show-pass"></button>
            </div>
            <?php get_template_part('widgets/tip-button') ?>
          </div>

          <div class="form-group checkbox-item redister__checkbox form-group">
            <div class="custom-control custom-checkbox">
              <a
                href="https://t.me/+Q3aRRHOmbJg4Zjlh"
                class="redister__tg-subscribe"
                target="_blank"
              ><?= __('Subscribe to our Telegram channel', '4nails'); ?></a>
            </div>
          </div>
          <div class="register__agree"><?= __('By clicking this button, you agree to our ', '4nails') ?>
            <a
              href="<?= get_privacy_policy_url() ?>"
              class="cyan-link"
              target="_blank"
            ><?= __('Privacy Policy.', '4nails') ?></a>
          </div>
          <div class="form-group">
            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
            <button
              type="submit"
              class="button sign-in__btn red-btn register__btn"
              name="register"
              value="Create Account"
            ><?= __('Create Account', '4nails') ?></button>
          </div>
        </form>
      </div>
      <div class="sign-in__right">
        <div class="registration-form registration-information">
          <h4 class="sign-in__question copyright"><?= __('Do you have a personal account?', '4nails') ?></h4>
          <p class="sign-in__text"><?= __('Sign in to your account.', '4nails') ?></p>
          <a
            href="<?= get_lang_url(); ?>my-account/"
            data-lang="<?= $current_language; ?>"
            class="sign-in__btn red-btn"
          ><?= __('Sign In', '4nails') ?></a>

        </div>
      </div>


</section>