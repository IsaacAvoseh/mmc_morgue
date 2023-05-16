@extends('layout.main')


@section('content')
@section('title', 'Request Items')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <p id="test">

        </p>
        <div class="row">
            <div class="col-12">
    
                {{-- Request modal --}}
                <div class="modal fade" id="request">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Request Item </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                  {{-- loading spinner --}}
                                <div class="overlay-wrapper hidden" id="overlay-wrapper">
                                    <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                {{-- end loading spinner --}}
                            
                                    <input type="hidden" name="id" id="id">
                                    <div class="row">
                                        <div class="form-group col">
                                        <label>Item Name</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name') }}" class="form-control form-control-sm datetimepicker-input"
                                                placeholder="Name" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label>Unit of Measure</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="unit_of_measure" id="unit_of_measure"
                                                value="{{ old('unit_of_measure') }}" class="form-control form-control-sm datetimepicker-input"
                                                placeholder="" required readonly>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Quatity</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="number" name="qty" id="qty"
                                                value="{{ old('qty') }}" class="form-control datetimepicker-input"
                                                placeholder="e.g 10" required>
                                        </div>
                                    </div>
                            
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" onclick="request()"
                                            class="btn btn-primary">Request</button>
                                    </div>
                             
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                </div>
                {{-- End of Request modal --}}
    
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                        <div class="col-md-4">
                            <div class="row justify-content-between">
                          
                        </div>
                        </div>
                        {{-- lodaing spinner --}}
                        <div class="overlay-wrapper hidden" id="overlay-wrapper">
                            <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                        {{-- end loading spinner --}}

                       <div class="col-md-8">
                         <div class="row">
                            <span class="" hidden id="show_upload">
                                <form action="{{ route('inventory') }}" onsubmit="loading()" class=""
                                    method="post">
                                    @csrf
                                    <div class="row d-flex justify-content-center">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Item Name:</label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" name="name" id="name"
                                                        value="{{ old('name') }}"
                                                        class="form-control datetimepicker-input"
                                                        placeholder="Name of service" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Unit of Measure:</label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text" name="unit_of_measure" id="unit_of_measure"
                                                        value="{{ old('unit_of_measure') }}"
                                                        class="form-control datetimepicker-input"
                                                        placeholder="i.e piece,litres e.t." required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Submit</label>
                                            <button type="submit" class="btn btn-success">
                                                Submit
                                            </button>
                                            </div>  
                                        </div>
                                    </div>
                                </form>
                            </span>
                        </div>
                       </div>
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Unit of Measure</th>
                                    <th>Balance</th>
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
                    url: "{{ route('item_list') }}",
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
                        data: 'unit_of_measure'
                    },
        
                    {
                        data: 'balance'
                    },

                    {
                        data: 'action'
                    },

                ],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });


     function get_item1(id){
         // open modal and send request to get conference data
        $('#request').modal('show');
        $('#request').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('get_item') }}",
            type: 'GET',
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(result) {
                console.log(result);
                $('#request').find('#overlay-wrapper').css('display', 'none');
                $('#request').find('#name').val(result?.data?.name);
                $('#request').find('#unit_of_measure').val(result?.data?.unit_of_measure);
                $('#request').find('#id').val(result?.data?.id);
             
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#request').find('#overlay-wrapper').css('display', 'none');
                Swal.fire(
                    'Error!',
                    'Something went wrong.',
                    'error'
                )
                console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }

    
    function request(id){
           let item_id = $('#request').find('#id').val();
            console.log('service', item_id)
        $('#request').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('make_request') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                item_id: $('#request').find('#id').val(),
                qty: $('#request').find('#qty').val(),
            },
            success: function(result) {
                console.log('resu;t', result);
                $('#request').find('#overlay-wrapper').css('display', 'none');
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
                $('#request').find('#overlay-wrapper').css('display', 'none');
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
@endsection
