$(document).ready(function () {
    var tableName = '#customerTbl';
    var tbl = $(tableName).DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 500,

        ajax: {
            url: customerUrl
        },
        columnDefs: [
            {
                'targets': [3],
                'className': 'text-center',
                'orderable': false,
                'width': '8%'
            }
        ],
        columns: [
            {
                data: function data(row) {
                    return `<div class="d-flex align-items-center">
                            <div class="mr-2">
                        <div class=""><img src="${row.image_url}" alt="" class="user-img rounded-circle" height="30px" width="30px"></div></div>
                        <div class="d-flex flex-column">${row.name}
                        </div></div>`;
                },
                name: 'name'
            },
            {
                data: 'mobile',
                name: 'mobile'
            },
            {
                data: function data(row) {
                    return moment(row.created_at, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
                },
                name: 'created_at'
            },
            {
                data: function data(row) {
                    return `<a title="Delete" class="btn btn-sm delete-btn text-white" data-id="${row.id}" href="#">
           <i class="fa-solid fa-trash"></i>
                </a>`
                },
                name: 'id',
            }]
    });

    $(document).on('click', '.delete-btn', function (event) {
        var customerId = $(event.currentTarget).attr('data-id');
        deleteItem(customerUrl + '/' + customerId, tableName, 'Customer');
    });
});
