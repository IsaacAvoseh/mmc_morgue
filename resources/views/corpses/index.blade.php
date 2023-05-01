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

                {{-- Relaese modal --}}

                <div class="modal fade" id="release_modal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Release Corpse</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{-- Loadin Spinner --}}
                                {{-- <div class="overlay-wrapper hidden" id="overlay-wrapper">
                                    <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div> --}}
                                {{-- end loading spinner --}}

                                <form action="{{ route('release') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="id">

                                    <div class="form-group">
                                        <label>Name of Deceased:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name') }}" class="form-control datetimepicker-input"
                                                placeholder="Name of Deceased" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date Admitted:</label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="date" name="date_admit" id="date_admit"
                                                        value="{{ old('date_admit') }}"
                                                        class="form-control datetimepicker-input"
                                                        placeholder="Name of Deceased" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date Discharge:<span class="badge bg-danger">****</span></label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="date" name="date_discharged" id="date_discharged"
                                                        value="{{ old('date_discharged') }}"
                                                        class="form-control datetimepicker-input"
                                                        placeholder="Name of Deceased" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                     <div class="form-group">
                                            <label>Address of Deceased:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="address" id="address" value="{{ old('address') }}"
                                                    class="form-control datetimepicker-input"
                                                    placeholder="Address of Deceased" required>
                                            </div>
                                    </div>

                                      <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Age of Deceased:</label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="number" name="age" id="age"
                                                        value="{{ old('age') }}"
                                                        class="form-control datetimepicker-input"
                                                        placeholder="76" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of Death:</label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="date" name="date" id="date"
                                                        value="{{ old('date') }}"
                                                        class="form-control datetimepicker-input"
                                                         required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                      <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Name of Collector:<span class="badge bg-danger">****</span></label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" name="collector" id="collector"
                                                        value="{{ old('collector') }}"
                                                        class="form-control datetimepicker-input"
                                                        placeholder="John Doe" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Relationship:<span class="badge bg-danger">****</span></label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" name="relation" id="relation"
                                                        value="{{ old('relation') }}"
                                                        class="form-control datetimepicker-input"
                                                         required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                      <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Address of Collector: <span class="badge bg-danger">****</span></label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" name="collector_address" id="collector_address"
                                                        value="{{ old('collector_address') }}"
                                                        class="form-control datetimepicker-input"
                                                         required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Phone: <span class="badge bg-danger">****</span></label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" name="collector_phone" id="collector_phone"
                                                        value="{{ old('collector_phone') }}"
                                                        class="form-control datetimepicker-input"
                                                         required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                      <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Interment Address:<span class="badge bg-danger">****</span></label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" name="interment_address" id="interment_address"
                                                        value="{{ old('interment_address') }}"
                                                        class="form-control datetimepicker-input"
                                                         required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>LGA: <span class="badge bg-danger">****</span></label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" name="interment_lga" id="interment_lga"
                                                        value="{{ old('interment_lga') }}"
                                                        class="form-control datetimepicker-input"
                                                         required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                      <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Drivers Name:<span class="badge bg-danger">****</span></label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" name="driver_name" id="driver_name"
                                                        value="{{ old('driver_name') }}"
                                                        class="form-control datetimepicker-input"
                                                         required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Vehicle Number:<span class="badge bg-danger">****</span></label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" name="vehicle_number" id="vehicle_number"
                                                        value="{{ old('vehicle_number') }}"
                                                        class="form-control datetimepicker-input"
                                                         required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                        

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" onclick="airline_edit()"
                                            class="btn btn-primary w-25">Submit</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                {{-- End of realse modal --}}
                <!-- /.modal-dialog -->
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <a href="{{ route('admit') }}" type="button" class="btn btn-primary btn-sm rounded">
                                <i class="fa fa-plus"></i>
                                Admit
                            </a>


                            <a onclick="get_airline(3)" class="btn btn-success text-white btn-sm rounded"><i
                                    class=" fas fa-folder-minus"></i> Release</a>
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
                                    <th>Date</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Relation</th>
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

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- SweetAlert2 -->
<script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
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

                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'date'
                    },
                    {
                        data: 'age'
                    },
                    {
                        data: 'sex'
                    },
                    {
                        data: 'relation'
                    },
                    {
                        data: 'action'
                    },

                ],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2')
                .DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "severSide": true,
                    "processing": true,
                });

        });


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
                confirm('Are you sure ?')
                $.ajax({
                    url: "{{ route('corpses') }}",
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
                            'Error Deleting !',
                            `${XMLHttpRequest.responseJSON.error}.`,
                            'error'
                        )
                        console.log(XMLHttpRequest, textStatus, errorThrown);
                    }
                });
            }
        })
    }

    function get_airline(id) {
        // open modal and send request to get conference data
        $('#release_modal').modal('show');
        $('#release_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('get_airline') }}",
            type: 'GET',
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(result) {
                console.log(result);
                $('#release_modal').find('#overlay-wrapper').css('display', 'none');
                $('#release_modal').find('#name').val(result?.data?.name);
                $('#release_modal').find('#naira_opening').val(result?.data?.naira_opening);
                $('#release_modal').find('#usd_opening').val(result?.data?.usd_opening);
                $('#release_modal').find('#id').val(result?.data?.id);
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

    function airline_edit() {
        if ($('#release_modal').find('#id').val() == '') {
            Swal.fire(
                'Error!',
                `Please Select Conference on Trainnig`,
                'warning'
            )
            return;
        }
        let airline_id = $('#release_modal').find('#id').val();
        console.log('airline', airline_id)
        $('#release_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('corpses') }}",
            type: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                airline_id: $('#release_modal').find('#id').val(),
                name: $('#release_modal').find('#name').val(),
                naira_opening: $('#release_modal').find('#naira_opening').val(),
                usd_opening: $('#release_modal').find('#usd_opening').val(),
            },
            success: function(result) {
                console.log('resu;t', result);
                $('#release_modal').find('#overlay-wrapper').css('display', 'none');
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
                $('#release_modal').find('#overlay-wrapper').css('display', 'none');
                console.log(XMLHttpRequest);
            }
        });

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
