/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************************!*\
  !*** ./resources/assets/js/custom/custom.js ***!
  \**********************************************/
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

window.deleteItem = function (url, tableId, header) {
  var callFunction = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
  swal({
    title: 'Delete !',
    text: 'Are You Sure Want To Delete ' + '"' + header + '" ?',
    type: 'warning',
    showCancelButton: true,
    closeOnConfirm: false,
    showLoaderOnConfirm: true,
    confirmButtonColor: '#1c75bc',
    cancelButtonColor: '#f58823',
    cancelButtonText: 'No',
    confirmButtonText: 'Yes'
  }, function () {
    deleteItemAjax(url, tableId, header, callFunction = null);
  });
};

function deleteItemAjax(url, tableId, header) {
  var callFunction = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
  $.ajax({
    url: url,
    type: 'DELETE',
    dataType: 'json',
    success: function success(obj) {
      if (obj.success) {
        if ($(tableId).DataTable().data().count() == 1) {
          $(tableId).DataTable().page('previous').draw('page');
        } else {
          $(tableId).DataTable().ajax.reload(null, false);
        }
      }

      swal({
        title: 'Deleted !',
        text: header + 'Has Been Deleted',
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
}

window.displaySuccessMessage = function (message) {
  iziToast.success({
    title: 'Success',
    message: message,
    position: 'topRight'
  });
};

window.displayErrorMessage = function (message) {
  iziToast.error({
    title: 'Error',
    message: message,
    position: 'topRight'
  });
};
/******/ })()
;