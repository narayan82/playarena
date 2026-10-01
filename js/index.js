jQuery(document).ready(function ($) {
  $(".activity-slider-container").each(function () {
    var _this = $(this);
    _this.slick({
      dots: false,
      arrows: true,
      infinite: true,
      slidesToShow: 6,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
    });
  });
  // Event archive page entertainment and merchandise activity slider
  // $('.entertainment-section .activity-slider-container').each(function () {
  //   var _this = $(this);
  //   _this.slick({
  //     dots: false,
  //     arrows: true,
  //     infinite: true,
  //     slidesToShow: 6,
  //     slidesToScroll: 1,
  //     autoplay: true,
  //     autoplaySpeed: 2000
  //   });
  // });

  // Activity Single Page top slider
  $(".activity-single-page-slider").each(function () {
    var _this = $(this);
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
            arrows: false,
          },
        },
      ],
    });
  });
  // taxonomy Location Single Page bottom slider
  $(".taxonomy-location-bottom-slider").each(function () {
    var _this = $(this);
    _this.slick({
      dots: false,
      arrows: true,
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      variableWidth: true,
      autoplay: true,
      autoplaySpeed: 2000,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            dots: true,
            arrows: false,
          },
        },
      ],
    });
  });

  // taxonomy Location Single Page stories slider
  $(".stories-container").each(function () {
    var _this = $(this);
    _this.slick({
      dots: false,
      arrows: false,
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      variableWidth: true,
      autoplay: false,
      autoplaySpeed: 2000,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            dots: true,
          },
        },
      ],
    });
  });

  // Activity Loadmore btn
  $("body").on("click", ".activity-archive-load-more-btn", function (e) {
    e.preventDefault();
    var _this = $(this);
    $(_this).text("Loading");
    var url = $(this).attr("href");
    $.get(url, function (data) {
      $(_this).closest(".button-container").remove();
      $(".post-content-container").append(
        $(data).find(".post-content-container").html()
      );
    }).fail(function () {
      alert("An error occured");
      $(_this).text("Load More");
    });
  });

  const lightbox = GLightbox({
    selector: ".video-glightbox",
  });

  // const eventLightbox = GLightbox({
  //   selector: ".event-archive-glightbox",
  // });

  $('.age-list input[type="checkbox"]').on("change", function (e) {
    var status = $(this).is(":checked");
    var val = $(this).val();
    if (val == "all") {
      if (status) {
        $(this)
          .closest(".age-list")
          .find('input[type="checkbox"]')
          .each(function () {
            if ($(this).val() != "all") {
              $(this).prop("checked", false);
            }
          });
      } else {
        $(this).prop("checked", true);
      }
    } else {
      $(this)
        .closest(".age-list")
        .find('input[type="checkbox"]')
        .each(function () {
          if ($(this).val() == "all") {
            $(this).prop("checked", false);
          }
        });
    }
  });

  // Event single page activity filter
  $("body").on("click", ".single-event-page .tab", function (e) {
    console.log("hi");
    e.preventDefault();
    var selectedTab = $(this).data("tab");
    console.log(selectedTab);
    $(".activity-slider-section .each-activity").hide();
    $(".activity-slider-section .each-activity." + selectedTab).show();
  });

  //taxonomy location tab in mobile view
  var select = $("#activity-select");
  $("#prev-button").click(function () {
    select.prop("selectedIndex", Math.max(select.prop("selectedIndex") - 1, 0));
  });

  $("#next-button").click(function () {
    select.prop(
      "selectedIndex",
      Math.min(
        select.prop("selectedIndex") + 1,
        select.prop("options").length - 1
      )
    );
  });

  function updateGrid() {
    var container = $(".mega-locations-row > ul.mega-sub-menu");
    var items = container.find("li.each-location");

    var rowHeights = Array.from(items).reduce(function (acc, item) {
      acc.push(item.clientHeight);
      return acc;
    }, []);

    items.each(function (index) {
      var row = rowHeights.indexOf(Math.min(...rowHeights));
      $(this).css("grid-row", "span " + 1 + " / span " + 1);
      rowHeights[row] += $(this).outerHeight(true);
    });
  }
  if ($(window).width() < 1024) {
    updateGrid();
  }

  /* Mobile Menu */
  $(".hamburger").on("click", function (e) {
    e.preventDefault();
    $(this).toggleClass("active");
    $("ul#mega-menu-header-menu").toggleClass("active");
  });

  // Hamburger close on menu click
  $(".menu-item").on("click", function (e) {
    if ($(window).width() < 1024) {
      if ($(".hamburger").hasClass("active")) {
        $(".hamburger").toggleClass("active");
        $(".header-main .right").toggleClass("active");
      }
    }
  });

  /* Offers slider in taxonomy location page start */
  $(".offer-slider-wrapper .content-wrapper").each(function () {
    var _this = $(this);
    var _pager = $(this).parents(".offer-slider-wrapper").find(".pager");
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
            dots: true,
            arrows: false,
          },
        },
      ],
    });
  });
  /* offers slider in taxonomy location page end */

  /* Events slider in taxonomy location page */
  $(".events-slider-wrapper .content-wrapper").each(function () {
    var _this = $(this);
    var _pager = $(this).parents(".events-slider-wrapper").find(".pager");
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
            dots: true,
            arrows: false,
          },
        },
      ],
    });
  });
  /* Events slider in taxonomy location page */

  /* Location page tab click */

  $(".location-taxonomy-page .each-tab").on("click", function (e) {
    e.preventDefault();

    $(".location-taxonomy-page .each-tab").removeClass("active");
    $(".activities-section").removeClass("active");

    $(this).addClass("active");

    // Get the target section ID from the tab's href attribute
    var target = $(this).attr("href").substring(1);

    // Add active class to the corresponding section
    $("#" + target).addClass("active");
  });

  /* Location page tab click end*/

  // Function to activate the section based on the hash
  function activateSectionFromHash() {
    var hash = window.location.hash; // Get the hash from the URL
    if (hash) {
      // Remove the active class from all tabs and sections
      $(".each-tab").removeClass("active");
      $(".activities-section").removeClass("active");

      // Find the tab and section with the matching ID
      var matchingTab = $('.each-tab[href="' + hash + '"]');
      var matchingSection = $(hash);

      // If a matching tab and section exist, activate them
      if (matchingTab.length && matchingSection.length) {
        matchingTab.addClass("active");
        matchingSection.addClass("active");
      }
      window.scrollTo(0, 0);
    }
  }

  // Activate section based on URL hash on page load
  activateSectionFromHash();

  // Optional: Re-run the activation if the hash changes
  $(window).on("hashchange", function () {
    activateSectionFromHash();
  });

  /* Activity single page mobile select click */

  var $select = $("#activity-page-select");

  // // Previous button click handler
  // $("#activity-page-prev-button").click(function () {
  //   var currentIndex = $select.prop("selectedIndex");
  //   if (currentIndex > 0) {
  //     $select.prop("selectedIndex", currentIndex - 1).change();
  //   }
  // });

  // // Next button click handler
  // $("#activity-page-next-button").click(function () {
  //   var currentIndex = $select.prop("selectedIndex");
  //   if (currentIndex < $select.find("option").length - 1) {
  //     $select.prop("selectedIndex", currentIndex + 1).change();
  //   }
  // });

  $("#activity-page-next-button").click(function () {
    var currentIndex = $select.prop("selectedIndex");
    var totalOptions = $select.find("option").length;

    if (currentIndex < totalOptions - 1) {
      $select.prop("selectedIndex", currentIndex + 1).change();
    }

    // Enable/disable buttons
    toggleButtonState();
  });

  $("#activity-page-prev-button").click(function () {
    var currentIndex = $select.prop("selectedIndex");

    if (currentIndex > 0) {
      $select.prop("selectedIndex", currentIndex - 1).change();
    }

    // Enable/disable buttons
    toggleButtonState();
  });

  // Function to enable/disable buttons
  function toggleButtonState() {
    var currentIndex = $select.prop("selectedIndex");
    var totalOptions = $select.find("option").length;

    // Disable 'Previous' button if at the first item
    if (currentIndex === 0) {
      $("#activity-page-prev-button").addClass("disabled");
    } else {
      $("#activity-page-prev-button").removeClass("disabled");
    }

    // Disable 'Next' button if at the last item
    if (currentIndex === totalOptions - 1) {
      $("#activity-page-next-button").addClass("disabled");
    } else {
      $("#activity-page-next-button").removeClass("disabled");
    }
  }

  // Initialize button state on page load
  toggleButtonState();

  /* Enquery form Optional section slide up and slide down */
  $(".gfield .about-event").click(function () {
    const $formSlideWrap = $(".form-slide-wrap");
    $formSlideWrap.slideToggle();
    $(this).toggleClass("open");
  });
});
// Consolidated plugin Purchase snippets: server-validated, paid confirmation pages only.
(function () {
  var purchase = window.playarenaPurchase;
  if (!purchase || typeof purchase.eventId !== "string" || !purchase.eventId ||
      typeof purchase.value !== "number" || !Number.isFinite(purchase.value) || purchase.value < 0 ||
      typeof purchase.currency !== "string" || !/^[A-Z]{3}$/.test(purchase.currency)) {
    return;
  }
  var storageKey = purchase.eventId;
  window.playarenaPurchaseEvents = window.playarenaPurchaseEvents || {};
  if (window.playarenaPurchaseEvents[storageKey]) return;
  window.playarenaPurchaseEvents[storageKey] = true;

  function sendPurchase() {
    try {
      if (window.localStorage.getItem(storageKey)) return;
    } catch (error) { /* Storage may be disabled; retain the in-page guard. */ }

    var attempts = 0;
    function attempt() {
      if (typeof window.fbq !== "function") {
        if (++attempts < 40) window.setTimeout(attempt, 250);
        return;
      }
      // Use the existing pixel setup; do not initialize another pixel.
      window.fbq("track", "Purchase", {
        value: purchase.value,
        currency: purchase.currency
      }, { eventID: purchase.eventId });
      try {
        window.localStorage.setItem(storageKey, "1");
      } catch (error) { /* The event was queued even if persistence is unavailable. */ }
    }
    attempt();
  }
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", sendPurchase, { once: true });
  } else {
    sendPurchase();
  }
})();

