<?php
function isWishlist($endpoint){
    echo ($endpoint == 'tinv_wishlist' || $endpoint == 'wishlist') && is_wishlist() ? ' active is-active' : '';
}

?>
<nav class="account__nav">
    <ul class="account__menu">
        <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>

            <?php if($endpoint == 'customer-logout') continue; ?>

            <li class="<?= strpos(wc_get_account_menu_item_classes($endpoint), 'is-active') && !isset($_GET['password_edit']) ? wc_get_account_menu_item_classes($endpoint) : ''; isWishlist($endpoint) ?>" data-temp="<?= $endpoint; ?>">
                <a href="<?= esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($label); ?></a>
            </li>
            <?php if($endpoint == 'edit-account'): ?>
                <li class="<?= isset($_GET['password_edit']) && $_GET['password_edit'] == 1 ? 'is-active' : ''; ?>"><a href="<?= esc_url(wc_get_account_endpoint_url($endpoint)); ?>?password_edit=1"><?= __('CHANGE PASS', '4nails'); ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</nav>