$(document).ready(function () {
    var tableName = '#feedbackTbl';
    var tbl = $(tableName).DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 500,

        ajax: {
            url: feedbackUrl
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
                data: 'id',
                name: 'id'
            },
            {
                data: function data(row) {
                    return `${row.feedback.substring(0,150)}`;
                },
                name: 'feedback'
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
        var complaintId = $(event.currentTarget).attr('data-id');
        deleteItem(feedbackUrl + '/' + complaintId, tableName, 'Complaint');
    });
});
