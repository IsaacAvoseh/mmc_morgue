@extends('layout.main')


@section('content')
@section('title', 'Released')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <p id="test">

        </p>
        <div class="row">
            <div class="col-12">
        
                <div class="card">
                    <div class="card-header">
                        {{-- <div class="row justify-content-between">
                            <a href="{{ route('admit') }}" type="button" class="btn btn-primary btn-sm rounded">
                                <i class="fa fa-plus"></i>
                                Admit
                            </a>
                        </div> --}}
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
                                    <th>Sex</th>
                                    <th>Date Discharged</th>
                                    <th>Collector</th>
                                    <th>Relationship</th>
                                    <th>Collector Phone</th>
                                    <th>Collector Address</th>
                                    <th>Interment Address</th>
                                    <th>Interment LGA</th>
                                    <th>Drivers Name</th>
                                    <th>Vehicle Number</th>
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
        $('.card').find('#overlay-wrapper').css('display', 'none');
            $("#example1").DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                ordering: false,
                pageLength: 50,
                responsive: true,
                info: true,
                ajax: {
                    type: "GET",
                    url: "{{ route('get_release_list') }}",
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
                        data: 'sex'
                    },
                    {
                        data: 'date_discharged'
                    },
                    {
                        data: 'collector'
                    },
                    {
                        data: 'relationship'
                    },
                    {
                        data: 'collector_phone'
                    },
                    {
                        data: 'collector_address'
                    },
                    {
                        data: 'interment_address'
                    },
                    {
                        data: 'interment_lga'
                    },
                    {
                        data: 'driver_name'
                    },
                    {
                        data: 'vehicle_number'
                    },

                    ],
                dom: '<"top"lBf>rt<"bottom"ip>',
                buttons: [
                'csv', 'excel', 'pdf', 'print'
                ],
            });
            
    });
</script>
@endsection
