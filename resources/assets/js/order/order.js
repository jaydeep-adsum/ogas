$(document).ready(function () {
    var tableName = '#orderTbl';
    var tbl = $(tableName).DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 500,

        ajax: {
            url: orderUrl
        },
        columnDefs: [
            {
                'targets': [5],
                'className': 'text-center',
                'orderable': false,
                'width': '8%'
            }
        ],
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'location',
                name: 'location'
            },
            {
                data: 'quantity',
                name: 'quantity'
            },
            {
                data: function data(row) {
                    return moment(row.date, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
                },
                name: 'date'
            },
            {
                data: 'total',
                name: 'total'
            },
            {
                data: function data(row) {
                    var url = orderUrl + '/' + row.id;
                    return `<a title="Show" class="btn btn-sm edit-btn" data-id="${row.id}" href="${url}">
            <i class="fa-solid fa-eye"></i>
                </a> <a title="Delete" class="btn btn-sm delete-btn text-white" data-id="${row.id}" href="#">
           <i class="fa-solid fa-trash"></i>
                </a>`
                },
                name: 'id',
            }]
    });

    $(document).on('click', '.delete-btn', function (event) {
        var orderId = $(event.currentTarget).attr('data-id');
        deleteItem(orderUrl + '/' + orderId, tableName, 'Order');
    });
});
