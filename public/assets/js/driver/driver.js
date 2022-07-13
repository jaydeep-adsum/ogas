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
      'targets': [6],
      'className': 'text-center',
      'orderable': false
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
        if (row.status == null) {
          return "-";
        } else {
          return "<span class=\"badge badge-".concat(row.status == 1 ? 'success' : 'danger', "\">").concat(row.status == 1 ? 'Accepted' : 'Rejected', "</span>");
        }
      },
      name: 'status'
    }, {
      data: function data(row) {
        if (row.status == null) {
          return "<a href=\"#\" class=\"btn btn-sm bg-success text-white accept\" data-id=\"".concat(row.id, "\" title=\"Accept !\">\n           <i class=\"fa-solid fa-thumbs-up\"></i>\n                </a>    <a title=\"Reject !\" class=\"btn btn-sm bg-danger text-white reject\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-thumbs-down\"></i>\n                </a>    <a title=\"Delete\" class=\"btn btn-sm delete-btn text-white\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
        } else {
          return "<a title=\"Delete\" class=\"btn btn-sm delete-btn text-white\" data-id=\"".concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
        }
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.delete-btn', function (event) {
    var driverId = $(event.currentTarget).attr('data-id');
    deleteItem(driverUrl + '/' + driverId, tableName, 'Driver');
  });
  $(document).on('click', '.accept', function (event) {
    var driverId = $(event.currentTarget).attr('data-id');
    swal({
      title: 'Accept !',
      text: 'Are You Sure Want To Accept Driver Request ?',
      type: 'info',
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
      confirmButtonColor: '#1c75bc',
      cancelButtonColor: '#f58823',
      cancelButtonText: 'No',
      confirmButtonText: 'Yes'
    }, function () {
      $.ajax({
        url: driverUrl + '/' + driverId + '/accept',
        type: 'get',
        dataType: 'json',
        success: function success(obj) {
          if (obj.success) {
            $(tableName).DataTable().ajax.reload(null, false);
          }

          swal({
            title: 'Status !',
            text: 'Driver Status Has Been Changed',
            type: 'success',
            confirmButtonColor: '#1c75bc',
            timer: 1000
          });

          if (callFunction) {
            eval(callFunction);
          }
        },
        error: function error(data) {
          swal({
            title: '',
            text: data.responseJSON.message,
            type: 'error',
            confirmButtonColor: '#1c75bc',
            timer: 5000
          });
        }
      });
    });
  });
  $(document).on('click', '.reject', function (event) {
    var driverId = $(event.currentTarget).attr('data-id');
    swal({
      title: 'Accept !',
      text: 'Are You Sure Want To Reject Driver Request ?',
      type: 'info',
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
      confirmButtonColor: '#1c75bc',
      cancelButtonColor: '#f58823',
      cancelButtonText: 'No',
      confirmButtonText: 'Yes'
    }, function () {
      $.ajax({
        url: driverUrl + '/' + driverId + '/reject',
        type: 'get',
        dataType: 'json',
        success: function success(obj) {
          if (obj.success) {
            $(tableName).DataTable().ajax.reload(null, false);
          }

          swal({
            title: 'Status !',
            text: 'Driver Status Has Been Changed',
            type: 'success',
            confirmButtonColor: '#1c75bc',
            timer: 1000
          });

          if (callFunction) {
            eval(callFunction);
          }
        },
        error: function error(data) {
          swal({
            title: '',
            text: data.responseJSON.message,
            type: 'error',
            confirmButtonColor: '#1c75bc',
            timer: 5000
          });
        }
      });
    });
  });
});
/******/ })()
;