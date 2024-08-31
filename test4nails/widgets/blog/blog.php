<?php global $post;

$image = get_field("preview_photo")['url'] ? get_field("preview_photo")['url'] : get_the_post_thumbnail_url($post->ID, 'blog_image');
$title = get_field("preview_title") ? get_field("preview_title") : get_the_title();
$description = get_field("preview_description") ? get_field("preview_description") : get_the_excerpt();
?>

<div class="blog__item">
    <div class="blog__img">
        <a href="<?php the_permalink() ?>">
            <img src="<?= $image ?>" width="<?=get_image_size_width('blog_image') ?>" height="<?=get_image_size_height('blog_image') ?>" class="img-fluid wp-post-image"
                 alt="<?= get_post_meta($post->ID, '_wp_attachment_image_alt', true) ?>">
        </a>
    </div>
    <div class="blog__date"><?= get_the_date('m.d.Y') ?></div>
    <div class="blog__name copyright"><?= $title ?></div>

    <div class="blog__preview copyright"><p><?= $description ?></p></div>

    <div class="blog__more">
        <a href="<?php the_permalink() ?>" class="cyan-link"><?= __('Read more', '4nails') ?>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                 y="0px" width="9px" height="16px" viewBox="-170 183.5 9 16" enable-background="new -170 183.5 9 16"
                 xml:space="preserve"> <polygon fill="#17CFB9"
                                                points="-162.671,191.5 -169.743,184.43 -169.036,183.723 -161.257,191.5 -169.036,199.277 -169.743,198.57  "></polygon> </svg>
        </a>
    </div>
</div>
