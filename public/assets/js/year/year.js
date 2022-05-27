/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./resources/assets/js/year/year.js ***!
  \******************************************/
$(document).ready(function () {
  var tableName = '#yearTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: yearUrl
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
      data: 'year',
      name: 'year'
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
  $(document).on('click', '.addYearModal', function () {
    $('#addYearModal').appendTo('body').modal('show');
  });
  $(document).on('submit', '#addYearForm', function (e) {
    e.preventDefault();

    if ($('#year').val() == "") {
      displayErrorMessage('Year field is required.');
      return false;
    }

    $.ajax({
      url: yearSaveUrl,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addYearModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.edit-btn', function (event) {
    var yearId = $(event.currentTarget).attr('data-id');
    renderData(yearId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: yearUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          $('#editYear').val(result.data.year);
          $('#yearId').val(result.data.id);
          $('#editYearModal').appendTo('body').modal('show');
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  };

  $(document).on('submit', '#editYearForm', function (e) {
    e.preventDefault();

    if ($('#editYear').val() == "") {
      displayErrorMessage('Year field is required.');
      return false;
    }

    var id = $('#yearId').val();
    $.ajax({
      url: yearUrl + '/' + id,
      type: 'PUT',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#editYearModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.delete-btn', function (event) {
    var yearId = $(event.currentTarget).attr('data-id');
    deleteItem(yearUrl + '/' + yearId, tableName, 'Year');
  });
  $('#addYearModal').on('hidden.bs.modal', function () {
    $('#addYearForm')[0].reset();
  });
});
/******/ })()
;