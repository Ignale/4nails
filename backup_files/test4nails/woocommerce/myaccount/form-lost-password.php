<section class="recovery recovery-form">

		<div class="recovery__container account__container">
			<h1 class="title recovery__title copyright"><?= __('Password recovery', '4nails')?></h1>
			<div class="recovery__content">


				<div class="recovery__text copyright"><?= __('Forgot You Password?', '4nails')?></div>
				<div><p> <?= __('Enter you email address below, and we’ll email you a link to set a new password', '4nails')?></p></div>
				<form method="post" class="recovery__form woocommerce-ResetPassword lost_reset_password">
					<div class="sign-in__item form-item">
						<input  type="text" name="user_login" id="user_login" placeholder="Email" required>
					</div>
                    <input type="hidden" name="wc_reset_password" value="true"/>
					<button type="submit" class="sign-in__btn red-btn" value="Email me"><?= __('Email me', '4nails')?></button>
					<a href="<?php account_url() ?>" class="cyan-link recovery__cancel"><?= __('Cancel', '4nails')?></a>
                    <?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>
				</form>
			</div>
		</div>

</section>