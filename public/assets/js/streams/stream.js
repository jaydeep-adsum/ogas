/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************************!*\
  !*** ./resources/assets/js/streams/stream.js ***!
  \***********************************************/
$(document).ready(function () {
  var tableName = '#streamTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: streamUrl
    },
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
        return "<a title=\"Edit\" class=\"btn btn-sm edit-btn\" data-id=\"".concat(row.id, "\" href=\"#\">\n            <i class=\"fa fa-edit\"></i>\n                </a>  <a title=\"Delete\" class=\"btn btn-sm delete-btn\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.addStreamModal', function () {
    $('#addStreamModal').appendTo('body').modal('show');
  });
  $(document).on('submit', '#addStreamForm', function (e) {
    e.preventDefault();

    if ($('#stream').val() == "") {
      displayErrorMessage('Stream Name field is required.');
      return false;
    }

    $.ajax({
      url: streamSaveUrl,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addStreamModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.edit-btn', function (event) {
    var streamId = $(event.currentTarget).attr('data-id');
    renderData(streamId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: streamUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          $('#editStream').val(result.data.name);
          $('#streamId').val(result.data.id);
          $('#editStreamModal').appendTo('body').modal('show');
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  };

  $(document).on('submit', '#editStreamForm', function (e) {
    e.preventDefault();

    if ($('#editStream').val() == "") {
      displayErrorMessage('Stream Name field is required.');
      return false;
    }

    $.ajax({
      url: streamUrl + '/update',
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#editStreamModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.delete-btn', function (event) {
    var streamId = $(event.currentTarget).attr('data-id');
    deleteItem(streamUrl + '/' + streamId, tableName, 'Stream');
  });
  $('#addStreamModal').on('hidden.bs.modal', function () {
    $('#addStreamForm')[0].reset();
  });
});
/******/ })()
;