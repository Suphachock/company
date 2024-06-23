$(document).ready(function () {
  manageWeb();
});
// ----------------------- ส่วนของจัดการเว็บทั้งหมด -------------------------
function manageWeb() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/manage_web.php",
    dataType: "html",
    success: function (res) {
      $(".body_content").html(res);
    },
  });
}
function show_md_website_add() {
  $.ajax({
    type: "POST",
    url: "../view/md_add_website.php",
    dataType: "html",
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_add_website").modal("show");
    },
  });
}
function delete_web(id, web_img) {
  $.ajax({
    type: "POST",
    url: "../model/delete_website.php",
    data: { id, web_img },
    success: function (res) {
      if (res === "success") {
        manageWeb();
      } else {
        alert("Failed to delete website!");
      }
    },
  });
}
function md_edit_web(id) {
  $.ajax({
    type: "POST",
    url: "../view/md_edit_website.php",
    data: { id },
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_edit_website").modal("show");
    },
  });
}
// ----------------------- ส่วนของจัดการเบอร์โทรภายในบริษัท SR&SK -------------------------
function manageTel() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/manage_tel.php",
    dataType: "html",
    success: function (res) {
      $(".body_content").html(res);
    },
  });
}
function show_md_tel_add() {
  $.ajax({
    type: "POST",
    url: "../view/md_add_tel.php",
    dataType: "html",
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_add_tel").modal("show");
    },
  });
}
function delete_tel(id, tel_pic) {
  $.ajax({
    type: "POST",
    url: "../model/delete_tel.php",
    data: { id, tel_pic },
    success: function (res) {
      if (res === "success") {
        manageTel();
      } else {
        alert("Failed to delete tel!");
      }
    },
  });
}
// ----------------------- ส่วนของจัดการVDO คู่มือการใช้งานต่างๆ -------------------------
function manageVdo() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/manage_vdo.php",
    dataType: "html",
    success: function (res) {
      $(".body_content").html(res);
    },
  });
}
function show_table_vdo_category() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/table_vdo_category.php",
    dataType: "html",
    success: function (res) {
      $(".vdo_category_data").html(res);
    },
  });
}
function show_md_vdo_add() {
  $.ajax({
    type: "POST",
    url: "../view/md_add_vdo.php",
    dataType: "html",
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_add_vdo").modal("show");
    },
  });
}
function show_md_vdo_category() {
  $.ajax({
    type: "POST",
    url: "../view/md_add_vdo_category.php",
    dataType: "html",
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_vdo_category").modal("show");
    },
  });
}
function add_vdo_category() {
  var vdo_category = $(".vdo_category").val();
  $.ajax({
    type: "POST",
    url: "../model/add_vdo_category.php",
    data: { vdo_category: vdo_category }, // The form data
    success: function (res) {
      if (res === "success") {
        $(".vdo_category").val("");
        show_table_vdo_category();
      } else {
        alert(res);
      }
    },
  });
}
function delete_vdo(id, vdo_path) {
  $.ajax({
    type: "POST",
    url: "../model/delete_vdo.php",
    data: { id, vdo_path },
    success: function (res) {
      let response = JSON.parse(res);
      if (response.status === "success") {
        manageVdo();
      } else {
        alert(response.message);
      }
    },
  });
}
function delete_vdo_category(id) {
  $.ajax({
    type: "POST",
    url: "../model/delete_vdo_category.php",
    data: { id },
    success: function (res) {
      if (res === "success") {
        show_table_vdo_category();
      } else {
        alert("หมวดหมู่วิดิโอนี้ถูกใช้งานอยู่!");
      }
    },
  });
}
function edit_vdo(id) {
  $.ajax({
    type: "POST",
    url: "../view/md_edit_vdo.php",
    data: { id },
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_edit_vdo").modal("show");
    },
  });
}
function edit_vdo_category(id) {
  $.ajax({
    type: "POST",
    url: "../view/md_edit_vdo_category.php",
    data: { id },
    success: function (res) {
      $(".modal_edit_vdeo_category").html(res);
      $("#md_edit_vdo_category").modal("show");
    },
  });
}
function delete_video_file(vdo_path, id) {
  $.ajax({
    type: "POST",
    url: "../model/delete_video_file.php",
    data: { vdo_path, id },
    success: function (res) {
      let response = JSON.parse(res);
      if (response.status === "success") {
        show_video_file(id);
      } else {
        alert(response.message);
      }
    },
  });
}
function show_video_file(id) {
  $.ajax({
    type: "POST",
    url: "/TEST/view/show_video_file.php",
    data: { id },
    dataType: "html",
    success: function (res) {
      $(".show_video_file").html(res);
    },
  });
}
// ----------------------- ส่วนของการจัดการวันหยุดบริษัท -------------------------
function manageHoliday() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/manage_holiday.php",
    dataType: "html",
    success: function (res) {
      $(".body_content").html(res);
    },
  });
}
function show_md_holiday_add() {
  $.ajax({
    type: "POST",
    url: "../view/md_add_holiday.php",
    dataType: "html",
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_add_holiday").modal("show");
    },
  });
}
function delete_holiday(id, holiday_img) {
  $.ajax({
    type: "POST",
    url: "../model/delete_holiday.php",
    data: { id, holiday_img },
    success: function (res) {
      if (res === "success") {
        manageHoliday();
      } else {
        alert("Failed to delete Holiday!");
      }
    },
  });
}
function update_status(id, status) {
  $.ajax({
    type: "POST",
    url: "../model/update_status_holiday.php",
    data: { id, status },
    success: function (res) {
      if (res === "success") {
        manageHoliday();
      } else {
        alert("Failed to delete Holiday!");
      }
    },
  });
}

