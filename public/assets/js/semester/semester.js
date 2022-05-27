/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************************!*\
  !*** ./resources/assets/js/semester/semester.js ***!
  \**************************************************/
$(document).ready(function () {
  var tableName = '#semesterTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: semesterUrl
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
      data: 'semester',
      name: 'semester'
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
  $(document).on('click', '.addSemesterModal', function () {
    $('#addSemesterModal').appendTo('body').modal('show');
  });
  $(document).on('submit', '#addSemesterForm', function (e) {
    e.preventDefault();

    if ($('#semester').val() == "") {
      displayErrorMessage('Semester Name field is required.');
      return false;
    }

    $.ajax({
      url: semesterSaveUrl,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addSemesterModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.edit-btn', function (event) {
    var semesterId = $(event.currentTarget).attr('data-id');
    renderData(semesterId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: semesterUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          $('#editSemester').val(result.data.semester);
          $('#semesterId').val(result.data.id);
          $('#editSemesterModal').appendTo('body').modal('show');
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  };

  $(document).on('submit', '#editSemesterForm', function (e) {
    e.preventDefault();

    if ($('#editSemester').val() == "") {
      displayErrorMessage('Semester field is required.');
      return false;
    }

    var id = $('#semesterId').val();
    $.ajax({
      url: semesterUrl + '/' + id,
      type: 'PUT',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#editSemesterModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.delete-btn', function (event) {
    var semesterId = $(event.currentTarget).attr('data-id');
    deleteItem(semesterUrl + '/' + semesterId, tableName, 'Semester');
  });
  $('#addSemesterModal').on('hidden.bs.modal', function () {
    $('#addSemesterForm')[0].reset();
  });
});
/******/ })()
;