@extends('layout.main')


@section('content')
@section('title', 'Services')
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
                                <h4 class="modal-title">Update Service</h4>
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
                               
                                    <input type="hidden" name="id" id="id">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name') }}" class="form-control datetimepicker-input"
                                                placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="number" price="price" id="price"
                                                value="{{ old('price') }}" class="form-control datetimepicker-input"
                                                placeholder="Price" required>
                                        </div>
                                    </div>
                            
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" onclick="service_edit()"
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
                        <div class="row">
                        <div class="col-md-4">
                            <div class="row justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="showUpload()">
                                <i class="fa fa-plus"></i>
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
                                <form action="{{ route('services') }}" onsubmit="loading()" class=""
                                    method="post">
                                    @csrf
                                    <div class="row d-flex justify-content-center">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Name:</label>
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
                                                <label>Price:</label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="number" name="price" id="price"
                                                        value="{{ old('price') }}"
                                                        class="form-control datetimepicker-input"
                                                        placeholder="Price" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Submit</label>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-plus"></i>
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
                                    <th>Price</th>
                                    <th>Added</th>
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
                    url: "{{ route('get_services') }}",
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
                        data: 'price'
                    },
                    {
                        data: 'added'
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
                    url: "{{ route('delete_service') }}",
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

       function get_service(id) {
        // open modal and send request to get conference data
        $('#update_modal').modal('show');
        $('#update_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('get_service') }}",
            type: 'GET',
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(result) {
                console.log(result);
                $('#update_modal').find('#overlay-wrapper').css('display', 'none');
                $('#update_modal').find('#name').val(result?.data?.name);
                $('#update_modal').find('#price').val(result?.data?.price);
                $('#update_modal').find('#id').val(result?.data?.id);
                if(result?.data?.name == 'Embalmment' || result?.data?.name == 'Daily Fee'){
                    $('#update_modal').find('#name').attr('readonly', true);
                }else{
                    $('#update_modal').find('#name').attr('readonly', false);

                }
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

    function service_edit() {
    
        let service_id = $('#update_modal').find('#id').val();
        console.log('service', service_id)
        $('#update_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('service_edit') }}",
            type: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                service_id: $('#update_modal').find('#id').val(),
                name: $('#update_modal').find('#name').val(),
                price: $('#update_modal').find('#price').val(),
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
