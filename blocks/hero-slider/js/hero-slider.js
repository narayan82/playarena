jQuery(document).ready(function ($) {

  var animationDuration = 5000;
  var interval = setInterval(changeTab, animationDuration);

  progressBarAnimation();

  $(".block-hero-slider .tab-section .single-tab").hover(
    function () {
      var windowWidth = $(window).width();
      if (windowWidth >= 1024) {
        hoverTab($(this));
        clearInterval(interval);
      }
    },
    function () {
      if (windowWidth >= 1024) {
        clearInterval(interval);
        interval = setInterval(changeTab, animationDuration);
      }
    }
  );

  /* Mobile Only */
  $(".mobile-tab-section .single-tab").on("click", function (e) {
    e.preventDefault();
    console.log(interval);
    clearInterval(interval);
    console.log(interval);
    $(".mobile-tab-section .single-tab").removeClass("active");
    $(this).addClass("active");
    var currentCount = $(this).data("count");
    $(".each-content").removeClass("active");
    $(".single-tab").removeClass("active");
    $(".single-tab-" + currentCount).addClass("active");
    $(".each-content-" + currentCount).addClass("active");
  });

  function hoverTab(_this) {
    var currentCount = _this.data("count");
    $(".single-tab").removeClass("active");
    _this.addClass("active");
    $(".each-content").removeClass("active");
    $(".each-content-" + currentCount).addClass("active");
    $(".each-content .progress .progress-bar").stop();
    $(".each-content .progress .progress-bar").width(0);
  }

  function changeTab() {
    const activeImage = $(".each-content.active");
    const nextImage = activeImage.next(".each-content").length ? activeImage.next(".each-content") : $(".each-content").first();
    activeImage.removeClass("active");
    nextImage.addClass("active");
    const activeCount = activeImage.data("count");
    const nextCount = nextImage.data("count");
    $(".single-tab-" + activeCount).removeClass("active");
    $(".single-tab-" + nextCount).addClass("active");
    progressBarAnimation();
  }

  function progressBarAnimation() {
    $(".each-content.active .progress .progress-bar").width(0);
    $(".each-content.active .progress .progress-bar").animate(
      {
        width: "100%",
      },
      animationDuration
    );
  }
});
