<?php

$args = [
    'numberposts'   => 5,
    'post_type'   => 'post',
    'orderby'     => 'date',
    'post_status' => 'publish',
    'suppress_filters' => false

];
global $post;

$current_post_id=$post->ID;
$myposts = get_posts($args);
wp_reset_postdata();
if ($myposts&&count($myposts)>1) {
    echo "<div class='article__content-title'>".__('Related articles','4nails').":</div>";
    foreach ($myposts as $post) {
        if($post->ID!=$current_post_id) {
            setup_postdata($post);
            ?>
            <div class="related-article__item">
                <div class="related-article__img copyright"><img src="<?= get_the_post_thumbnail_url($post->ID, 'thumbnail') ?>" alt="<?=  get_the_title($post)?>"></div>
                <a class="related-article__link" href="<?= get_permalink($post->ID)?>"><?=  get_the_title($post)?></a>
            </div>
<?php
        }
    }
}
wp_reset_postdata();
