function getWebsite() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/all_website.php",
    dataType: "html",
    success: function (res) {
      $(".body_content").html(res);
    },
  });
}
function getTel() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/tel.php",
    dataType: "html",
    success: function (res) {
      $(".body_content").html(res);
    },
  });
}
function getVDO() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/vdo_guide.php",
    dataType: "html",
    success: function (res) {
      $(".body_content").html(res);
    },
  });
}
function getCalendar() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/calendar_holiday.php",
    dataType: "html",
    success: function (res) {
      $(".body_content").html(res);
    },
  });
}
function getEvent() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/event.php",
    dataType: "html",
    success: function (res) {
      $(".body_content").html(res);
    },
  });
}
function getEventdetail(id) {
  $.ajax({
    type: "GET",
    url: "/TEST/view/event_detail.php",
    data: { id },
    dataType: "html",
    success: function (res) {
      $(".body_content").html(res);
    },
  });
}
