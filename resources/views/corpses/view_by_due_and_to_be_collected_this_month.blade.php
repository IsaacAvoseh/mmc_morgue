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
                url: "{{ route('get_view_by_due_and_to_be_collected_this_month', ['stats' => request()->query('stats')]) }}",
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
