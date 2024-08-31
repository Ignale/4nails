<?php $order = get_field('modal_order', 'option');
$all_world_order = 0;
if (isset($_GET['key'])) {
    $order_id = wc_get_order_id_by_order_key($_GET['key']);
    $order_ = wc_get_order($order_id);
} ?>

<section class="thanks">
    <div class="wrapper">
        <div class="thanks__container">
            <h1 class="title thanks__title"><?= $order['title'] ?></h1>
            <div class="thanks__text"> <?= $order['text'];
                ?>
            </div>
        </div>
    </div>
</section>