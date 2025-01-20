<footer>
    <div class="footer-top">
        <div class="wrapper">
            <div class="footer-top__container">
                <div class="footer__nav">
                    <div class="footer__nav-item">
                        <div class="footer__title copyright"><?= __('Account', '4nails') ?></div>
                        <?php wp_nav_menu([
                            'menu' => 'account',
                            'container' => null,
                            'menu_class' => 'footer__nav-menu'
                        ]); ?>
                    </div>
                    <div class="footer__nav-item">
                        <div class="footer__title copyright"><?= __('Information', '4nails') ?></div>
                        <?php wp_nav_menu([
                            'menu' => 'information',
                            'container' => null,
                            'menu_class' => 'footer__nav-menu'
                        ]); ?>
                    </div>

                    <div class="footer__nav-item">
                        <div class="footer__title copyright"><?= __('Terms and Conditions', '4nails') ?></div>
                        <?php wp_nav_menu([
                            'menu' => 'Terms and Conditions',
                            'container' => null,
                            'menu_class' => 'footer__nav-menu'
                        ]); ?>
                    </div>

                    <div class="footer__work-hours"><?php the_field('hours', 'options') ?></div>
                </div>

                <div class="footer__subscribe">
                    <div class="footer__subscribe-inner">
                        <div class="footer__title copyright"><?= get_field('subscribe_title', 'option'); ?></div>
                        <div class="footer__subscribe-text copyright">
                            <?= get_field('subscribe_text', 'option'); ?>
                        </div>
                        <div>
                            <a href="https://t.me/+Q3aRRHOmbJg4Zjlh" class="telegram-subscribe" target="_blank">
                                <span class="telegram__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                    width="50" height="50"
                                    viewBox="0 0 50 50"
                                    style=" fill:#fff;"><path d="M46.137,6.552c-0.75-0.636-1.928-0.727-3.146-0.238l-0.002,0C41.708,6.828,6.728,21.832,5.304,22.445   c-0.259,0.09-2.521,0.934-2.288,2.814c0.208,1.695,2.026,2.397,2.248,2.478l8.893,3.045c0.59,1.964,2.765,9.21,3.246,10.758 c0.3,0.965,0.789,2.233,1.646,2.494c0.752,0.29,1.5,0.025,1.984-0.355l5.437-5.043l8.777,6.845l0.209,0.125 c0.596,0.264,1.167,0.396,1.712,0.396c0.421,0,0.825-0.079,1.211-0.237c1.315-0.54,1.841-1.793,1.896-1.935l6.556-34.077    C47.231,7.933,46.675,7.007,46.137,6.552z M22,32l-3,8l-3-10l23-17L22,32z"></path></svg>
                                </span>
                                <span class="telegram__text"><?=__('Subscribe','4nails')?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="wrapper">
            <div class="footer-bottom__container">
                <div class="footer__left">
                    <div class="footer__logo">
											<a href="<?php bloginfo('url') ?>">
													<?php the_image('logo_footer', null, 'option') ?>
											</a>
                    </div>
                    <div class="footer__address">
											<div class="footer-bottom__title copyright"><?= __(get_field('address_label', 'option'), '4nails'); ?></div>
											<div class="copyright">
												<a href="<?= get_field('address_link', 'option'); ?>" target="_blank" rel="nofollow">
													<?= get_field('address', 'option'); ?>
												</a>
											</div>
											<div class="footer__mail">
												<div class="footer-bottom__title copyright"><?= __(get_field('email_label', 'option'), '4nails'); ?></div>
												<div class="footer__mail-wrapp">
													<svg class="mail-svg" version="1.1" xmlns="http://www.w3.org/2000/svg"
															xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25px" height="18px"
															viewBox="-164.5 181.5 25 18" enable-background="new -164.5 181.5 25 18"
															xml:space="preserve">
															<path fill="rgb(21, 230, 205)"
																		d="M-141.516,181.5h-20.969c-1.111,0-2.016,0.916-2.016,2.041v13.918c0,1.125,0.905,2.041,2.016,2.041h20.969	c1.112,0,2.016-0.916,2.016-2.041v-13.918C-139.5,182.416-140.404,181.5-141.516,181.5z M-141.516,182.5	c0.269,0,0.509,0.111,0.691,0.286l-10.026,8.852c-0.604,0.535-1.692,0.534-2.298,0.001l-10.026-8.853	c0.182-0.175,0.422-0.286,0.69-0.286H-141.516z M-141.516,198.5h-20.969c-0.56,0-1.016-0.467-1.016-1.041v-13.625l9.689,8.555	c0.486,0.429,1.129,0.664,1.811,0.664c0.683,0,1.326-0.236,1.812-0.666l9.688-8.553v13.625	C-140.5,198.033-140.956,198.5-141.516,198.5z"></path> </svg>
													<?php $email = get_field('email', 'option') ?>
													<a href="mailto:<?= $email ?>" class="footer__mail-link">
															<?= $email ?>
													</a>
												</div>
											</div>
                    </div>
								</div>
                <div class="footer__right">
									<div class="footer__follow">
										<div class="footer-bottom__title copyright"><?= __('Follow us:', '4nails') ?></div>
										<?php while (have_rows('follow_us', 'options')): the_row() ?>
											<a href="<?php the_sub_field('link') ?>" aria-label="social-link" class="link-<?=get_sub_field('name')  ?>" rel="nofollow noreferrer" target="_blank">
												<?php the_icon(get_sub_field('name')) ?>
											</a>
										<?php endwhile; ?>
									</div>
                </div>
                <div class="footer__copyright copyright">
                    <?php the_field('copyright', 'option') ?>
                    <?= __('This site is protected by reCAPTCHA and the Google', '4nails') ?>
                    <a href="https://policies.google.com/privacy"><?= __('Privacy Policy', '4nails') ?></a>
                    <?= __('and', '4nails') ?>
                    <a href="https://policies.google.com/terms"><?= __('Terms of Service', '4nails') ?></a>
                    <?= __('apply.', '4nails') ?>
                </div>
            </div>
        </div>
    </div>

</footer>
<div style="display: none; width: 500px;" class="modal fade" id="addedToCart" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div style="display: none; width: 550px;" class="modal fade" id="leavePagePopup" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header__title">
                <h3 class="modal-header"><?= __('Please answer a few questions', '4nails'); ?></h3>
                <div class="modal-header__delete">
                    <img src="<?= path() ?>assets/img/icons/delete_b.svg"
                         alt="<?php _e('Remove', 'ti-woocommerce-wishlist') ?>">
                </div>
            </div>
            <div class="modal-body"><?= do_shortcode('[contact-form-7 id="13066" title="User feedback" html_class="user-feedback-form]') ?></div>
        </div>
    </div>
</div>
<?php wp_footer() ?>
<div class="layer"></div>

</body>
</html>
