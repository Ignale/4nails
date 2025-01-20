<?php


if (!$load_address):
    wc_get_template('myaccount/my-address.php');
else:
    ?>
   <div class="billing profile personal-info">
            <div class="profile__title copyright"><?= ('billing' === $load_address) ? __('Billing address', 'woocommerce') : __('Shipping address', 'woocommerce')?></div>
            <form method="post" class="profile__form">

                <?php
                foreach ($address as $key => $field) {
                    if (isset($field['country_field'], $address[$field['country_field']])) {
                        $field['country'] = wc_get_post_data_by_key($field['country_field'], $address[$field['country_field']]['value']);
                    }

                    $field['class'][] = 'form-group';
                    if (in_array($key, ['billing_email'])) {
                        $field['class'][] = 'box-tooltip';
                    }
                    $field['input_class'][] = 'control-form';

                    $value = wc_get_post_data_by_key($key, $field['value']);

                    if($field['label'] == 'First name') $value = $value == 'Default name' ? '' : $value;
                    if($field['label'] == 'Last name') $value = $value == 'Default lastname' ? '' : $value;

                    woocommerce_form_field($key, $field, $value);
                }
                ?>
                <div class="profile__btn form-group">
                    <button type="submit" class="profile__save red-btn button" name="save_address" value="Save address"><?= __('Save address', '4nails')?></button>
                    <a href="<?php account_url() ?>edit-address/" class="profile__cancel red-btn"><?= __('Cancel', '4nails')?></a>
                    <?php wp_nonce_field('woocommerce-edit_address', 'woocommerce-edit-address-nonce'); ?>
                    <input type="hidden" name="action" value="edit_address"/>
                </div>
            </form>
        </div>
<?php endif; ?>