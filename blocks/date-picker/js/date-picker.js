jQuery(document).ready(function ($) {
  $("#date-input").datepicker({ dateFormat: "DD, dd MM yy", defaultDate: 0 });
  var weekday = new Array(7);
  weekday[0] = "Sunday";
  weekday[1] = "Monday";
  weekday[2] = "Tuesday";
  weekday[3] = "Wednesday";
  weekday[4] = "Thursday";
  weekday[5] = "Friday";
  weekday[6] = "Saturday";
  $("#date-input").change(function () {
    var date = new Date($("#date-input").val());
    var dayname = weekday[date.getDay()];
    $(".block-date-picker .warning").removeClass("active");
    $(".block-date-picker .content-wrapper").removeClass("active");
    $(".block-date-picker .warning." + dayname).addClass("active");
    $(".block-date-picker .content-wrapper." + dayname).addClass("active");
  });

  function maal() {
    const date = new Date();
    const weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const dayOfWeek = weekdays[date.getDay()];
    const dayOfMonth = String(date.getDate()).padStart(2, "0");
    const month = months[date.getMonth()];
    const year = String(date.getFullYear());
    const formattedDate = `${dayOfWeek}, ${dayOfMonth} ${month} ${year}`;
    $("#date-input").val(formattedDate);
    var dayname = weekday[date.getDay()];
    $(".block-date-picker .warning").removeClass("active");
    $(".block-date-picker .content-wrapper").removeClass("active");
    $(".block-date-picker .warning." + dayname).addClass("active");
    $(".block-date-picker .content-wrapper." + dayname).addClass("active");
  }
  maal();
});
