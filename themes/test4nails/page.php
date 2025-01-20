<?php get_header(); ?>

    <main class="content">

        <div class="wrapper">

            <h1 class="title policy__title copyright"><?php the_title()  ?></h1>

            <div class="policy text"><?php the_post_content() ?></div>

        </div>

    </main>

<?php get_footer(); ?>

