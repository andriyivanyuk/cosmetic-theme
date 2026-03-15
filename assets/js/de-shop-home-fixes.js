(function ($) {
  "use strict";

  $(function () {
    var $html = $("html");
    var $slider = $(".home-slideshow");
    var $heroParallaxImage = $(
      ".home5-cosmetic .hero.hero--large.hero__overlay.bg-size .bg-img",
    );

    if ($html.hasClass("no-js")) {
      $html.removeClass("no-js").addClass("js");
    }

    if (
      $slider.length &&
      $.fn.slick &&
      !$slider.hasClass("slick-initialized")
    ) {
      $slider.slick({
        dots: false,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 4000,
        lazyLoad: "ondemand",
      });
    }

    // Ensure hero images are sharp even if lazy classes were not upgraded.
    $slider.find("img.blur-up").addClass("lazyloaded");

    // Ensure parallax hero image is sharp and not held in lazy/blur state.
    if ($heroParallaxImage.length) {
      $heroParallaxImage.each(function () {
        var $img = $(this);
        var src = $img.attr("src") || $img.attr("data-src") || "";
        var $hero = $img.closest(".hero.bg-size");

        $img.removeClass("lazyload").addClass("lazyloaded");

        if (!src || !$hero.length) {
          return;
        }

        // Match the static template behavior: convert image to section background.
        $hero.css({
          backgroundImage: "url('" + src + "')",
          backgroundSize: "cover",
          backgroundPosition: "50% 50%",
          backgroundRepeat: "no-repeat",
        });

        $hero.addClass("de-fixed-hero-bg");
      });
    }
  });
})(jQuery);
