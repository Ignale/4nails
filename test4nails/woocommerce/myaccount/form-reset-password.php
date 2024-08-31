<section class="reset">

		<div class="reset__container account__container">
			<h1 class="title reset__title copyright"><?= __('Reset You Password', '4nails')?></h1>
			<div class="reset__content">
				<div class="reset__img"><img src="<?= path() ?>assets/img/icons/passwordr.svg"></div>
				<div class="reset__text"><?= __('Enter a new password for you account.', '4nails')?></div>
				<form method="post" class="reset__form">
					<div class="reset__item form-item">
						<input type="password" placeholder="Password" name="password_1" id="password_1" autocomplete="new-password" required="">
						<button class="show-pass"></button>
					</div>
					<div class="reset__item form-item">
						<input type="password" placeholder="Password"  name="password_2" id="password_2" autocomplete="new-password" required="">
						<button class="show-pass"></button>
					</div>
                    <input type="hidden" name="reset_key" value="<?= esc_attr($args['key']); ?>"/>
                    <input type="hidden" name="reset_login" value="<?= esc_attr($args['login']); ?>"/>
                    <input type="hidden" name="wc_reset_password" value="true"/>
					<button type="submit" class="sign-in__btn red-btn" value="Reset Password">Reset Password</button>
					<a href="" class="cyan-link reset__cancel">Cancel</a>
                    <?php wp_nonce_field('reset_password', 'woocommerce-reset-password-nonce'); ?>
				</form>
			</div>
		</div>

</section>