jQuery(document).ready(function ($) {
  function updateTab(tabIndex) {
    $(".academy-tab-section .tab").removeClass("active");
    $(".academy-tab-content .tab-pane").removeClass("active");

    $('.academy-tab-section .tab[data-tab-index="' + tabIndex + '"]').addClass(
      "active"
    );
    $(
      '.academy-tab-content .tab-pane[data-tab-index="' + tabIndex + '"]'
    ).addClass("active");

    $("#academy-tab-select").val(tabIndex); // Update select dropdown
  }

  $(".academy-tab-section .tab").on("click", function () {
    var tabIndex = $(this).data("tab-index");
    updateTab(tabIndex);
  });

  $("#academy-tab-select").on("change", function () {
    var tabIndex = $(this).val();
    updateTab(tabIndex);
  });

  $("#academy-next-button").on("click", function () {
    var currentIndex = parseInt(
      $(".academy-tab-section .tab.active").data("tab-index")
    );
    var nextIndex = currentIndex + 1;
    if (nextIndex >= $(".academy-tab-section .tab").length) {
      nextIndex = 0; // Loop back to the first tab
    }
    updateTab(nextIndex);
  });

  $("#academy-prev-button").on("click", function () {
    var currentIndex = parseInt(
      $(".academy-tab-section .tab.active").data("tab-index")
    );
    var prevIndex = currentIndex - 1;
    if (prevIndex < 0) {
      prevIndex = $(".academy-tab-section .tab").length - 1; // Loop back to the last tab
    }
    updateTab(prevIndex);
  });

  // Initialize
  $(".academy-tab-section .tab").first().addClass("active");
  $(".academy-tab-content .tab-pane").first().addClass("active");
  $("#academy-tab-select").val(0); // Set default value for the select dropdown
});
