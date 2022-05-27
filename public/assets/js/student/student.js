/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./resources/assets/js/student/student.js ***!
  \************************************************/
$(document).ready(function () {
  var tableName = '#studentTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: studentUrl
    },
    columnDefs: [{
      'targets': [7],
      'className': 'text-center',
      'orderable': false,
      'width': '8%'
    }],
    columns: [{
      data: function data(row) {
        return "<div class=\"d-flex align-items-center\">\n                            <div class=\"mr-2\">\n                        <div class=\"\"><img src=\"".concat(row.image_url, "\" alt=\"\" class=\"user-img rounded-circle\" height=\"30px\" width=\"30px\"></div></div>\n                        <div class=\"d-flex flex-column\">").concat(row.first_name, " ").concat(row.last_name, "</a><span>").concat(row.email, "</span>\n                        </div></div>");
      },
      name: 'first_name'
    }, {
      data: 'student_id',
      name: 'student_id'
    }, {
      data: 'mobile_no',
      name: 'mobile_no'
    }, {
      data: function data(row) {
        return row.institute.institute;
      },
      name: 'institute_id'
    }, {
      data: function data(row) {
        return row.department.department;
      },
      name: 'department_id'
    }, {
      data: function data(row) {
        return row.year.year;
      },
      name: 'year_id'
    }, {
      data: function data(row) {
        return row.semester.semester;
      },
      name: 'semester_id'
    }, {
      data: function data(row) {
        var url = studentUrl + '/' + row.id;
        return "<a title=\"Edit\" class=\"btn btn-sm edit-btn\" data-id=\"".concat(row.id, "\" href=\"").concat(url, "/edit\">\n            <i class=\"fa fa-edit\"></i>\n                </a>  <a title=\"Delete\" class=\"btn btn-sm delete-btn text-white\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.delete-btn', function (event) {
    var studentId = $(event.currentTarget).attr('data-id');
    deleteItem(studentUrl + '/' + studentId, tableName, 'Student');
  });
});
/******/ })()
;