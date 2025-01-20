// function getEventHandlers(element, eventns) {
//   const $ = window.jQuery;
//   const i = (eventns || "").indexOf("."),
//     event = i > -1 ? eventns.substr(0, i) : eventns,
//     namespace = i > -1 ? eventns.substr(i + 1) : void 0,
//     handlers = Object.create(null);
//   element = $(element);
//   if (!element.length) return handlers;
//   // gets the events associated to a DOM element
//   const listeners = $._data(element.get(0), "events") || handlers;
//   const events = event ? [event] : Object.keys(listeners);
//   if (!eventns) return listeners; // Object with all event types
//   events.forEach((type) => {
//     // gets event-handlers by event-type or namespace
//     (listeners[type] || []).forEach(getHandlers, type);
//   });
//   // eslint-disable-next-line
//   function getHandlers(e) {
//     const type = this.toString();
//     const eNamespace = e.namespace || (e.data && e.data.handler);
//     // gets event-handlers by event-type or namespace
//     if (
//       (event === type && !namespace) ||
//       (eNamespace === namespace && !event) ||
//       (eNamespace === namespace && event === type)
//     ) {
//       handlers[type] = handlers[type] || [];
//       handlers[type].push(e);
//     }
//   }
//   return handlers;
// }

const checkout_form = $("form.checkout");

$(document).on("ajaxSuccess", function (event, xhr, settings) {
  if (
    settings.url === "/?wc-ajax=update_order_review" ||
    settings.url === "/ru/?wc-ajax=update_order_review" ||
    settings.url === "/es/?wc-ajax=update_order_review"
  ) {
    calcCurrentTotalPrice(
      $(".totals__item--shipping").data("shipping") || 0,
      $(".totals__item--fee")?.data("fee") || 0,
      $(".totals__item--tax")?.data("tax") || 0
    );
  }
});
checkout_form.off(
  "change",
  "#ship-to-different-address-checkbox input",
  "ship_to_different_address"
);

if ($("#ship-to-different-address-checkbox").prop("checked") === true) {
  $(".checkout__billing").slideDown();
}
/* CHECKOUT CHECKBOX */
const checkout = document.querySelector(".checkout__container");
let currentStep = "first";
const margin = isMobile() ? 60 : 150;
const sheepToDifferent = () =>
  $("#ship-to-different-address-checkbox").is(":checked");
/* CHECKOUT CHECKBOX */

let CURRENT_URL = window.location.href;
function eraseBilling() {
  var _form = $("form.checkout");
  _form
    .find(".woocommerce-billing-fields")
    .find("input, select")
    .each(function () {
      $(this).val("");
    });
}

//since in woocommerce checkout.js priority is billing
//fields, so if we don't want edit it we copy all sheepeng
//fields to billing fields in every checkout update
$("body").on("update_checkout", checkFields);

/* END CHECKOUT CHECKBOX */
function checkFields(placeOrder = false) {
  var _form = $("form.checkout");
  var _data = {};
  if (sheepToDifferent()) {
    _form
      .find(".woocommerce-shipping-fields")
      .find("input, select")
      .each(function () {
        _data[$(this).attr("name")] = $(this).val();
      });
  }

  _form
    .find(".woocommerce-billing-fields")
    .find("input, select")
    .each(function () {
      let name = $(this).attr("name");
      //if checkbox is checked copy shipping fields to billing
      if (!sheepToDifferent()) {
        let shippingFieldValue = _form
          .find(".woocommerce-shipping-fields")
          .find(`[name=${name.replace("billing", "shipping")}]`)
          .val();

        $(this).val(shippingFieldValue);
      }
      _data[name] = $(this).val();
    });

  _data["ship_to_different_address"] = +sheepToDifferent();
  _data["woocommerce_checkout_place_order"] = 1;
  // _data["payment_method"] = "paypal";
  _data["woocommerce-process-checkout-nonce"] = $(
    "#woocommerce-process-checkout-nonce"
  ).val();

  return _data;
}

$("#ship-to-different-address-checkbox").click(function (e) {
  if ($(this).prop("checked") == true) {
    $(".checkout__billing").slideDown();
    eraseBilling();
    checkFields();
  } else if ($(this).prop("checked") == false) {
    checkFields();
    $(".checkout__billing").slideUp();
  }
});

