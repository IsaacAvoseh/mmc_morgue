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

           var table = $("#example1").DataTable({
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

                  initComplete: function() {
                // Add date range picker
                $('<div class="float-right"><input type="text" class="form-control form-control-sm" id="daterange"><button class="btn btn-secondary btn-sm mb-1" ><i class="fas fa-calendar-alt"></i></button></div>')
                    .appendTo('.dataTables_wrapper .dataTables_filter');

                // Initialize date range picker
                $('#daterange').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    },
                    buttonClasses: 'btn btn-sm btn-outline-secondary',
                    applyButtonClasses: 'btn-primary text-white',
                    cancelButtonClasses: 'btn-secondary text-white',
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1,
                            'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'),
                            moment().subtract(1, 'month').endOf('month')
                        ]
                    },
                    showCustomRangeLabel: false,
                    alwaysShowCalendars: true,
                    opens: 'left'
                }).on('apply.daterangepicker', function(ev, picker) {
                    var startDate = picker.startDate.format('YYYY-MM-DD');
                    var endDate = picker.endDate.format('YYYY-MM-DD');
                    table.ajax.url("{{ route('get_release_list') }}?start_date=" +
                        startDate + "&end_date=" + endDate).load();
                    // set the value of the input field to the selected date range
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker
                        .endDate.format('YYYY-MM-DD'));

                }).on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                    $('#daterange').val('');
                    $('#example1').DataTable().draw();
                }).attr("placeholder", "Select Date Range").append(
                    '<i class="fas fa-calendar-alt"></i>');

            }
            });
            
    });
</script>
@endsection
