<?php get_header(); ?>

    <main class="content">

        <div class="wrapper">

            <div class="text-center not-found">

                <img src="<?= path() ?>assets/img/error.png" alt="">

                <div class="mb-4 base-title"><?= __('The page you requested does not exist.', '4nails')?></div>

                <a href="<?php bloginfo('url') ?>" class="button btn-cyan-outline w-100"><?= __('Go to homepage', '4nails')?></a>

            </div>

        </div>

    </main>

<?php get_footer(); ?>