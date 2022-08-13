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
                'targets': [7],
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
                data: function data(row){
                    return row.customer.name
                },
                name: 'customer_id'
            },
            {
                data: function data(row) {
                    return row.address.location;
                },
                name: 'location'
            },
            {
                data: function data(row) {
                    return moment(row.date, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
                },
                name: 'date'
            },
            {
                data: function data(row) {
                    if (row.payment==null) {
                        return `<span class="badge badge-danger">Unpaid</span>`;
                    } else {
                        return `<span class="badge badge-danger">${row.payment.payment_status}</span>`;
                    }
                },
                name: 'id'
            },
            {
                data: function data(row) {
                    if(row.status==0){
                        return `<span class="badge badge-secondary">Ordered</span>`
                    }else if (row.status==1){
                        return `<span class="badge badge-primary">Confirmed</span>`
                    }else if (row.status==2){
                        return `<span class="badge badge-warning">Ongoing</span>`
                    }else if (row.status==3){
                        return `<span class="badge badge-info">Order Processing</span>`
                    }else if (row.status==4){
                        return `<span class="badge badge-success">Delivered</span>`
                    }else if (row.status==5){
                        return `<span class="badge badge-danger">Canceled</span>`
                    }
                },
                name: 'status'
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
