<?php
global $category;

if_gel_category(get_queried_object());
$title = $category->name;
$link = get_term_link($category);
$img_category = if_gel_category(get_queried_object())? wp_get_attachment_image_url(categoryImage($category->term_id), 'medium'):wp_get_attachment_image_url(categoryImage($category->term_id), '4nails_category_product');
$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
?>

    <div <?php wc_product_cat_class('item category__item', $category); ?>>
        <a href="<?= $link ?>">
            <div class="category__img copyright">
                <picture>
                <img width="150" height="150" src="<?= $img_category; ?>" alt="<?= $title; ?>" style="width: 100%; height: auto" loading="lazy" />
                </picture>
            </div>
            <div class="category__name copyright"><?= $title ?></div>
        </a>
    </div>
