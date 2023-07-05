@extends('layout.main')


@section('content')
@section('title', 'Referrals')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <p id="test">

        </p>
        <div class="row">
            <div class="col-12">
                {{-- Add new Modal name, start and end date --}}
                <div class="modal fade" id="addNewModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New Referral</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('referrals') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control datetimepicker-input"
                                                placeholder="e.g Jane Doe">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Phone</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="phone" value="{{ old('phone') }}"
                                                class="form-control datetimepicker-input"
                                                placeholder="Phone Number">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                class="form-control datetimepicker-input"
                                                placeholder="Valid email">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="address" value="{{ old('address') }}"
                                                class="form-control datetimepicker-input"
                                                placeholder="Home address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="date" name="dob" value="{{ old('dob') }}"
                                                class="form-control datetimepicker-input"
                                                placeholder="dob">
                                        </div>
                                    </div>
                                 

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                {{-- add new modal --}}

                {{-- Update modal --}}
                <div class="modal fade" id="update_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Update Referral</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="overlay-wrapper hidden" id="overlay-wrapper">
                                    <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                {{-- end loading spinner --}}
                                 <input type="hidden" name="" id="id">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                                class="form-control datetimepicker-input"
                                                placeholder="e.g Jane Doe">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Phone</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                                class="form-control datetimepicker-input"
                                                placeholder="Phone Number">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                                class="form-control datetimepicker-input"
                                                placeholder="Valid email">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="address" id="address" value="{{ old('address') }}"
                                                class="form-control datetimepicker-input"
                                                placeholder="Home address">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="date" name="dob" id="dob" value="{{ old('dob') }}"
                                                class="form-control datetimepicker-input"
                                                placeholder="dob">
                                        </div>
                                    </div>
                                   
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" onclick="referral_edit()"
                                            class="btn btn-primary">Submit</button>
                                    </div>
                             
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                </div>

                <!-- /.modal-dialog -->
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#addNewModal">
                                <i class="fa fa-plus"></i>
                                Add New
                            </button>

                        </div>
                        {{-- lodaing spinner --}}
                        <div class="overlay-wrapper hidden" id="overlay-wrapper">
                            <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                        {{-- end loading spinner --}}

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <p>You can manage Referrals here</p>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Referred</th>
                                    {{-- <th>DOB</th> --}}
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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
    function loading() {
        $('.card').find('#overlay-wrapper').css('display', 'block');
    }

    $(function() {
        $(function() {
            var tt = 0;
            $('.card').find('#overlay-wrapper').css('display', 'none');
            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                ordering: true,
                pageLength: 10,
                // responsive: true,
                info: true,
                ajax: {
                    type: "GET",
                    url: "{{ route('get_referrals') }}",
                    dataSrc: function(data) {
                        return data.aaData
                    }
                },
                columns: [{
                        data: 'id',

                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'phone'
                    },
                   
                    {
                        data: 'email'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'referred'
                    },
                    {
                        data: 'action'
                    },

                ],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });


    });


    function get_referral(id) {
        // open modal and send request to get conference data
        $('#update_modal').modal('show');
        $('#update_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('get_referral') }}",
            type: 'GET',
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(result) {
                console.log(result);
                $('#update_modal').find('#overlay-wrapper').css('display', 'none');
                $('#update_modal').find('#name').val(result?.data?.name);
                $('#update_modal').find('#phone').val(result?.data?.phone);
                $('#update_modal').find('#email').val(result?.data?.email);
                $('#update_modal').find('#address').val(result?.data?.address);
                $('#update_modal').find('#dob').val(result?.data?.dob);
                
                $('#update_modal').find('#id').val(result?.data?.id);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire(
                    'Error!',
                    'Something went wrong.',
                    'error'
                )
                console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }

    function referral_edit() {
       
        let id = $('#update_modal').find('#id').val();
        $('#update_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('referral_edit') }}",
            type: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                id: $('#update_modal').find('#id').val(),
                name: $('#update_modal').find('#name').val(),
                email: $('#update_modal').find('#email').val(),
                address: $('#update_modal').find('#address').val(),
                phone: $('#update_modal').find('#phone').val(),
                dob: $('#update_modal').find('#dob').val(),
            },
            success: function(result) {
                console.log('result', result);
                $('#update_modal').find('#overlay-wrapper').css('display', 'none');
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
                    `${XMLHttpRequest.responseJSON.error?XMLHttpRequest.responseJSON.error: 'Something went wrong!' }`,
                    'error'
                )
                $('#update_modal').find('#overlay-wrapper').css('display', 'none');
                console.log(XMLHttpRequest);
            }
        });

    }

</script>
@endsection
@endsection
