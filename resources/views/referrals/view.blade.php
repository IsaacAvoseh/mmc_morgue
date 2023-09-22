@extends('layout.main')


@section('content')
@section('title', 'Referral - View')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <p id="test">

        </p>
        <div class="row">
            <div class="col-12">

                <!-- /.modal-dialog -->
                <div class="card" id="print-card">
                    <div class="card-header">
                        <a class="align-self-start btn btn-default" href="{{ url()->previous() }}"> <i
                                class="fa fa-arrow-left"> </i> Back</a>
                        <div class="row d-flex justify-content-center">
                            <p class="h5">{{ $data->name ?? 'Corpse' }}</p>
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
                        
                        {{-- Update modal --}}
                <div class="modal fade" id="update_modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Update</h4>
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
                                            <input type="text" name="amount" id="amount"
                                                value="{{ old('amount') }}" class="form-control datetimepicker-input"
                                                placeholder="Amount">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Status:</label>
                                        <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <select class="form-control select2bs4 select2-hidden-accessible" name="status" id="status"
                                                    style="width: 100%;" data-select2-id="17" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option selected="selected">Select</option>
                                                    <option value="paid">Paid</option>
                                                     <option value="pending">Pending</option>
                                                </select>
                                            </div>
                                    </div>
                            
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" onclick="single_referral_details_edit()"
                                            class="btn btn-primary">Submit</button>
                                    </div>
                             
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                </div>


                        <div class="row">
                            <div class="col-md-6">
                                <h6>Details:</h6>
                                <p><strong>Phone Number:</strong> {{ $data->phone ?? '-' }}</p>
                                <p><strong>Address:</strong> {{ $data->address ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">

                                <p><strong>Email:</strong> {{ $data->email ?? '-' }}</p>
                                <p><strong>Referred:</strong>
                                    {{ DB::table('referral_details')->where('referral_id', $data->id)->count() ?? '0' }}
                                </p>
                                <p><strong>DOB:</strong> {{ $data->dob ?? '-' }}</p>


                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="card-body">
                        <p>Referral history</p>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    {{-- <th>Referred</th> --}}
                                    {{-- <th>DOB</th> --}}
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>
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


        // submit form
        function submitForm() {
            // $("#submit_button").click(function(){
            var allFilled = true;
            $('#admission_form input[required]').each(function() {
                if ($(this).val() == '') {
                    allFilled = false;
                    // return false;
                    $(this).css('border-color', 'red');
                    $(this).next('.error-message').text('This field is required.');
                }
            });
            if (allFilled) {
                // All required fields are filled
                console.log('fofof111')
                $('.card').find('#overlay-wrapper1').css('display', 'block');
                // $("#admission_form").find('form').submit();
                event.preventDefault();
                var formData = new FormData($('#form')[0]);
                console.log('fofof')
                $.ajax({
                    url: "{{ route('admit') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        $('.card').find('#overlay-wrapper1').css('display', 'none');
                        Swal.fire({
                            title: `Successfull !!`,
                            text: `${response.success?? 'Data Saved Successfully!'}`,
                            icon: 'success',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK!'
                        });
                        $('#admission_form').attr('hidden', true);
                        $('#admission_form2').attr('hidden', false);
                        $('#admission_form').find('#admission_id').val(response?.data.id);
                        $('#admission_form2').find('#admission_id2').val(response?.data.id);

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        $('.card').find('#overlay-wrapper1').css('display', 'none');

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

        $(function() {
            $('.card').find('#overlay-wrapper').css('display', 'none');
            $('.card').find('#overlay-wrapper1').css('display', 'none');
            $('#admission_form').attr('hidden', false);
            // $('#admission_form2').attr('hidden', false);

        });


        function printCard() {
            var card = $('#print-card');
            var originalDisplay = card.css('display');

            // Temporarily show the card for printing
            card.css('display', 'block');

            // Print the card section
            window.print();

            // Restore the original display style
            card.css('display', originalDisplay);
        }

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
                url: "{{ route('get_referral_details') }}",
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
                    data: 'amount'
                },

                {
                    data: 'status'
                },
                {
                    data: 'date'
                },

                {
                    data: 'action'
                },

            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

       

        function get_single_referral_details(id) {
        // open modal and send request to get conference data
        $('#update_modal').modal('show');
        $('#update_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('get_single_referral_details') }}",
            type: 'GET',
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(result) {
                console.log(result);
                $('#update_modal').find('#overlay-wrapper').css('display', 'none');
                $('#update_modal').find('#amount').val(result?.data?.amount);
                 $('#update_modal').find('#status').prepend($("<option selected ></option>")
                    .attr("value", result?.data?.status)
                    .text(result?.data?.status)); 
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

    function single_referral_details_edit() {

        $('#update_modal').find('#overlay-wrapper').css('display', 'block');
        $.ajax({
            url: "{{ route('single_referral_details_edit') }}",
            type: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                id: $('#update_modal').find('#id').val(),
                amount: $('#update_modal').find('#amount').val(),
                status: $('#update_modal').find('#status').val(),
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
    </script>
@endsection
@endsection
