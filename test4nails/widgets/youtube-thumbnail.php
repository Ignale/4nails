<?php
if($args['get_id']){
    $url=$args['link'];
    $link='https://www.youtube.com/watch?v='.$args['link'];
}else {
    $url = get_youtube_id_from_url($args['link']);
    $link=$args['link'];
}
$youtubeThumbnail = getYoutubeThumbnails($url);
$title=getYoutubeTitle($url);
?>

<div class="video__item" data-id="<?= $url ?>" >
    <a class="video__link" href="<?= $link ?>" >
        <div class="video__info" >
            <div class="video__img"></div>
            <div class="video__name"><?= $title?></div>
        </div>
        <img loading="lazy" class="<?= $youtubeThumbnail['class'] ?>" src="<?= $youtubeThumbnail['url'] ?>" alt="<?= $title?>">
    </a>
    <button class="video__btn">
        <svg width="68" height="48" viewBox="0 0 68 48"><path class="video__button-shape" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path><path class="video__button-icon" d="M 45,24 27,14 27,34"></path></svg>
    </button>
</div>
