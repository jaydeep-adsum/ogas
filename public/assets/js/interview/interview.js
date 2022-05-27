/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./resources/assets/js/interview/interview.js ***!
  \****************************************************/
$(document).ready(function () {
  var tableName = '#interviewTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: interviewUrl
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
      data: 'question',
      name: 'question'
    }, {
      data: function data(row) {
        return moment(row.created_at, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
      },
      name: 'created_at'
    }, {
      data: function data(row) {
        var url = interviewUrl + '/' + row.id;
        return "<a title=\"Edit\" class=\"btn btn-sm edit-btn\" data-id=\"".concat(row.id, "\" href=\"#\">\n            <i class=\"fa fa-edit\"></i>\n                </a>  <a title=\"Delete\" class=\"btn btn-sm delete-btn\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.addInterviewModal', function () {
    $('#addInterviewModal').appendTo('body').modal('show');
  });
  $(document).on('submit', '#addInterviewForm', function (e) {
    e.preventDefault();

    if ($('#question').val() == "") {
      displayErrorMessage('Question field is required.');
      return false;
    }

    if ($('#answer').val() == "") {
      displayErrorMessage('Answer field is required.');
      return false;
    }

    $.ajax({
      url: interviewSaveUrl,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addInterviewModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.edit-btn', function (event) {
    var interviewId = $(event.currentTarget).attr('data-id');
    renderData(interviewId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: interviewUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          $('#editQuestion').val(result.data.question);
          CKEDITOR.instances['editAnswer'].setData(result.data.answer);
          $('#interviewId').val(result.data.id);
          $('#editInterviewModal').appendTo('body').modal('show');
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  };

  $(document).on('submit', '#editInterviewForm', function (e) {
    e.preventDefault();

    if ($('#editQuestion').val() == "") {
      displayErrorMessage('Question field is required.');
      return false;
    }

    if ($('#editAnswer').val() == "") {
      displayErrorMessage('Answer field is required.');
      return false;
    }

    $.ajax({
      url: interviewUrl + '/update',
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#editInterviewModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.delete-btn', function (event) {
    var interviewId = $(event.currentTarget).attr('data-id');
    deleteItem(interviewUrl + '/' + interviewId, tableName, 'Interview');
  });
  $('#addInterviewModal').on('hidden.bs.modal', function () {
    CKEDITOR.instances['answer'].setData('');
    $('#addInterviewForm')[0].reset();
  });
});
/******/ })()
;