function validateCheckout(callback) {
  var _payment_method = $("input[name=payment_method]:checked").val();
  var _form = $("form.checkout");
  _form
    .addClass("processing")
    .append(
      '<div class="blockUI" style="display:none"></div><div class="blockUI blockOverlay firstStepShow" style="z-index: 1000; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: 0px; left: 0px; background: rgb(255, 255, 255); opacity: 0.6; cursor: default; position: absolute;"></div><div class="blockUI blockMsg blockElement" style="z-index: 1011; display: none; position: absolute; left: 296px; top: 337px;"></div></div>'
    );

  const _data = checkFields(true);

  return $.ajax({
    url: "/?wc-ajax=checkout",
    type: "POST",
    data: _data,
    dataType: "json",
    success: function (data) {
      var _flug_payment = false;
      _form.removeClass("processing").find(".blockUI").remove();
      if (data.result === "failure") {
        $(".woocommerce-notices-wrapper").hide().html(data.messages);
        $(".woocommerce-notices-wrapper li").each(function () {
          if ("Invalid payment method." === $(this).text().trim()) {
            if ($(".woocommerce-notices-wrapper li").length === 1) {
              _flug_payment = true;
            } else {
              $(this).hide();
            }
          }
        });
      } else {
        _flug_payment = true;
      }

      if (!_flug_payment) {
        $(".woocommerce-notices-wrapper").show();
        $("html, body").animate(
          { scrollTop: $(".woocommerce-error").offset().top - margin },
          500
        );
        return false;
      }

      $(".woocommerce-notices-wrapper").html("");
      _form.removeClass("processing").find(".blockUI").remove();

      if (callback) {
        callback();
      }
    },
  });
}

if (bodyClass("woocommerce-checkout")) {
  setInterval(function () {
    $(".input-radio[name='payment_method']")
      .off()
      .change(function () {
        $(".steps__payment").addClass("active");
        jQuery("body").trigger("update_checkout");
        $(".aside__content #place_order").prop("disabled", false);
      });
  }, 500);
}
$("body").on("click", "#go_to_step1", function () {
  $("#go_to_step2").removeClass("active-step");
  $("#go_to_step1").addClass("active-step");
  $("#first_step").slideDown(0, function () {
    $("#order_review").slideUp(200, function () {
      $("body, html").animate(
        { scrollTop: $("form.checkout").offset().top - 50 },
        0
      );
    });
  });
  return false;
});

$("#place_order").click(function () {
  var timer = setTimeout(function () {
    if ($(".woocommerce-error").get(0) != undefined) {
      clearTimeout(timer);
      if (
        $(".woocommerce-error").find("li").attr("data-id") != "" &&
        $(".woocommerce-error").find("li").attr("data-id") != undefined
      ) {
        $("#accordion-step1").slideDown(0, function () {
          $("#accordion-step2").slideUp(200);
        });
      }
    }
  }, 100);
});
if (document.querySelector(".mailchimp-newsletter")) {
  document.querySelector(".mailchimp-newsletter").remove();
}

if (document.querySelector(".have-data")) {
  $(".step__fields").hide();
  $(".have-data .step__button").click(function () {
    showFirstStepBlock();
  });
}
$(document).ready(function () {
  updateSummary();
});
jQuery("body").on("updated_checkout", function () {
  updateSummary();
});

function updateSummary() {
  $(".checkout-aside").empty();

  $("#asideSumm .checkout-aside__container")
    .clone()
    .css("display", "block")
    .appendTo(".checkout-aside");

  if (document.querySelector("#asideSumm").classList.contains("ppcp-gateway")) {
    const ss = document.querySelector(
      "#asideSumm .checkout-aside__button"
    ).innerHTML;
    document.querySelector("#asideSumm .checkout-aside__button").innerHTML = "";
    document.querySelector(
      ".checkout-aside .checkout-aside__button"
    ).innerHTML = "";
    document.querySelector(
      ".checkout-aside .checkout-aside__button"
    ).innerHTML = ss;
  }
}

