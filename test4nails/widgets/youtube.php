<div class="youtube__videos">

    <?php

    $url=get_youtube_id_from_url($args['link']);
    $youtubeThumbnail=getYoutubeThumbnails($url) ?>
    <div class="video" data-id="<?= $url?>">

        <div class="video__description"><div class="video__image"></div><div class="video__title"><div class="youtube__text"><?= getYoutubeTitle($url)?></div></div></div>

        <a class="video__link" href="<?= get_sub_field('youtube')?>">

            <img  class="video__media <?=$youtubeThumbnail['class'] ?>" src="<?=$youtubeThumbnail['url'] ?>" alt="">

        </a>
        <button class="video__button" aria-label="Play video">
            <svg width="68" height="48" viewBox="0 0 68 48"><path class="video__button-shape" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path><path class="video__button-icon" d="M 45,24 27,14 27,34"></path></svg>
        </button>
    </div>
</div>
