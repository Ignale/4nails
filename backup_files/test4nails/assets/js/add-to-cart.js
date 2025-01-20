/*ADD TO CART BUTTON*/

const url = SharedData.adminAjax;

// add to cart function
function addToCart(id, qty = 1, $btn) {
  let data = {
    action: "add_to_cart",
    product_id: id,
    qty,
  };
  $("body").block({
    message: null,
  });
  $btn.addClass("loading");

  $.post(url, data, (res) => {
    res = JSON.parse(res);
    console.log(res);

    if (res.status === "ok") {
      $(".count-error").hide();
      trigger();
      updateModal(res.modal);
    }
    if (res.status === "error") {
      $(document.body).trigger("checkout_error");

      $(".modalContainer").append(res.notice);

      Fancybox.show([
        {
          src: "#quantity-modal",
          type: "inline",
        },
      ]);
      $(".product__value").val($(".count-error").data("count"));
    }
  }).done(() => {
    $btn.removeClass("loading");
    $btn.addClass("added");
    $("body").trigger("wc_fragment_refresh");
    $("body").unblock();
  });
}
$(document.body).on("checkout_error", function () {});
// trigger add to cart events

// Insert data into modal and show modal window
function updateModal(modal) {
  if (!bodyClass("woocommerce-cart")) {
    $("#addedToCart .modal-body").replaceWith(modal);

    Fancybox.show(
      [
        {
          src: "#addedToCart",
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
}

// Ajax adding to cart from product archive
if (bodyClass("archive")) {
  $(".ajax_add_to_cart").on("click", function (e) {
    e.preventDefault();
    let $btn = $(e.currentTarget),
      id = $btn.data("product_id"),
      count = $btn.data("count");
    addToCart(id, count, $btn);

    //https://test1.4nails.us/?wc-ajax=add_to_cart
  });
}

$("body").on("added_to_cart", (e, data) => {
  updateModal(data.modal);
});

if (bodyClass("single-product")) {
  $("button.add-to-cart:not(.add-to-cart-variable)").click((e) => {
    e.preventDefault();
    let $btn = $(e.currentTarget),
      id = $btn.val(),
      count = $btn.closest("form").find(".product__value").val();
    addToCart(id, count, $btn);
  });
}
/* END ADD BUTTON*/

/* MINI CART*/

// Update mini cart
function updateCart() {
  let $cart = $(".mini-cart"),
    qty = $cart.find(".cart-fragments .qty").first().text();
  $(".product-quantity").html(qty);
  qty > 0 ? $cart.addClass("active") : $cart.removeClass("active");
}

// Add update mini cart events
if (!bodyClass("woocommerce-cart")) {
  $("body")
    .on("removed_from_cart added_to_cart", () => {
      setTimeout(() => updateCart(), 1000);
    })
    .on("click", ".remove_from_cart_button", () => {
      $(".mini-cart").find(".mini-content").addClass("blockOverlay");
    })
    .on("wc_fragments_refreshed ", () => updateCart());
} else {
  $(document).ajaxComplete(() => $("html, body").stop());
}

/* END MINI CART*/

function watch() {
  $("body").on("click", ".qty-btn", (e) => {
    e.preventDefault();
    const current = $(e.currentTarget);
    const input = current.parent().find("input");
    const max = input.attr("max");
    let value = Math.abs(parseInt(input.val()));
    if (current.hasClass("product__plus") && value < max) {
      input.val(++value).trigger("change");
    } else if (current.hasClass("product__minus") && value > 0) {
      input.val(--value).trigger("change");
    }
  });
}

$("body").on("change", ".qty", () => {
  enable();
  trigger();
});

function enable() {
  $(":input[name=update_cart]").removeAttr("disabled");
}

function trigger() {
  $(":input[name=update_cart]").trigger("click");
}

if (bodyClass("single-product") || bodyClass("woocommerce-cart")) {
  setTimeout(() => enable());
  watch();
  jQuery(document.body).on("updated_cart_totals", () => {
    enable();
  });

  jQuery(document.body).on("removed_from_cart", () => {
    enable();
  });
}
/*
function  variable() {
    const $input = $('.variation-items input:checked');
    if ($input.length) {
        const variation = $input.val();
        const id = $('.product').data('id');
        const quantity = $('.quantity input').val();

        let link = location.protocol + '//' + location.host + location.pathname;
        link += '?add-to-cart=' + id + '&variation_id=' + variation + '&quantity=' + quantity;
        $('.product .add-to-cart').attr('href', link);

        const name = $input.data('name'),
            price = $input.data('price'),
            oldPrice = $input.data('old-price'),
            sku = $input.data('sku');
        $('.variation-name').text(name);
        $('.product-price .woocommerce-Price-amount').replaceWith(price);
        $('.product-old-price .woocommerce-Price-amount').replaceWith(oldPrice);
        $('.product__number span').text(sku);
    }
}
function gallery() {
    $('.variation-items input').click(function () {
            let src = $(this).attr('data-gallery'),
            $main = $('.gallery .main-photo');
        console.log(123123);

        if ($main.attr('href') !== src) {
            $('.thumbnail.active').removeClass('active');
            $(this).addClass('active');
            $main.fadeOut(function () {
                $(this).attr('href', src);
                $(this).css('background-image', `url('${src}')`);
                $(this).fadeIn();
            });
        }
    });

}
if (bodyClass('single-product')) {
    gallery();
    $('button.add-to-cart:not(.add-to-cart-variable)').click((e) => {
        console.log('qwewqe');
        e.preventDefault();
        let $btn = $(e.currentTarget),
            id = $btn.val(),
            count = $btn.closest('form').find('.qty').val();
        this.addToCart(id, count, $btn);
    });
}

*/
