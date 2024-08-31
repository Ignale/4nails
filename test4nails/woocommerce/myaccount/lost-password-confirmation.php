<section class="recovery">

        <div class="recovery__container">
            <h1 class="title recovery__title copyright"><?= __('Password recovery', '4nails')?></h1>
            <div class="recovery__content">

                <div class="email-checked">
                    <div class="email-checked__img"><img class=" lazyloaded" src="https://4nails.us/wp-content/themes/4nails/assets/img/icons/check_email.svg" data-src="https://4nails.us/wp-content/themes/4nails/assets/img/icons/check_email.svg" alt="" draggable="false"></div>
                    <div class="recovery__text"><?= __('Check Your Email', '4nails')?></div>
                    <div>
                        <div><?= __("We’ve emailed a password reset link to your email", '4nails')?></div>
                        <br/>
                        <?= sprintf(__('If you don’t receive this email within a few minutes,<br>
        please check you email’s spam and <br>
        junk filters or <a href="%s" class="cyan-link">contact us</a> for <br>
        furher assistance.', '4nails'),get_the_permalink(81))?>
                    </div>
                </div>

            </div>
        </div>

</section>