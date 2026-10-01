jQuery(document).ready(function ($) {
  $(".offer-slider").each(function () {
    var $slider = $(this);
    var $block = $slider.closest(".block-offers-slider");
    var $pager = $block.find(".pager");
    var $section = $block.closest(".home .fp-section-4");

    if ($section.length) {
      // Keep Slick's viewport width stable; only the initial visual inset changes.
      function alignFirstCard() {
        var heading = $section.find(".wp-block-heading").get(0);
        var card = $slider.find('.single-slide:not(.slick-cloned)').get(0);
        if (!heading || !card) return;
        var cardMargin = parseFloat(window.getComputedStyle(card).marginLeft) || 0;
        var inset = Math.max(0, heading.getBoundingClientRect().left -
          $slider.get(0).getBoundingClientRect().left - cardMargin);
        $block.get(0).style.setProperty("--offers-start-inset", inset + "px");
      }

      // Register once, before initialization, including the initial positioning event.
      $slider.on("init.offersLayout setPosition.offersLayout", alignFirstCard);
      $slider.on("beforeChange.offersLayout", function () {
        $block.addClass("offers-has-started");
      });
      alignFirstCard();
    }

    $slider.slick({
      dots: false,
      arrows: true,
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      variableWidth: true,
      autoplay: true,
      autoplaySpeed: 2000,
      speed: 500,
      prevArrow: $pager.find(".prev"),
      nextArrow: $pager.find(".next"),
      responsive: [
        {
          breakpoint: 768,
          settings: {
            dots: true,
            arrows: false,
          },
        },
      ],
    });
  });
});
