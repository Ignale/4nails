<?php

$firstname = esc_attr($user->first_name) == 'Default name' ? '' : esc_attr($user->first_name);

$lastname = esc_attr($user->last_name) == 'Default lastname' ? '' : esc_attr($user->last_name);

?>
<?php acf_form_head(); ?>

<div class="profile">

    <form method="post" class="profile__form">

        <?php if (isset($_GET['password_edit']) && $_GET['password_edit'] == 1): ?>

            <h2 class="profile__title copyright"><?= __('Change password', '4nails'); ?></h2>

        <?php else: ?>

            <h2 class="profile__title copyright"><?= __('Personal Information', '4nails'); ?></h2>

        <?php endif; ?>

        <?php if (isset($_GET['password_edit']) && $_GET['password_edit'] == 1): ?>

            <input type="hidden" name="account_first_name" id="account_first_name" autocomplete="given-name"
                   value="<?= $firstname; ?>">

            <input type="hidden" class="control-form" name="account_last_name" id="account_last_name"
                   autocomplete="family-name" value="<?= $lastname; ?>"/>

            <input type="hidden" class="control-form" name="account_email" id="account_email" autocomplete="email"
                   value="<?= esc_attr($user->user_email); ?>"/>


            <div class="profile__item form-item">

                <label for="password_current"><?= __('Current password (leave blank to leave unchanged)', '4nails') ?></label>

                <div class="pass__item">

                    <input type="password" name="password_current" id="password_current" autocomplete="nope"
                           value="">

                    <button class="show-pass"></button>

                </div>

                <?php get_template_part('widgets/tip-button') ?>


            </div>

            <div class="profile__item form-item">

                <label for="password_1"><?= __('New password (leave blank to leave unchanged)', '4nails')?></label>

                <div class="pass__item">

                    <input type="password" name="password_1" id="password_1" autocomplete="off"
                           value="">

                    <button class="show-pass"></button>

                </div>

                <?php get_template_part('widgets/tip-button') ?>
            </div>

            <div class="profile__item form-item">

                <label for="password_2"><?= __('Confirm new password', '4nails')?></label>

                <div class="pass__item">

                    <input type="password" name="password_2" id="password_2" autocomplete="off"
                           value="">

                    <button class="show-pass"></button>

                </div>

                <?php get_template_part('widgets/tip-button') ?>
            </div>

        <?php else: ?>

            <div class="profile__item form-item">

                <label for="account_first_name"><?= __('First name&nbsp;', '4nails') ?>

                    <span class="required">*</span>

                </label>

                <input type="text" name="account_first_name" id="account_first_name" autocomplete="given-name"

                       value="<?= $firstname; ?>">

            </div>

            <div class="profile__item form-item">

                <label for="account_last_name"><?= __('Last name&nbsp;', '4nails') ?>

                    <span class="required">*</span>

                </label>

                <input type="text" name="account_last_name" id="account_last_name" autocomplete="family-name"

                       value="<?= $lastname; ?>">

            </div>


            <div class="profile__item form-item profile__item-email">

                <label for="account_email"><?= __('Email address&nbsp;', '4nails') ?>

                    <span class="required">*</span>

                </label>

                <input type="email" name="account_email" id="account_email" autocomplete="email"

                       value="<?= esc_attr($user->user_email); ?>">



            </div>




        <?php endif; ?>

        <div class="profile__btn">

            <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>

            <button class="profile__save red-btn" name="save_account_details"
                    value="Save changes" type="submit"><?= __('Save changes', '4nails') ?></button>

            <input type="hidden" name="action" value="save_account_details"/>

        </div>

    </form>

</div>
