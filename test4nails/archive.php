<?php get_header(); ?>

<main class="content">

    <section class="blog">
        <div class="wrapper">
            <div class="blog__container">
                <h1 class="title blog__title copyright"><?php single_cat_title() ?></h1>
                <div class="blog__search">
                    <form action="" class="field-search" method="post">
                        <input  value="<?= get_search_query() ?>" type="text" name="ss" minlength="3" placeholder="Search for article" required>
                        <button type="submit" class="btn-search"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="21px" height="22px" viewBox="-164 186.5 21 22" enable-background="new -164 186.5 21 22" xml:space="preserve"> <g> <path fill="#17CFB9" d="M-155.506,186.5c-4.691,0-8.494,3.814-8.494,8.52s3.803,8.521,8.494,8.521c1.805,0,3.477-0.563,4.852-1.526      l6.19,6.442c0.06,0.058,0.153,0.058,0.207,0.003l1.211-1.213c0.055-0.057,0.052-0.153-0.004-0.208l-6.108-6.358     c1.336-1.505,2.146-3.486,2.146-5.66C-147.012,190.314-150.814,186.5-155.506,186.5z M-155.501,202.5       c-4.142,0-7.499-3.357-7.499-7.5s3.357-7.5,7.499-7.5c4.144,0,7.501,3.357,7.501,7.5S-151.357,202.5-155.501,202.5z"></path> </g> </svg></button>
                    </form>
                </div>
                <div class="blog__content copyright">


                    <?php
                    if(isset($_POST["ss"])){
                        $args = array(
                            's' => $_POST["ss"],
                            'post_type' => 'post'
                        );
                        $the_query = new WP_Query($args);
                        if ($the_query->have_posts()) {
                            while ($the_query->have_posts()) {
                                $the_query->the_post();
                                get_template_part('views/blog');
                            }
                        }else{
                            get_template_part('widgets/blog/nothing_found');
                        }
                    }else{

                        while (have_posts()) {
                            the_post();
                            get_template_part('widgets/blog/blog');
                        } }?>
                    
                </div>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>

