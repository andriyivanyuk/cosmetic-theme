(function () {
  "use strict";

  function readCart() {
    try {
      var raw = localStorage.getItem("de_cart");
      if (!raw) {
        return [];
      }

      var parsed = JSON.parse(raw);
      return Array.isArray(parsed) ? parsed : [];
    } catch (e) {
      return [];
    }
  }

  function getItemQty(item) {
    var qty = parseInt(item && item.qty ? item.qty : 0, 10);
    return Number.isNaN(qty) || qty < 1 ? 1 : qty;
  }

  function getCount() {
    var items = readCart();
    var total = 0;

    items.forEach(function (item) {
      total += getItemQty(item);
    });

    return total;
  }

  function updateHeaderCount() {
    var count = getCount();
    var counter = document.getElementById("CartCount");

    if (counter) {
      counter.textContent = String(count);
    }
  }

  function bindHeaderCartLink() {
    var link = document.querySelector(".site-header__cart");

    if (!link) {
      return;
    }

    var orderUrl =
      link.getAttribute("data-order-url") || link.getAttribute("href") || "";

    if (orderUrl) {
      link.setAttribute("href", orderUrl);
    }
  }

  window.deShopCart = {
    read: readCart,
    count: getCount,
    updateCounter: updateHeaderCount,
  };

  document.addEventListener("DOMContentLoaded", function () {
    bindHeaderCartLink();
    updateHeaderCount();
  });

  window.addEventListener("de:cart-updated", updateHeaderCount);
  window.addEventListener("storage", function (event) {
    if (!event || event.key === "de_cart") {
      updateHeaderCount();
    }
  });
})();
