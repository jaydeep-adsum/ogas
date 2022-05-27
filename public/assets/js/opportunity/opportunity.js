/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************************!*\
  !*** ./resources/assets/js/opportunity/opportunity.js ***!
  \********************************************************/
$(document).ready(function () {
  var tableName = '#opportunityTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    ajax: {
      url: opportunityUrl
    },
    columnDefs: [{
      'targets': [5, 7],
      'orderable': false,
      'className': 'text-center'
    }],
    columns: [{
      data: function data(row) {
        return "<div class=\"d-flex align-items-center\">\n                            <div class=\"mr-2\">\n                        <div class=\"\"><img src=\"".concat(row.image_url, "\" alt=\"\" class=\"user-img rounded-circle\" height=\"30px\" width=\"30px\"></div></div>\n                        </div>");
      },
      name: 'id'
    }, {
      data: 'company_name',
      name: 'company_name'
    }, {
      data: function data(row) {
        return moment(row.interview_date, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY H:mm');
      },
      name: 'interview_date'
    }, {
      data: 'location',
      name: 'location'
    }, {
      data: 'criteria',
      name: 'criteria'
    }, {
      data: function data(row) {
        return "<a href=\"".concat(row.overview, "\" class=\"btn btn-sm edit-btn\"><i class=\"fa-solid fa-eye\"></i></a>");
      },
      name: 'overview'
    }, {
      data: function data(row) {
        return moment(row.created_at, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
      },
      name: 'created_at'
    }, {
      data: function data(row) {
        var url = opportunityUrl + '/' + row.id;
        return "<a title=\"Edit\" class=\"btn btn-sm edit-btn\" data-id=\"".concat(row.id, "\" href=\"").concat(url, "/edit\">\n            <i class=\"fa fa-edit\"></i>\n                </a>  <a title=\"Delete\" class=\"btn btn-sm delete-btn\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.delete-btn', function (event) {
    var opportunityId = $(event.currentTarget).attr('data-id');
    deleteItem(opportunityUrl + '/' + opportunityId, tableName, 'Opportunity');
  });
});
/******/ })()
;