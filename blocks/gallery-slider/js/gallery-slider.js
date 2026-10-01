jQuery(document).ready(function ($) {
  $(".block-gallery-slider .slider-container").each(function () {
    var _this = $(this);
    var _pager = $(this).parents(".block-gallery-slider").find(".pager");
    _this.slick({
      dots: false,
      arrows: true,
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      variableWidth: true,
      autoplay: true,
      autoplaySpeed: 2000,
      prevArrow: $(_pager).find(".prev"),
      nextArrow: $(_pager).find(".next"),
      responsive: [
        {
          breakpoint: 768,
          settings: {
            dots: false,
            arrows: true,
          },
        },
      ],
    });
  });
});
