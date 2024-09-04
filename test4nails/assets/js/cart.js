$("#login-btn").click((e) => {
  e.preventDefault();
  Fancybox.show(
    [
      {
        closeExisting: true,
        src: "#login-form",
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

const maybeDisablePlusButton = () => {
  const cartProduct = $(".cart__product");

  cartProduct.each(function () {
    const productValue = $(this).find(".product__value");
    const productPlus = $(this).find("button.product__plus");

    if (productValue.attr("max") == productValue.val()) {
      productPlus.prop("disabled", true);
    }
  });
};

maybeDisablePlusButton();

$(document).on("updated_cart_totals", function (e) {
  maybeDisablePlusButton();
});

$("#goToCheckoutBtn").click((e) => {
  $("body")
    .addClass("processing")
    .append(
      '<div class="blockUI" style="display:none"></div><div class="blockUI blockOverlay" style="z-index: 1000; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: 0px; left: 0px; background: rgb(255, 255, 255); opacity: 0.6; cursor: default; position: absolute;"></div><div class="blockUI blockMsg blockElement" style="z-index: 1011; display: none; position: absolute; left: 296px; top: 337px;"></div></div>'
    );
});

$("body").on("click", "#change-shipping", (e) => {
  enable();
  jQuery("[name='update_cart']").trigger("click");
});

$("#login-error").click((e) => {
  e.preventDefault();
  Fancybox.show(
    [
      {
        closeExisting: true,
        src: "#login-error-massage",
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
$("#overweight").click((e) => {
  e.preventDefault();
  Fancybox.show(
    [
      {
        closeExisting: true,
        src: "#overweight-massage",
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
if (document.querySelector("#backToCart")) {
  document.querySelector("#backToCart").addEventListener("touchend", () => {
    Fancybox.close();
  });
  document.querySelector("#backToCart").addEventListener("click", () => {
    Fancybox.close();
  });
}
class ShowMore {
  constructor(
    cartItemsContainer,
    cartItems,
    mobile,
    desktop,
    showMoreBtn,
    showMoreArrow,
    showMoreText,
    hideMore,
    showMore
  ) {
    this.hideMore = hideMore;
    this.showMore = showMore;
    this.cartItemsContainer = cartItemsContainer;
    this.cartItems = cartItems;
    this.maxItems = isMobile() ? mobile : desktop;
    this.showMoreBtn = showMoreBtn;
    this.showMoreArrow = showMoreArrow;
    this.showMoreText = showMoreText;
    this.hide = true;
    this.showMoreBtn.addEventListener("wc_fragments_refreshed", () => {
      if (this.hide) {
        this.showElements();
        this.showMoreArrow.classList.remove("show");
        this.showMoreArrow.classList.add("hide");
        this.showMore.hide();
        this.hideMore.show();
        this.hide = false;
      } else {
        this.hideElements();
        this.removeClass(cartItems, "shown-item");
        this.showMoreArrow.classList.remove("hide");
        this.showMoreArrow.classList.add("show");
        this.hideMore.hide();
        this.showMore.show();
        this.hide = true;
      }
    });
    this.showMoreBtn.addEventListener("click", () => {
      if (this.hide) {
        this.showElements();
        this.showMoreArrow.classList.remove("show");
        this.showMoreArrow.classList.add("hide");
        this.showMore.hide();
        this.hideMore.show();
        this.hide = false;
      } else {
        window.location.href = "#firstItem";
        this.hideElements();
        this.removeClass(cartItems, "shown-item");
        this.showMoreArrow.classList.remove("hide");
        this.showMoreArrow.classList.add("show");
        this.hideMore.hide();
        this.showMore.show();
        this.hide = true;
      }
    });
    this.hideElements();
  }

  showElements() {
    for (let i = this.maxItems; i < this.cartItems.length; i++) {
      this.cartItems[i].style.display = "flex";
      this.cartItems[i].classList.add("shown-item");
    }
    this.addCartItemBorder(this.cartItems[this.maxItems - 1]);
    this.removeCartItemBorder(this.cartItems[this.cartItems.length - 1]);
  }
  removeClass(items, className) {
    items.forEach((item) => {
      item.classList.remove(className);
    });
  }
  hideElements() {
    if (this.cartItems.length > this.maxItems) {
      this.showMoreBtn.style.display = "flex";
      this.hideMore.hide();
      this.showMore.show();
      for (let i = this.maxItems; i < this.cartItems.length; i++) {
        this.cartItems[i].style.display = "none";
        this.cartItems[i].classList.add("hidden-item");
      }
      this.removeCartItemBorder(this.cartItems[this.maxItems - 1]);
    } else {
      this.showMoreBtn.style.display = "none";
    }
  }

  removeCartItemBorder(item) {
    item.style.borderBottom = "none";
  }

  addCartItemBorder(item) {
    item.style.borderBottom = "1px solid #bbcac8";
  }
}
if (document.getElementById("overweight-massage")) {
  const modalOverweight = new ShowMore(
    document.querySelector("#overweight-massage .modal-error__first"),
    document.querySelectorAll("#overweight-massage .modal-error__item"),
    3,
    4,
    document.querySelector("#overweight-massage .show-more__btn"),
    document.querySelector("#overweight-massage .show-more-arrow "),
    document.querySelector(" #overweight-massage .show-more__text"),
    $(" #overweight-massage #hideMore"),
    $(" #overweight-massage #showMore")
  );
}
if (document.querySelector("#login-error-massage")) {
  const modalWearhouse = new ShowMore(
    document.querySelector("#login-error-massage .modal-error__second"),
    document.querySelectorAll(
      "#login-error-massage .modal-error__second .modal-error__item"
    ),
    3,
    4,
    document.querySelector("#login-error-massage .show-more__btn"),
    document.querySelector("#login-error-massage .show-more-arrow "),
    document.querySelector(" #login-error-massage .show-more__text"),
    $(" #login-error-massage #hideMore"),
    $(" #login-error-massage #showMore")
  );
}
if (document.querySelector(".cart__product-wrapper")) {
  const modalCart = new ShowMore(
    document.querySelector(".cart__product-wrapper"),
    document.querySelectorAll(".woocommerce-cart-form__cart-item"),
    5,
    8,
    document.querySelector(".cart__product-wrapper .show-more__btn"),
    document.querySelector(".cart__product-wrapper .show-more-arrow "),
    document.querySelector(".cart__product-wrapper .show-more__text"),
    $(".cart__product-wrapper #hideMore"),
    $(".cart__product-wrapper #showMore")
  );
}

$("#goToLogin").click(function () {
  createCookie("returnToCart", window.location.href, 1);
});

$("body").on("updated_cart_totals", function () {
  $('input[name="update_cart"]').prop("disabled", false); // this will enable the button.
});

$(document).on("click", ".cart__product-delete", function (e) {
  e.preventDefault();

  var product_id = $(this).attr("data-product_id"),
    cart_item_key = $(this).attr("data-cart_item_key"),
    product_container = $(this).parents(".mini_cart_item");

  // Add loader
  product_container.block({
    message: null,
    overlayCSS: {
      cursor: "none",
    },
  });

  $.ajax({
    type: "POST",
    dataType: "json",
    url: wc_cart_params.ajax_url,
    data: {
      action: "product_remove",
      product_id: product_id,
      cart_item_key: cart_item_key,
    },
    success: function (response) {
      if (!response || response.error) return;

      var fragments = response.fragments;

      // Replace fragments
      if (fragments) {
        $.each(fragments, function (key, value) {
          $(key).replaceWith(value);
        });
      }
    },
  });
});
