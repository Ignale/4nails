<?php

/*  Подключение стилей и скриптов ||  Connecting styles and scripts */
require_once "app/includes.php";

/* Вспомогательные функции || Helper functions */
require_once "app/helpers.php";

/* Классы и функции woocommerce || Woocommers classes and functions */
if (class_exists('WooCommerce')) {
    require_once('app/woo4nails.php');
}

/*  Конфигурация темы, плагинов ||  Configuration of themes, plugins */
require_once "app/settings.php";

/*Global variables*/
global $current_language;
$current_language = get_bloginfo("language");

/**
 * Проверяет есть ли миниатюра на ютуб видео в хорошем качестве, если нет, то возвращает в пониженом качестве
 * Checks if there is a thumbnail for YouTube video in good quality, if not, then returns in low quality
 * @param $id
 * @return string[]
 */
function getYoutubeThumbnails($id)
{
    $file_headers = get_headers('http://img.youtube.com/vi/' . $id . '/maxresdefault.jpg');
    $is_404 = $file_headers[0] == 'HTTP/1.0 404 Not Found' || false !== strpos($file_headers[0], '404 Not Found');
    if (!$is_404) {
        return ['url' => 'http://img.youtube.com/vi/' . $id . '/maxresdefault.jpg', 'class' => ''];
    } else {
        return ['url' => 'http://img.youtube.com/vi/' . $id . '/hqdefault.jpg', 'class' => 'hqdefault-quality'];
    }
}


function qwe($id)
{
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $url = 'https://img.youtube.com/vi/2RGyQzsC5Kg/hqdefault.jpg';
    $post_id = 1366;
    $desc = "Логотип WordPress";

// Загрузим файл
    $tmp = download_url($url);

// Установим данные файла
    $file_array = [
        'name' => basename($url), // ex: wp-header-logo.png
        'tmp_name' => $tmp,
        'error' => 0,
        'size' => filesize($tmp),
    ];

// загружаем файл
    $id = media_handle_sideload($file_array, $post_id, $desc);

// если ошибка
    if (is_wp_error($id)) {
        @unlink($file_array['tmp_name']);
        return $id->get_error_messages();
    }

// удалим временный файл
    @unlink($tmp);

}


/* Получить название youtube видео || Get youtube video title */

function getYoutubeTitle($video_id)
{
    $api_key = "AIzaSyCn3U5crNIAyod5qzr1OMvJJnRFs3KL9Ws";
    $url = "https://www.googleapis.com/youtube/v3/videos?id=" . $video_id . "&key=" . $api_key . "&part=snippet,contentDetails,statistics,status";
    $json = file_get_contents($url);
    $getData = json_decode($json, true);
    foreach ((array)$getData['items'] as $key => $gDat) {
        $title = $gDat['snippet']['title'];
    }
    return $title;
}

function comments($comments, $is_reply = false)
{
    echo '<ul class="reviews">';
    foreach ($comments as $comment) {
        $author = $comment->comment_author;
        $content = $comment->comment_content;
        $date = get_comment_date('d F Y', $comment);
        $rate = intval(get_comment_meta($comment->comment_ID, 'rating', true));
        echo '<li class="comment">';
        echo "<div class='name'>$author</div>";
        echo '<div class="comment-content">';
        if (!$is_reply) {
            echo '<div class="product__rating">';
            for ($i = 1; $i <= $rate; $i++) echo '<span class="product-star star-full"> <svg  viewBox="0 -10 511.99143 511" width="511pt" xmlns="http://www.w3.org/2000/svg"> <path d="m510.652344 185.882812c-3.371094-10.367187-12.566406-17.707031-23.402344-18.6875l-147.796875-13.417968-58.410156-136.75c-4.3125-10.046875-14.125-16.53125-25.046875-16.53125s-20.738282 6.484375-25.023438 16.53125l-58.410156 136.75-147.820312 13.417968c-10.835938 1-20.011719 8.339844-23.402344 18.6875-3.371094 10.367188-.257813 21.738282 7.9375 28.925782l111.722656 97.964844-32.941406 145.085937c-2.410156 10.667969 1.730468 21.699219 10.582031 28.097656 4.757813 3.457031 10.347656 5.183594 15.957031 5.183594 4.820313 0 9.644532-1.28125 13.953125-3.859375l127.445313-76.203125 127.421875 76.203125c9.347656 5.585938 21.101562 5.074219 29.933593-1.324219 8.851563-6.398437 12.992188-17.429687 10.582032-28.097656l-32.941406-145.085937 111.722656-97.964844c8.191406-7.1875 11.308594-18.535156 7.9375-28.925782zm-252.203125 223.722657"/> </svg> </span>';
            for ($i = 1; $i <= 5 - $rate; $i++) echo '<span class="product-star star-empty"> <svg  viewBox="0 -10 511.98685 511" width="511pt" xmlns="http://www.w3.org/2000/svg"> <path d="m114.59375 491.140625c-5.609375 0-11.179688-1.75-15.933594-5.1875-8.855468-6.417969-12.992187-17.449219-10.582031-28.09375l32.9375-145.089844-111.703125-97.960937c-8.210938-7.167969-11.347656-18.519532-7.976562-28.90625 3.371093-10.367188 12.542968-17.707032 23.402343-18.710938l147.796875-13.417968 58.433594-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.433594 136.769532 147.773437 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.367187.253906 21.738281-7.957032 28.90625l-111.703125 97.941406 32.9375 145.085938c2.414063 10.667968-1.726562 21.699218-10.578125 28.097656-8.832031 6.398437-20.609375 6.890625-29.910156 1.300781l-127.445312-76.160156-127.445313 76.203125c-4.308594 2.558594-9.109375 3.863281-13.953125 3.863281zm141.398438-112.875c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.746094 1.089843-19.921875 8.621093-26.515625l105.472657-92.5-139.542969-12.671875c-10.046875-.917969-18.6875-7.234375-22.613281-16.492188l-55.082031-129.046875-55.148438 129.066407c-3.882812 9.195312-12.523438 15.511718-22.546875 16.429687l-139.5625 12.671875 105.46875 92.5c7.554687 6.613281 10.859375 16.769531 8.621094 26.539062l-31.0625 136.9375 120.277343-71.914062c4.308594-2.558594 9.109376-3.859375 13.953126-3.859375zm-84.585938-221.847656s0 .023437-.023438.042969zm169.128906-.0625.023438.042969c0-.023438 0-.023438-.023438-.042969zm0 0"/> </svg> </span>';
            echo '</div>';
        }
        echo "<p class='text'>$content</p>";
        echo "<p class='date'>$date</p>";
        $children = $comment->get_children();
        if ($children) comments($children, true);
        echo '</div></li>';
    }
    echo '</ul>';
}

