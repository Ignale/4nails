<?php
$username = (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : '';
$first_name = (!empty($_POST['first_name'])) ? esc_attr(wp_unslash(trim($_POST['first_name']))) : '';
$last_name = (!empty($_POST['last_name'])) ? esc_attr(wp_unslash(trim($_POST['last_name']))) : '';
$email = (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : '';
?>


<?php if(!isset($_GET['registration'])): ?>
    <?php require_once "form-login-auth.php"; ?>
<?php else: ?>
    <?php require_once  "form-login-registration.php"; ?>
<?php endif; ?>