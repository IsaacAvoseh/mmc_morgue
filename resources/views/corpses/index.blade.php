@extends('layout.main')


@section('content')
@section('title', 'Corpses')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <p id="test">

        </p>
        <div class="row">
            <div class="col-12">


                {{-- add new modal --}}

                {{-- Update modal --}}
                <div class="modal fade" id="update_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Update Airline</h4>
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
                                <p class="text-danger text-bold"> Please type airline correctly or copy and pase from
                                    payment or billing excel sheet</p>
                                <form action="{{ route('corpses') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="id">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name') }}" class="form-control datetimepicker-input"
                                                placeholder="Africa World Corpses Limited" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Naira Opening Balance:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="number" name="naira_opening" min="0" id="naira_opening"
                                                placeholder="18278666.12" value="{{ old('naira_opening') }}"
                                                class="form-control datetimepicker-input"
                                                data-target="#reservationdate">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>USD Opening Balance:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="number" name="usd_opening" min="0" id="usd_opening"
                                                placeholder="18278666.12" class="form-control datetimepicker-input"
                                                value="{{ old('usd_opening') }}" data-target="#reservationdate">
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" onclick="airline_edit()"
                                            class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <a href="{{ route('admit') }}" type="button" class="btn btn-primary btn-sm rounded">
                                <i class="fa fa-plus"></i>
                                Admit
                            </a>
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
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Relation</th>
                                    <th>Admission Date</th>
                                    <th>Collection Date</th>
                                    <th>Rack</th>
                                    <th>Actions</th>
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
        var tt = 0;
        $('.card').find('#overlay-wrapper').css('display', 'none');
        $("#example1").DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            ordering: true,
            pageLength: 50,
            // responsive: true,
            info: true,
            ajax: {
                type: "GET",
                url: "{{ route('get_corpses') }}",
                dataSrc: function(data) {
                    return data.aaData
                }
            },
            columns: [{
                    data: 'id',
                    orderable: false

                },
                {
                    data: 'name'
                },

                {
                    data: 'age'
                },
                {
                    data: 'sex'
                },
                {
                    data: 'relation',
                    orderable: false
                },
                {
                    data: 'date_received'
                },
                {
                    data: 'date_to'
                },
                {
                    data: 'rack',
                },
                {
                    data: 'action',
                    orderable: false
                },

            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    });


    function deleteConfirm(id, name) {
        Swal.fire({
            title: `Are you sure you want to delete ${name}?`,
            text: `You won't be able to revert this!, This will also remove all payment,referral and uploaded files record for ${name}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('delete_corpse') }}",
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(result) {
                        console.log(result)
                        Swal.fire(
                            'Deleted!',
                            `${result[1]}.`,
                            'success'
                        )
                        location.reload();
                    },
                    
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                    if (XMLHttpRequest.responseJSON.error) {
                        Swal.fire(
                            'Error !',
                            `${XMLHttpRequest.responseJSON.error?XMLHttpRequest.responseJSON.error: 'Something went wrong!'}.`,
                            'error'
                        )
                    } else {
                        $.each(XMLHttpRequest.responseJSON.errors, function(key, value) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: value[0],
                            });
                        });
                    }

                }
                });
            }
        })
    }


    function showUpload() {
        if ($('#show_upload').attr('hidden')) {
            $('#show_upload').attr('hidden', false);
        } else {
            $('#show_upload').attr('hidden', true);
        }
    }
</script>
@endsection
@endsection
