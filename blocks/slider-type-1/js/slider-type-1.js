jQuery(document).ready(function ($) {
  $(".block-slider-type-1 .slider-container").each(function () {
    var _this = $(this);
    var _pager = $(this).parents(".block-slider-type-1 ").find(".pager");
    _this.slick({
      dots: false,
      arrows: true,
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      variableWidth: true,
      autoplay: !document.body.matches('.page-id-834, .page-id-36, .page-id-1495'),
      autoplaySpeed: 2000,
      prevArrow: $(_pager).find(".prev"),
      nextArrow: $(_pager).find(".next"),
      responsive: [
        {
          breakpoint: 768,
          settings: {
            dots: false,
            arrows: false,
          },
        },
      ],
    });
  });
});