function get_local_facebook()
{
    global $current_language;
    switch ($current_language) {
        case 'ru-RU':
            return "https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2F%25D0%259C%25D0%25B0%25D0%25B3%25D0%25B0%25D0%25B7%25D0%25B8%25D0%25BD-Mashas-Nails-Shop-549659442641802%2F&tabs=timeline&width=231&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1234367356961387";

        case 'es':
            return "https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fmashas.esp%2F&tabs=timeline&width=231&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1234367356961387";

        default:
            return "https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fmashas.nails.shop%2F&tabs=timeline&width=231&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1234367356961387";
    }
}

function get_latest_youtube_videos($count)
{
    $API_Key = 'AIzaSyCn3U5crNIAyod5qzr1OMvJJnRFs3KL9Ws';
    $Channel_ID = 'UCYRw15Xypbn4nILXNe4KSTw';
    $video_ids = [];

    $apiData = @file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=' . $Channel_ID . '&maxResults=' . $count . '&key=' . $API_Key . '');
    if ($apiData) {
        $videoList = json_decode($apiData);

    } else {
        return;
    }
    if (!empty($videoList->items)) {
        foreach ($videoList->items as $item) {
            $video_ids[] = $item->id->videoId;
        }
    }
    return $video_ids;
}

function nails_active_news()
{
    $active = get_field('news_line_are_active', 'options');
    if (!$active) return false;


    $now = strtotime(date('d.m.Y 00:00:00'));



    $begin_date = strtotime(get_field('news_line_date_begin', 'options'));
    $end_date = strtotime(get_field('news_line_date_end', 'options'));

    if ($now <= $begin_date || $now >= $end_date) {
        return false;
    }

    return [
        'text' => get_field('news_line_content', 'options'),
        'url' => get_field('news_line_link', 'options'),
    ];
}

add_action('wp_login', function () {
    if (isset($_COOKIE["return"])) {
        wp_redirect($_COOKIE["return"], 301);
        unset($_COOKIE['return']);
        exit;
    }
});


/* Show comments on all languages*/
global $sitepress;
remove_filter('comments_clauses', array($sitepress, 'comments_clauses'), 10, 2);


add_filter('comment_edit_redirect', 'save_comment_wpse_82317', 10, 2);


/**
 * Save Custom Comment Field
 * This hook deals with the redirect after saving, we are only taking advantage of it
 */
function save_comment_wpse_82317($location, $comment_id)
{
    // Not allowed, return regular value without updating meta
    if (!wp_verify_nonce($_POST['noncename_wpse_82317'], plugin_basename(__FILE__))
        && !isset($_POST['rating_counts'])
    )
        return $location;

    // Update meta
    update_comment_meta(
        $comment_id,
        'rating_counts',
        sanitize_text_field($_POST['rating_counts'])
    );

    // Return regular value after updating
    return $location;
}

