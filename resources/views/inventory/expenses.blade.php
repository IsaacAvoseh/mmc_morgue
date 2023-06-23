@extends('layout.main')


@section('content')
@section('title', 'Expense Journal')
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
                                {{-- lodaing spinner --}}
                                <div class="overlay-wrapper" id="overlay-wrapper" hidden>
                                    <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                {{-- end loading spinner --}}
                                <form action="{{ route('expenses') }}" method="POST" id="form">
                                    @csrf
                                   <div class="row">
                                    <div class="col">
                                         <div class="form-group">
                                        <label> Date </label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="date" name="date" value="{{ old('date') }}"
                                                class="form-control datetimepicker-input" placeholder="15/03/2024"
                                                required>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col">
                                         <div class="form-group">
                                        <label> Category </label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                           <select class="form-control select2bs4 select2-hidden-accessible" name="expense_category_id" id="required"
                                                    style="width: 100%;" data-select2-id="17" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option selected="selected" value="">Select</option>
                                                     @forelse ($expense_category as $category)
                                                         <option value="{{ $category->id?? '-' }}">{{ $category->name?? '-' }}</option>
                                                     @empty
                                                      <p>No category</p>
                                                     @endforelse
                                                </select>
                                        </div>
                                    </div>
                                    </div>
                                   </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label> Vendor </label>
                                                <div class="input-group date">
                                                    <input type="text" name="vendor" value="{{ old('vendor') }}"
                                                        class="form-control" placeholder="e.g Filling Station" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label> Amount </label>
                                                <div class="input-group date">
                                                    <input type="number" name="amount" value="{{ old('amount') }}"
                                                        class="form-control" placeholder="3000" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label> Details </label>
                                        <div class="input-group date">
                                            <textarea type="date" name="details" value="{{ old('details') }}" class="form-control datetimepicker-input"
                                                cols="30" rows="5" placeholder="e.g Purchase of hand of glove" required></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" onclick="submitForm()"
                                            class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                {{-- add new modal --}}

                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <p></p>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#addNewModal">
                                <i class="fa fa-plus"></i>
                                Add New
                            </button>
                        </div>
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
                                    <th>Vendor</th>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Details</th>
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

        var table;

        $(function() {
            $('.card').find('#overlay-wrapper').css('display', 'none');

            table = $("#example1").DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                ordering: true,
                pageLength: 50,
                responsive: true,
                info: true,
                ajax: {
                    type: "GET",
                    url: "{{ route('get_expenses') }}",
                    dataSrc: function(data) {
                        console.log('data', data)
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
                        data: 'vendor'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'category'
                    },
                    {
                        data: 'details'
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
                        table.ajax.url("{{ route('get_expenses') }}?start_date=" +
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
        console.log('first', table)
        // Submit form
        function submitForm() {
            // $("#submit_button").click(function(){
            var allFilled = true;
            $('#form input[required]').each(function() {
                if ($(this).val() == '') {
                    allFilled = false;
                    // return false;
                    $(this).css('border-color', 'red');
                    $(this).next('.error-message').text('This field is required.');
                }
            });
            if (allFilled) {
                // All required fields are filled
                $('#addNewModal').find('#overlay-wrapper').css('display', 'block');
                event.preventDefault();
                var formData = new FormData($('#form')[0]);
                console.log('form', formData)
                $.ajax({
                    url: "{{ route('expenses') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Payment', response);
                        $('#addNewModal').find('#overlay-wrapper').css('display', 'none');
                        Swal.fire({
                            title: `Successfull !!`,
                            text: `${response.success?? 'Saved Successfully!'}`,
                            icon: 'success',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                table.ajax.reload();
                                $('#addNewModal').find('#overlay-wrapper').css('display', 'none');
                                $('#addNewModal').modal('hide'); // hide the modal
                                $('#form')[0].reset();
                            }
                        })
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest);
                        if (XMLHttpRequest.responseJSON.error) {
                            Swal.fire(
                                'Error !',
                                `${XMLHttpRequest.responseJSON.error?XMLHttpRequest.responseJSON.error: 'Something went wrong!'}.`,
                                'error'
                            )
                        } else {
                            $.each(XMLHttpRequest.responseJSON.errors, function(key, value) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: value[0],
                                });
                            });
                        }
                        $('#addNewModal').find('#overlay-wrapper3').css('display', 'none');

                    }
                });
                return true;
            } else {
                // Some required fields are not filled
                Swal.fire({
                    title: `Please fill all required input`,
                    text: "Input with red outline are required!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Back!'
                });
                return false;
            }

        }
    </script>
@endsection
@endsection