// Two identical ticker groups make the loop boundary visually continuous.
(function () {
  function initHomeTickers() {
    document.querySelectorAll('.home .fp-sec-scroll').forEach(function (ticker) {
      if (ticker.querySelector('.home-ticker-track')) return;
      var group = ticker.querySelector('.wp-block-group.is-nowrap, .wp-block-group.is-layout-flex');
      if (!group) return;
      var track = document.createElement('div');
      track.className = 'home-ticker-track';
      group.classList.add('home-ticker-group');
      var copy = group.cloneNode(true);
      copy.setAttribute('aria-hidden', 'true');
      copy.setAttribute('inert', '');
      copy.removeAttribute('id');
      copy.querySelectorAll('[id]').forEach(function (element) { element.removeAttribute('id'); });
      group.parentNode.insertBefore(track, group);
      track.appendChild(group);
      track.appendChild(copy);
    });
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHomeTickers, { once: true });
  } else {
    initHomeTickers();
  }
})();

// Keep the header glass at the top and opaque after scrolling.
(function () {
  var header = document.querySelector('.header-main');
  if (!header) return;
  function updateHeaderSurface() {
    header.classList.toggle('header-is-scrolled', window.scrollY > 8);
  }
  updateHeaderSurface();
  window.addEventListener('scroll', updateHeaderSurface, { passive: true });
  window.addEventListener('pageshow', updateHeaderSurface);
})();

