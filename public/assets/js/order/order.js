/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/assets/js/order/order.js ***!
  \********************************************/
$(document).ready(function () {
  var tableName = '#orderTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: orderUrl
    },
    columnDefs: [{
      'targets': [5],
      'className': 'text-center',
      'orderable': false,
      'width': '8%'
    }],
    columns: [{
      data: 'id',
      name: 'id'
    }, {
      data: function data(row) {
        return row.customer.name;
      },
      name: 'customer_id'
    }, {
      data: 'location',
      name: 'location'
    }, {
      data: function data(row) {
        return moment(row.date, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
      },
      name: 'date'
    }, {
      data: 'total',
      name: 'total'
    }, {
      data: function data(row) {
        var url = orderUrl + '/' + row.id;
        return "<a title=\"Show\" class=\"btn btn-sm edit-btn\" data-id=\"".concat(row.id, "\" href=\"").concat(url, "\">\n            <i class=\"fa-solid fa-eye\"></i>\n                </a> <a title=\"Delete\" class=\"btn btn-sm delete-btn text-white\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.delete-btn', function (event) {
    var orderId = $(event.currentTarget).attr('data-id');
    deleteItem(orderUrl + '/' + orderId, tableName, 'Order');
  });
});
/******/ })()
;