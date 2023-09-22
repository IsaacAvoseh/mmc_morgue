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
                                                <input type="text" name="name" id="name"
                                                    value="{{ old('name') }}"
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
                                                            data-target="#reservationdate" required>
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
                            @include('shared.referral', [
                                'ref_corpse_id' => session()->get('ref_corpse_id'),
                            ])

                              @include('shared.payment', [
                                'ref_corpse_id' => session()->get('ref_corpse_id'),
                            ])

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
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });
        
        document.addEventListener("DOMContentLoaded", function(event) {
            $('.fee-checkbox').prop('checked', true);
        });

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

    
        $(function() {
            $('.card').find('#overlay-wrapper').css('display', 'none');
            $('.card').find('#overlay-wrapper1').css('display', 'none');
            $('.card').find('#overlay-wrapper2').css('display', 'none');
            $('.card').find('#overlay-wrapper3').css('display', 'none');
            $('#admission_form').attr('hidden', false);

        });



    </script>

@endsection
@endsection
