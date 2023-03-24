import dateFormat from "dateformat/lib/dateformat.js";

jQuery(document).ready(function ($) {
  const $date = $(".c-date__time");

  if (!$date) {
    return;
  }

  let timeDate = () => {
    let now = new Date();
    let currentTime = dateFormat(now, "dddd dS mmmm, H:MM:ss");
    $date.text(currentTime);
    setTimeout(timeDate, 1000);
  };

  timeDate();
});
