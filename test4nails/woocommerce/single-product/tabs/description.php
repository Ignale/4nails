<div>
    <?php the_post_content(); ?>
</div>
<?php if (get_field('youtube_videos')): ?>
    <div class="product-video">

        <?php while (have_rows('youtube_videos')): the_row(); ?>
            <div class="product-video__item">
                <?php get_template_part('widgets/youtube','thumbnail',['link'=>get_sub_field('youtube')]); ?>
                <div class="product-video__text copyright"><p><?= get_sub_field('video_content') ?></p></div>
            </div>

        <?php endwhile; ?>

    </div>
<?php endif; ?>
