/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************************!*\
  !*** ./resources/assets/js/category/category.js ***!
  \**************************************************/
$(document).ready(function () {
  var tableName = '#categoryTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: categoryUrl
    },
    columnDefs: [{
      'targets': [2],
      'orderable': false,
      'className': 'text-center'
    }],
    columns: [{
      data: 'id',
      name: 'id'
    }, {
      data: 'category',
      name: 'category'
    }, {
      data: function data(row) {
        return "<a title=\"Edit\" class=\"btn btn-sm edit-btn\" data-id=\"".concat(row.id, "\" href=\"#\">\n            <i class=\"fa fa-edit\"></i>\n                </a>  <a title=\"Delete\" class=\"btn btn-sm delete-btn\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.addModal', function () {
    $('#addModal').appendTo('body').modal('show');
  });
  $(document).on('submit', '#addForm', function (e) {
    e.preventDefault();

    if ($('#category').val() == "") {
      displayErrorMessage('Category field is required.');
      return false;
    }

    $.ajax({
      url: categorySaveUrl,
      type: 'POST',
      data: $(this).serialize(),
      success: function success(result) {
        if (result.success) {
          displaySuccessMessage(result.message);
          $('#addModal').modal('hide');
          $(tableName).DataTable().ajax.reload(null, false);
        }
      },
      error: function error(result) {
        displayErrorMessage(result.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.edit-btn', function (event) {
    var categoryId = $(event.currentTarget).attr('data-id');
    renderData(categoryId);
  });

  window.renderData = function (id) {
    $.ajax({
      url: categoryUrl + '/' + id + '/edit',
      type: 'GET',
      success: function success(result) {
        if (result.success) {
          $('#editCategory').val(result.data.category);
          $('#categoryId').val(result.data.id);
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

    if ($('#editCategory').val() == "") {
      displayErrorMessage('Category field is required.');
      return false;
    }

    var id = $('#categoryId').val();
    $.ajax({
      url: categoryUrl + '/' + id,
      type: 'PUT',
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
    var categoryId = $(event.currentTarget).attr('data-id');
    deleteItem(categoryUrl + '/' + categoryId, tableName, 'Category');
  });
  $('#addModal').on('hidden.bs.modal', function () {
    $('#addForm')[0].reset();
  });
});
/******/ })()
;