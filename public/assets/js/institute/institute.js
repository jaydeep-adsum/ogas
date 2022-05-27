/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./resources/assets/js/institute/institute.js ***!
  \****************************************************/
$(document).ready(function () {
  var tableName = '#instituteTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: instituteUrl
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
      data: 'institute',
      name: 'institute'
    }, {
      data: function data(row) {
        return moment(row.created_at, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
      },
      name: 'created_at'
    }, {
      data: function data(row) {
        return "<a title=\"Edit\" class=\"btn btn-sm edit-btn\" data-id=\"".concat(row.id, "\" href=\"#\">\n            <i class=\"fa fa-edit\"></i>\n                </a>  <a title=\"Delete\" class=\"btn btn-sm delete-btn\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.addInstituteModal', function () {
    $('#addInstituteModal').appendTo('body').modal('show');
  });
  $(document).on('submit', '#addInstituteForm', function (e) {
    e.preventDefault();

    if ($('#institute').val() == "") {
      displayErrorMessage('Institute Name field is required.');
      return false;
    }

    $.ajax({
      url: instituteSaveUrl,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addInstituteModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.edit-btn', function (event) {
    var instituteId = $(event.currentTarget).attr('data-id');
    renderData(instituteId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: instituteUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          $('#editInstitute').val(result.data.institute);
          $('#instituteId').val(result.data.id);
          $('#editInstituteModal').appendTo('body').modal('show');
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  };

  $(document).on('submit', '#editInstituteForm', function (e) {
    e.preventDefault();

    if ($('#editInstitute').val() == "") {
      displayErrorMessage('Institute field is required.');
      return false;
    }

    $.ajax({
      url: instituteUrl + '/update',
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#editInstituteModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.delete-btn', function (event) {
    var instituteId = $(event.currentTarget).attr('data-id');
    deleteItem(instituteUrl + '/' + instituteId, tableName, 'Institute');
  });
  $('#addInstituteModal').on('hidden.bs.modal', function () {
    $('#addInstituteForm')[0].reset();
  });
});
/******/ })()
;