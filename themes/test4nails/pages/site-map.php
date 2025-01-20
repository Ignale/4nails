<?php

/*

Template Name: Site map

*/

?>

<?php get_header(); ?>

	<main>
		<section class="sitemap">
			<div class="wrapper">
				<div class="sitemap__container">
					<h1 class="title sitemap__title copyright"><?php the_title() ?></h1>
					<div class="sitemap__content">
                        <ul class="site-map__wrap">

                            <?php

                            $args = array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => false,
                                'parent' => 0,
                                'exclude' => '15',
                                'include' => ['20', '39', '19', '33', '21', '22', '34', '38'],
                                'orderby' => 'include',

                            );

                            $parents_terms = get_terms($args);

                            foreach ($parents_terms as $terms) {


                                $id = $terms->term_id;
                                $childrens_terms = get_terms('product_cat', ['child_of' => $terms->term_id]);
                                if ($childrens_terms) {
                                    echo '<li class="site-map__category">' . '<a href="' . get_term_link($terms) . '">' . $terms->name . '</a>' . '</li>';
                                    foreach ($childrens_terms as $term) {
                                        echo '<details class="site-map__item">';
                                        echo '<summary class="site-map__sub-category">' . '<a href="' . get_term_link($term) . '">' . $term->name . '</a>' . '</summary>';
                                        echo '<div class="site-map__wrapper">';
                                        $argyments = [
                                            'post_type' => 'product',
                                            'order' => 'ASC',
                                            'posts_per_page' => -1,
                                            'suppress_filters' => false,
                                            'post_status' => 'publish',
                                            'product_cat' => $term->slug,


                                        ];
                                        $myposts = new WP_Query($argyments);
                                        if ($myposts->have_posts()) {
                                            while ($myposts->have_posts()) {
                                                $myposts->the_post();

                                                echo '<li class="site-map__product">' . '<a href="' . get_permalink($post->id) . '">' . get_the_title($post) . '</a>' . '</li>';
                                            }
                                        }
                                        echo '</div></details>';
                                    }
                                } else {
                                    echo '<details><summary class="site-map__category">' . '<a href="' . get_term_link($terms) . '">' . $terms->name . '</a>' . '</summary>';
                                    echo '<ul>';
                                    echo '<div class="site-map__wrapper">';
                                    if ($terms->term_id != '34') {
                                        $argyments = [
                                            'post_type' => 'product',
                                            'order' => 'ASC',
                                            'posts_per_page' => -1,
                                            'suppress_filters' => false,
                                            'post_status' => 'publish',
                                            'product_cat' => $terms->slug,
                                            'category__not_in' => '-34',


                                        ];
                                        $myposts = new WP_Query($argyments);
                                        if ($myposts->have_posts()) {
                                            while ($myposts->have_posts()) {
                                                $myposts->the_post();

                                                echo '<li class="site-map__product-wc">' . '<a href="' . get_permalink($post->id) . '">' . get_the_title($post) . '</a>' . '</li>';
                                            }
                                        }
                                    }
                                    echo '</div></ul></details>';
                                }
                                wp_reset_postdata();


                            }


                            ?>


                            <a href="<?= get_lang_url(); ?>blog/" class="site-map__category"><?= __('Blog', '4nails') ?></a>
                            <ul class="site-map__wrap">
                                <?php
                                $args = [
                                    'post_type' => 'post',
                                    'posts_per_page' => -1,
                                    'suppress_filters' => false,
                                    'post_status' => 'publish'
                                ];
                                $myposts = get_posts($args);
                                foreach ($myposts as $post) {
                                    setup_postdata($post);

                                    echo '<li  class="site-map__product-blog">' . '<a href="' . get_permalink($post->id) . '">' . get_the_title($post) . '</a>' . '</li>';

                                }
                                wp_reset_postdata();

                                ?>
                            </ul>
                        </ul>
						
					</div>
				</div>
			</div>
		</section>
	</main>

<?php get_footer() ?>

