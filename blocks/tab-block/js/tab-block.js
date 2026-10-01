jQuery(document).ready(function ($) {
  $(".block-tab-block .slider-sec-outer .slider-container").each(function () {
    var $parent = $(this).parents(".content-section");
    var _this = $(this);
    var _pager = $(this).parents(".block-tab-block .slider-sec-outer").find(".pager");
    _this.slick({
      dots: false,
      arrows: true,
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      variableWidth: true,
      // autoplay: true,
      // autoplaySpeed: 2000,
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

  /* Tab click  */
  function updateButtonState(currentIndex, maxIndex) {
    if (currentIndex <= 0) {
      $("#single-event-prev-button").prop("disabled", true);
    } else {
      $("#single-event-prev-button").prop("disabled", false);
    }

    if (currentIndex >= maxIndex) {
      $("#single-event-next-button").prop("disabled", true);
    } else {
      $("#single-event-next-button").prop("disabled", false);
    }
  }

  // Initially display the first tab content and update button state
  $('.block-tab-block .content-section[data-tab-index="0"]').show();
  $(".block-tab-block .tab[data-tab-index='0']").addClass("active");
  updateButtonState(0, $("#single-event-tab-select option").length - 1);

  // Click event for tab buttons
  $(".block-tab-block .tab").click(function () {
    var tabIndex = $(this).data("tab-index");
    $(".block-tab-block .content-section").hide();
    $('.block-tab-block .content-section[data-tab-index="' + tabIndex + '"]').show();
    $(".block-tab-block .tab").removeClass("active");
    $(this).addClass("active");

    // Update the select dropdown to reflect the current tab
    $("#single-event-tab-select").val(tabIndex);

    // Update button state
    updateButtonState(tabIndex, $("#single-event-tab-select option").length - 1);
  });

  // Change event for the select dropdown
  $("#single-event-tab-select").change(function () {
    var tabIndex = $(this).val();
    $(".block-tab-block .content-section").hide();
    $('.block-tab-block .content-section[data-tab-index="' + tabIndex + '"]').show();
    $(".block-tab-block .tab").removeClass("active");
    $('.block-tab-block .tab[data-tab-index="' + tabIndex + '"]').addClass("active");

    // Update button state
    updateButtonState(parseInt(tabIndex), $("#single-event-tab-select option").length - 1);
  });

  // Click event for the previous button
  $("#single-event-prev-button").click(function () {
    var currentIndex = parseInt($("#single-event-tab-select").val());
    var newIndex = currentIndex > 0 ? currentIndex - 1 : currentIndex;
    $("#single-event-tab-select").val(newIndex).change();

    // Update button state
    updateButtonState(newIndex, $("#single-event-tab-select option").length - 1);
  });

  // Click event for the next button
  $("#single-event-next-button").click(function () {
    var currentIndex = parseInt($("#single-event-tab-select").val());
    var maxIndex = $("#single-event-tab-select option").length - 1;
    var newIndex = currentIndex < maxIndex ? currentIndex + 1 : currentIndex;
    $("#single-event-tab-select").val(newIndex).change();

    // Update button state
    updateButtonState(newIndex, maxIndex);
  });
});
