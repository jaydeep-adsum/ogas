/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************************!*\
  !*** ./resources/assets/js/department/department.js ***!
  \******************************************************/
$(document).ready(function () {
  var tableName = '#departmentTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: departmentUrl
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
      data: 'department',
      name: 'department'
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
  $(document).on('click', '.addDepartmentModal', function () {
    $('#addDepartmentModal').appendTo('body').modal('show');
  });
  $(document).on('submit', '#addDepartmentForm', function (e) {
    e.preventDefault();

    if ($('#department').val() == "") {
      displayErrorMessage('Department field is required.');
      return false;
    }

    $.ajax({
      url: departmentSaveUrl,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addDepartmentModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.edit-btn', function (event) {
    var departmentId = $(event.currentTarget).attr('data-id');
    renderData(departmentId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: departmentUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          $('#editDepartment').val(result.data.department);
          $('#departmentId').val(result.data.id);
          $('#editDepartmentModal').appendTo('body').modal('show');
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  };

  $(document).on('submit', '#editDepartmentForm', function (e) {
    e.preventDefault();

    if ($('#editDepartment').val() == "") {
      displayErrorMessage('Department field is required.');
      return false;
    }

    var id = $('#departmentId').val();
    $.ajax({
      url: departmentUrl + '/' + id,
      type: 'PUT',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#editDepartmentModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.delete-btn', function (event) {
    var departmentId = $(event.currentTarget).attr('data-id');
    deleteItem(departmentUrl + '/' + departmentId, tableName, 'Department');
  });
  $('#addDepartmentModal').on('hidden.bs.modal', function () {
    $('#addDepartmentForm')[0].reset();
  });
});
/******/ })()
;