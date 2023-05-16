@extends('layout.main')


@section('content')
@section('title', 'Users')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <p id="test">

        </p>
        <div class="row">
            <div class="col-12">
                {{-- Add new Modal with conference name, start and end date --}}
                <div class="modal fade" id="addNewModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New User</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('users') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control datetimepicker-input" placeholder="Name" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="email" name="email" placeholder="Email"
                                                value="{{ old('email') }}" class="form-control datetimepicker-input"
                                                data-target="#reservationdate" required>
                                        </div>
                                    </div>

                                     <div class="form-group">
                                                <label>User Type</label>
                                                <select class="form-control select2 select2-hidden-accessible"
                                                    style="width: 100%;" data-select2-id="1" tabindex="-1"
                                                    aria-hidden="true" name="type" required>
                                                    <option selected="selected" value="" >Select</option>
                                                    <option value="reception">Reception</option>
                                                    <option value="accounts">Accounts</option>
                                                    <option value="admin">Admin</option>
                                                    
                                                </select>
                                            </div>

                                    <div class="form-group">
                                        <label>Password:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="password" placeholder="Password"
                                                class="form-control datetimepicker-input" data-target="#reservationdate"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password Confirmation:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="password_confirmation"
                                                placeholder="Password Confirmation"
                                                class="form-control datetimepicker-input" data-target="#reservationdate"
                                                required>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                {{-- Update modal --}}
                <div class="modal fade" id="update_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Update User</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{-- <form action="{{ route('update_staff') }}" method="POST"> --}}
                                @csrf
                                {{-- lodaing spinner --}}
                                <div class="overlay-wrapper hidden" id="overlay-wrapper">
                                    <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                {{-- end of loading spinner --}}
                                <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label>Name</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="name" id="name"
                                            class="form-control datetimepicker-input" placeholder="User Name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="email" name="email" placeholder="Email" id="email"
                                            class="form-control datetimepicker-input" data-target="#reservationdate"
                                            required>
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default"
                                        data-dismiss="modal">Close</button>
                                    <button type="button" onclick="update_user($('#id').val())"
                                        class="btn btn-primary">Submit</button>
                                </div>
                                {{-- </form> --}}
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                {{-- Update Password modal --}}
                <div class="modal fade" id="update_password_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Update User Password</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{-- <form action="{{ route('update_staff') }}" method="POST"> --}}
                                @csrf
                                {{-- lodaing spinner --}}
                                <div class="overlay-wrapper hidden" id="overlay-wrapper">
                                    <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                {{-- end of loading spinner --}}
                                <input type="hidden" name="id" id="user_id">
                                <div class="form-group">
                                    <label>Name</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="name" id="name"
                                            class="form-control datetimepicker-input" placeholder="User Name" required
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Password:</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="password" placeholder="Password" id="password"
                                            class="form-control datetimepicker-input" data-target="#reservationdate"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Password Confirmation:</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="password_confirmation"
                                            placeholder="Password Confirmation" id="password_confirmation"
                                            class="form-control datetimepicker-input" data-target="#reservationdate"
                                            required>
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default"
                                        data-dismiss="modal">Close</button>
                                    <button type="button" onclick="update_password($('#user_id').val())"
                                        class="btn btn-primary">Submit</button>
                                </div>
                                {{-- </form> --}}
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal-dialog -->
                <!-- /.modal -->
                {{-- add_conference modal --}}

                <div class="card">
                    <div class="card-header">
                        {{-- add new modal button --}}
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#addNewModal">
                            <i class="fa fa-plus"></i>
                            Add New
                        </button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name ?? '-' }}</td>
                                        <td>{{ $user->email ?? '-' }}</td>
                                        <td>{{ ucfirst($user->type)?? '-' }}</td>
                                        <td>
                                            <div class="flex">

                                                <a class="btn btn-primary m-1" title="Edit User details"
                                                    onclick="get_user({{ $user->id }})"> <i
                                                        class="fa fa-edit"></i> </a>
                                                <a class="btn btn-warning m-1" title="Change User Password"
                                                    onclick="get_user_password_details({{ $user->id }})">
                                                    <i class="fas fa-sync-alt"></i> </a>
                                                <a class="btn btn-danger m-1" title="Delete user"
                                                    onclick="deleteConfirm({{ $user->id }},'{{ $user->name }}')">
                                                    <i class="fa fa-trash"></i> </a>

                                            </div>
                                        </td>
                                    @empty
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<!-- /.content -->

