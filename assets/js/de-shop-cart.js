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

  function ensureToastStack() {
    var existing = document.querySelector(".de-cart-toast-stack");

    if (existing) {
      return existing;
    }

    var stack = document.createElement("div");
    stack.className = "de-cart-toast-stack";
    stack.setAttribute("aria-live", "polite");
    stack.setAttribute("aria-atomic", "false");
    document.body.appendChild(stack);

    return stack;
  }

  function showToast(message) {
    if (!message) {
      return;
    }

    var stack = ensureToastStack();
    var toast = document.createElement("div");
    toast.className = "de-cart-toast";
    toast.setAttribute("role", "status");

    toast.innerHTML =
      '<span class="de-cart-toast__icon"><i class="icon anm anm-check-l"></i></span>' +
      '<div class="de-cart-toast__text"></div>' +
      '<button type="button" class="de-cart-toast__close" aria-label="Close">&times;</button>';

    var textEl = toast.querySelector(".de-cart-toast__text");
    if (textEl) {
      textEl.textContent = String(message);
    }

    var close = function () {
      toast.classList.remove("is-visible");
      window.setTimeout(function () {
        if (toast.parentNode) {
          toast.parentNode.removeChild(toast);
        }
      }, 220);
    };

    var closeButton = toast.querySelector(".de-cart-toast__close");
    if (closeButton) {
      closeButton.addEventListener("click", close);
    }

    stack.appendChild(toast);
    window.requestAnimationFrame(function () {
      toast.classList.add("is-visible");
    });

    window.setTimeout(close, 2600);
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
    showToast: showToast,
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
