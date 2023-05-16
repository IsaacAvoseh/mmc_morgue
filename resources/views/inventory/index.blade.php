@extends('layout.main')


@section('content')
@section('title', 'Inventory')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <p id="test">

        </p>
        <div class="row">
            <div class="col-12">
                {{-- Update modal --}}
                <div class="modal fade" id="update_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Update Item</h4>
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
                                    <div class="form-group">
                                        <label>Item Name</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name') }}" class="form-control datetimepicker-input"
                                                placeholder="Name" required>
                                        </div>
                                    </div>
                                       <div class="form-group">
                                        <label>Unit of Measure</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="unit_of_measure" id="unit_of_measure"
                                                value="{{ old('unit_of_measure') }}" class="form-control datetimepicker-input"
                                                placeholder="" required>
                                        </div>
                                    </div>

                            
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" onclick="edit_item()"
                                            class="btn btn-primary">Submit</button>
                                    </div>
                             
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                </div>
                {{-- End of update modal --}}
    
                {{-- Restock modal --}}
                <div class="modal fade" id="restock">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Restock Item </h4>
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
                                                placeholder="30,100 e.t." required>
                                        </div>
                                    </div>
                            
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" onclick="restock()"
                                            class="btn btn-primary">Restock</button>
                                    </div>
                             
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                </div>
                {{-- End of Restock modal --}}
    
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                        <div class="col-md-4">
                            <div class="row justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="showUpload()">
                                {{-- <i class="fa fa-plus"></i> --}}
                                Add New
                            </button>
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
                                                        placeholder="Name of item" required>
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
                                                <i class="fa fa-circle"></i>
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
                                    <th>Updated</th>
                                    <th>Total Stock In</th>
                                    <th>Total Stock Out</th>
                                    <th>Balance</th>
                                    <th>Action</th>
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
                pageLength: 25,
                // responsive: true,
                info: true,
                ajax: {
                    type: "GET",
                    url: "{{ route('get_inventory') }}",
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
                        data: 'updated'
                    },
                    {
                        data: 'total_in_stock'
                    },
                    {
                        data: 'total_out_stock'
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
                // confirm('Are you sure ?')
                $.ajax({
                    url: "{{ route('delete_item') }}",
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

    function get_item1(id){
         // open modal and send request to get conference data
        $('#restock').modal('show');
        $('#restock').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('get_item') }}",
            type: 'GET',
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(result) {
                console.log(result);
                $('#restock').find('#overlay-wrapper').css('display', 'none');
                $('#restock').find('#name').val(result?.data?.name);
                $('#restock').find('#unit_of_measure').val(result?.data?.unit_of_measure);
                $('#restock').find('#id').val(result?.data?.id);
             
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#restock').find('#overlay-wrapper').css('display', 'none');
                Swal.fire(
                    'Error!',
                    'Something went wrong.',
                    'error'
                )
                console.log(XMLHttpRequest, textStatus, errorThrown);
            }
        });
    }

    function get_item(id){
         // open modal and send request to get conference data
        $('#update_modal').modal('show');
        $('#update_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('get_item') }}",
            type: 'GET',
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(result) {
                console.log(result);
                $('#update_modal').find('#overlay-wrapper').css('display', 'none');
                 $('#update_modal').find('#name').val(result?.data?.name);
                $('#update_modal').find('#unit_of_measure').val(result?.data?.unit_of_measure);
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

    function edit_item(id){
           let item_id = $('#update_modal').find('#id').val();
            console.log('item', item_id)
        $('#update_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('edit_item') }}",
            type: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                item_id: $('#update_modal').find('#id').val(),
                name: $('#update_modal').find('#name').val(),
                unit_of_measure: $('#update_modal').find('#unit_of_measure').val(),
            },
            success: function(result) {
                console.log('resu;t', result);
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

    function restock(id){
           let item_id = $('#restock').find('#id').val();
            console.log('item', item_id)
        $('#restock').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('restock_item') }}",
            type: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                item_id: $('#restock').find('#id').val(),
                qty: $('#restock').find('#qty').val(),
            },
            success: function(result) {
                console.log('resu;t', result);
                $('#restock').find('#overlay-wrapper').css('display', 'none');
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
                $('#restock').find('#overlay-wrapper').css('display', 'none');
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
