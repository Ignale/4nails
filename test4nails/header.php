<!doctype html>

<html <?= language_attributes(); ?>>

<head>

  <meta charset="utf-8">

  <meta
    name="viewport"
    content="width=device-width , initial-scale=1.0"
  >
  <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet"> -->

  <?php wp_head() ?>

  <title> <?= wp_get_document_title() ?></title>

  <!-- Google Tag Manager -->
  <script>
  (function(w, d, s, l, i) {
    w[l] = w[l] || [];
    w[l].push({
      'gtm.start': new Date().getTime(),
      event: 'gtm.js'
    });
    var f = d.getElementsByTagName(s)[0],
      j = d.createElement(s),
      dl = l != 'dataLayer' ? '&l=' + l : '';
    j.async = true;
    j.src =
      'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
    f.parentNode.insertBefore(j, f);
  })(window, document, 'script', 'dataLayer', 'GTM-TZQ8ZHL');
  </script>
  <!-- End Google Tag Manager -->


</head>


<body <?php body_class() ?>>

  <!-- Google Tag Manager (noscript) -->
  <noscript>
    <iframe
      src="https://www.googletagmanager.com/ns.html?id=GTM-TZQ8ZHL"
      height="0"
      width="0"
      style="display:none;visibility:hidden"
    ></iframe>
  </noscript>
  <!-- End Google Tag Manager (noscript) -->

  <!-- Messenger Плагин чата Code -->
  <?php
if (ICL_LANGUAGE_CODE == 'en') { //This is for English language
    ?>
  <div
    id="fb-root"
    class="<?= wp_is_mobile() ? 'fb-root-mobile' : '' ?>"
  ></div>
  <!--    <style>-->
  <!--        #fb-root{-->
  <!--            transition: none;-->
  <!--        }-->
  <!--        .fb-root-mobile{-->
  <!--           display: none;-->
  <!--        }-->
  <!--    </style>-->

  <!-- Your Плагин чата на Английском code -->
  <div
    id="fb-customer-chat"
    class="fb-customerchat"
  >
  </div>

  <script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "100550711432372");
  chatbox.setAttribute("attribution", "biz_inbox");

  window.fbAsyncInit = function() {
    FB.init({
      xfbml: true,
      version: 'v11.0'
    });

  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/en_GB/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);

  }(document, 'script', 'facebook-jssdk'));

  // window.setTimeout(()=>{
  //     document.querySelector('#fb-root').classList.remove('fb-root-mobile');
  // },10000)
  </script>
  <?php } ?>
  <?php
