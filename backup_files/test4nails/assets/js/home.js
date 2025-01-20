new Swiper(".banner__swiper", {
    lazy: true,
    slidesPerView: 1,
    loop: true,
    autoplay: {
        delay: 5000
    },
});

if (window.matchMedia('(max-width: 767px)').matches) {
    new Swiper(".video__swiper", {
        lazy: true,
        autoplay: {
            delay: 3000,
        },
        disableOnInteraction: false,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        spaceBetween: 15,
        loop: true,
        slidesPerView: 1
    });
} else {
    new Swiper(".video__swiper", {
        lazy: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        spaceBetween: 15,
        loop: true,
        breakpoints: {
            993: {
                centeredSlides: false,
                slidesPerView: 3
            },
            768: {
                slidesPerView: 2,
                centeredSlides: true
            }
        }
    });
}

/* ABOUT */
if (window.matchMedia('(max-width: 767px)').matches) {
    $('.hide__content').hide();
    $('.show__more .showMoreBtn').show();
    $('.show__more .showMoreBtn').click(function () {
        $('.hide__content').slideToggle();
        $('.show__more .showMoreBtn').hide();
        $('.hide__more .showMoreBtn').show();
    });
    $('.hide__more .showMoreBtn').click(function () {
        $('.hide__content').slideUp();
        $('.show__more .showMoreBtn').show();
    });
}
/* END ABOUT */


if (isMobile() && document.documentElement.lang === 'ru-RU') {

    const elem = document.querySelector('.footer__work-hours');

    const data = elem.innerHTML.replace(/: /g, ":<br>");
    elem.innerHTML = data;
}