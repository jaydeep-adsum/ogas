/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./resources/assets/js/product/product.js ***!
  \************************************************/
$(document).ready(function () {
  var tableName = '#productTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: productUrl
    },
    columnDefs: [{
      'targets': [4],
      'className': 'text-center',
      'orderable': false
    }],
    columns: [{
      data: 'product_name',
      name: 'product_name'
    }, {
      data: function data(row) {
        return row.category.category;
      },
      name: 'category_id'
    }, {
      data: 'refill_price',
      name: 'refill_price'
    }, {
      data: 'new_price',
      name: 'new_price'
    }, {
      data: function data(row) {
        var url = productUrl + '/' + row.id;
        return "<a title=\"Edit\" class=\"btn btn-sm edit-btn\" data-id=\"".concat(row.id, "\" href=\"").concat(url, "/edit\">\n            <i class=\"fa fa-edit\"></i>\n                </a>  <a title=\"Delete\" class=\"btn btn-sm delete-btn text-white\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.delete-btn', function (event) {
    var productId = $(event.currentTarget).attr('data-id');
    deleteItem(productUrl + '/' + productId, tableName, 'Product');
  });
});
/******/ })()
;