if (ICL_LANGUAGE_CODE == 'ru') { //This is for Russian language
    ?>
  <div
    id="fb-root"
    class="<?= wp_is_mobile() ? 'fb-root-mobile' : '' ?>"
  ></div>

  <!-- Your Плагин чата на Русском code -->
  <div
    id="fb-customer-chat"
    class="fb-customerchat"
  >
  </div>

  <!--    <style>-->
  <!--        #fb-root{-->
  <!--            transition: none;-->
  <!--        }-->
  <!--        .fb-root-mobile{-->
  <!--            display: none;-->
  <!--        }-->
  <!--    </style>-->

  <script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "549659442641802");
  chatbox.setAttribute("attribution", "biz_inbox");


  window.fbAsyncInit = function() {
    FB.init({
      xfbml: true,
      version: 'v11.0',
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/ru_RU/sdk/xfbml.customerchat.js?alignment=LEFT';
    js.alignment = 'left';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // window.setTimeout(()=>{
  //     document.querySelector('#fb-root').classList.remove('fb-root-mobile');
  // },10000)
  </script>
  <?php } ?>
  <?php
if (ICL_LANGUAGE_CODE == 'es') { //This is for Spanish language
    ?>
  <div
    id="fb-root"
    class="<?= wp_is_mobile() ? 'fb-root-mobile' : '' ?>"
  ></div>

  <!--    <style>-->
  <!--        #fb-root{-->
  <!--            transition: none;-->
  <!--        }-->
  <!--        .fb-root-mobile{-->
  <!--            display: none;-->
  <!--        }-->
  <!--    </style>-->

  <!-- Your Плагин чата на Испанском code -->
  <div
    id="fb-customer-chat"
    class="fb-customerchat"
  >
  </div>

  <script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "103075198489933");
  chatbox.setAttribute("attribution", "biz_inbox");

  window.fbAsyncInit = function() {
    FB.init({
      xfbml: true,
      version: 'v11.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // window.setTimeout(()=>{
  //     document.querySelector('#fb-root').classList.remove('fb-root-mobile');
  // },10000)
  </script>
  <?php } ?>
  <!-- END Messenger Плагин чата Code -->
  <header>
    <div class="header-top">
      <div class="wrapper">
        <div class="header-top__container">
          <div class="header__info copyright">
            <div class="header__delivery">
              <?php the_icon('delivery'); ?>
              <?php the_field('shipping_text', 'option') ?></div>
            <div class="header__shipping">
              <?php the_icon('usa'); ?>
              <?php //the_field('ship_us_text', 'option') ?>
            </div>
          </div>
          <div class="header__lang">
            <div class="header__lang-logo">
              <svg
                id="Layer_1"
                data-name="Layer 1"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 25 22"
                width="21"
                height="19"
              >
                <path
                  fill="#17cfb9"
                  d="M12.49,0a11.37,11.37,0,0,0-1.18.06c-.33,0-.68.09-1.07.17L10,.28a10.94,10.94,0,0,0-5.43,3c-.14.14-.27.28-.4.43a11,11,0,0,0,16.15,15c.14-.14.28-.29.41-.44A11,11,0,0,0,12.49,0ZM7.26,16.31a12.66,12.66,0,0,0-2.57,1A10.07,10.07,0,0,1,2.46,11.5h4.1A19,19,0,0,0,7.26,16.31ZM8.52,5C9.36,2.75,10.62,1.3,12,1V5.43A17.69,17.69,0,0,1,8.52,5ZM5.36,4l.09-.09,0,0,.17-.16.18-.17L6,3.32a1.81,1.81,0,0,1,.19-.15l0,0A1.09,1.09,0,0,1,6.45,3l.19-.15.06,0a1,1,0,0,1,.17-.12l.2-.14.24-.14.21-.13.24-.13L8,2.05l.25-.12.22-.1.26-.11.22-.09.26-.09.23-.08.14,0a9.07,9.07,0,0,0-2,3.37A12.17,12.17,0,0,1,5.36,4ZM12,6.41v4.12H7.54A17.73,17.73,0,0,1,8.21,6,19.34,19.34,0,0,0,12,6.41ZM7.54,11.5H12v4.12a20.22,20.22,0,0,0-3.79.45A17.66,17.66,0,0,1,7.54,11.5Zm0,5.74a9.07,9.07,0,0,0,2,3.37l-.14,0-.16-.06-.07,0-.26-.09-.16-.07-.32-.13-.22-.1L8,20l-.21-.11a2,2,0,0,1-.25-.14l-.16-.09,0,0-.24-.14,0,0-.16-.11-.18-.12-.05,0L6.44,19l-.22-.18L6,18.71l-.21-.19-.07-.06-.12-.1-.15-.15-.1-.1,0,0A12.17,12.17,0,0,1,7.56,17.24ZM12,16.59V21c-1.38-.27-2.64-1.72-3.48-4A19.34,19.34,0,0,1,12,16.59ZM2.46,10.53A10,10,0,0,1,4.69,4.69a12.63,12.63,0,0,0,2.57,1,19.16,19.16,0,0,0-.7,4.82Zm15,0H13V6.41A19.25,19.25,0,0,0,16.76,6,18.18,18.18,0,0,1,17.44,10.53Zm-2-9.11.14,0,.22.08.27.09.22.09.25.11.22.1.25.12.22.11.24.13.21.12.23.15.21.13.19.14,0,0,.2.15.18.13,0,0,.19.15.17.15.22.2.16.15,0,0,.09.09a12.17,12.17,0,0,1-2.2.84A9.21,9.21,0,0,0,15.43,1.42ZM13,5.43V1c1.39.28,2.65,1.73,3.49,4A17.88,17.88,0,0,1,13,5.43Zm6.65,12.65-.06.05-.09.09a1.85,1.85,0,0,1-.14.14l-.11.1-.07.06-.21.19-.2.15-.21.17-.2.14,0,0-.2.13-.2.14-.23.14-.21.12-.24.13L17,20l-.24.12-.22.1-.48.19-.27.1-.22.08-.14,0a9.25,9.25,0,0,0,2-3.38A12.21,12.21,0,0,1,19.62,18.08ZM13,15.62V11.5h4.47a18.11,18.11,0,0,1-.68,4.57A20,20,0,0,0,13,15.62ZM16.46,17c-.84,2.28-2.1,3.73-3.49,4V16.59A19.56,19.56,0,0,1,16.46,17Zm6.05-5.5a10.07,10.07,0,0,1-2.23,5.84,12.44,12.44,0,0,0-2.57-1,18.64,18.64,0,0,0,.7-4.81Zm0-1h-4.1a18.72,18.72,0,0,0-.7-4.82,12.4,12.4,0,0,0,2.57-1A10,10,0,0,1,22.51,10.53Z"
                />
              </svg>
            </div>
            <?= do_shortcode('[wpml_language_selector_widget]') ?>
          </div>

        </div>
      </div>
    </div>
    <div class="header-center">
      <div class="wrapper">
        <div class="header-center__container">
          <?php if (is_front_page()): ?>
          <div
            class="header__logo"
            id="logo-big"
          >
            <?php the_image('logo', null, 'option', "") ?>
          </div>
          <div
            class="header__logo"
            id="logo-small"
            style="display: none; width: 55px"
          >
            <?php the_image('logo_mini', null, 'option') ?>
          </div>
          <?php else: ?>
          <a
            href="<?php bloginfo('url') ?>"
            class="header__logo"
            style='width: 73px'
          >

            <?php the_image('logo', null, 'option') ?>
          </a>
          <?php endif; ?>

          <?php get_search_form() ?>

          <div class="header__mini">
            <div>
              <button class="header-fixed__btn">
                <svg
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  x="0px"
                  y="0px"
                  width="21px"
                  height="22px"
                  viewBox="-164 186.5 21 22"
                  enable-background="new -164 186.5 21 22"
                  xml:space="preserve"
                >
                  <g>
                    <path
                      fill="#17CFB9"
                      d="M-155.506,186.5c-4.691,0-8.494,3.814-8.494,8.52s3.803,8.521,8.494,8.521c1.805,0,3.477-0.563,4.852-1.526       l6.19,6.442c0.06,0.058,0.153,0.058,0.207,0.003l1.211-1.213c0.055-0.057,0.052-0.153-0.004-0.208l-6.108-6.358     c1.336-1.505,2.146-3.486,2.146-5.66C-147.012,190.314-150.814,186.5-155.506,186.5z M-155.501,202.5       c-4.142,0-7.499-3.357-7.499-7.5s3.357-7.5,7.499-7.5c4.144,0,7.501,3.357,7.501,7.5S-151.357,202.5-155.501,202.5z"
                    ></path>
                  </g>
                </svg>
              </button>
              <a
                href="<?php account_url() ?>"
                class="header__account <?= is_user_logged_in() ? "active-account" : '' ?>"
              >
                <svg
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  x="0px"
                  y="0px"
                  width="19px"
                  height="20px"
                  viewBox="-165 185.5 19 20"
                  enable-background="new -165 185.5 19 20"
                  xml:space="preserve"
                >
                  <path
                    fill="#17CFB9"
                    d="M-155.289,186.5c0.591,0,1.105,0.135,1.6,0.428c0.437,0.242,0.688,0.54,0.799,0.696  c0.125,0.175,0.305,0.306,0.509,0.371c0.168,0.054,0.315,0.162,0.433,0.317c0.407,0.541,0.491,1.615,0.234,3.024    c-0.055,0.296,0.011,0.578,0.206,0.808c0.001,0.002,0.1,0.248-0.112,0.992c-0.203,0.728-0.361,0.93-0.413,0.98  c-0.297,0.121-0.521,0.379-0.595,0.695c-0.073,0.305-0.17,0.596-0.291,0.867c-0.059,0.129-0.087,0.268-0.087,0.407v1.215    c0,0.378,0.212,0.722,0.546,0.892c0.732,0.373,2.637,1.397,4.503,2.852c0.603,0.473,0.963,1.219,0.963,1.996v1.064  c0,0.215-0.178,0.395-0.389,0.395h-16.231c-0.214,0-0.389-0.174-0.389-0.391v-1.064c0-0.777,0.36-1.523,0.964-1.996 c1.852-1.447,3.766-2.477,4.502-2.852c0.334-0.17,0.545-0.514,0.545-0.891v-0.986c0-0.166-0.041-0.33-0.121-0.478   c-0.211-0.392-0.366-0.835-0.458-1.313c-0.048-0.249-0.187-0.468-0.391-0.618c-0.031-0.023-0.192-0.188-0.414-0.982 c-0.204-0.729-0.128-0.951-0.131-0.957c0.319-0.233,0.47-0.636,0.384-1.022c-0.104-0.472-0.093-0.951,0.04-1.458    c0.133-0.583,0.45-1.135,0.953-1.655c0.259-0.278,0.556-0.524,0.906-0.75c0.275-0.188,0.555-0.333,0.833-0.428l0,0  c0.004-0.002,0.008-0.003,0.012-0.005c0.248-0.081,0.497-0.127,0.754-0.141C-155.522,186.507-155.406,186.5-155.289,186.5    M-155.289,185.5c-0.14,0-0.278,0.008-0.4,0.016c-0.342,0.018-0.68,0.082-1.014,0.192c-0.004,0-0.008,0.004-0.012,0.004 c-0.367,0.127-0.725,0.312-1.071,0.549c-0.396,0.255-0.758,0.556-1.072,0.892c-0.615,0.635-1.022,1.351-1.197,2.115 c-0.167,0.635-0.179,1.272-0.041,1.898c-0.073,0.053-0.138,0.114-0.196,0.188c-0.28,0.373-0.293,0.957-0.044,1.846  c0.171,0.613,0.399,1.238,0.786,1.521c0.114,0.59,0.305,1.125,0.562,1.6v0.986c-0.7,0.355-2.7,1.418-4.664,2.953    c-0.843,0.658-1.348,1.697-1.348,2.785v1.064c0,0.77,0.624,1.391,1.385,1.391h16.23c0.763,0,1.385-0.627,1.385-1.395v-1.064 c0-1.084-0.505-2.127-1.35-2.785c-1.963-1.531-3.961-2.598-4.662-2.953v-1.215c0.143-0.32,0.261-0.668,0.351-1.044  c0.521-0.188,0.808-0.957,0.998-1.636c0.257-0.904,0.228-1.539-0.073-1.891c0.317-1.738,0.176-3.02-0.418-3.809 c-0.316-0.413-0.682-0.589-0.926-0.667c-0.176-0.246-0.529-0.658-1.129-0.99C-153.828,185.684-154.523,185.5-155.289,185.5  L-155.289,185.5z"
                  ></path>
                </svg>
                <?php if (is_user_logged_in()): ?>
                <div class="login-name">
                  <?= wp_get_current_user()->user_firstname == 'Default name' ? __('Hello Friend', '4nails') : __('Hi,', '4nails') . wp_get_current_user()->user_firstname; ?>
                </div>
                <?php endif; ?>
              </a>

              <a
                href="<?php the_permalink(81) ?>"
                class="header__contact <?= is_page('contact-us') ? 'current' : '' ?>"
              >
                <svg
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  x="0px"
                  y="0px"
                  width="25px"
                  height="18px"
                  viewBox="-164.5 181.5 25 18"
                  enable-background="new -164.5 181.5 25 18"
                  xml:space="preserve"
                >
                  <path
                    fill="#17CFB9"
                    d="M-141.516,181.5h-20.969c-1.111,0-2.016,0.916-2.016,2.041v13.918c0,1.125,0.905,2.041,2.016,2.041h20.969   c1.112,0,2.016-0.916,2.016-2.041v-13.918C-139.5,182.416-140.404,181.5-141.516,181.5z M-141.516,182.5    c0.269,0,0.509,0.111,0.691,0.286l-10.026,8.852c-0.604,0.535-1.692,0.534-2.298,0.001l-10.026-8.853   c0.182-0.175,0.422-0.286,0.69-0.286H-141.516z M-141.516,198.5h-20.969c-0.56,0-1.016-0.467-1.016-1.041v-13.625l9.689,8.555   c0.486,0.429,1.129,0.664,1.811,0.664c0.683,0,1.326-0.236,1.812-0.666l9.688-8.553v13.625 C-140.5,198.033-140.956,198.5-141.516,198.5z"
                  ></path>
                </svg>
              </a>
              <a
                href="<?php wishlist_url() ?>"
                class="header__wishlist <?= is_page('wishlist') ? 'current' : '' ?>"
              >
                <svg
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  x="0px"
                  y="0px"
                  width="25px"
                  height="22px"
                  viewBox="-164.5 181.5 25 22"
                  enable-background="new -164.5 181.5 25 22"
                  xml:space="preserve"
                >
                  <path
                    fill="#17CFB9"
                    d="M-146.438,182.5c0.176,0,0.347,0.011,0.503,0.026c2.109,0.225,3.57,0.901,4.465,2.07 c0.888,1.157,1.167,2.774,0.832,4.805c-0.494,3.013-4.86,7.129-8.061,10.146c-0.845,0.791-1.895,1.775-2.555,2.489  c-0.185,0.214-0.529,0.463-0.698,0.463c-0.177,0-0.534-0.254-0.752-0.498c-0.578-0.619-1.435-1.419-2.418-2.338l-0.098-0.094    c-3.227-3.015-7.646-7.143-8.145-10.168c-0.333-2.031-0.052-3.648,0.835-4.807c0.896-1.168,2.356-1.845,4.459-2.068 c0.165-0.018,0.334-0.027,0.509-0.027c1.816,0,3.653,0.846,4.794,2.207l0.767,0.915l0.767-0.916    C-150.094,183.346-148.257,182.5-146.438,182.5 M-146.438,181.5c-2.126,0-4.245,0.99-5.562,2.564   c-1.319-1.574-3.436-2.564-5.561-2.564c-0.211,0-0.414,0.012-0.612,0.032c-2.394,0.255-4.078,1.058-5.15,2.455  c-1.062,1.386-1.408,3.261-1.028,5.577c0.555,3.364,4.938,7.456,8.458,10.745l0.081,0.077c0.98,0.916,1.828,1.708,2.379,2.298   c0.075,0.084,0.747,0.815,1.483,0.815c0.741,0,1.398-0.743,1.459-0.814c0.586-0.633,1.537-1.527,2.477-2.408    c3.48-3.281,7.814-7.363,8.364-10.714c0.382-2.314,0.037-4.189-1.025-5.575c-1.071-1.398-2.756-2.201-5.153-2.456   C-146.022,181.513-146.227,181.5-146.438,181.5L-146.438,181.5z"
                  ></path>
                </svg>
              </a>
              <?php
                        get_template_part('widgets/cart/miniCart');

                        ?>
            </div>
          </div>

          <button class="mobile-btn">
            <span></span>
            <span></span>
            <span></span>
          </button>

        </div>
      </div>
    </div>
    <div class="header-bottom">
      <div class="header-shadow">
        <div class="wrapper">
          <div class="header-bottom__container">
            <nav class="header__menu">
              <?php wp_nav_menu(['menu' => 'header', 'container' => null, 'menu_class' => 'header__menu']); ?>
            </nav>
            <div class="header__mini header-fixed__mini">
              <div>
                <button class="header-fixed__btn">
                  <svg
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    width="21px"
                    height="22px"
                    viewBox="-164 186.5 21 22"
                    enable-background="new -164 186.5 21 22"
                    xml:space="preserve"
                  >
                    <g>
                      <path
                        fill="#17CFB9"
                        d="M-155.506,186.5c-4.691,0-8.494,3.814-8.494,8.52s3.803,8.521,8.494,8.521c1.805,0,3.477-0.563,4.852-1.526       l6.19,6.442c0.06,0.058,0.153,0.058,0.207,0.003l1.211-1.213c0.055-0.057,0.052-0.153-0.004-0.208l-6.108-6.358     c1.336-1.505,2.146-3.486,2.146-5.66C-147.012,190.314-150.814,186.5-155.506,186.5z M-155.501,202.5       c-4.142,0-7.499-3.357-7.499-7.5s3.357-7.5,7.499-7.5c4.144,0,7.501,3.357,7.501,7.5S-151.357,202.5-155.501,202.5z"
                      ></path>
                    </g>
                  </svg>
                </button>
                <a
                  href=""
                  class="header__account"
                >
                  <svg
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    width="19px"
                    height="20px"
                    viewBox="-165 185.5 19 20"
                    enable-background="new -165 185.5 19 20"
                    xml:space="preserve"
                  >
                    <path
                      fill="#17CFB9"
                      d="M-155.289,186.5c0.591,0,1.105,0.135,1.6,0.428c0.437,0.242,0.688,0.54,0.799,0.696  c0.125,0.175,0.305,0.306,0.509,0.371c0.168,0.054,0.315,0.162,0.433,0.317c0.407,0.541,0.491,1.615,0.234,3.024    c-0.055,0.296,0.011,0.578,0.206,0.808c0.001,0.002,0.1,0.248-0.112,0.992c-0.203,0.728-0.361,0.93-0.413,0.98  c-0.297,0.121-0.521,0.379-0.595,0.695c-0.073,0.305-0.17,0.596-0.291,0.867c-0.059,0.129-0.087,0.268-0.087,0.407v1.215    c0,0.378,0.212,0.722,0.546,0.892c0.732,0.373,2.637,1.397,4.503,2.852c0.603,0.473,0.963,1.219,0.963,1.996v1.064  c0,0.215-0.178,0.395-0.389,0.395h-16.231c-0.214,0-0.389-0.174-0.389-0.391v-1.064c0-0.777,0.36-1.523,0.964-1.996 c1.852-1.447,3.766-2.477,4.502-2.852c0.334-0.17,0.545-0.514,0.545-0.891v-0.986c0-0.166-0.041-0.33-0.121-0.478   c-0.211-0.392-0.366-0.835-0.458-1.313c-0.048-0.249-0.187-0.468-0.391-0.618c-0.031-0.023-0.192-0.188-0.414-0.982 c-0.204-0.729-0.128-0.951-0.131-0.957c0.319-0.233,0.47-0.636,0.384-1.022c-0.104-0.472-0.093-0.951,0.04-1.458    c0.133-0.583,0.45-1.135,0.953-1.655c0.259-0.278,0.556-0.524,0.906-0.75c0.275-0.188,0.555-0.333,0.833-0.428l0,0  c0.004-0.002,0.008-0.003,0.012-0.005c0.248-0.081,0.497-0.127,0.754-0.141C-155.522,186.507-155.406,186.5-155.289,186.5    M-155.289,185.5c-0.14,0-0.278,0.008-0.4,0.016c-0.342,0.018-0.68,0.082-1.014,0.192c-0.004,0-0.008,0.004-0.012,0.004 c-0.367,0.127-0.725,0.312-1.071,0.549c-0.396,0.255-0.758,0.556-1.072,0.892c-0.615,0.635-1.022,1.351-1.197,2.115 c-0.167,0.635-0.179,1.272-0.041,1.898c-0.073,0.053-0.138,0.114-0.196,0.188c-0.28,0.373-0.293,0.957-0.044,1.846  c0.171,0.613,0.399,1.238,0.786,1.521c0.114,0.59,0.305,1.125,0.562,1.6v0.986c-0.7,0.355-2.7,1.418-4.664,2.953    c-0.843,0.658-1.348,1.697-1.348,2.785v1.064c0,0.77,0.624,1.391,1.385,1.391h16.23c0.763,0,1.385-0.627,1.385-1.395v-1.064 c0-1.084-0.505-2.127-1.35-2.785c-1.963-1.531-3.961-2.598-4.662-2.953v-1.215c0.143-0.32,0.261-0.668,0.351-1.044  c0.521-0.188,0.808-0.957,0.998-1.636c0.257-0.904,0.228-1.539-0.073-1.891c0.317-1.738,0.176-3.02-0.418-3.809 c-0.316-0.413-0.682-0.589-0.926-0.667c-0.176-0.246-0.529-0.658-1.129-0.99C-153.828,185.684-154.523,185.5-155.289,185.5  L-155.289,185.5z"
                    ></path>
                  </svg>
                </a>

                <a
                  href=""
                  class="header__contact"
                >
                  <svg
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    width="25px"
                    height="18px"
                    viewBox="-164.5 181.5 25 18"
                    enable-background="new -164.5 181.5 25 18"
                    xml:space="preserve"
                  >
                    <path
                      fill="#17CFB9"
                      d="M-141.516,181.5h-20.969c-1.111,0-2.016,0.916-2.016,2.041v13.918c0,1.125,0.905,2.041,2.016,2.041h20.969    c1.112,0,2.016-0.916,2.016-2.041v-13.918C-139.5,182.416-140.404,181.5-141.516,181.5z M-141.516,182.5    c0.269,0,0.509,0.111,0.691,0.286l-10.026,8.852c-0.604,0.535-1.692,0.534-2.298,0.001l-10.026-8.853   c0.182-0.175,0.422-0.286,0.69-0.286H-141.516z M-141.516,198.5h-20.969c-0.56,0-1.016-0.467-1.016-1.041v-13.625l9.689,8.555   c0.486,0.429,1.129,0.664,1.811,0.664c0.683,0,1.326-0.236,1.812-0.666l9.688-8.553v13.625 C-140.5,198.033-140.956,198.5-141.516,198.5z"
                    ></path>
                  </svg>
                </a>
                <a
                  href=""
                  class="header__wishlist"
                >
                  <svg
                    version="1.1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    width="25px"
                    height="22px"
                    viewBox="-164.5 181.5 25 22"
                    enable-background="new -164.5 181.5 25 22"
                    xml:space="preserve"
                  >
                    <path
                      fill="#17CFB9"
                      d="M-146.438,182.5c0.176,0,0.347,0.011,0.503,0.026c2.109,0.225,3.57,0.901,4.465,2.07 c0.888,1.157,1.167,2.774,0.832,4.805c-0.494,3.013-4.86,7.129-8.061,10.146c-0.845,0.791-1.895,1.775-2.555,2.489  c-0.185,0.214-0.529,0.463-0.698,0.463c-0.177,0-0.534-0.254-0.752-0.498c-0.578-0.619-1.435-1.419-2.418-2.338l-0.098-0.094    c-3.227-3.015-7.646-7.143-8.145-10.168c-0.333-2.031-0.052-3.648,0.835-4.807c0.896-1.168,2.356-1.845,4.459-2.068 c0.165-0.018,0.334-0.027,0.509-0.027c1.816,0,3.653,0.846,4.794,2.207l0.767,0.915l0.767-0.916    C-150.094,183.346-148.257,182.5-146.438,182.5 M-146.438,181.5c-2.126,0-4.245,0.99-5.562,2.564   c-1.319-1.574-3.436-2.564-5.561-2.564c-0.211,0-0.414,0.012-0.612,0.032c-2.394,0.255-4.078,1.058-5.15,2.455  c-1.062,1.386-1.408,3.261-1.028,5.577c0.555,3.364,4.938,7.456,8.458,10.745l0.081,0.077c0.98,0.916,1.828,1.708,2.379,2.298   c0.075,0.084,0.747,0.815,1.483,0.815c0.741,0,1.398-0.743,1.459-0.814c0.586-0.633,1.537-1.527,2.477-2.408    c3.48-3.281,7.814-7.363,8.364-10.714c0.382-2.314,0.037-4.189-1.025-5.575c-1.071-1.398-2.756-2.201-5.153-2.456   C-146.022,181.513-146.227,181.5-146.438,181.5L-146.438,181.5z"
                    ></path>
                  </svg>
                </a>
                <?php get_template_part('widgets/cart/miniCart') ?>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </header>

  <?php
$news_content = nails_active_news();

if ($news_content): ?>
  <div class="notification news__notification">
    <div class="wrapper">
      <<?= $news_content['url'] == '' ? 'div' : 'a href="' . $news_content['url'] . '"'; ?> class="header_news">

        <div class="notification-text"><?= $news_content['text']; ?></div>
        <button
          onclick="jQuery(this).closest('.notification').animate({opacity: 0}, 300, function(){jQuery(this).remove()})"
          click="jQuery(this).closest('.notification').animate({opacity: 0}, 300, function(){jQuery(this).remove()})"
          class="notification__button"
        >OK
        </button>
        <?= $news_content['url'] == '' ? '</div' : '</a'; ?>>
    </div>
  </div>
  <?php endif; ?>

  <?php woocommerce_breadcrumb(); ?>

  <?php wp_body_open() ?>