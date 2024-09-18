<?php /* Template Name: Cart */ ?>

<?php get_header(); ?>

<main>

  <section class="cart">

    <div class="wrapper">

      <div class="cart__container">

        <h1 class="title copyright"><?= __('Shopping Cart', '4nails'); ?></h1>

        <?php the_post_content() ?>

      </div>
    </div>

  </section>

  <?php if (WC()->cart->get_cart_contents_count() !== 0): ?>

  <?php $saved = get_wishlist(); ?>

  <?php if ($saved): ?>

  <section class="saved">

    <div class="wrapper">

      <div class="saved__container">

        <h2 class="title copyright"><?= __('Wish List', '4nails') ?></h2>

        <div class="swiper__content">

          <div class="viewed__swiper">

            <div class="swiper-wrapper">

              <?php

                  $class_saved = count($saved->posts) < 4 ? 'hide-buttons' : '';
                  $lessThenOne = count($saved->posts) < 2;
                  global $saved;
                  while ($saved->have_posts()):

                    $saved->the_post();

                    wc_get_template_part('content', 'product');

                  endwhile;
                  if ($lessThenOne) {
                    while ($saved->have_posts()):

                      $saved->the_post();

                      wc_get_template_part('content', 'product');

                    endwhile;
                  }
                  if ($lessThenOne) {
                    while ($saved->have_posts()):

                      $saved->the_post();

                      wc_get_template_part('content', 'product');

                    endwhile;
                  }
                  wp_reset_query();

                  $saved = false; ?>



            </div>

            <div class="swiper-pagination"></div>

            <div class="swiper-button-next swiper-arrow ">

              <svg
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                x="0px"
                y="0px"
                width="25px"
                height="48px"
                viewBox="-164.5 181.5 25 48"
                enable-background="new -164.5 181.5 25 48"
                xml:space="preserve"
              >

                <polygon
                  fill="#BBCAC8"
                  points="-139.675,205.5 -163.618,181.558 -164.325,182.265 -141.089,205.5 -164.325,228.735 -163.618,229.442 "
                ></polygon>
              </svg>

            </div>

            <div class="swiper-button-prev swiper-arrow">

              <svg
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                x="0px"
                y="0px"
                width="25px"
                height="48px"
                viewBox="-164.5 181.5 25 48"
                enable-background="new -164.5 181.5 25 48"
                xml:space="preserve"
              >

                <polygon
                  fill="#BBCAC8"
                  points="-164.325,205.5 -140.382,181.558 -139.675,182.265 -162.911,205.5 -139.675,228.735 -140.382,229.442 "
                ></polygon>
              </svg>

            </div>

          </div>

        </div>

      </div>

    </div>

  </section>

  <?php endif; ?>

  <section class="viewed">

    <div class="wrapper">

      <div class="viewed__container">

        <h2 class="title copyright"><?= __('Recently Viewed Products', '4nails') ?></h2>

        <div class="swiper__content">

          <div class="viewed__swiper">

            <div class="swiper-wrapper">

              <?php $viewed = get_viewed(8);

                while ($viewed->have_posts()):

                  $viewed->the_post();

                  if (!get_field('attached_product', get_the_ID())) {
                    wc_get_template_part('content', 'product');

                  }
                endwhile;

                wp_reset_query(); ?>



            </div>

            <div class="swiper-pagination"></div>

            <div class="swiper-button-next swiper-arrow">

              <svg
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                x="0px"
                y="0px"
                width="25px"
                height="48px"
                viewBox="-164.5 181.5 25 48"
                enable-background="new -164.5 181.5 25 48"
                xml:space="preserve"
              >

                <polygon
                  fill="#BBCAC8"
                  points="-139.675,205.5 -163.618,181.558 -164.325,182.265 -141.089,205.5 -164.325,228.735 -163.618,229.442 "
                ></polygon>
              </svg>

            </div>

            <div class="swiper-button-prev swiper-arrow">

              <svg
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                x="0px"
                y="0px"
                width="25px"
                height="48px"
                viewBox="-164.5 181.5 25 48"
                enable-background="new -164.5 181.5 25 48"
                xml:space="preserve"
              >

                <polygon
                  fill="#BBCAC8"
                  points="-164.325,205.5 -140.382,181.558 -139.675,182.265 -162.911,205.5 -139.675,228.735 -140.382,229.442 "
                ></polygon>
              </svg>

            </div>

          </div>

        </div>

      </div>

    </div>

  </section>

  <?php endif; ?>

</main>



<?php get_footer() ?>