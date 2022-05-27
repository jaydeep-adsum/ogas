/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************************!*\
  !*** ./resources/assets/js/textbooks/textbook.js ***!
  \***************************************************/
$(document).ready(function () {
  var tableName = '#textBookTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    // language: {
    //     processing: `<img src='${loaderUrl}'>`,
    // },
    ajax: {
      url: textBooksUrl
    },
    columnDefs: [{
      'targets': [0],
      'orderable': false
    }, {
      'targets': [7],
      'className': 'text-center',
      'orderable': false,
      'width': '8%'
    }],
    columns: [{
      data: function data(row) {
        return "<div class=\"d-flex align-items-center\">\n                            <div class=\"mr-2\">\n                        <div class=\"\"><img src=\"".concat(row.image_url, "\" alt=\"\" class=\"user-img rounded-circle\" height=\"30px\" width=\"30px\"></div></div>\n                        </div>");
      },
      name: 'id'
    }, {
      data: 'title',
      name: 'title'
    }, {
      data: 'written_by',
      name: 'written_by'
    }, {
      data: function data(row) {
        return row.year.year;
      },
      name: 'year_id'
    }, {
      data: function data(row) {
        return row.department.department;
      },
      name: 'department_id'
    }, {
      data: function data(row) {
        var pdf = 'N/A';

        if (row.pdf_url) {
          pdf = "<a title=\"Download\" class=\"btn btn-sm edit-btn\" href=\"".concat(row.pdf_url, "\" download>\n                        <i class=\"fa-solid fa-download\"></i>\n                </a>");
        }

        return pdf;
      },
      name: 'id'
    }, {
      data: function data(row) {
        return moment(row.created_at, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
      },
      name: 'created_at'
    }, {
      data: function data(row) {
        var url = textBooksUrl + '/' + row.id;
        return "<a title=\"Edit\" class=\"btn btn-sm edit-btn\" data-id=\"".concat(row.id, "\" href=\"").concat(url, "/edit\">\n            <i class=\"fa fa-edit\"></i>\n                </a>  <a title=\"Delete\" class=\"btn btn-sm delete-btn\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.delete-btn', function (event) {
    var textBookId = $(event.currentTarget).attr('data-id');
    deleteItem(textBooksUrl + '/' + textBookId, tableName, 'Text Book');
  });
});
/******/ })()
;