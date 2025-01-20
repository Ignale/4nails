
	<section class="sign-in">

			<div class="sign-in__container account__container">
				<h1 class="title sign-in__title copyright"><?= __("Sign In  ", '4nails')?></h1>
                <?php wc_print_notices(); ?>
				<div class="sign-in__content">

					<div class="sign-in__left">
                        <?php do_action('woocommerce_before_customer_login_form'); ?>
						<form method="post" class="sign-in__form woocommerce-form woocommerce-form-login ">
							<div class="sign-in__item form-item"> 
								<label for="email"><?= __('Email', '4nails')?> <span class="required">*</span></label>
								<input type="text" name="username" id="username" autocomplete="username"
                                       placeholder="Email" value="<?= $username ?>" required>
							</div>
							<div class="sign-in__item form-item"> 
								<a  href="<?= esc_url(wc_lostpassword_url()); ?>" class="forgot-password cyan-link"><?= __('Forgot your password?', '4nails')?></a>
								<label for="reg_password"><?= __('Password', '4nails')?>  <span class="required">*</span></label>
								<div class="sign-in__password"> 
									<input type="password" placeholder="Password" name="password" id="password"
                                           autocomplete="current-password" required>
									<button class="show-pass"></button>
								</div>
							</div>
							<div class="sign-in__buttons">
                                <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
								<div class="sign-in__remember checkbox-item">
									<label>
										<input type="checkbox" name="rememberme"  id="rememberme"  value="forever">
										<span for="rememberme"><?= __('Remember me', '4nails')?></span>
									</label>
								</div>
								<button class="sign-in__btn red-btn" type="submit" name="login" value="Sign In"><?= __('Sign In', '4nails')?></button>
							</div>
						</form>
					</div>
					<div class="sign-in__right">
						<h4 class="sign-in__question copyright"><?= __("Don`t have a personal account?", '4nails')?></h4>
						<div class="sign-in__text"><?= __('Creating a new account is easy and takes less than a minute.', '4nails')?></div>
						<a href="<?= get_registration_link(); ?>" class="sign-in__btn red-btn"><?= __('Create Account', '4nails')?></a>
					</div>
				</div>
			</div>

	</section>
