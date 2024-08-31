$(document).ready(function () {
  setTimeout(() => {
    var productThumbs = new Swiper(".product__thumbs .swiper-container", {
      navigation: {
        nextEl: ".swiper-button-next-thumbs",
        prevEl: ".swiper-button-prev-thumbs",
      },
      slidesPerView: 3,
      spaceBetween: 14,
      freemode: true,
      breakpoints: {
        993: {
          slidesPerView: 3,
          direction: "vertical",
          spaceBetween: 14,
        },
        768: {
          slidesPerView: 4,
        },
        320: {
          spaceBetween: 10,
          slidesPerView: 1,
          direction: "horizontal",
        },
      },
    });

    if (
      productThumbs.slides.length < 3 &&
      window.matchMedia("(min-width: 768px)").matches
    ) {
      $(".product__thumbs .swiper-arrow").css("display", "none");
    }
    if (
      productThumbs.slides.length === 1 &&
      window.matchMedia("(min-width: 768px)").matches
    ) {
      $(".product__main-btn").css("display", "none");
    }

    const slides = document.querySelectorAll(".product__thumbs .swiper-slide");
    let currentSlide = 0;
    const countOfSlides = productThumbs.slides.length;

    // Show next slide
    $(".product__main .product__main-next").click(function (e) {
      if (currentSlide >= countOfSlides - 1) return;
      ++currentSlide;
      let src = $("[data-count= " + currentSlide + "] ").attr("data-bigimage");
      let main = $(".product__main-img a");
      main.fadeOut(function () {
        $(this).css("background-image", `url('${src}')`);
        $(this).fadeIn();
      });
      productThumbs.slideNext();
    });

    // Show prev slide
    $(".product__main .product__main-prev").click(function (e) {
      if (currentSlide < 1) return;
      --currentSlide;
      let src = $("[data-count= " + currentSlide + "] ").attr("data-bigimage");
      let main = $(".product__main-img a");
      main.fadeOut(function () {
        $(this).css("background-image", `url('${src}')`);
        $(this).fadeIn();
      });
      productThumbs.slidePrev();
    });

    function showThumb(index) {
      let imagesUrl = [];
      const currentIndex = $(this).attr("data-count") || index || 0;

      const thumbImages = document.querySelectorAll(
        ".product__thumbs [data-count] img"
      );

      thumbImages.forEach((item) =>
        imagesUrl.push({ src: item.getAttribute("data-src") })
      );
      Fancybox.show(imagesUrl, {
        startIndex: currentIndex,
      });
    }

    // Show clicked thumb
    $("#main-image").click(showThumb);

    $(".product__thumbs .swiper-slide").click(function (e) {
      currentSlide = $(this).attr("data-count");
      let main = $(".product__main-img a");
      let src = $(this).attr("data-bigimage");

      main.attr("data-count", currentSlide);
      main.fadeOut(function () {
        $(this).css("background-image", `url('${src}')`);
        $(this).fadeIn();
      });
      if ($(window).width() < 768) {
        showThumb(currentSlide); //on mobile open main image fullscreen by clicking
      }
    });

    $(".product__tabs-item").not(":first").hide();
    $(".tab_item").not(":first").hide();
    $(".product__tabs li").click(function () {
      $(".product__tabs li")
        .removeClass("active-tab")
        .eq($(this).index())
        .addClass("active-tab");
      $(".product__tabs-item").hide().eq($(this).index()).fadeIn();
    });

    function copyTextToClipboard(copyUrlBtn) {
      let tempInput = document.createElement("textarea");

      tempInput.style.fontSize = "12pt";
      tempInput.style.border = "0";
      tempInput.style.padding = "0";
      tempInput.style.margin = "0";
      tempInput.style.position = "absolute";
      tempInput.style.left = "-9999px";
      tempInput.setAttribute("readonly", "");

      tempInput.value = window.location.href;

      copyUrlBtn.parentNode.appendChild(tempInput);

      tempInput.select();
      tempInput.setSelectionRange(0, 99999);

      document.execCommand("copy");

      tempInput.parentNode.removeChild(tempInput);
    }
    function toClipboard() {
      $(".product-share").on("click", () => {
        copyTextToClipboard(document.querySelector("#clipboard"));
        $("#clipboard").show();
        setTimeout(() => {
          $("#clipboard").hide();
        }, 2000);
      });
    }

    toClipboard();

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

    $(".woocommerce-verification-required a").click(function () {
      createCookie("return", window.location.href, 1);
    });

    if (document.querySelector(".variable-product")) {
      hideArrows();
      displayImage();
      displayVariable();
      document.querySelectorAll(".variation-items input").forEach((item) => {
        item.addEventListener("click", (item) => {
          displayImage();
          displayVariable();
        });
      });
    }
    function displayVariable() {
      const $input = $(".variation-items input:checked");
      if ($input.length) {
        const variation = $input.val();
        const id = $(".product__container").data("id");
        const quantity = $(".quantity input").val();
        let link = location.protocol + "//" + location.host + location.pathname;
        link +=
          "?add-to-cart=" +
          id +
          "&variation_id=" +
          variation +
          "&quantity=" +
          quantity;
        $(".product .add-to-cart").attr("href", link);

        const name = $input.data("name"),
          price = $input.data("price"),
          oldPrice = $input.data("old-price"),
          sku = $input.data("sku");
        $(".variation-name").text(name);
        $(".product-price .woocommerce-Price-amount").replaceWith(price);
        $(".product-old-price .woocommerce-Price-amount").replaceWith(oldPrice);
        $(".product__number span").text(sku);
      }
    }
    function displayImage() {
      const $input = $(".variation-items input:checked");
      const thumb = $(".swiper-container .product__slide img");
      let main = $(".product__main-img a");
      let src = $input.attr("data-gallery");

      main.data("src", src);
      thumb.attr("src", src);
      main.fadeOut(function () {
        $(this).css("background-image", `url('${src}')`);
        $(this).fadeIn();
      });
    }
    function hideArrows() {
      document.querySelectorAll(".product__main-btn").forEach((item) => {
        item.style.display = "none";
      });
    }
  }, 2000);
});

document.addEventListener("readystatechange", function (e) {
  console.log(e);
});

document.addEventListener("DOMContentLoaded", function () {
  document.querySelector(".product__img").style.visibility = "unset";
});
