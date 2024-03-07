<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crud ajax</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Ajax Crud <button class="btn btn-success btn-sm float-end" data-bs-toggle="modal"
                    data-bs-target="#addModal">Add New</button></div>
            <span class="alert alert-success" id="alert-success" style="display: none;"></span>
            <span class="alert alert-danger" id="alert-danger" style="display: none;"></span>
            <div class="card-body">
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($all_users) > 0)
                            @foreach ($all_users as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td><button class="btn btn-primary btn-sm editBtn"data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}" data-email="{{ $item->email }}"
                                            data-bs-toggle="modal"data-bs-target="#editModal">Edit</button>
                                        <button class="btn btn-danger btn-sm deleteBtn"
                                            data-id="{{ $item->id }}"data-name="{{ $item->name }}"
                                            data-bs-toggle="modal"data-bs-target="#deleteModal">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">No Data Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--create Modal -->

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group">
                            <label for="">User Name</label>
                            <input type="text" name="name" class="form-control" id="" placeholder="Name">
                            <span id="name_error" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="">User Email</label>
                            <input type="text" name="email" class="form-control" id=""
                                placeholder="Email">
                            <span id="email_error" class="text-danger"></span>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary addBtn">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!--edit Modal -->

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        @csrf
                        <input type="hidden" id="user_id" name="user_id">
                        <div class="form-group">
                            <label for="">User Name</label>
                            <input type="text" name="name" class="form-control" id="name">
                            <span id="name_error" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="">User Email</label>
                            <input type="text" name="email" class="form-control" id="email">
                            <span id="email_error" class="text-danger"></span>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary editButton">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- delete modal --}}

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ! Do you really want to Delete<p class="user_name"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger deleteButton">Delete</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // add

            $('#addUserForm').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('addUser') }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.addBtn').prop('disabled', true);
                    },
                    complete: function() {
                        $('.addBtn').prop('disabled', false);
                    },
                    success: function(data) {
                        if (data.success == true) {
                            $('#addModal').modal('hide');
                            printSuccessMsg(data.msg);
                            var reloadInterval = 1000;

                            function reloadPage() {
                                location.reload(true);
                            }
                            var intervalId = setInterval(reloadPage, reloadInterval);
                        } else if (data.success == false) {
                            printErrorMsg(data.msg);
                        } else {
                            printValidationErrorMsg(data.msg);
                        }
                    }
                });
                return false;
            });

            // delete

            $('.deleteBtn').on('click', function() {
                var user_id = $(this).attr('data-id');
                var user_name = $(this).attr('data-name');

                $('.user_name').html('');
                $('.user_name').html(user_name);

                $('.deleteButton').on('click', function() {
                    var url = "{{ route('deleteUser', 'user_id') }}";
                    url = url.replace('user_id', user_id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('.deleteButton').prop('disabled', true);
                        },
                        complete: function() {
                            $('.deleteButton').prop('disabled', false);
                        },
                        success: function(data) {
                            if (data.success == true) {
                                $('#deleteModal').modal('hide');
                                printSuccessMsg(data.msg);
                                var reloadInterval = 1000;

                                function reloadPage() {
                                    location.reload(true);
                                }
                                var intervalId = setInterval(reloadPage,
                                    reloadInterval);
                            } else {
                                printErrorMsg(data.msg);
                            }
                        }
                    });
                });
            });

            // edit

            $('.editBtn').on('click', function() {
                var user_id = $(this).data('id');
                var user_name = $(this).data('name');
                var user_email = $(this).data('email');
                $('#name').val(user_name);
                $('#email').val(user_email);
                $('#user_id').val(user_id);
        

            $('#editUserForm').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('editUser') }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.editButton').prop('disabled', true);
                    },
                    complete: function() {
                        $('.editButton').prop('disabled', false);
                    },
                    success: function(data) {
                        if (data.success == true) {                                                                             
                            $('#editModal').modal('hide');
                            printSuccessMsg(data.msg);
                            var reloadInterval = 1000;

                            function reloadPage() {
                                location.reload(true);
                            }
                            var intervalId = setInterval(reloadPage,
                                reloadInterval);
                        } else if (data.success == false) {
                            printErrorMsg(data.msg);
                        } else {
                            printValidationErrorMsg(data.msg);
                        }
                    }
                });
            });
        });

        // message
        function printValidationErrorMsg(msg) {
            $.each(msg, function(field_name, error) {
                // console.log(field_name, error);
                $(document).find('#' + field_name + '_error').text(error);
            });
        }

        function printErrorMsg(msg) {
            $('#alert-danger').html('');
            $('#alert-danger').css('display', 'block');
            $('#alert-danger').append('' + msg + '');
        }

        function printSuccessMsg(msg) {
            $('#alert-success').html('');
            $('#alert-success').css('display', 'block');
            $('#alert-success').append('' + msg + '');
            document.getElementById('addUserForm').reset();
        }
        });
    </script>

