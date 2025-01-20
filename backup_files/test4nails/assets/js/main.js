var $ = jQuery.noConflict();
/* MOBILE-MENU */
$(".mob-menu").hide();
if (window.matchMedia("(max-width: 850px)").matches) {
  $(".header-bottom").addClass("mob-menu");
} else {
  $(".header-bottom").removeClass("mob-menu");
}
$(".mobile-btn").click(function () {
  $(".header__search-fixed").hide();
  if (!$(this).hasClass("open-btn")) {
    $(".header-bottom.mob-menu").css("transform", "translate(0,0)");
    $(".header__menu li").addClass("transform");
    $(this).addClass("open-btn");
    $("html, body").addClass("mob-menu__open");
  } else {
    if (window.matchMedia("(max-width: 767px)").matches) {
      $(".header-bottom.mob-menu").css("transform", "translate(100%,0)");
    } else {
      $(".header-bottom.mob-menu").css("transform", "translate(-100%,0)");
    }
    $(".header__menu li").removeClass("transform");
    $(this).removeClass("open-btn");
    $("html, body").removeClass("mob-menu__open");
  }
});
/* END MOBILE-MENU */

/* SEARCH */
$(".header-bottom .header-fixed__btn").click(function () {
  if (!$(this).hasClass("open")) {
    $(this).addClass("open");
    $(".layer").show();
    $(".header__search ").addClass("header__search-fixed").animate(
      {
        left: "0",
      },
      300
    );
  } else {
    $(".header__search ").removeClass("header__search-fixed").animate(
      {
        left: "-100%",
      },
      300
    );
    $(".header-fixed__btn").removeClass("open");
    $(".layer").hide();
  }
});

$(".header-center .header-fixed__btn").click(function () {
  if (!$(this).hasClass("open")) {
    $(this).addClass("open");
    $(".layer").show();
    $(".header__search").addClass("slide");
  } else {
    $(".header-fixed__btn").removeClass("open");
    $(".layer").hide();
    $(".header__search").removeClass("slide");
  }
});

$(".close-icon, .layer").click(function () {
  $(".header__search-fixed").removeClass("header__search-fixed").animate(
    {
      left: "-100%",
    },
    300
  );
  $(".header__search.slide").removeClass("slide");
  $(".header-fixed__btn").removeClass("open");
  $(".layer").hide();
});
/* END SEARCH */

$(".header-fixed__mini").hide();
var stickyOffset = $(".header-bottom").offset().top;
$(window).scroll(function () {
  var sticky = $(".header-bottom"),
    scroll = $(window).scrollTop();

  if (scroll >= stickyOffset && $(window).width() > 850) {
    sticky.addClass("header-fixed");
    $(".header-fixed__mini").show();
    $(".header__search").addClass("header__search-fixed");
  } else {
    sticky.removeClass("header-fixed");
    $(".header-fixed__mini").hide();
    $(".header__search").removeClass("header__search-fixed");
  }
});

$(window).scroll(function () {
  var fixed = $(".header-center"),
    scroll = $(window).scrollTop();

  if (scroll >= 165 && $(window).width() < 851) {
    fixed.addClass("header-fixed");
    $(".header__search").addClass("hide");
    $(".header-top").hide();
    $("#logo-big").hide();
    $("#logo-small").show();
    $(".open-search__btn").show();
  } else {
    $(".header__search").removeClass("hide");
    fixed.removeClass("header-fixed");
    $(".header-top").show();
    $("#logo-big").show();
    $("#logo-small").hide();
  }
});

$(".mobile-btn").click(function () {
  $("html, body").animate({ scrollTop: 0 }, "fast");
});
/*END SEARCH */

/* SWIPER */
if (
  bodyClass("woocommerce-cart") ||
  bodyClass("home") ||
  bodyClass("single-product")
) {
  if (window.matchMedia("(max-width: 1024px)").matches) {
    new Swiper(".products__swiper, .viewed__swiper", {
      autoplay: {
        delay: 3000,
      },
      disableOnInteraction: false,
      loop: true,
      spaceBetween: 15,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      observer: true,
      loopFillGroupWithBlank: false,
      breakpoints: {
        992: {
          slidesPerView: 3.5,
        },
        768: {
          slidesPerView: 2.7,
        },
        576: {
          spaceBetween: 15,
          slidesPerView: 2,
        },
        320: {
          spaceBetween: 6,
          slidesPerView: 2.5,
        },
      },
    });
  } else {
    new Swiper(".products__swiper", {
      loop: true,
      spaceBetween: 15,

      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        1200: {
          slidesPerView: 4.5,
        },
        992: {
          slidesPerView: 3.5,
        },
      },
    });

    new Swiper(".viewed__swiper", {
      loop: true,
      spaceBetween: 15,

      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        1200: {
          slidesPerView: 4.5,
        },
        992: {
          slidesPerView: 3.5,
        },
      },
    });
  }
}
/* END SWIPER */

// get active body class
function bodyClass($class) {
  if (typeof $class == "string") $class = [$class];
  return document.querySelector("body").classList.contains($class);
}

$.fn.extend({
  hasClasses: function (selectors) {
    var self = this;
    for (var i in selectors) {
      if ($(self).hasClass(selectors[i])) return true;
    }
    return false;
  },
});