// Birthday carousels advance only while visible, with no offscreen autoplay timer.
jQuery(function ($) {
  if (!document.body.matches('.page-id-834, .page-id-36, .page-id-1495') || !window.IntersectionObserver) return;
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  var selectors = '.block-tab-block .slider-container, .block-slider-type-1 .slider-container, .event-space-cards .space-card-row';
  document.querySelectorAll(selectors).forEach(function (slider) {
    var $slider = $(slider);
    var nativeRow = slider.classList.contains('space-card-row');
    var frame = slider.closest('.slider-sec-outer, .block-slider-type-1, .event-space-cards') || slider;
    var visible = false;
    var hovered = false;
    var interacting = false;
    var timer = null;

    function stop() {
      window.clearInterval(timer);
      timer = null;
    }
    function sync() {
      stop();
      if (!visible || hovered || interacting || document.hidden || reducedMotion.matches || frame.contains(document.activeElement)) return;
      if (!nativeRow && !$slider.hasClass('slick-initialized')) return;
      timer = window.setInterval(function () {
        if (!slider.getClientRects().length) { stop(); return; }
        if (!nativeRow) {
          $slider.slick('slickNext');
          return;
        }
        var card = slider.querySelector('.space-card');
        if (!card || slider.scrollWidth <= slider.clientWidth + 1) return;
        var atEnd = slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 2;
        var step = card.getBoundingClientRect().width + parseFloat(window.getComputedStyle(slider).columnGap || 0);
        slider.scrollTo({ left: atEnd ? 0 : slider.scrollLeft + step, behavior: 'smooth' });
      }, 3500);
    }

    var observer = new IntersectionObserver(function (entries) {
      visible = entries[0].isIntersecting && entries[0].intersectionRatio >= 0.15;
      sync();
    }, { threshold: [0, 0.15], rootMargin: '-84px 0px 0px 0px' });
    observer.observe(slider);
    $slider.on('init.viewportAutoplay reInit.viewportAutoplay', sync);
    frame.addEventListener('pointerenter', function (event) { if (event.pointerType === 'mouse') { hovered = true; sync(); } });
    frame.addEventListener('pointerleave', function () { hovered = false; sync(); });
    frame.addEventListener('pointerdown', function () { interacting = true; sync(); });
    window.addEventListener('pointerup', function () { if (interacting) { interacting = false; sync(); } });
    window.addEventListener('pointercancel', function () { interacting = false; sync(); });
    frame.addEventListener('focusin', sync);
    frame.addEventListener('focusout', function () { window.setTimeout(sync, 0); });
    document.addEventListener('visibilitychange', sync);
    reducedMotion.addEventListener('change', sync);
  });
});

