/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************************!*\
  !*** ./resources/assets/js/events/event.js ***!
  \*********************************************/
$(document).ready(function () {
  var tableName = '#eventTbl';
  var tbl = $(tableName).DataTable({
    processing: true,
    serverSide: true,
    searchDelay: 500,
    // language: {
    //     processing: `<img src='${loaderUrl}'>`,
    // },
    ajax: {
      url: eventUrl
    },
    columnDefs: [{
      'targets': [0],
      'orderable': false
    }, {
      'targets': [6],
      'orderable': false,
      'className': 'text-center',
      'width': '9%'
    }],
    columns: [{
      data: function data(row) {
        return "<div class=\"d-flex align-items-center\">\n                            <div class=\"mr-2\">\n                        <div class=\"\"><img src=\"".concat(row.image_url, "\" alt=\"\" class=\"user-img rounded-circle\" height=\"30px\" width=\"30px\"></div></div>\n                        </div>");
      },
      name: 'id'
    }, {
      data: 'title',
      name: 'title'
    }, {
      data: function data(row) {
        return moment(row.date, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY hh:mm');
      },
      name: 'date'
    }, {
      data: 'location',
      name: 'location'
    }, // {
    //     data: 'detail',
    //     name: 'detail'
    // },
    // {
    //     data: function data(row) {
    //         return `<div class=""><a href="${row.registration_link}" target="_blank">${row.registration_link}</a></div>`;
    //     },
    //     name: 'registration_link'
    // },
    {
      data: 'created_by',
      name: 'created_by'
    }, {
      data: function data(row) {
        return moment(row.created_at, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
      },
      name: 'created_at'
    }, {
      data: function data(row) {
        var url = eventUrl + '/' + row.id;
        return "<a title=\"Edit\" class=\"btn btn-sm edit-btn\" data-id=\"".concat(row.id, "\" href=\"").concat(url, "/edit\">\n            <i class=\"fa fa-edit\"></i>\n                </a>  <a title=\"Delete\" class=\"btn btn-sm delete-btn\" data-id=\"").concat(row.id, "\" href=\"#\">\n           <i class=\"fa-solid fa-trash\"></i>\n                </a>");
      },
      name: 'id'
    }]
  });
  $(document).on('click', '.delete-btn', function (event) {
    var eventId = $(event.currentTarget).attr('data-id');
    deleteItem(eventUrl + '/' + eventId, tableName, 'Event');
  });
});
/******/ })()
;