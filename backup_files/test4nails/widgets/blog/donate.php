<div class="article__content-title"><?= __('Support','4nails')?> <img src="<?= path() ?>assets/img/donate2.png" alt="Support"></div>
<div class="donate__text copyright">
    <p><?= __('If you found the information on my blog useful and would like to support me, I will gladly accept any sum.','4nails')?></p>
</div>
<?php

if(get_field('donate', 'options')):
    while (have_rows('donate', 'options')): the_row();
        $image = get_sub_field('donate_image');
        ?>
<div class="donate__way">
    <div><img  src="<?=$image['url']?>" alt="PayPal">
        - <?=get_sub_field('donate_name') ?></div>
</div>
<?php
    endwhile;
    endif; ?>