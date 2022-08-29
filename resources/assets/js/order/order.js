$(document).ready(function () {
    var tableName = '#orderTbl';
    var tbl = $(tableName).DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 500,
        ajax: {
            url: orderUrl,
            data: function (d) {
                d.status = $('#status_id').val()
                d.payment = $('#payment').val()
            }
        },
        columnDefs: [
            {
                'targets': [11],
                'className': 'text-center',
                'orderable': false,
                'width': '10%'
            }
        ],
        columns: [
            {
                data: function data(row){
                    return `<span class="badge order_id_badge"><i class="fa-solid fa-hashtag"></i>${row.order_invoice}</span>`
                },
                name: 'order_invoice'
            },
            {
                data: function data(row){
                    return `<span class="badge order_invoice_badge"><i class="fa-solid fa-hashtag"></i>${row.invoice_id}</span>`
                },
                name: 'invoice_id'
            },
            {
                data: function data(row){
                    return row.customer.name
                },
                name: 'customer_id'
            },
            {
                data: function data(row) {
                    return row.address.location.substring(0, 50) + '...';
                },
                name: 'id'
            },
            {
                data: function data(row) {
                    return moment(row.date, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY');
                },
                name: 'date'
            },
            {
                data: function data(row) {
                    return row.payment_method=='Cash on Delivery'?'Cash':row.payment_method=='Debit card / Credit card'?'Card':'-';
                },
                name: 'payment_method'
            },
            {
                data: function data(row) {
                    if (row.payment && row.payment.payment_status=="paid") {
                        return `<span class="badge badge-paid-success">Paid</span>`;
                    } else {
                        return `<span class="badge badge-unpaid-danger">Unpaid</span>`;
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
                        return `<span class="badge badge-danger">Cancelled</span>`
                    }
                },
                name: 'status'
            },
            {
                data: function data(row){
                    return row.driver?row.driver.name:'-'
                },
                name: 'driver_id'
            },
            {
                data: function data(row){
                    return row.driver?row.driver.mobile:'-'
                },
                name: 'driver_id'
            },
            {
                data: 'total',
                name: 'total'
            },
            {
                data: function data(row) {
                    var url = orderUrl + '/' + row.id;
                    return `
<div class="d-flex"> <a title="Show" class="btn btn-sm mr-1 edit-btn" data-id="${row.id}" href="${url}">
            <i class="fa-solid fa-eye"></i>
                </a> <a title="Delete" class="btn btn-sm delete-btn text-white" data-id="${row.id}" href="#">
           <i class="fa-solid fa-trash"></i>
                </a></div>`
                },
                name: 'id',
            }]
    });
    $("#status_id").change(function () {
        $(tableName).DataTable().draw(true);
    });
    $("#payment").change(function () {
        $(tableName).DataTable().draw(true);
    });
    $(document).on('click', '.delete-btn', function (event) {
        var orderId = $(event.currentTarget).attr('data-id');
        deleteItem(orderUrl + '/' + orderId, tableName, 'Order');
    });
});
