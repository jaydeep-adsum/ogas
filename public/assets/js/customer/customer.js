/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************************!*\
  !*** ./resources/assets/js/customer/customer.js ***!
  \**************************************************/
$(document).ready(function () {
  var tableName = '#customerTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: customerUrl
    },
    columnDefs: [{
      'targets': [3],
      'className': 'text-center',
      'orderable': false,
      'width': '8%'
    }],
    columns: [{
      data: function data(row) {
        return "<div class=\"d-flex align-items-center\">\n                            <div class=\"mr-2\">\n                        <div class=\"\"><img src=\"".concat(row.image_url, "\" alt=\"\" class=\"user-img rounded-circle\" height=\"30px\" width=\"30px\"></div></div>\n                        <div class=\"d-flex flex-column\">").concat(row.name, "\n                        </div></div>");
      },
      name: 'name'
    }, {
      data: 'mobile',
      name: 'mobile'
    }, {
      data: function data(row) {
        return moment(row.created_at, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
      },
      name: 'created_at'
    }, {
      data: function data(row) {
        return "<a title=\"Delete\" class=\"btn btn-sm delete-btn text-white\" data-id=\"".concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.delete-btn', function (event) {
    var customerId = $(event.currentTarget).attr('data-id');
    deleteItem(customerUrl + '/' + customerId, tableName, 'Customer');
  });
});
/******/ })()
;