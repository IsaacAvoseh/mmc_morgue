@extends('layout.main')


@section('content')
@section('title', 'Documents')
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
                                <h4 class="modal-title">Add New</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('documents') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Please enter document title</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control datetimepicker-input"
                                                placeholder="e.g Death Certificate">
                                        </div>
                                    </div>
                                 <div class="form-group">
                                            <label>Required ?:</label>
                                            <div class="input-group date" data-target-input="nearest">
                                                <select class="form-control select2bs4 select2-hidden-accessible"
                                                    style="width: 100%;" name="required">
                                                    <option selected="selected" value="">Select</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Continue</button>
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
                                <h4 class="modal-title">Update Document</h4>
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
                                        <label>Status:</label>
                                        <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <select class="form-control select2bs4 select2-hidden-accessible" name="status" id="required"
                                                    style="width: 100%;" data-select2-id="17" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option selected="selected">Select</option>
                                                     <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                    </div>
                            
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" onclick="document_edit()"
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
                        <p>Documents to be uploaded/provided before realeasing a Corpse.</p>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Document</th>
                                    <th>Required</th>
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
                    url: "{{ route('get_documents') }}",
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
                        data: 'required'
                    },
                   
                    {
                        data: 'added'
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
                // confirm('Are you sure ?')
                $.ajax({
                    url: "{{ route('delete_document') }}",
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
                            `${XMLHttpRequest.responseJSON.error?XMLHttpRequest.responseJSON.error: 'Something went wrong!'}.`,
                            'error'
                        )
                        console.log(XMLHttpRequest, textStatus, errorThrown);
                    }
                });
            }
        })
    }

    function get_document(id) {
        // open modal and send request to get conference data
        $('#update_modal').modal('show');
        $('#update_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('get_document') }}",
            type: 'GET',
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(result) {
                console.log(result);
                $('#update_modal').find('#overlay-wrapper').css('display', 'none');
                $('#update_modal').find('#name').val(result?.data?.name);
                // $('#update_modal').find('#status').val(result?.data?.status);
                 $('#update_modal').find('#required').prepend($("<option class='text-capitalize' selected ></option>")
                    .attr("value", result?.data?.required)
                    .text(result?.data?.required)); 
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

    function document_edit() {
        if ($('#update_modal').find('#id').val() == '') {
            Swal.fire(
                'Error!',
                `Please Select Conference on Trainnig`,
                'warning'
            )
            return;
        }
        let document_id = $('#update_modal').find('#id').val();
        console.log('document', document_id)
        $('#update_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('document_edit') }}",
            type: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                document_id: $('#update_modal').find('#id').val(),
                name: $('#update_modal').find('#name').val(),
                required: $('#update_modal').find('#required').val(),
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
