// Birthday event-space cards use native scrolling and one gallery per space.
jQuery(document).ready(function ($) {
  if (typeof GLightbox === 'function' && document.querySelector('.event-space-cards')) {
    GLightbox({ selector: '.event-space-cards .space-photo-link', loop: true });
  }
  document.querySelectorAll('.event-space-cards').forEach(function (block) {
    var row = block.querySelector('.space-card-row');
    var previous = block.querySelector('.space-card-prev');
    var next = block.querySelector('.space-card-next');
    var section = block.closest('.event-space-sec');
    var headingSection = section && section.previousElementSibling;
    if (headingSection && headingSection.matches('.single-page-event-sec')) {
      var headingRow = headingSection.querySelector('.wp-block-group__inner-container') || headingSection;
      headingRow.classList.add('space-heading-row');
      headingRow.appendChild(block.querySelector('.space-card-controls'));
    }
    function updateControls() {
      previous.disabled = row.scrollLeft <= 1;
      next.disabled = row.scrollLeft + row.clientWidth >= row.scrollWidth - 1;
    }
    function move(direction) {
      var card = row.querySelector('.space-card');
      if (!card) return;
      row.scrollBy({ left: direction * (card.getBoundingClientRect().width + 24), behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' });
    }
    previous.addEventListener('click', function () { move(-1); });
    next.addEventListener('click', function () { move(1); });
    row.addEventListener('scroll', updateControls, { passive: true });
    window.addEventListener('resize', updateControls);
    updateControls();
  });
});

jQuery(document).ready(function ($) {
  $(".block-event-spaces .slider-container").each(function () {
    var _this = $(this);
    sliderReinit(_this);
  });

  function sliderReinit(_this) {
    _this.slick({
      dots: false,
      arrows: true,
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            arrows: true,
          },
        },
      ],
    });
  }
  // Default to showing the first tab content
  $('.block-event-spaces .content-section[data-tab-index="0"]').show();

  // Function to update button states
  function updateButtonStates() {
    var currentIndex = parseInt($("#event-space-tab-select").val());
    var maxIndex = $("#event-space-tab-select option").length - 1;

    $("#event-space-prev-button").prop("disabled", currentIndex === 0);
    $("#event-space-next-button").prop("disabled", currentIndex === maxIndex);
  }

  // Initial update of button states
  updateButtonStates();

  // Click event for tab buttons
  $(".block-event-spaces .tab").click(function () {
    var tabIndex = $(this).data("tab-index");
    $(".block-event-spaces .content-section").hide();
    $('.block-event-spaces .content-section[data-tab-index="' + tabIndex + '"]').show(function () {
      var _this = $('.block-event-spaces .content-section[data-tab-index="' + tabIndex + '"]').find(".slider-container");
      _this.slick("unslick");
      sliderReinit(_this);
    });
    $(".block-event-spaces .tab").removeClass("active");
    $(this).addClass("active");

    // Sync the select dropdown with tab button click
    $("#event-space-tab-select").val(tabIndex);

    // Update button states
    updateButtonStates();
  });

  // Change event for mobile select dropdown
  $("#event-space-tab-select").change(function () {
    var tabIndex = $(this).val();
    $(".block-event-spaces .content-section").hide();
    $('.block-event-spaces .content-section[data-tab-index="' + tabIndex + '"]').show(function () {
      alert();
    });
    $(".block-event-spaces .tab").removeClass("active");
    $('.block-event-spaces .tab[data-tab-index="' + tabIndex + '"]').addClass("active");
    updateButtonStates();
  });

  // Click event for previous button
  $("#event-space-prev-button").click(function () {
    var currentIndex = parseInt($("#event-space-tab-select").val());
    var newIndex = currentIndex > 0 ? currentIndex - 1 : 0;
    $("#event-space-tab-select").val(newIndex).trigger("change");
  });

  // Click event for next button
  $("#event-space-next-button").click(function () {
    var currentIndex = parseInt($("#event-space-tab-select").val());
    var maxIndex = $("#event-space-tab-select option").length - 1;
    var newIndex = currentIndex < maxIndex ? currentIndex + 1 : maxIndex;
    $("#event-space-tab-select").val(newIndex).trigger("change");
  });
});
