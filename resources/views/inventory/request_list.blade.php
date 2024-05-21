@extends('layout.main')
@section('content')
@section('title', 'Request List')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <p id="test">

        </p>
        <div class="row">
            <div class="col-12">
    
                {{-- Request modal --}}
                <div class="modal fade" id="approve">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Approve Item </h4>
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
                                    <input type="hidden" name="inventory_id" id="inventory_id">
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
                                                placeholder="10" required>
                                        </div>
                                    </div>
                            
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" onclick="approve()"
                                            class="btn btn-success">Approve</button>
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
                                    <th>Quantity</th>
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
                    url: "{{ route('get_request_list') }}",
                    dataSrc: function(data) {
                        return data.aaData
                    }
                },
                columns: [{
                        data: 'id',

                    },
                    {
                        data: 'name',
                        sortable: false
                    },
                    {
                        data: 'unit_of_measure',
                        sortable: false
                    },
        
                    {
                        data: 'quantity',
                        sortable: false
                    },

                    {
                        data: 'action',
                        sortable: false
                    },

                ],
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });


     function get_item1(id){
         // open modal and sapproverequest').modal('show');
        $('#approve').modal('show');
        $('#approve').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('get_requested_item') }}",
            type: 'GET',
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(result) {
                console.log(result);
                $('#approve').find('#overlay-wrapper').css('display', 'none');
                $('#approve').find('#name').val(result?.data?.inventory.name);
                $('#approve').find('#unit_of_measure').val(result?.data?.inventory.unit_of_measure);
                $('#approve').find('#qty').val(result?.data?.qty);
                $('#approve').find('#id').val(result?.data?.id);
                $('#approve').find('#inventory_id').val(result?.data?.inventory_id);
             
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#approve').find('#overlay-wrapper').css('display', 'none');
                Swal.fire(
                    'Error!',
                    'Something went wrong.',
                    'error'
                )
                console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }

    
    function approve(id){
           let item_id = $('#approve').find('#id').val();
           let inventory_id = $('#approve').find('#inventory_id').val();
            console.log('inventory_id', inventory_id)
        $('#approve').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('approve_request') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: $('#approve').find('#id').val(),
                inventory_id: $('#approve').find('#inventory_id').val(),
                qty: $('#approve').find('#qty').val(),
            },
            success: function(result) {
                console.log('resu;t', result);
                $('#approve').find('#overlay-wrapper').css('display', 'none');
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
                $('#approve').find('#overlay-wrapper').css('display', 'none');
                console.log(XMLHttpRequest);
            }
        });

    }

      function rejectConfirm(id, name) {
        Swal.fire({
            title: `Are you sure you want to reject ${name}?`,
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reject it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // confirm('Are you sure ?')
                $.ajax({
                    url: "{{ route('reject_request') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        name: name,
                    },
                    success: function(result) {
                        Swal.fire(
                            'Rejected !',
                            `${result?.success}.`,
                            'success'
                        )
                        location.reload();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        Swal.fire(
                            'Error !',
                            `${XMLHttpRequest.responseJSON.error?XMLHttpRequest.responseJSON.error: 'Something went wrong!'}.`,
                            'error'
                        )
                        console.log(XMLHttpRequest, textStatus, errorThrown);
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
