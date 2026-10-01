jQuery(document).ready(function ($) {
  $(".pre-packed-fun-slider").slick({
    slidesToScroll: 1,
    infinite: true,
    arrows: false,
    dots: false,
    variableWidth: true,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: true,
        },
      },
    ],
  });
});