$(document).ready(function () {
  if ($().select2) {
    $("select").select2();
  }
});

window.onload = function () {
  findVideos();
};

function findVideos() {
  let videos = document.querySelectorAll(".video__item");

  for (let i = 0; i < videos.length; i++) {
    setupVideo(videos[i]);
  }
}

function setupVideo(video) {
  let link = video.querySelector(".video__link");
  let button = video.querySelector(".video__btn");
  let id = video.getAttribute("data-id");

  video.addEventListener("click", () => {
    let iframe = createIframe(id);

    link.remove();
    button.remove();

    video.appendChild(iframe);
  });

  link.removeAttribute("href");
  video.classList.add("video--enabled");
}

function createIframe(id) {
  let iframe = document.createElement("iframe");

  iframe.setAttribute("allowfullscreen", "");
  iframe.setAttribute("allow", "autoplay");
  iframe.setAttribute("src", generateURL(id));
  iframe.classList.add("video__media");

  return iframe;
}

function generateURL(id) {
  let query = "?rel=0&showinfo=0&autoplay=1";

  return "https://www.youtube.com/embed/" + id + query;
}

if (bodyClass("woocommerce-account")) {
  $(".show-pass").click(function (e) {
    e.preventDefault();
    $(this).toggleClass("active");
    $(this)
      .siblings("input")
      .attr("type", $(this).hasClass("active") ? "text" : "password");
  });
}
$(".toast .close").click(() => {
  $(".toast").hide();
});

/* Notification banner*/
if (document.querySelector(".news__notification")) {
  if (
    !sessionStorage.getItem("banner") ||
    sessionStorage.getItem("banner") !== document.documentElement.lang
  ) {
    document.querySelector(".news__notification").style.display = "block";
    sessionStorage.setItem("banner", document.documentElement.lang);
  }
}
$(function () {
  $imgs = $("img,.main-photo, .products__img img");
  $imgs.prop({
    draggable: false,
  });
  $imgs.on({
    dragstart: noselect,
    selectstart: noselect,
    contextmenu: noselect,
  });

  function noselect(e) {
    e.preventDefault();
    return false;
  }
});

function getCookie(name) {
  let matches = document.cookie.match(
    new RegExp(
      "(?:^|; )" +
        name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") +
        "=([^;]*)"
    )
  );
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

function isMobile() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
    navigator.userAgent
  );
}

if (!isMobile()) {
  if (typeof getCookie("nailsMassage") === "undefined") {
    $(document).mouseleave(function (e) {
      if (e.clientY < 10) {
        let date = new Date();
        date.setFullYear(date.getFullYear() + 1);
        document.cookie =
          "nailsMassage=true; path=/; expires=" + date.toUTCString();
        $(document).off("mouseleave");
        Fancybox.show(
          [
            {
              closeExisting: true,
              src: "#leavePagePopup",
              type: "inline",
            },
          ],
          {
            on: {
              destroy: (fancybox, slide) => {},
            },
          }
        );
      }
    });
  }
  document.querySelectorAll(".modal-header__delete").forEach((item) => {
    item.addEventListener("click", () => {
      Fancybox.close();
    });
  });
}
document
  .querySelector(".modal-header__delete")
  .addEventListener("touchend", () => {
    Fancybox.close();
  });

$("#leavePagePopup .wpcf7-form").submit(() => {
  Fancybox.close();
  $("body")
    .addClass("processing")
    .append(
      '<div class="blockUI" style="display:none"></div><div class="blockUI blockOverlay popup-feedback" style="z-index: 1000; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: 0px; left: 0px; background: rgb(255, 255, 255); opacity: 0.6; cursor: default; position: absolute;"></div><div class="blockUI blockMsg blockElement" style="z-index: 1011; display: none; position: absolute; left: 296px; top: 337px;"></div></div>'
    );
  $(".popup-feedback").fadeOut(3000, "swing");
});
function createCookie(name, value) {
  var expires;
  var date = new Date();
  date.setTime(date.getTime() + 60000);
  expires = "; expires=" + date.toGMTString();

  document.cookie =
    encodeURIComponent(name) +
    "=" +
    encodeURIComponent(value) +
    expires +
    "; path=/";
}

$("#goToLoginBtn").click((e) => {
  e.preventDefault();
  Fancybox.show(
    [
      {
        closeExisting: true,
        src: "#goToLoginForm",
        type: "inline",
      },
    ],
    {
      on: {
        destroy: (fancybox, slide) => {},
      },
    }
  );
});
$("#accountLogIn").click(() => {
  createCookie("returnToCancelOrder", window.location.href, 1);
});

$("#cancel-order-btn").click(function (e) {
  e.preventDefault();
  const url = $(this).data("cancel-url"),
    confirmButton = $(".cancel-order__button");
  confirmButton.attr("href", url);

  Fancybox.show(
    [
      {
        closeExisting: true,
        src: "#cancel-order-modal",
        type: "inline",
      },
    ],
    {
      on: {
        destroy: (fancybox, slide) => {},
      },
    }
  );
});
/* Contact 7 */
// Remove no-validate
document.addEventListener("DOMContentLoaded", function () {
  const contactForms = $(".wpcf7-form");
  if (contactForms.length) {
    contactForms.each(function (index, form) {
      $(form).removeAttr("novalidate");
    });
  }
});
