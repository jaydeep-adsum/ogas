/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/assets/js/driver/driver.js ***!
  \**********************************************/
$(document).ready(function () {
  var tableName = '#driverTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: driverUrl
    },
    columnDefs: [{
      'targets': [5],
      'className': 'text-center',
      'orderable': false,
      'width': '8%'
    }],
    columns: [{
      data: 'name',
      name: 'name'
    }, {
      data: 'mobile',
      name: 'mobile'
    }, {
      data: 'email',
      name: 'email'
    }, {
      data: 'licence_no',
      name: 'licence_no'
    }, {
      data: 'vehicle_no',
      name: 'vehicle_no'
    }, {
      data: function data(row) {
        return "<a title=\"Delete\" class=\"btn btn-sm delete-btn text-white\" data-id=\"".concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.delete-btn', function (event) {
    var driverId = $(event.currentTarget).attr('data-id');
    deleteItem(driverUrl + '/' + driverId, tableName, 'Driver');
  });
});
/******/ })()
;