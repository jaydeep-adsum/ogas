$(document).ready(function () {
    var tableName = '#faqTbl';
    var tbl = $(tableName).DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 500,
        ajax: {
            url: faqUrl
        },
        columnDefs: [
            {
                'targets': [2],
                'orderable': false,
                'width': '8%'
            },
        ],
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'question',
                name: 'question'
            },
            {
                data: function data(row) {
                    return `<a title="Edit" class="btn btn-sm edit-btn" data-id="${row.id}" href="#">
            <i class="fa fa-edit"></i>
                </a>  <a title="Delete" class="btn btn-sm delete-btn" data-id="${row.id}" href="#">
           <i class="fa-solid fa-trash"></i>
                </a>`
                },
                name: 'id',
            }]
    });

    $(document).on('click', '.addModal', function () {
        $('#addModal').appendTo('body').modal('show');
    });
    $(document).on('submit', '#addForm', function (e) {
        e.preventDefault();
        $.ajax({
            url: faqSaveUrl,
            type: 'POST',
            data: $(this).serialize(),
            success: function (result) {
                if (result.success) {
                    displaySuccessMessage(result.message);
                    $('#addModal').modal('hide');
                    $(tableName).DataTable().ajax.reload(null, false);
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    });

    $(document).on('click', '.edit-btn', function (event) {
        let faqId = $(event.currentTarget).attr('data-id');
        renderData(faqId);
    });
    window.renderData = function (id) {
        $.ajax({
            url: faqUrl + '/' + id + '/edit',
            type: 'GET',
            success: function (result) {
                if (result.success) {
                    $('#editQuestion').val(result.data.question);
                    $('#editAnswer').val(result.data.answer);
                    $('#faqId').val(result.data.id);
                    $('#editModal').appendTo('body').modal('show');
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    };

    $(document).on('submit', '#editForm', function (e) {
        e.preventDefault();
        var id = $('#faqId').val();
        $.ajax({
            url: faqUrl +'/'+id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function (result) {
                if (result.success) {
                    displaySuccessMessage(result.message);
                    $('#editModal').modal('hide');
                    $(tableName).DataTable().ajax.reload(null, false);
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    });

    $(document).on('click', '.delete-btn', function (event) {
        var faqId = $(event.currentTarget).attr('data-id');
        deleteItem(faqUrl + '/' + faqId, tableName, 'Faq');
    });

    $('#addModal').on('hidden.bs.modal', function () {
        $('#addForm')[0].reset();
    });

});
