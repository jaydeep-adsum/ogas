$(document).ready(function () {
    var tableName = '#notificationTbl';
    var tbl = $(tableName).DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 500,

        ajax: {
            url: notificationUrl
        },
        // columnDefs: [
        //     {
        //         'targets': [4],
        //         'className': 'text-center',
        //         'orderable': false,
        //         'width': '8%'
        //     }
        // ],
        columns: [
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: function data(row) {
                    return moment(row.created_at, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY  hh:mm');
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
        var notificationId = $(event.currentTarget).attr('data-id');
        deleteItem(notificationUrl + '/' + notificationId, tableName, 'Notification');
    });
});
