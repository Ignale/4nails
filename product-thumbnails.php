
<?php

global $product;

$attachment_ids = $product->get_gallery_image_ids();
if($product->is_type('variable')){
    $variations = $product->get_available_variations();
    $product = new WC_Product_Variable( $product->get_id() );
    $variations = $product->get_available_variations();
    $temp= $variations[0]['image']['url'];
}
$main_id= get_post_thumbnail_id();

if ( in_array( $main_id, $attachment_ids ) ) {
    unset( $attachment_ids[ array_search( $main_id, $attachment_ids ) ] );
}

array_unshift( $attachment_ids, $main_id );
$count=0;

if($product->is_type('variable')):?>
<div class="swiper-wrapper">
    <a data-count="<?= $count ?>"  class="swiper-slide product__slide product-image copyright" data-thumbImage="<?=$temp?>" data-bigImage="<?=$temp?>" >
        <img <?= wp_is_mobile()?'data-fancybox="gallery"':''?> src="<?=$temp?>" data-src="<?= $temp ?>">
    </a>
</div>
<?php endif;
if ($attachment_ids && $product->get_image_id()):?>
    <div class="swiper-wrapper">
        <?php foreach ($attachment_ids as $attachment_id):

            $imageBig = wp_get_attachment_image_url($attachment_id, 'full');
             if (wp_is_mobile()){
                 $imageThumbnail=wp_get_attachment_image_url($attachment_id, 'full');
             }else{
                 $imageThumbnail= wp_get_attachment_image_url($attachment_id, 'thumbnail');
             }

            ?>
            <a data-count="<?= $count ?>"  class="swiper-slide product__slide product-image copyright" data-thumbImage="<?=$imageThumbnail?>" data-bigImage="<?=$imageBig?>" >
                <img <?= wp_is_mobile()?'data-fancybox="gallery"':''?> src="<?=$imageThumbnail?>" data-src="<?= wp_get_attachment_image_url($attachment_id, 'full') ?>">
            </a>
            <?php $count++ ?>

        <?php endforeach; ?>

    </div>
<?php endif; ?>