// Mobile card carousels start on the content inset, then reveal the full-width track.
jQuery(function ($) {
  var selectors = '.block-tab-block .slider-sec-outer .slider-container, .block-slider-type-1 .slider-container, .block-offers-slider .offer-slider, .block-coming-events .content-wrapper';
  $(selectors).each(function () {
    var $slider = $(this);
    var $frame = $slider.closest('.slider-sec-outer, .block-slider-type-1, .block-offers-slider, .events-outer-wrap');
    $frame.addClass('mobile-edge-carousel');
    if (document.body.matches('.page-id-834, .page-id-36, .page-id-1495')) {
      $frame.addClass('birthday-edge-carousel');
      function alignBirthdaySlider() {
        var tabBlock = $slider.get(0).closest('.block-tab-block');
        var content = tabBlock
          ? tabBlock.querySelector('.tab-section .tab-wrap')
          : document.querySelector('.single-hero-sec .head-sec');
        if (!content || !$slider.get(0).getClientRects().length) return;
        var card = $slider.get(0).querySelector('.slick-current');
        var list = $slider.get(0).querySelector('.slick-list');
        if (!card || !list) return;
        // Slick includes slide margins in its track offset; measure the rendered card.
        var transform = new DOMMatrixReadOnly(window.getComputedStyle(list).transform);
        var inset = Math.max(0, transform.m41 + content.getBoundingClientRect().left - card.getBoundingClientRect().left);
        $frame.get(0).style.setProperty('--birthday-slider-inset', inset + 'px');
      }
      function scheduleAlignment() {
        window.requestAnimationFrame(alignBirthdaySlider);
      }
      $slider.on('init.birthdayEdge setPosition.birthdayEdge', scheduleAlignment);
      window.addEventListener('load', scheduleAlignment);
      window.addEventListener('resize', scheduleAlignment);
      scheduleAlignment();
    }
    $slider.on('beforeChange.mobileEdge', function () {
      $frame.addClass('mobile-edge-started');
    });
  });
  $(':is(.page-id-834, .page-id-36, .page-id-1495) .block-tab-block').find('.tab, .tab-select').on('click.birthdayEdge change.birthdayEdge', function () {
    window.requestAnimationFrame(function () {
      $('.birthday-edge-carousel .slick-initialized:visible').slick('setPosition');
    });
  });
});

// Use Max Mega Menu's native height animation for mobile accordion panels.
jQuery(function ($) {
  var $menu = $('#mega-menu-header-menu');
  var motion = window.matchMedia('(prefers-reduced-motion: reduce)');
  function configureMobileMenu() {
    var menu = $menu.data('maxmegamenu');
    if (!menu) return;
    menu.settings.effect_mobile = 'slide';
    menu.settings.effect_speed_mobile = motion.matches ? 0 : 280;
  }
  $menu.on('after_mega_menu_init', function () { window.setTimeout(configureMobileMenu, 0); });
  motion.addEventListener('change', configureMobileMenu);
  configureMobileMenu();
  if ($menu.get(0)) $menu.get(0).addEventListener('click', function (event) {
    if (!window.matchMedia('(max-width: 1023px)').matches) return;
    var anchor = event.target.closest('a.mega-menu-link');
    if (!anchor || anchor.parentElement.parentElement !== $menu.get(0)) return;
    var $anchor = $(anchor);
    if (!$anchor.siblings('.mega-sub-menu').length) return;
    var menu = $menu.data('maxmegamenu');
    if (!menu) return;
    event.preventDefault();
    event.stopPropagation();
    if ($anchor.parent().hasClass('mega-toggle-on')) menu.hidePanel($anchor, false);
    else menu.showPanel($anchor);
  }, true);
});
