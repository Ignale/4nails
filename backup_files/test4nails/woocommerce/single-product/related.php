<?php

$global_viewed_products = [];

//  хотим ли мы что бы выводились только те продукты что указаны в поле Products viewed in the single page product или, ещё и те что мы указали глобально в settings

if (!get_field('only_local_viewed_products')) {

    $global_viewed_products = get_field('products_viewed', 'option');

}



if (get_field('products_viewed_local')) {

    $local_viewed_products = get_field('products_viewed_local');

} else {

    $local_viewed_products = [];

}

// Порядок вывода

if (get_field('sorting_viewed_products') == 'global') {
    $viewed_products = array_merge(is_array($global_viewed_products) ? $global_viewed_products : [], $local_viewed_products);
} else {
    $viewed_products = array_merge($local_viewed_products, is_array($global_viewed_products) ? $global_viewed_products : []);
}

//print_r($viewed_products);

// Берем перекрестные товары

global $product;

if ($cross = $product->get_cross_sell_ids()) {

    $related_products = array_map(function (WP_Post $post) {

        return wc_get_product($post);

    }, get_posts([

        'post_type' => 'product',

        'post__in' => $cross,



    ]));

}

//

if ($related_products) : ?>

    <section class="viewed">

        <div class="wrapper">

            <div class="viewed__container">

                <h2 class="title"><?= __("Customers also viewed", '4nails') ?></h2>

                <div class="swiper__content">

                    <div class="viewed__swiper">

                        <div class="swiper-wrapper">



                            <?php

                            // Выводим продекты из полей

                            if (!empty($viewed_products)) {

                                foreach ($viewed_products as $product) {

                                    setup_postdata($GLOBALS['post'] =& $product);

                                    wc_get_template_part('content', 'product');

                                }

                                wp_reset_postdata();

                            } ?>



                            <?php // Выводим перекрестные продукты

                            foreach ($related_products as $related_product) {

                                $post_object = get_post($related_product->get_id());

                                setup_postdata($GLOBALS['post'] =& $post_object);

                                wc_get_template_part('content', 'product');

                            } ?>



                        </div>

                        <div class="swiper-pagination"></div>

                        <div class="swiper-button-next swiper-arrow">

                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"

                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25px"

                                 height="48px" viewBox="-164.5 181.5 25 48"

                                 enable-background="new -164.5 181.5 25 48" xml:space="preserve">

                            <polygon fill="#BBCAC8"

                                     points="-139.675,205.5 -163.618,181.558 -164.325,182.265 -141.089,205.5 -164.325,228.735 -163.618,229.442 "></polygon></svg>

                        </div>

                        <div class="swiper-button-prev swiper-arrow">

                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"

                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25px"

                                 height="48px" viewBox="-164.5 181.5 25 48"

                                 enable-background="new -164.5 181.5 25 48" xml:space="preserve">

                            <polygon fill="#BBCAC8"

                                     points="-164.325,205.5 -140.382,181.558 -139.675,182.265 -162.911,205.5 -139.675,228.735 -140.382,229.442 "></polygon></svg>

                        </div>

                    </div>

                </div>

    </section>

<?php endif;

wp_reset_postdata();

wp_reset_query();