function wcs_change_submit_button_text($defaults)
{
    $defaults['label_submit'] = __('Post a comment', '4nails');
    return $defaults;
}

add_filter('comment_form_defaults', 'wcs_change_submit_button_text');

function get_image_size_width($size)
{
    if (!$size = get_image_size($size))
        return false;

    return isset($size['width']) ? $size['width'] : false;
}

/**
 * Получает высоту определенного размера изображения.
 *
 * @param string $size Название размера
 * @return bool|int Высоту или false если размера нет.
 * @uses   get_image_size()
 */
function get_image_size_height($size)
{
    if (!$size = get_image_size($size))
        return false;

    return isset($size['height']) ? $size['height'] : false;
}

function get_image_size($size)
{
    $sizes = get_image_sizes(0);

    return isset($sizes[$size]) ? $sizes[$size] : false;
}

function get_image_sizes($unset_disabled = true)
{
    $wais = &$GLOBALS['_wp_additional_image_sizes'];

    $sizes = array();

    foreach (get_intermediate_image_sizes() as $_size) {
        if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
            $sizes[$_size] = array(
                'width' => get_option("{$_size}_size_w"),
                'height' => get_option("{$_size}_size_h"),
                'crop' => (bool)get_option("{$_size}_crop"),
            );
        } elseif (isset($wais[$_size])) {
            $sizes[$_size] = array(
                'width' => $wais[$_size]['width'],
                'height' => $wais[$_size]['height'],
                'crop' => $wais[$_size]['crop'],
            );
        }

        // size registered, but has 0 width and height
        if ($unset_disabled && ($sizes[$_size]['width'] == 0) && ($sizes[$_size]['height'] == 0))
            unset($sizes[$_size]);
    }

    return $sizes;
}

add_filter('woocommerce_registration_error_email_exists', function ($html) {
    $url = wc_get_page_permalink('myaccount');
    $url = add_query_arg('redirect_checkout', 1, $url);
    $html = str_replace('Please log in', '<a href="' . $url . '">Please log in</a>', $html);
    return $html;
});


function send_notification_about_sub($user_id)
{
    $message = 'User ' . get_userdata($user_id)->user_email . ' subscribed to the advertising mailing';
    wp_mail(get_bloginfo('admin_email'), __('User subscribed to the advertising mailing', '4nails'), $message);

}

/**
 * Ниже код, который исправляет ошибку в .htaccess файле.
 * замена строчек RewriteBase /es
 * на RewriteBase /
 * взято с сайта поддержки WPML
 */
add_filter('mod_rewrite_rules', 'fix_rewritebase');
function fix_rewritebase($rules)
{
    $home_root = parse_url(home_url());
    if (isset($home_root['path'])) {
        $home_root = trailingslashit($home_root['path']);
    } else {
        $home_root = '/';
    }

    $wpml_root = parse_url(get_option('home'));
    if (isset($wpml_root['path'])) {
        $wpml_root = trailingslashit($wpml_root['path']);
    } else {
        $wpml_root = '/';
    }

    $rules = str_replace("RewriteBase $home_root", "RewriteBase $wpml_root", $rules);
    $rules = str_replace("RewriteRule . $home_root", "RewriteRule . $wpml_root", $rules);

    return $rules;
}

add_action('init', 'remove_woocommerce_form_start');
function remove_woocommerce_form_start()
{
    remove_action('woocommerce_form_start', 'function_name_here');
}

add_action('woocommerce_form_start', 'my_custom_function');
function my_custom_function($id)
{
    echo '<p class="zelle__text">' . __("Instant, fee-free money transfer directly to the recipient's account. After placing an order, you will have 24 hours to make a payment via Zelle to our e-mail: mail@4nails.us", '4nails') . '</p>';
}



function is_safari_or_iphone() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    return (bool) (strpos($user_agent, 'Safari') && !strpos($user_agent, 'Chrome')) || (bool) strpos($user_agent, 'iPhone');
}

// Enable SKU search in WooCommerce
function search_by_sku( $search, &$query_vars ) {
    global $wpdb;
    if(isset($query_vars->query['s']) && !empty($query_vars->query['s'])){
        $args = array(
            'posts_per_page'  => -1,
            'post_type'       => 'product',
            'meta_query' => array(
                array(
                    'key' => '_sku',
                    'value' => $query_vars->query['s'],
                    'compare' => 'LIKE'
                )
            )
        );
        $posts = get_posts($args);
        if(empty($posts)) return $search;
        $get_post_ids = array();
        foreach($posts as $post){
            $get_post_ids[] = $post->ID;
        }
        if(sizeof( $get_post_ids ) > 0 ) {
                $search = str_replace( 'AND (((', "AND ((({$wpdb->posts}.ID IN (" . implode( ',', $get_post_ids ) . ")) OR (", $search);
        }
    }
    return $search;

}
add_filter( 'posts_search', 'search_by_sku', 999, 2 );