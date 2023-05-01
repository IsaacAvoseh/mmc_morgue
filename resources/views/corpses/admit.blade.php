@extends('layout.main')


@section('content')
@section('title', 'Corpse - Admission')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <p id="test">

        </p>
        <div class="row">
            <div class="col-12">

                <!-- /.modal-dialog -->
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-center">
                            <p class="h5">CORPSE ADMISSION FORM</p>
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

                        <div class="modal-body" id="admission_form" hidden>

                            <form enctype="multipart/form-data" id="form">
                                @csrf
                                <div class="row" data-select2-id="50">
                                    {{-- lodaing spinner --}}
                                    <div class="overlay-wrapper hidden" id="overlay-wrapper1">
                                        <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                        </div>
                                    </div>
                                    {{-- end loading spinner --}}
                                    <input type="hidden" name="admission_id" id="admission_id">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name of Deceased:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                                    class="form-control datetimepicker-input"
                                                    placeholder="Name of Deceased" required>
                                                {{-- <p class="error-message text-danger"></p> --}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Place of Death:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" step=".01" name="place_of_death"
                                                    min="0" placeholder="Abuja"
                                                    class="form-control datetimepicker-input"
                                                    value="{{ old('place_of_death') }}" data-target="#reservationdate">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Sex:</label>
                                                    <div class="input-group date" id="reservationdate"
                                                        data-target-input="nearest">
                                                        <input type="text" name="sex" min="0"
                                                            value="{{ old('sex') }}" placeholder="Male"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#reservationdate">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Age:</label>
                                                    <div class="input-group date" id="reservationdate"
                                                        data-target-input="nearest">
                                                        <input type="number" name="age" min="0"
                                                            value="{{ old('age') }}" placeholder="76"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#reservationdate">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" step=".01" name="address" min="0"
                                                    placeholder="Full Address" value="{{ old('address') }}"
                                                    class="form-control datetimepicker-input"
                                                    data-target="#reservationdate">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date:</label>
                                                    <div class="input-group date" id="reservationdate"
                                                        data-target-input="nearest">
                                                        <input type="date" step=".01" name="date_of_death"
                                                            min="0" value="{{ old('date_of_death') }}"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#reservationdate">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Time:</label>
                                                    <div class="input-group date" id="reservationdate"
                                                        data-target-input="nearest">
                                                        <input type="time" name="time_of_death"
                                                            class="form-control datetimepicker-input"
                                                            value="{{ old('time_of_death') }}"
                                                            data-target="#reservationdate">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Date Received at funeral home:</label>
                                                    <div class="input-group date" id="reservationdate"
                                                        data-target-input="nearest">
                                                        <input type="date" name="date_received" min="0"
                                                            value="{{ old('date_received') }}"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#reservationdate">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Time Received at funeral home:</label>
                                                    <div class="input-group date" id="reservationdate"
                                                        data-target-input="nearest">
                                                        <input type="time" name="time_received" min="0"
                                                            value="{{ old('time_received') }}"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#reservationdate">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    {{-- family rep 1 --}}
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Authorised Family Representative 1:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="family_rep1_name"
                                                    class="form-control datetimepicker-input" placeholder="Name"
                                                    value="{{ old('family_rep1_name') }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Address:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="family_rep1_address"
                                                    class="form-control datetimepicker-input" placeholder="Address"
                                                    value="{{ old('family_rep1_address') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Phone:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="family_rep1_phone"
                                                    placeholder="0812345678" class="form-control datetimepicker-input"
                                                    value="{{ old('family_rep1_phone') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Relationship with deceased:</label>
                                            <div class="input-group " id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="family_rep1_rel"
                                                    class="form-control datetimepicker-input" placeholder="Sister"
                                                    value="{{ old('family_rep1_rel') }}">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Authorised Family Representative 2:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="family_rep2_name"
                                                    class="form-control datetimepicker-input" placeholder="Name"
                                                    value="{{ old('family_rep2_name') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Address:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="family_rep2_address"
                                                    class="form-control datetimepicker-input" placeholder="Address"
                                                    value="{{ old('family_rep2_address') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Phone:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="family_rep2_phone"
                                                    placeholder="0812345678" class="form-control datetimepicker-input"
                                                    value="{{ old('family_rep2_phone') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Relationship with deceased:</label>
                                            <div class="input-group " id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="family_rep2_rel"
                                                    class="form-control datetimepicker-input" placeholder="Brother"
                                                    value="{{ old('family_rep2_rel') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Items removed from the deceased collected by - Name:</label>
                                                    <div class="input-group date" id="reservationdate"
                                                        data-target-input="nearest">
                                                        <input type="text" name="items_collected_by"
                                                            value="{{ old('items_collected_by') }}"
                                                            class="form-control datetimepicker-input"
                                                            placeholder="Name" data-target="#reservationdate"
                                                            required>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Items removed from the deceased collected by - Phone:</label>
                                                    <div class="input-group date" id="reservationdate"
                                                        data-target-input="nearest">
                                                        <input type="text" name="items_collected_phone"
                                                            value="{{ old('items_collected_phone') }}"
                                                            class="form-control datetimepicker-input"
                                                            placeholder="Phone" data-target="#reservationdate"
                                                            required>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Rack:</label><br>
                                            <small>Available: {{ count($racks) }}</small>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <select class="form-control" name="rack_id" id="rack_id"
                                                    style="width: 100%;" required>
                                                    @forelse ($racks as $rack)
                                                        <option value="{{ $rack->id }}">{{ $rack->name ?? '-' }}
                                                        </option>
                                                    @empty
                                                        <option value="">No rack availbe</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal-footer justify-content-between">
                                    <a href="{{ url()->previous() }}" class="btn btn-default"
                                        data-dismiss="modal">Back</a>
                                    <button type="button" onclick="submitForm()" class="btn btn-primary w-25">Submit
                                        & Continue</button>
                                </div>
                            </form>
                        </div>

                        {{-- FIle Upload --}}
                        <div class="modal-body" id="admission_form2" hidden>
                            {{-- lodaing spinner --}}
                            <div class="overlay-wrapper hidden" id="overlay-wrapper2">
                                <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                </div>
                            </div>
                            {{-- end loading spinner --}}
                            <form enctype="multipart/form-data" id="form2">
                                @csrf
                                <input type="hidden" name="admission_id" id="admission_id2">
                                {{-- <input type="hidden" name="admission_id" id="admission_id2"> --}}
                                <p class="">Please Upload the following files (You can skip and upload later)</p>
                                <a onclick="showPrev()" class="btn btn-default mb-2"> <i
                                        class="fas fa-arrow-left"></i> Back</a>
                                <div class="row">
                                    @forelse ($files as $key => $file)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ $file->name ?? 'File' }}:</label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="file" name="document_{{ $key + 1 }}"
                                                        class="form-control datetimepicker-input"
                                                        {{ $file->required == 'yes' ? 'required' : '' }} />
                                                    <input type="hidden" value="{{ $file->id }}">
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-danger">No files to upload for now, please continue...</p>
                                    @endforelse
                                    <input type="hidden" name="filename" value="{{ $file->name ?? 'No Name' }}">
                                    <div class="col-md-12">
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" onclick="showPaymentForm()"
                                                class="btn btn-secondary">Continue without Upload</button>
                                            <button type="button" onclick="submitFileForm()"
                                                class="btn btn-primary w-25">Upload & Continue</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Payment --}}
                        <div class="modal-body" id="admission_form3" hidden>
                            {{-- lodaing spinner --}}
                            <div class="overlay-wrapper hidden" id="overlay-wrapper3">
                                <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                </div>
                            </div>
                            {{-- end loading spinner --}}
                            <form method="POST" action="{{ route('with_payment') }}" enctype="multipart/form-data"
                                id="form3">
                                @csrf
                                <input type="hidden" name="admission_id" id="admission_id3">
                                <p class="text-danger"></p>
                                <a onclick="showFileForm()" class="btn btn-default mb-2"> <i
                                        class="fas fa-arrow-left"></i> Back</a>
                                <div class="row">
                                    <div class="col-md-6" id="rcp">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Fee</th>
                                                    <th>Amount</th>
                                                    <th>Select</th>
                                                    <th class="text-center">Unit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $totalAmount = 0; ?>
                                                @foreach ($fees as $fee)
                                                    <tr>
                                                        <td>{{ $fee->name }}</td>
                                                        <td
                                                            class="{{ $fee->name == 'Daily Fee' ? 'daily-fee' : 'no' }}">
                                                            {{ $fee->price }}</td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input fee-checkbox"
                                                                    type="checkbox" name="fee[]"
                                                                    value="{{ $fee->id }}"
                                                                    data-amount="{{ $fee->price }}" />
                                                                <input type="hidden" value="{{ $fee->price }}"
                                                                    name="price[]">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <button class="btn btn-outline-danger decrement-btn"
                                                                    type="button">-</button>
                                                                <input type="text"
                                                                    class="form-control text-center unit-fee"
                                                                    name="unit_fee[]"
                                                                    id="{{ $fee->name == 'Daily Fee' ? 'daily' : 'na' }}"
                                                                    value="{{ $fee->name == 'Embalmment' ? '1' : '0' }}"
                                                                    readonly />
                                                                <button class="btn btn-outline-success increment-btn"
                                                                    type="button">+</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td><strong>Total:</strong></td>
                                                    <td><strong>N<span
                                                                id="total-amount">{{ $totalAmount }}</span></strong>
                                                        <span> <button type="button" class="btn btn-secondary btn-sm"
                                                                onclick="resetForm()"> <i
                                                                    class="fas fa-undo"></i></button> </span>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>FROM:</label>
                                                    <div class="input-group date" data-target-input="nearest">
                                                        <input type="date" name="date_from" id="date_from"
                                                            value="{{ old('date_from') }}"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#reservationdate" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>TO:</label>
                                                    <div class="input-group date" data-target-input="nearest">
                                                        <input type="date" name="date_to" id="date_to"
                                                            value="{{ old('date_to') }}"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#reservationdate" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Number of Days:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="number" min="0" name="no_of_days"
                                                    id="no-of-days" class="form-control datetimepicker-input"
                                                    placeholder="Number of days" data-target="#reservationdate"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Amount:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="total_amount" id="total_amount" readonly
                                                    class="form-control datetimepicker-input"
                                                    placeholder="Total Amount" data-target="#reservationdate"
                                                    required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Payment Mode:</label><br>
                                            <div class="input-group date">
                                                <select class="form-control" name="mode" id="mode"
                                                    style="width: 100%;" required>
                                                    <option value="">Select</option>
                                                    <option value="cash">Cash</option>
                                                    <option value="tranfer">Transfer</option>
                                                    <option value="pos">POS</option>
                                                    <option value="others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="modal-footer justify-content-between">
                                            <a href="{{ route('without_payment') }}"
                                                class="btn btn-secondary">Continue without
                                                Payment</a>
                                            <button type="button" onclick="submitWithPayment()" class="btn btn-primary w-25">Pay Now & Continue </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        
                        </div>
                        <style>
                            .my-toast-class {
                                font-size: 14px;
                                padding: 10px 20px;
                            }
                        </style>
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
     var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000
    });
    // $(window).on('beforeunload', function() {
    //     return 'Are you sure you want to leave?';
    // });
    $(document).on('change', 'input[type="file"]', function() {
        var input = $(this);
        var fileName = input.val().split('\\').pop();
        var hiddenInput = input.closest('.form-group').find('input[type="hidden"]');
        if (fileName) {
            hiddenInput.attr('name', 'document_id[]');
        } else {
            hiddenInput.removeAttr('name');
        }
    });
    document.addEventListener("DOMContentLoaded", function(event) {
        $('.fee-checkbox').prop('checked', true);
        document.getElementById('date_from').valueAsDate = new Date();
    });

    function loading() {
        $('.card').find('#overlay-wrapper').css('display', 'block');
    }

    // show main forrm
    function showPrev() {
        $('#admission_form').attr('hidden', false);
        $('#admission_form2').attr('hidden', true);
    }

    // Show with_payment form
    function showPaymentForm() {
        $('#admission_form').attr('hidden', true);
        $('#admission_form2').attr('hidden', true);
        $('#admission_form3').attr('hidden', false);
    }

    // Show files form
    function showFileForm() {
        $('#admission_form').attr('hidden', true);
        $('#admission_form2').attr('hidden', false);
        $('#admission_form3').attr('hidden', true);
    }


    // submit form
    function submitForm() {
        // $("#submit_button").click(function(){
        var allFilled = true;
        $('#admission_form input[required]').each(function() {
            if ($(this).val() == '' || $(this).val() == null) {
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
                    $('#admission_form3').find('#admission_id3').val(response?.data.id);

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

    // submit file form 
    function submitFileForm() {
        // $("#submit_button").click(function(){
        var allFilled = true;
        $('#admission_form2 input[required]').each(function() {
            console.log($(this).val())
            if ($(this).val() == '' || $(this).val() == null) {
                allFilled = false;
                // return false;
                $(this).css('border-color', 'red');
                $(this).next('.error-message').text('This field is required.');
            }
        });
        if (allFilled) {
            // All required fields are filled
            $('.card').find('#overlay-wrapper2').css('display', 'block');
            event.preventDefault();
            var formData = new FormData($('#form2')[0]);
            console.log('fofof', formData)
            $.ajax({
                url: "{{ route('update_admission') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('.card').find('#overlay-wrapper2').css('display', 'none');
                    Swal.fire({
                        title: `Successfull !!`,
                        text: `${response.success?? 'Files Saved Successfully!'}`,
                        icon: 'success',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK!'
                    });
                    $('#admission_form').attr('hidden', true);
                    $('#admission_form2').attr('hidden', true);
                    $('#admission_form3').attr('hidden', false);
                    // $('#admission_form').find('#admission_id').val(response?.data.id);
                    // $('#admission_form2').find('#admission_id2').val(response?.data.id);
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
                    $('.card').find('#overlay-wrapper2').css('display', 'none');

                }
            });
            return true;
        } else {
            // Some required fields are not filled
            Swal.fire({
                title: `Please upload all required files`,
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

    // submit with with_payment
    // submit form
    function submitWithPayment() {
        // $("#submit_button").click(function(){
        var allFilled = true;
        $('#admission_form3 input[required]').each(function() {
            if ($(this).val() == '') {
                allFilled = false;
                // return false;
                $(this).css('border-color', 'red');
                $(this).next('.error-message').text('This field is required.');
            }
        });
        if (allFilled) {
            // Get the receipt contents
            const receipt = document.getElementById('rcp').innerHTML;
            // All required fields are filled
            $('.card').find('#overlay-wrapper3').css('display', 'block');
            // $("#admission_form3").find('#form3').submit();
            event.preventDefault();
            var formData = new FormData($('#form3')[0]);
            console.log('form', formData)
            $.ajax({
                url: "{{ route('with_payment') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Payment',response);
                    $('.card').find('#overlay-wrapper1').css('display', 'none');
                    Swal.fire({
                        title: `Successfull !!`,
                        text: `${response.success?? 'Saved Successfully!'}`,
                        icon: 'success',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK!'
                    }).then((result) => {
                        generateReceipt();
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('corpses') }}"
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
                    $('.card').find('#overlay-wrapper3').css('display', 'none');

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
        $(function() {
            $('.card').find('#overlay-wrapper').css('display', 'none');
            $('.card').find('#overlay-wrapper1').css('display', 'none');
            $('.card').find('#overlay-wrapper2').css('display', 'none');
            $('.card').find('#overlay-wrapper3').css('display', 'none');
            $('#admission_form').attr('hidden', false);
            // $('#admission_form2').attr('hidden', false);

            // fee cal
            updateTotalAmount();

            // Update total amount when a checkbox is checked or unchecked
            $('.fee-checkbox').change(function() {
                updateTotalAmount();
            });

            // Increment unit fee when the plus button is clicked
            $('.increment-btn').click(function() {
                let unitFeeInput = $(this).prev('.unit-fee');
                let checkbox = $(this).closest('tr').find('.fee-checkbox');
                let isChecked = checkbox.prop('checked');

                if (!isChecked) {
                    checkbox.prop('checked', true);
                }

                let unitFee = parseInt(unitFeeInput.val());
                let day = unitFee++;
                if ($(this).prev('.unit-fee').attr('id') == 'daily') {
                    // $('#no-of-days').off('change');
                    $('#no-of-days').val(unitFee).focus().trigger('change');
                }
                unitFeeInput.val(unitFee);

                updateTotalAmount();
            });

            // Decrement unit fee when the minus button is clicked
            $('.decrement-btn').click(function() {
                let unitFeeInput = $(this).next('.unit-fee');
                let checkbox = $(this).closest('tr').find('.fee-checkbox');
                let isChecked = checkbox.prop('checked');

                if (!isChecked) {
                    checkbox.prop('checked', true);
                }

                let unitFee = parseInt(unitFeeInput.val());
                if (unitFee > 0) {
                    let day1 = unitFee--;
                    if ($(this).next('.unit-fee').attr('id') == 'daily') {
                        // $('#no-of-days').off('change');
                        $('#no-of-days').val(unitFee).focus().trigger('change');
                    }
                    unitFeeInput.val(unitFee);

                    updateTotalAmount();
                }
            });

            // Update total amount when the number of days input changes
            $('#no-of-days').on('change', function() {
                let dailyFeeAmount = $('.daily-fee').text().trim();
                let noOfDays = $(this).val();
                let dailyFeeTotal = dailyFeeAmount * noOfDays;

                // Read the value of the date_from field
                var date_from = $("#date_from").val();
                $.ajax({
                    url: "{{ route('add_days') }}",
                    type: 'GET',
                    data: {
                        _token: "{{ csrf_token() }}",
                        date_from: $('#date_from').val(),
                        days: noOfDays,
                    },
                    success: function(result) {
                        console.log('result', result);
                        if (result) {
                            $("#date_to").val(result.date);
                        }

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {

                    console.log(XMLHttpRequest);
                    }
                });

                let dailyFeeInput = $('.daily-fee input');
                if (dailyFeeInput.length > 0) {
                    dailyFeeInput.val(dailyFeeTotal);
                } else {
                    let dailyFeeRow = $('.daily-fee');
                    dailyFeeRow.find('td').eq(1).text(dailyFeeAmount * noOfDays);
                }
                $('#daily').val(noOfDays);
                updateTotalAmount();
            });

            // Function to update the total amount
            function updateTotalAmount() {
                let totalAmount = 0;
                $('.fee-checkbox:checked').each(function() {
                    let amount = $(this).data('amount');
                    let unitFee = $(this).closest('tr').find('.unit-fee').val();
                    let feeTotal = amount * unitFee;
                    totalAmount += feeTotal;
                });

                let dailyFeeInput = $('.daily-fee input');
                let dailyFeeAmount = $('.daily-fee').text().trim();
                let noOfDays = $('#no-of-days').val();
                // let dailyFeeTotal = dailyFeeAmount * noOfDays;

                if (dailyFeeInput.length > 0) {
                    dailyFeeInput.val(dailyFeeAmount * noOfDays);
                } else {
                    let dailyFeeRow = $('.daily-fee');
                    dailyFeeRow.find('td').eq(1).text(dailyFeeAmount * noOfDays);
                    // totalAmount += dailyFeeTotal;
                }

                $('#total-amount').text(totalAmount.toLocaleString());
                $('#total_amount').val(totalAmount);
            }

        });

        $('#date_to').change(function() {
            if ($('#date_from').val() == '') {
                Swal.fire(
                    'Error!',
                    `Please select both dates`,
                    'warning'
                )
                return;
            }
            $('.card').find('#overlay-wrapper3').css('display', 'block');
            $.ajax({
                url: "{{ route('get_num_of_days') }}",
                type: 'GET',
                data: {
                    _token: "{{ csrf_token() }}",
                    date_from: $('#date_from').val(),
                    date_to: $('#date_to').val(),
                },
                success: function(result) {
                    console.log('result', result);
                    // $('#no-of-days').val(result.days)
                    if (result.days > 0) {
                        $('#no-of-days').val(result.days).focus().trigger('change');
                        $('#daily').val(result.days);
                    }
                    $('.card').find('#overlay-wrapper3').css('display', 'none');
                     Toast.fire({
                    icon: 'success',
                    title: 'Number of days updated Successfully !'
                  })
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: `${XMLHttpRequest.responseJSON.error}`,
                        showConfirmButton: false,
                        timer: 3000
                    })
                    $('.card').find('#overlay-wrapper3').css('display', 'none');
                    console.log(XMLHttpRequest);
                }
            });

        });

        $('#date_from').change(function() {

            if ($('#date_to').val() == '') {
                Swal.fire(
                    'Error!',
                    `Please select both dates`,
                    'warning'
                )
                return;
            }

        });


    });

    function resetForm() {
        // Reset all unit fees to 0
        $('.unit-fee').val(0);

        // Uncheck all fee checkboxes
        // $('.fee-checkbox').prop('checked', false);

        // Reset number of days to 1
        $('#no-of-days').val(0);

        // Reset total amount
        $('#total-amount').text('5000');
        $('#total_amount').val('5000');
    }

    function generateReceipt() {
        // Get all selected fees
        var fees = document.querySelectorAll('input[name="fee[]"]:checked');
        var name =  $('#name').val();
        var mode =  $('#mode').val().toUpperCase();

        // receipt no
         // Generate a random 6-digit number
  const randomNumber = Math.floor(Math.random() * 900000) + 100000;
  // Get the current timestamp in milliseconds
  const timestamp = Date.now();
  // Combine the random number and timestamp to create the receipt number
  const receiptNumber = `#REC-${randomNumber}-${timestamp}`;

        // Create a table to display the receipt
        var table = '<table>' +
            '<thead>' +
            `<tr> ${receiptNumber} </tr>` +
            '<tr>' +
            '<th>Fee</th>' +
            '<th>Amount</th>' +
            '<th>Units</th>' +
            '<th>Subtotal</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';

        // Loop through each selected fee and calculate subtotal
        var totalAmount = 0;
        fees.forEach(function(fee) {
            var amount = parseFloat(fee.dataset.amount);
            var units = parseInt(fee.parentNode.parentNode.parentNode.querySelector('.unit-fee').value);
            var subtotal = amount * units;
            totalAmount += subtotal;

            // Add fee details to the table
            table += '<tr>' +
                '<td>' + fee.parentNode.parentNode.parentNode.querySelector('td:first-child').textContent +
                '</td>' +
                '<td>' + amount.toFixed(2) + '</td>' +
                '<td>' + units + '</td>' +
                '<td>' + subtotal.toFixed(2) + '</td>' +
                '</tr>';
        });

        // Add total amount to the table
        table += '<tr>' +
            '<td colspan="3"><strong>Total:</strong></td>' +
            '<td><strong>' + totalAmount.toFixed(2) + '</strong></td>' +
            '</tr>' +
            '<tr>' +
            '<td colspan="2"><strong>Deceased Name:</strong></td>' +
            '<td><strong>' + name + '</strong></td>' +
            '</tr>'+
            '<tr>' +
            '<td colspan="2"><strong>Payment Mode:</strong></td>' +
            '<td><strong>' + mode + '</strong></td>' +
            '</tr>'+
            '</tbody>' +
            '</table>';


        // Display the table as a receipt
        var receipt = document.createElement('div');
        receipt.innerHTML = table;
        // document.getElementById('rcp').appendChild(receipt);
          const printWindow = window.open('', 'Print Receipt');
        printWindow.document.write(receipt.innerHTML);
         printWindow.document.close();
        // Print the receipt
        printWindow.print();
    }

    function printReceipt() {
        // Get the receipt HTML element
        const receipt = document.getElementById('rcp');
        // Clone the receipt node so we can modify it without changing the original
        const clonedReceipt = receipt.cloneNode(true);
        // Remove the print button from the cloned receipt
        const printButton = clonedReceipt.querySelector('#print-btn');
        printButton.parentNode.removeChild(printButton);
        // Open a new window with the cloned receipt
        const printWindow = window.open('', 'Print Receipt');
        printWindow.document.write(clonedReceipt.innerHTML);
        //   printWindow.document.close();
        // Print the receipt
        printWindow.print();
    }

    function generateReceipt4() {
        // Get the selected fees
        const selectedFees = document.querySelectorAll('input[type="checkbox"]:checked');
        console.log(typeof(selectedFees))
        // Calculate the total amount
        let totalAmount = 0;
        selectedFees.forEach((fee) => {
            totalAmount += parseFloat(fee.dataset.amount) * parseInt(fee.closest('tr').querySelector(
                '.unit-fee').value);
        });

        // Create the receipt HTML
            const receiptHTML = `
        <h1>Receipt</h1>
        <table>
        <thead>
            <tr>
            <th>Fee</th>
            <th>Amount</th>
            <th>Unit</th>
            <th>Total</th>
            </tr>
        </thead>
        <tbody>
            ${selectedFees.map((fee) => `
            <tr>
                <td>${fee.closest('td').previousElementSibling.textContent}</td>
                <td>${fee.dataset.amount}</td>
                <td>${fee.closest('tr').querySelector('.unit-fee').value}</td>
                <td>${(parseFloat(fee.dataset.amount) * parseInt(fee.closest('tr').querySelector('.unit-fee').value)).toFixed(2)}</td>
            </tr>
            `).join('')}
            <tr>
            <td colspan="3"><strong>Total:</strong></td>
            <td><strong>${totalAmount.toFixed(2)}</strong></td>
            </tr>
        </tbody>
        </table>
          `;

            // Create a new window with the receipt HTML
            const receiptWindow = window.open('', 'PRINT', 'height=600,width=800');
            receiptWindow.document.write(`<html><head><title>Receipt</title></head><body>${receiptHTML}</body></html>`);

            // Prompt the user to print the receipt
            receiptWindow.document.close();
            receiptWindow.focus();
            receiptWindow.print();
            receiptWindow.close();
    }
</script>
@endsection
