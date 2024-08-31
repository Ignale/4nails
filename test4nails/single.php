<?php get_header(); ?>

<main class="content">
  <section class="article">
    <div class="wrapper">
      <div class="article__container">
        <h1 class="article__title title copyright"><?php the_title() ?></h1>
        <div class="article__content">
          <div class="article__main">
            <article class="article__text text copyright">
              <?php the_post_content();


              ?>

            </article>
            <div class="article__like">
              <iframe
              src="https://www.facebook.com/plugins/like.php?href=<?= the_permalink(); ?>%2F&width=450&layout=standard&action=like&size=small&share=false&height=35&appId"
              width="450"
              height="35"
              style="border:none;overflow:hidden"
              scrolling="no"
              frameborder="0"
              allowfullscreen="true"
              allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
              ></iframe>
              </iframe>
            </div>
            <div class="article__share">
              <div class="article__share-title"><?= __('To share this article', '4nails') ?>:</div>
              <div
              class="article__share-links shareon"
              data-url="<?php the_permalink() ?>"
              >
                <a class="facebook"></a>
                <a class="linkedin"></a>
                <a class="pinterest"></a>
                <button class="telegram"></button>
                <button class="twitter"></button>
                <button class="whatsapp"></button>

              </div>
            </div>
          </div>
          <aside class="sidebar">
            <div class="related-article sidebar__item">
              <?php get_template_part('widgets/blog/related-articles'); ?>
            </div>
            <?php if (get_field('facebook_link', 'options')): ?>
              <div class="follow-us sidebar__item">
                <div class="article__content-title"><?= __('Follow us on Facebook', '4nails') ?></div>
                <div class="follow-us__content">
                  <iframe
                  src="https://www.facebook.com/plugins/page.php?href=<?= get_field('facebook_link', 'options') ?>&tabs=timeline&width=231&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1234367356961387"
                  ,
                  width="231"
                  adapt_container_width="true"
                  height="500"
                  style="border:none;overflow:hidden"
                  scrolling="no"
                  frameborder="0"
                  allowfullscreen="true"
                  allow="autoplay;
                                     clipboard-write; encrypted-media; picture-in-picture; web-share"
                  ></iframe>
                </div>
              </div>
            <?php endif; ?>
            <div class="donate sidebar__item">
              <?php get_template_part('widgets/blog/donate'); ?>
            </div>
            <div class="youtube blog-youtube">
              <div class="article__content-title"><?= __('Watch Our Videos', '4nails') ?></div>
              <div class="youtube__item">
                <?php if (have_rows('blog_videos')): ?>
                  <?php while (have_rows('blog_videos')):
                    the_row(); ?>
                    <div class="youtube__item">

                      <?php
                      get_template_part('widgets/youtube', 'thumbnail', ['link' => get_sub_field('blog_video_link')]); ?>
                    </div>
                  <?php endwhile; ?>
                <?php endif; ?>
              </div>
              <div class="youtube__subscribe">
                <script src="https://apis.google.com/js/platform.js"></script>
                <div
                class="g-ytsubscribe"
                data-channelid="UCYRw15Xypbn4nILXNe4KSTw"
                data-layout="full"
                data-count="default"
                data-width="200px"
                ></div>
              </div>

            </div>
          </aside>
          <div class="blog__comments">
            <?= comments_template(); ?>
          </div>
        </div>

      </div>
    </div>
  </section>
</main>
<script>
  var shareon = function () {
    "use strict";
    var t = {
      facebook: function (t) {
        return "https://www.facebook.com/sharer/sharer.php?u=" + t.url
      },
      linkedin: function (t) {
        return "https://www.linkedin.com/shareArticle?mini=true&url=" + t.url + "&title=" + t.title
      },
      messenger: function (t) {
        return "https://www.facebook.com/dialog/send?app_id=" + t.fbAppId + "&link=" + t.url + "&redirect_uri=" + t
          .url
      },
      pinterest: function (t) {
        return "https://pinterest.com/pin/create/button/?url=" + t.url + "&description=" + t.title + (t.media ?
          "&media=" + t.media : "")
      },
      telegram: function (t) {
        return "https://telegram.me/share/url?url=" + t.url + (t.text ? "&text=" + t.text : "")
      },
      twitter: function (t) {
        return "https://twitter.com/intent/tweet?url=" + t.url + "&text=" + t.title + (t.via ? "&via=" + t.via : "")
      },


      whatsapp: function (t) {
        return "https://wa.me/?text=" + t.title + "%0D%0A" + t.url + (t.text ? "%0D%0A%0D%0A" + t.text : "")
      }
    },
      e = function () {
        for (var e = document.getElementsByClassName("shareon"), r = 0; r < e.length; r += 1)
          for (var n = e[r], i = 0; i < n.children.length; i += 1) {
            var a = n.children[i];
            if (a)
              for (var o = a.classList.length, u = 0; u < o; u += 1) {
                var l = a.classList.item(u);
                if (Object.prototype.hasOwnProperty.call(t, l)) {
                  var s = {
                    url: encodeURIComponent(a.dataset.url || n.dataset.url || window.location.href),
                    title: encodeURIComponent(a.dataset.title || n.dataset.title || document.title),
                    media: encodeURIComponent(a.dataset.media || n.dataset.media || ""),
                    text: encodeURIComponent(a.dataset.text || n.dataset.text || ""),
                    via: encodeURIComponent(a.dataset.via || n.dataset.via || ""),
                    fbAppId: encodeURIComponent(a.dataset.fbAppId || n.dataset.fbAppId || "")
                  },
                    d = t[l](s);
                  if ("a" === a.tagName.toLowerCase()) a.setAttribute("href", d), a.setAttribute("rel",
                    "noopener noreferrer"), a.setAttribute("target", "_blank");
                  else {
                    a.addEventListener("click", function (t) {
                      return function () {
                        window.open(t, "_blank", "noopener,noreferrer")
                      }
                    }(d))
                  }
                  break
                }
              }
          }
      };
    return window.onload = function () {
      e()
    }, e
  }();

  shareon();
</script>
<?php get_footer(); ?>