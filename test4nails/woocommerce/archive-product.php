<?php
$cate = get_queried_object();
$cateID = $cate->term_id;
$children = get_terms(
    'product_cat',
    [
        'parent' => get_queried_object_id()
    ]
);
if (!is_tax()) $children = parentCategories();
$isEquipment = !empty($children); ?>
<?php get_header(); ?>

<main>
  <?php if ($isEquipment && !is_search()) : ?>
  <section
    class="category-page <?= $isEquipment ? 'equipment' : 'catalog' ?> <?= ($cateID == 20 || $cateID == 87 || $cateID == 126) ? "gel_category" : "" ?>"
  >
    <div class="wrapper">
      <h1 class="title copyright"><?php woocommerce_page_title() ?></h1>


      <div class="category-page__content">
        <?php global $category;
                        foreach ($children as $category) {
                            wc_get_template_part('content', 'product_cat');
                        } ?>
      </div>


    </div>
    <?php if (wc_get_loop_prop('total')) {
                    woocommerce_pagination();
                } ?>
  </section>
  <?php endif; ?>
  <?php if (wc_get_loop_prop('total') && !$isEquipment || is_search()) : ?>
  <section class="category-page">
    <div class="wrapper">
      <h1 class="title copyright"><?php woocommerce_page_title() ?></h1>
      <div class="catalog__content">
        <?php while (have_posts()) :
                            the_post();
                            wc_get_template_part('content', 'product');
                        endwhile; ?>
      </div>
    </div>
    <?php if (wc_get_loop_prop('total')) {
                    woocommerce_pagination();
                } ?>
  </section>

  <?php endif; ?>

</main>

<?php get_footer();