$(document).ready(function () {
    var tableName = '#driverTbl';
    var tbl = $(tableName).DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 500,

        ajax: {
            url: driverUrl
        },
        columnDefs: [
            {
                'targets': [6],
                'className': 'text-center',
                'orderable': false,
            }
        ],
        columns: [
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'mobile',
                name: 'mobile'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'licence_no',
                name: 'licence_no'
            },
            {
                data: 'vehicle_no',
                name: 'vehicle_no'
            },
            {
                data: function data(row){
                    if (row.status==null){
                        return `-`
                    }else {
                        return `<span class="badge badge-${row.status==1?'success':'danger'}">${row.status==1?'Accepted':'Rejected'}</span>`
                    }
                },
                name: 'status'
            },
            {
                data: function data(row) {
                    if (row.status==null){
                        return `<a href="#" class="btn btn-sm bg-success text-white accept" data-id="${row.id}" title="Accept !">
           <i class="fa-solid fa-thumbs-up"></i>
                </a>    <a title="Reject !" class="btn btn-sm bg-danger text-white reject" data-id="${row.id}" href="#">
           <i class="fa-solid fa-thumbs-down"></i>
                </a>    <a title="Edit" class="btn btn-sm edit-btn" data-id="${row.id}" href="#">
            <i class="fa fa-edit"></i>
                </a>    <a title="Delete" class="btn btn-sm delete-btn text-white" data-id="${row.id}" href="#">
           <i class="fa-solid fa-trash"></i>
                </a>`
                    } else {
                        return `<a title="Edit" class="btn btn-sm edit-btn" data-id="${row.id}" href="#">
            <i class="fa fa-edit"></i>
                </a>    <a title="Delete" class="btn btn-sm delete-btn text-white" data-id="${row.id}" href="#">
           <i class="fa-solid fa-trash"></i>
                </a>`
                    }
                },
                name: 'id',
            }]
    });

    $(document).on('click', '.edit-btn', function (event) {
        let driverId = $(event.currentTarget).attr('data-id');
        renderData(driverId);
    });

    window.renderData = function (id) {
        $.ajax({
            url: driverUrl + '/' + id + '/edit',
            type: 'GET',
            success: function (result) {
                if (result.success) {
                    $('#editName').val(result.data.name);
                    $('#editMobile').val(result.data.mobile);
                    $('#editEmail').val(result.data.email);
                    $('#editLicenceNo').val(result.data.licence_no);
                    $('#editVehicleNo').val(result.data.vehicle_no);
                    $('#driverId').val(result.data.id);
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
        var id = $('#driverId').val();
        $.ajax({
            url: driverUrl +'/'+id,
            type: 'POST',
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
        var driverId = $(event.currentTarget).attr('data-id');
        deleteItem(driverUrl + '/' + driverId, tableName, 'Driver');
    });

    $(document).on('click', '.accept', function (event) {
        var driverId = $(event.currentTarget).attr('data-id');
        swal({
                title: 'Accept !',
                text: 'Are You Sure Want To Accept Driver Request ?',
                type: 'info',
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#1c75bc',
                cancelButtonColor: '#f58823',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
            },
            function () {
                $.ajax({
                    url: driverUrl+'/'+driverId+'/accept',
                    type: 'get',
                    dataType: 'json',
                    success: function (obj) {
                        if (obj.success) {
                                $(tableName).DataTable().ajax.reload(null, false);
                        }
                        swal({
                            title: 'Status !',
                            text: 'Driver Status Has Been Changed',
                            type: 'success',
                            confirmButtonColor: '#1c75bc',
                            timer: 1000,
                        });
                        if (callFunction) {
                            eval(callFunction);
                        }
                    },
                    error: function (data) {
                        swal({
                            title: '',
                            text: data.responseJSON.message,
                            type: 'error',
                            confirmButtonColor: '#1c75bc',
                            timer: 5000,
                        });
                    },
                });
            });
    });

    $(document).on('click', '.reject', function (event) {
        var driverId = $(event.currentTarget).attr('data-id');
        swal({
                title: 'Accept !',
                text: 'Are You Sure Want To Reject Driver Request ?',
                type: 'info',
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#1c75bc',
                cancelButtonColor: '#f58823',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes',
            },
            function () {
                $.ajax({
                    url: driverUrl+'/'+driverId+'/reject',
                    type: 'get',
                    dataType: 'json',
                    success: function (obj) {
                        if (obj.success) {
                            $(tableName).DataTable().ajax.reload(null, false);
                        }
                        swal({
                            title: 'Status !',
                            text: 'Driver Status Has Been Changed',
                            type: 'success',
                            confirmButtonColor: '#1c75bc',
                            timer: 1000,
                        });
                        if (callFunction) {
                            eval(callFunction);
                        }
                    },
                    error: function (data) {
                        swal({
                            title: '',
                            text: data.responseJSON.message,
                            type: 'error',
                            confirmButtonColor: '#1c75bc',
                            timer: 5000,
                        });
                    },
                });
            });
    });
});
