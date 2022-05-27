/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************************!*\
  !*** ./resources/assets/js/question/question.js ***!
  \**************************************************/
$(document).ready(function () {
  var tableName = '#questionTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: questionUrl
    },
    columns: [{
      data: 'id',
      name: 'id'
    }, {
      data: 'category',
      name: 'category'
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
  $(document).on('click', '.addQuestionModal', function () {
    $('#addQuestionModal').appendTo('body').modal('show');
  });
  $(document).on('submit', '#addQuestionForm', function (e) {
    e.preventDefault();

    if ($('#category').val() == "") {
      displayErrorMessage('Category field is required.');
      return false;
    }

    if ($('#response').val() == "") {
      displayErrorMessage('Response field is required.');
      return false;
    }

    $.ajax({
      url: questionSaveUrl,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addQuestionModal').modal('hide');
          $("#response-div").load(" #response-div > *");
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.edit-btn', function (event) {
    var questionId = $(event.currentTarget).attr('data-id');
    renderData(questionId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: questionUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          $('#editCategory').val(result.data.category);
          CKEDITOR.instances['editResponse'].setData(result.data.response);
          $('#questionId').val(result.data.id);
          $('#editQuestionModal').appendTo('body').modal('show');
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  };

  $(document).on('submit', '#editQuestionForm', function (e) {
    e.preventDefault();

    if ($('#editCategory').val() == "") {
      displayErrorMessage('Category field is required.');
      return false;
    }

    if ($('#editResponse').val() == "") {
      displayErrorMessage('Response field is required.');
      return false;
    }

    $.ajax({
      url: questionUrl + '/update',
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#editQuestionModal').modal('hide');
          $("#response-div").load(" #response-div > *");
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.delete-btn', function (event) {
    var questionId = $(event.currentTarget).attr('data-id');
    swal({
      title: 'Delete !',
      text: 'Are You Sure Want To Delete "Response" ?',
      type: 'warning',
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
      confirmButtonColor: '#1e4080',
      cancelButtonColor: '#d94b09',
      cancelButtonText: 'No',
      confirmButtonText: 'Yes'
    }, function () {
      $.ajax({
        url: questionUrl + '/' + questionId,
        type: 'DELETE',
        dataType: 'json',
        success: function success(obj) {
          if (obj.success) {
            $("#response-div").load(" #response-div > *");
          }

          swal({
            title: 'Deleted !',
            text: 'Response Has Been Deleted',
            type: 'success',
            confirmButtonColor: '#1e4080',
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
            confirmButtonColor: '#1e4080',
            timer: 5000
          });
        }
      });
    });
  });
  $('#addQuestionModal').on('hidden.bs.modal', function () {
    CKEDITOR.instances['response'].setData('');
    $('#addQuestionForm')[0].reset();
  });
});
/******/ })()
;