@section('scripts')
    @parent
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    function deleteConfirm(id, name) {
        Swal.fire({
            title: `Are you sure you want to delete ${name}?`,
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('delete_user') }}",
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(result) {
                        Swal.fire(
                            'Deleted!',
                            `${result?.success}.`,
                            'success'
                        )
                        location.reload();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        Swal.fire(
                            'Error Deleting User !',
                            `${XMLHttpRequest.responseJSON.error}.`,
                            'error'
                        )
                        console.log(XMLHttpRequest, textStatus, errorThrown);
                    }
                });
            }
        })
    }

    function get_user(id) {
        // open modal and send request to get conference data
        $('#update_modal').modal('show');
        $('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('get_user') }}",
            type: 'GET',
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(result) {
                console.log(result);
                $('#overlay-wrapper').css('display', 'none');
                $('#update_modal').find('#name').val(result?.data?.name);
                $('#update_modal').find('#email').val(result?.data?.email);
                $('#update_modal').find('#id').val(result?.data?.id);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire(
                    'Error!',
                    `${XMLHttpRequest.responseJSON.error}`,
                    'error'
                )
                console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }

    function update_user(id) {
        $('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('update_user') }}",
            type: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                name: $('#update_modal').find('#name').val(),
                email: $('#update_modal').find('#email').val(),
            },
            success: function(result) {
                $('#overlay-wrapper').css('display', 'none');
                Swal.fire(
                    'Success!',
                    `${result?.success} `,
                    'success'
                )
                location.reload();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire(
                    'Error!',
                    `${XMLHttpRequest.responseJSON.error}`,
                    'error'
                )
                $('#overlay-wrapper').css('display', 'none');
                console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        })
    }

    function get_user_password_details(id) {
        // open modal and send request to get conference data
        $('#update_password_modal').modal('show');
        $('#update_password_modal').find('#overlay-wrapper').css('display', 'block');
        $('#update_password_modal').find('#password_confirmation').val('')
        $('#update_password_modal').find('#password').val('')
        $.ajax({
            url: "{{ route('get_user') }}",
            type: 'GET',
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(result) {
                console.log(result);
                $('#update_password_modal').find('#overlay-wrapper').css('display', 'none');
                $('#update_password_modal').find('#name').val(result?.data?.name);
                $('#update_password_modal').find('#email').val(result?.data?.email);
                $('#update_password_modal').find('#user_id').val(result?.data?.id);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#update_password_modal').find('#overlay-wrapper').css('display', 'none');
                Swal.fire(
                    'Error!',
                    `${XMLHttpRequest.responseJSON.error}`,
                    'error'
                )
                console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }

    function update_password(id) {
        $('#update_password_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('update_password') }}",
            type: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                password: $('#update_password_modal').find('#password').val(),
                password_confirmation: $('#update_password_modal').find('#password_confirmation').val()
            },
            success: function(result) {
                $('#update_password_modal').find('#overlay-wrapper').css('display', 'none');
                Swal.fire(
                    'Success!',
                    `${result?.success}`,
                    'success'
                )
                $('#update_password_modal').modal('hide');
                // location.reload();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire(
                    'Error!',
                    `${XMLHttpRequest.responseJSON.error? XMLHttpRequest.responseJSON.error:XMLHttpRequest.responseJSON.errors.password[0]} `,
                    'error'
                )
                $('#update_password_modal').find('#overlay-wrapper').css('display', 'none');
                console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        })
    }
</script>
@endsection
@endsection
