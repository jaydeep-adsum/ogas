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
      data: 'payment_customer_id',
      name: 'payment_customer_id'
    }, {
      data: function data(row) {
        return moment(row.created_at, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
      },
      name: 'created_at'
    }, {
      data: function data(row) {
        return "<a title=\"Edit\" class=\"btn btn-sm edit-btn\" data-id=\"".concat(row.id, "\" href=\"#\">\n            <i class=\"fa fa-edit\"></i>\n                </a>  <a title=\"Delete\" class=\"btn btn-sm delete-btn text-white\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.edit-btn', function (event) {
    var customerId = $(event.currentTarget).attr('data-id');
    renderData(customerId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: customerUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          $('#editName').val(result.data.name);
          $('#editMobile').val(result.data.mobile);
          $('#editEmail').val(result.data.email);
          $('#editCustomerId').val(result.data.payment_customer_id);
          $('#editAddress').val(result.data.address);
          $('#customerId').val(result.data.id);
          $('#editModal').appendTo('body').modal('show');
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  };

  $(document).on('submit', '#editForm', function (e) {
    e.preventDefault();
    var id = $('#customerId').val();
    $.ajax({
      url: customerUrl + '/' + id,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#editModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.delete-btn', function (event) {
    var customerId = $(event.currentTarget).attr('data-id');
    deleteItem(customerUrl + '/' + customerId, tableName, 'Customer');
  });
});
/******/ })()
;