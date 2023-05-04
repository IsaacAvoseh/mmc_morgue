@extends('layout.main')


@section('content')
@section('title', 'Payment History')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <p id="test">

        </p>
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <i class="fas fa-file-invoice"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Cash</span>
                                <span class="info-box-number" id="cash"></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>

                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-success">
                                <i class="fas fa-money-check"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">Transfer</span>
                                <span class="info-box-number" id="transfer"></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="fas fa-money-check-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">POS</span>
                                <span class="info-box-number" id="pos"> </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-secondary"><i class="fas fa-money-check-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Others</span>
                                <span class="info-box-number" id="others"></span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <div class="card">
                    <div class="card-header">

                        {{-- lodaing spinner --}}
                        <div class="overlay-wrapper" id="overlay-wrapper">
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
                                    <th>Date</th>
                                    <th>Corpse</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Payment Method</th>
                                    <th>User</th>
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
                url: "{{ route('get_payment_history') }}",
                dataSrc: function(data) {
                    console.log('data', data)
                    $('#cash').text(data.cash)
                    $('#transfer').text(data.transfer)
                    $('#pos').text(data.pos)
                    $('#others').text(data.others)
                    return data.aaData
                }
            },
            columns: [{
                    data: 'id',

                },
                {
                    data: 'date'
                },
                {
                    data: 'corpse_name'
                },
                {
                    data: 'amount'
                },
                {
                    data: 'service'
                },
                {
                    data: 'payment_method'
                },

                {
                    data: 'user_name'
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
                    table.ajax.url("{{ route('get_payment_history') }}?start_date=" +
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