function firstStep() {
  pasteShippingData();

  hideFirstStepBlock();

  showSecondStepBlock();

  $(".checkout__container").removeClass("hide-second-step");

  $(".steps__shipping").addClass("active");

  $(".totals__item--shipping").removeClass("d-none");
  $(".totals__item--total").removeClass("d-none");

  hideThirdStepBlock();

  changeCurrentStepClass(currentStep, "second");
  currentStep = "second";

  calcCurrentTotalPrice(
    $(".totals__item--shipping").data("shipping") || 0,
    $(".totals__item--tax")?.data("tax") || 0
  );

  $(".steps__payment").removeClass("active");

  if (checkout.dataset.user) {
    saveUserData();
  }
}

function calcCurrentTotalPrice(...prices) {
  const cartSubtotal = Number(
      +$(".totals__item--subtotal").data("subtotal")
    ).toFixed(2),
    cartTotal = $("#totalPrice bdi"),
    zelleTotal = $("#wc-zelle-form .woocommerce-Price-amount");
  let total = 0;

  for (const arg of prices) {
    total += +arg.toFixed(2);
  }

  let totalPrice = +cartSubtotal + total;

  const formattedPrice = totalPrice.toLocaleString("en-US", {
    style: "currency",
    currency: "USD",
  });
  cartTotal.html(formattedPrice);
  zelleTotal.html(formattedPrice);
}

function hideFirstStepBlock() {
  $(".step__diff-addres").hide();
  $(".step__fields").slideUp();
  $(".aside__content .address-next-step").hide();
  $(".step__data").removeClass("step__info--hide");
  $(".shipping-title").hide();
}

function showFirstStepBlock() {
  $(".step__diff-addres").show();
  $(".step__fields").slideDown();
  $(".aside__content .address-next-step").show();
  $(".step__data").addClass("step__info--hide");
  $(".shipping-title").show();

  $("html, body").animate(
    { scrollTop: $(".first-step").offset().top - margin },
    500
  );
}

function showSecondStepBlock() {
  $(".checkout__container").removeClass("hide-second-step");

  $(".shipp-info").slideDown();

  $("html, body").animate(
    {
      scrollTop: $(".woocommerce-checkout-review-order").offset().top - margin,
    },
    1000
  );
}

function secondStep() {
  updateSummary();

  pasteShipMethodData();

  hideSecondStepBlock();
  hideFirstStepBlock();

  $(".steps__shipping").addClass("active");
  $(".steps__payment").addClass("active");
  changeCurrentStepClass(currentStep, "third");

  currentStep = "third";
  showThirdStepBlock();

  calcCurrentTotalPrice(
    $(".totals__item--shipping").data("shipping") || 0,
    $(".totals__item--fee")?.data("fee") || 0,
    $(".totals__item--tax")?.data("tax") || 0
  );

  $(".aside__content #place_order").prop("disabled", false);
}

function showThirdStep() {
  pasteShipMethodData();
  hideSecondStepBlock();
  showThirdStepBlock();

  hideFirstStepBlock();

  $(".steps__shipping").addClass("active");
  $(".steps__payment").addClass("active");

  changeCurrentStepClass(currentStep, "third");
  currentStep = "third";
}

function showSecondStep() {
  pasteShippingData();
  hideFirstStepBlock();
  showSecondStepBlock();

  $(".checkout__container").removeClass("hide-second-step");

  $(".steps__shipping").addClass("active");

  $(".totals__item--shipping").removeClass("d-none");
  $(".totals__item--total").removeClass("d-none");

  hideThirdStepBlock();

  changeCurrentStepClass(currentStep, "second");
  currentStep = "second";
}

function hideSecondStepBlock() {
  pasteShipMethodData();

  $(".info__data").slideDown();
  if (currentStep === "first") {
    $(".checkout__container").addClass("hide-second-step");
  } else {
    $(".shipp-info").slideDown();
  }
}

function showThirdStepBlock() {
  $(".checkout__container").removeClass("hide-third-step");
  $(".third-step").slideDown();
  $(".checkout__terms").show();
  $(".totals__title").show();

  $("html, body").animate(
    {
      scrollTop: $(".woocommerce-checkout-payment").offset().top - margin,
    },
    1000
  );
}

function hideThirdStepBlock() {
  $(".third-step").slideUp();
  $(".checkout__terms").hide();
  $(".totals__title").hide();
}