// ----------------------- ส่วนของการจัดการกิจกรรมบริษัท -------------------------
function manageEvent() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/manage_event.php",
    dataType: "html",
    success: function (res) {
      $(".body_content").html(res);
    },
  });
}
function show_md_event_category() {
  $.ajax({
    type: "POST",
    url: "../view/md_add_event_category.php",
    dataType: "html",
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_event_category").modal("show");
    },
  });
}
function show_table_event_category() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/table_event_category.php",
    dataType: "html",
    success: function (res) {
      $(".event_category_data").html(res);
    },
  });
}
function add_event_category() {
  var event_category = $(".event_category").val();
  $.ajax({
    type: "POST",
    url: "../model/add_event_category.php",
    data: { event_category: event_category }, // The form data
    success: function (res) {
      if (res === "success") {
        $(".event_category").val("");
        show_table_event_category();
      } else {
        alert(res);
      }
    },
  });
}
function delete_event_category(id) {
  $.ajax({
    type: "POST",
    url: "../model/delete_event_category.php",
    data: { id },
    success: function (res) {
      if (res === "success") {
        show_table_event_category();
      } else {
        alert("หมวดหมู่อีเว้นท์นี้ถูกใช้งานอยู่!");
      }
    },
  });
}
function show_md_event_add() {
  $.ajax({
    type: "POST",
    url: "../view/md_add_event.php",
    dataType: "html",
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_add_event").modal("show");
    },
  });
}
function delete_event(id) {
  $.ajax({
    type: "POST",
    url: "../model/delete_event.php",
    data: { id },
    success: function (res) {
      let response = JSON.parse(res);
      if (response.status === "success") {
        manageEvent();
      } else {
        alert(response.message);
      }
    },
  });
}
function edit_event(id) {
  $.ajax({
    type: "POST",
    url: "../view/md_edit_event.php",
    data: { id },
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_edit_event").modal("show");
    },
  });
}
function edit_event_category(id) {
  $.ajax({
    type: "POST",
    url: "../view/md_edit_event_category.php",
    data: { id },
    success: function (res) {
      $(".modal_edit_event_category").html(res);
      $("#md_edit_event_category").modal("show");
    },
  });
}
// ----------------------- ส่วนของการจัดการสมาชิก -------------------------
function manageUser() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/manage_user.php",
    dataType: "html",
    success: function (res) {
      $(".body_content").html(res);
    },
  });
}
function show_md_user_add() {
  $.ajax({
    type: "POST",
    url: "../view/md_add_user.php",
    dataType: "html",
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_add_user").modal("show");
    },
  });
}
function show_md_department() {
  $.ajax({
    type: "POST",
    url: "../view/md_add_department.php",
    dataType: "html",
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_department").modal("show");
    },
  });
}
function show_table_department() {
  $.ajax({
    type: "POST",
    url: "/TEST/view/table_department.php",
    dataType: "html",
    success: function (res) {
      $(".table_department").html(res);
    },
  });
}
function add_department() {
  var department = $(".department").val();
  $.ajax({
    type: "POST",
    url: "../model/add_department.php",
    data: { department }, // The form data
    success: function (res) {
      if (res === "success") {
        $(".department").val("");
        show_table_department();
      } else {
        alert(res);
      }
    },
  });
}
function delete_department(id) {
  $.ajax({
    type: "POST",
    url: "../model/delete_department.php",
    data: { id },
    success: function (res) {
      let response = JSON.parse(res);
      if (response.status == "success") {
        show_table_department();
      } else {
        alert(response.message);
      }
    },
  });
}
function delete_user(id) {
  $.ajax({
    type: "POST",
    url: "../model/delete_user.php",
    data: { id },
    success: function (res) {
      let response = JSON.parse(res);
      if (response.status === "success") {
        manageUser();
      } else {
        alert(response.message);
      }
    },
  });
}
function edit_user(id) {
  $.ajax({
    type: "POST",
    url: "../view/md_edit_user.php",
    data: { id },
    success: function (res) {
      $(".modal_show").html(res);
      $("#md_edit_user").modal("show");
    },
  });
}
function edit_department(id) {
  $.ajax({
    type: "POST",
    url: "../view/md_edit_department.php",
    data: { id },
    success: function (res) {
      $(".modal_edit_dept").html(res);
      $("#md_edit_department").modal("show");
    },
  });
}
