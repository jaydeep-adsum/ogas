/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************************!*\
  !*** ./resources/assets/js/category/category.js ***!
  \**************************************************/
$(document).ready(function () {
  var tableName = '#categoryTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: categoryUrl
    },
    columnDefs: [{
      'targets': [3],
      'orderable': false,
      'width': '8%'
    }],
    columns: [{
      data: 'id',
      name: 'id'
    }, {
      data: 'name',
      name: 'name'
    }, {
      data: function data(row) {
        return moment(row.created_at, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
      },
      name: 'created_at'
    }, {
      data: function data(row) {
        var url = categoryUrl + '/' + row.id;
        return "<a title=\"Edit\" class=\"btn btn-sm edit-btn\" data-id=\"".concat(row.id, "\" href=\"").concat(url, "/edit\">\n            <i class=\"fa fa-edit\"></i>\n                </a>  <a title=\"Delete\" class=\"btn btn-sm delete-btn\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.delete-btn', function (event) {
    var categoryId = $(event.currentTarget).attr('data-id');
    deleteItem(categoryUrl + '/' + categoryId, tableName, 'Category');
  });
});
/******/ })()
;