function pasteShippingData() {
  const shipping_country = $("#select2-shipping_country-container").attr(
    "title"
  );
  const shipping_state = $("#select2-shipping_state-container").attr("title");
  const billing_country = $("#select2-billing_country-container").attr("title");
  const billing_state = $("#select2-billing_state-container").attr("title");

  $(".shipping-info__name").text(
    $("[name='shipping_first_name']").val() +
      " " +
      $("[name='shipping_last_name']").val()
  );
  $(".shipping-info__location").text(
    $("[name='shipping_city']").val() +
      " " +
      $("[name='shipping_postcode']").val() +
      " " +
      shipping_state +
      " " +
      shipping_country || ""
  );
  $(".shipping-info__street").text(
    $("#shipping_address_1").val() + " " + $("#shipping_address_2").val()
  );
  if (!sheepToDifferent()) {
    $(".billing-info__name").text(
      $("[name='shipping_first_name']").val() +
        " " +
        $("[name='shipping_last_name']").val()
    );
    $(".billing-info__location").text(
      $("[name='shipping_city']").val() +
        " " +
        $("[name='shipping_postcode']").val() +
        " " +
        shipping_state +
        " " +
        shipping_country
    );
    $(".billing-info__street").text(
      $("#shipping_address_1").val() + " " + $("#shipping_address_2").val()
    );
  } else {
    $(".billing-info__name").text(
      $("[name='billing_first_name']").val() +
        " " +
        $("[name='billing_last_name']").val()
    );
    $(".billing-info__location").text(
      $("[name='billing_city']").val() +
        " " +
        $("[name='billing_postcode']").val() +
        " " +
        billing_state +
        " " +
        billing_country || ""
    );
    $(".billing-info__street").text(
      $("#billing_address_1").val() + " " + $("#billing_address_2").val()
    );
  }
}

function compareShippingFields() {
  if (!$("#ship-to-different-address-checkbox").prop("checked")) {
    return true;
  }
  if (
    $("[name='shipping_first_name']").val() ===
      $("[name='billing_first_name']").val() &&
    $("[name='billing_city']").val() === $("[name='shipping_city']").val() &&
    $("[name='shipping_postcode']").val() ===
      $("[name='billing_postcode']").val() &&
    $("[name='billing_state']").val() === $("[name='shipping_state']").val() &&
    $("#select2-shipping_country-container").text() ===
      $("#select2-billing_country-container").text()
  ) {
    return true;
  }

  return false;
}

function changeAddressData() {
  changeCurrentStepClass(currentStep, "first");
  currentStep = "first";
  showFirstStepBlock();
  hideThirdStepBlock();
  hideSecondStepBlock();

  $(".steps__payment").removeClass("active");
  $(".steps__shipping").removeClass("active");
  $(".aside__content #place_order").prop("disabled", true);
}

function changeShippingData() {
  changeCurrentStepClass(currentStep, "second");
  currentStep = "second";
  showSecondStepBlock();
  hideThirdStepBlock();
  hideFirstStepBlock();

  $(".steps__shipping").addClass("active");

  $(".steps__payment").removeClass("active");
  $(".aside__content #place_order").prop("disabled", true);

  calcCurrentTotalPrice(
    $(".totals__item--shipping").data("shipping") || 0,
    $(".totals__item--tax")?.data("tax") || 0
  );
}

function pasteShipMethodData() {
  let shippName = document.querySelector(
    ".shipping_method:checked + .custom-control-label .delivery-method"
  );
  if (!shippName) {
    if ($(".shipp-for-training-text")) {
      $(".shipp-info__name").html($(".shipp-for-training-text").text());
      return;
    }
    return;
  }
  let text = "";
  if (shippName?.querySelector(".woocommerce-Price-amount")) {
    const price = shippName.querySelector(
      ".woocommerce-Price-amount bdi"
    ).innerHTML;
    const shippingMethod = shippName.childNodes[1].textContent.trim();
    if (shippName.querySelector(".shipping_method-description")) {
      const qualityScore = shippName
        .querySelector(".shipping_method-description")
        .textContent.trim();
      text = `${price}  ${shippingMethod}  <small>${qualityScore} </small>`;
    } else {
      text = `${price}  ${shippingMethod}`;
    }
  } else {
    text = shippName.textContent;
  }

  $(".shipp-info__name").html(text);
  $(".shipp-info__desc").text(
    $(
      ".shipping_method:checked + .custom-control-label .delivery__info-text"
    ).text()
  );
}

