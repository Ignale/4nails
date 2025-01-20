<?php /* Template Name: Home1 */ ?>
<?php get_header(); ?>

<?php /* Template Name: Home */ ?>

<section class="banner">
  <div class="banner__container">
    <div class="banner__swiper">
      <div class="banner__wrapper swiper-wrapper ">

        <?php if (have_rows('home_banner')): ?>

        <?php while (have_rows('home_banner')):
            the_row(); ?>
        <?php
            $slider_image = get_sub_field('banner-image');
            $mobile_image = get_sub_field('banner-mobile');
            $banner_mobile_small = get_sub_field('banner_mobile_small');
            ?>
        <div class="banner__slide swiper-slide copyright">
          <picture>
            <source
              class="image-banner"
              srcset="<?= $banner_mobile_small['url']; ?>"
              media="(max-width: 370px)"
            >
            <source
              class="image-banner"
              srcset="<?= $slider_image['url']; ?>"
              media="(min-width: 851px)"
            >
            <source
              class="image-banner"
              srcset="<?= $mobile_image['url']; ?>"
            >
            <img
              width="1"
              height="1"
              style="width: 100%; height: auto"
              class="image-banner"
              src="<?= $slider_image['url']; ?>"
              alt="<?= $slider_image['alt']; ?>"
            >
          </picture>
        </div>
        <?php endwhile; ?>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>

<section class="category">
  <div class="wrapper">
    <div class="category__container copyright">
      <?php
      global $category;
      foreach (get_field('position_category', get_the_ID()) as $category):
        if ($category->name == 'Uncategorized')
          continue;
        wc_get_template_part('content', 'product_cat');
      endforeach;
      ?>
    </div>
  </div>
</section>

<section class="best products">
  <div class="wrapper">
    <div class="products__container">
      <div class="products__content">
        <h2 class="title copyright"><?= __('Top Sellers', '4nails') ?></h2>
        <div class="swiper__content">
          <div class="products__swiper">
            <div class="swiper-wrapper">
              <?php show_products('top_sellers', 8) ?>
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
  </div>

</section>

<section class="arrived products">
  <div class="wrapper">
    <div class="products__container">
      <div class="products__content">
        <h2 class="title copyright"><?= __('Just Arrived', '4nails') ?></h2>
        <div class="swiper__content">
          <div class="products__swiper">
            <div class="swiper-wrapper">
              <?php show_products('just_arrived', 10, true) ?>
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
  </div>
</section>

<section class="video">
  <div class="wrapper">
    <div class="video__container">
      <h2 class="video__title title copyright"><?= __('YouTube Videos', '4nails') ?></h2>
      <div class="swiper__content">
        <div class="video__swiper">
          <div class="swiper-wrapper">
            <?php while (have_rows('youtube_video')):
              the_row(); ?>
            <div class="video__slide swiper-slide">
              <?php get_template_part('widgets/youtube', 'thumbnail', ['link' => get_sub_field('id_video')]); ?>
            </div>
            <?php endwhile; ?>
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
      <div class="video__more cyan-link">
        <a
          target="_blank"
          href="https://www.youtube.com/channel/UCYRw15Xypbn4nILXNe4KSTw"
          class="video__more-link"
        ><?php echo __('More videos', '4nails') ?>

          <svg
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px"
            y="0px"
            width="9px"
            height="16px"
            viewBox="-170 183.5 9 16"
            enable-background="new -170 183.5 9 16"
            xml:space="preserve"
          >
            <polygon
              fill="#17CFB9"
              points="-162.671,191.5 -169.743,184.43 -169.036,183.723 -161.257,191.5 -169.036,199.277 -169.743,198.57 	"
            ></polygon>
          </svg>
        </a>
      </div>
    </div>
  </div>
</section>

<section class="about copyright text">
  <div class="wrapper">
    <div class="about__container">
      <?php the_post_content() ?>
    </div>
  </div>
</section>


<?php get_footer() ?>