</body>

</html>



{{-- 
$(document).ready(function() {
    // add

    $('#addUserForm').submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: '{{ route('addUser') }}',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('.addBtn').prop('disabled', true);
            },
            complete: function() {
                $('.addBtn').prop('disabled', false);
            },
            success: function(data) {
                if (data.success == true) {
                    $('#addModal').modal('hide');
                    printSuccessMsg(data.msg);
                    var reloadInterval = 5000;

                    function reloadPage() {
                        location.reload(true);
                    }
                    var intervalId = setInterval(reloadPage, reloadInterval);
                } else if (data.success == false) {
                    printErrorMsg(data.msg);
                } else {
                    printValidationErrorMsg(data.msg);
                }
            }
        });
        return false;


    });

    // delete

    $('.deleteBtn').on('click', function() {
        var user_id = $(this).attr('data-id');
        var user_name = $(this).attr('data-name');

        $('.user_name').html('');
        $('.user_name').html(user_name);


        $('.deleteButton').on('click', function() {
            var url = "{{ route('deleteUser', 'user_id') }}";
            url = url.replace('user_id', user_id);

            $.ajax({
                url: url,
                typr: 'GET',
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('.deleteButton').prop('disabled', true);
                },
                complete: function() {
                    $('.deleteButton').prop('disabled', false);
                },
                success: function(data) {
                    if (data.success == true) {
                        $('#deleteModal').modal('hide');
                        printSuccessMsg(data.msg);
                        var reloadInterval = 5000;

                        function reloadPage() {
                            location.reload(true);
                        }
                        var intervalId = setInterval(reloadPage,
                            reloadInterval);
                    } else {
                        printErrorMsg(data.msg);
                    }
                }
            });
        });
    });

    // edit

    $('.editBtn').on('click', function() {
        var user_id = $(this).attr('data_id');
        var user_name = $(this).attr('data_name');
        var user_email = $(this).attr('data_email');

        $('#name').val(user_name);
        $('#email').val(user_email);
        $('#user_id').val(user_id);

        $('.editUserForm').submit(function(e){
            e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: '{{ route('editUser') }}',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('.editButton').prop('disabled', true);
            },
            complete: function() {
                $('.editButton').prop('disabled', false);
            },
            success: function(data) {
                if (data.success == true) {
                    $('#editModal').modal('hide');
                    printSuccessMsg(data.msg);
                    var reloadInterval = 5000;

                    function reloadPage() {
                        location.reload(true);
                    }
                    var intervalId = setInterval(reloadPage, reloadInterval);
                } else if (data.success == false) {
                    printErrorMsg(data.msg);
                } else {
                    printValidationErrorMsg(data.msg);
                }
            }
        });
    });

    // message
    function printValidationErrorMsg(msg) {
        $.each(msg, function(field_name, error) {
            // console.log(field_name, error);

            $(document).find('#' + field_name + '_error').text(error);
        });
    }

    function printErrorMsg(msg) {
        $('#alert-danger').html('');
        $('#alert-danger').css('display', 'block');
        $('#alert-danger').append('' + msg + '');
    }

    function printSuccessMsg(msg) {
        $('#alert-success').html('');
        $('#alert-success').css('display', 'block');
        $('#alert-success').append('' + msg + '');
        document.getElementById('addUserForm').reset();
    }
});
</script> --}}