function changeCurrentStepClass(past, current) {
  checkout.classList.remove(`current-step--${past}`);
  checkout.classList.add(`current-step--${current}`);
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

if (document.querySelector(".checkout-total__content")) {
  const modalCart = new ShowMore(
    document.querySelector(".checkout-total__content"),
    document.querySelectorAll(".checkout-total__item"),
    5,
    8,
    document.querySelector(".checkout-total__content .show-more__btn"),
    document.querySelector(".checkout-total__content .show-more-arrow "),
    document.querySelector(".checkout-total__content .show-more__text"),
    $(".checkout-total__content #hideMore"),
    $(".checkout-total__content #showMore")
  );
}

if (document.querySelector(".step__fields-save-btn")) {
  document
    .querySelector(".step__fields-save-btn")
    .addEventListener("click", () => {
      $(".step__diff-addres").hide();
      $(".step__fields").slideUp();
      $(".step__data").removeClass("step__info--hide");
      saveUserData();
    });
}

function collectShippingData() {
  var _form = $("form.checkout");
  var _data = {};
  _form
    .find(".woocommerce-shipping-fields")
    .find("input, select")
    .each(function () {
      _data[$(this).attr("name")] = $(this).val();
    });
  if (!$("#ship-to-different-address-checkbox").prop("checked")) {
    _form
      .find(".woocommerce-billing-fields")
      .find("input, select")
      .each(function () {
        console.log("qwe");
        _data[$(this).attr("name")] = $(this).val();
      });
  }
  return _data;
}

function saveUserData() {
  const userData = JSON.stringify(collectShippingData());
  $.ajax({
    url: wc_add_to_cart_params.ajax_url,
    type: "POST",
    data: `action=checkoutState&userData=${userData}`, // можно также передать в виде массива или объекта
    success: function (data) {},
    error: function (request, status, error) {
      console.log(request.responseText);
    },
  });
}

jQuery("body").on("updated_checkout", function () {
  pasteShipMethodData();

  if ($(".checkout__container").hasClass("current-step--third")) {
    // If it doesn't, disable the button
    $(".aside__content #place_order").prop("disabled", false);
  }
});

jQuery("body").on("updated_shipping_method", function () {
  pasteShipMethodData();
});

let mySavedShippingMethod = $('input[name="shipping_method[0]"]:checked').val();
jQuery(document).on("updated_checkout", function () {
  // Check if the shipping method has changed
  if (
    jQuery('input[name="shipping_method[0]"]:checked').val() !==
    mySavedShippingMethod
  ) {
    // Update the saved shipping method
    mySavedShippingMethod = jQuery(
      'input[name="shipping_method"]:checked'
    ).val();
    if ($(".checkout__container").hasClass("current-step--second")) {
      calcCurrentTotalPrice(
        $(".totals__item--shipping").data("shipping") || 0,
        $(".totals__item--tax")?.data("tax") || 0
      );
    }
  }
});

function saveFirstStep() {
  pasteBillingData();
  validateCheckout(secondStep);
}

$(".shipping-info--hide").click(function () {
  $(this).removeClass("shipping-info--hide");
});

if (document.querySelector(".mailchimp-newsletter")) {
  document.querySelector(".mailchimp-newsletter").remove();
}

document.addEventListener("DOMContentLoaded", function () {
  const input = document.querySelector("#billing_phone");
  const addressDropdown = document.querySelector("#billing_country_field");
  const iti = window.intlTelInputGlobals.getInstance(input);
});

window.onload = function () {
  const input = document.querySelector("#billing_phone");
  const addressDropdown = document.querySelector("#billing_country_field");
  const iti = window.intlTelInputGlobals.getInstance(input);

  // listen to the address dropdown for changes
};

// $( document.body ).on( 'updated_checkout', function(data) {
//     if($('#billing_phone').val()!=='') {
//         const ajax_url = SharedData.adminAjax,
//             country_code = $('#billing_country').val();
//
//         const ajax_data = {
//             action: 'append_country_prefix_in_billing_phone',
//             country_code: country_code
//         };
//
//         $.post(ajax_url, ajax_data, function (response) {
//             $('#billing_phone').val(response);
//         });
//     }
// } );
