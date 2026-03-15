jQuery(function ($) {
  var $sidebar = $(".sidebar.filterbar");
  var $sortForm = $("#de-sort-form");
  var $priceForm = $("#de-price-filter-form");
  var $amount = $("#amount");
  var $minPrice = $("#de-min-price");
  var $maxPrice = $("#de-max-price");
  var $priceSlider = $("#slider-range");
  var $quickviewTitle = $("#de-quickview-title");
  var $quickviewSku = $("#de-quickview-sku");
  var $quickviewImage = $("#de-quickview-image");
  var $quickviewAddButton = $(".js-quickview-add-to-request");
  var $catalogProducts = $("#de-catalog-products");
  var $viewSwitches = $(".collection-view-as .change-view[data-view]");

  function toNumber(value, fallback) {
    var parsed = parseFloat(value);
    return Number.isFinite(parsed) ? parsed : fallback;
  }

  function clamp(value, min, max) {
    return Math.min(Math.max(value, min), max);
  }

  function applyCatalogView(view) {
    if (!$catalogProducts.length) {
      return;
    }

    var safeView = view === "list" ? "list" : "grid";
    var $productList = $catalogProducts.closest(".productList");

    $productList.removeClass("catalog-view-grid catalog-view-list");
    $productList.addClass(
      safeView === "list" ? "catalog-view-list" : "catalog-view-grid",
    );

    $viewSwitches.removeClass("change-view--active");
    $viewSwitches
      .filter('[data-view="' + safeView + '"]')
      .addClass("change-view--active");

    try {
      localStorage.setItem("de_catalog_view", safeView);
    } catch (_err) {
      // Ignore storage errors in private mode.
    }
  }

  function formatRange(min, max) {
    return "$" + Math.round(min) + " - $" + Math.round(max);
  }

  if ($priceSlider.length && $.ui && $.ui.slider) {
    var minBound = toNumber($priceSlider.data("min"), 0);
    var maxBound = toNumber($priceSlider.data("max"), minBound + 1);

    if (maxBound <= minBound) {
      maxBound = minBound + 1;
    }

    var currentMin = clamp(
      toNumber($priceSlider.data("current-min"), minBound),
      minBound,
      maxBound,
    );
    var currentMax = clamp(
      toNumber($priceSlider.data("current-max"), maxBound),
      minBound,
      maxBound,
    );

    if (currentMin > currentMax) {
      var temp = currentMin;
      currentMin = currentMax;
      currentMax = temp;
    }

    $priceSlider.slider({
      range: true,
      min: minBound,
      max: maxBound,
      values: [currentMin, currentMax],
      slide: function (_event, ui) {
        $minPrice.val(ui.values[0]);
        $maxPrice.val(ui.values[1]);
        $amount.val(formatRange(ui.values[0], ui.values[1]));
      },
    });

    $minPrice.val(currentMin);
    $maxPrice.val(currentMax);
    $amount.val(formatRange(currentMin, currentMax));
  }

  $(".btn-filter").on("click", function (event) {
    event.preventDefault();
    $sidebar.addClass("active");
  });

  $(".closeFilter").on("click", function () {
    $sidebar.removeClass("active");
  });

  $("#SortBy").on("change", function () {
    if ($sortForm.length) {
      $sortForm.trigger("submit");
    }
  });

  $priceForm.on("submit", function () {
    if ($priceSlider.length && $.ui && $.ui.slider) {
      var sliderValues = $priceSlider.slider("values") || [];

      if (sliderValues.length === 2) {
        $minPrice.val(sliderValues[0]);
        $maxPrice.val(sliderValues[1]);
      }
    }
  });

  if ($catalogProducts.length && $viewSwitches.length) {
    var initialView = String($catalogProducts.data("default-view") || "grid");

    try {
      var savedView = String(localStorage.getItem("de_catalog_view") || "");
      if (savedView === "grid" || savedView === "list") {
        initialView = savedView;
      }
    } catch (_err) {
      // Ignore storage errors in private mode.
    }

    applyCatalogView(initialView);

    $viewSwitches.on("click", function (event) {
      event.preventDefault();
      applyCatalogView(String($(this).data("view") || "grid"));
    });
  }

  function addToRequest($button) {
    var productId = String($button.data("product-id") || "");
    var productTitle = String($button.data("product-title") || "");
    var productPrice = String($button.data("product-price") || "");
    var productImage = String($button.data("product-image") || "");
    var cart = [];

    if (!productId) {
      return;
    }

    try {
      var saved = localStorage.getItem("de_cart");
      if (saved) {
        var parsed = JSON.parse(saved);
        if (Array.isArray(parsed)) {
          cart = parsed;
        }
      }
    } catch (e) {
      cart = [];
    }

    var existingItem = null;

    cart.forEach(function (item) {
      if (item && String(item.id) === productId) {
        existingItem = item;
      }
    });

    if (existingItem) {
      var currentQty = parseInt(existingItem.qty, 10);
      existingItem.qty = Number.isNaN(currentQty) ? 1 : currentQty + 1;
    } else {
      cart.push({
        id: productId,
        title: productTitle,
        price: productPrice,
        image: productImage,
        qty: 1,
      });
    }

    localStorage.setItem("de_cart", JSON.stringify(cart));
    window.dispatchEvent(new Event("de:cart-updated"));

    $button.addClass("added");
    window.setTimeout(function () {
      $button.removeClass("added");
    }, 450);
  }

  $(".js-open-quickview").on("click", function () {
    var $trigger = $(this);
    var productId = String($trigger.data("product-id") || "");
    var productTitle = String($trigger.data("product-title") || "");
    var productSku = String($trigger.data("product-sku") || "-");
    var productImage = String($trigger.data("product-image") || "");
    var productPrice = String($trigger.data("product-price") || "");

    if ($quickviewTitle.length) {
      $quickviewTitle.text(productTitle || "Швидкий перегляд товару");
    }

    if ($quickviewSku.length) {
      $quickviewSku.text(productSku || "-");
    }

    if ($quickviewImage.length && productImage) {
      $quickviewImage.attr("src", productImage);
      $quickviewImage.attr("alt", productTitle);
    }

    if ($quickviewAddButton.length) {
      $quickviewAddButton.attr("data-product-id", productId);
      $quickviewAddButton.attr("data-product-title", productTitle);
      $quickviewAddButton.attr("data-product-price", productPrice);
      $quickviewAddButton.attr("data-product-image", productImage);
    }
  });

  $(".js-add-to-request, .js-quickview-add-to-request").on(
    "click",
    function (event) {
      event.preventDefault();
      addToRequest($(this));
    },
  );
});
