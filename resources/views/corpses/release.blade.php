@extends('layout.main')


@section('content')
@section('title', 'Coprse - Release')
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
                            <p class="h3 font-weight-bold">{{ $data->name ?? 'Corpse' }}</p>
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
                        @if ($release == 'no')
                            <div class="col">
                                @if ($file_message != 'no')
                                    <p class="font-weight-bold text-danger">** {{ $file_message ?? '' }}. <a
                                            href="{{ route('update_before_release', ['id' => base64_encode($data->id)]) }}">Click
                                            here to upload</a></p>
                                @endif

                                @if ($payment_message != 'no')
                                    <p class="font-weight-bold text-danger">** {{ $payment_message ?? '' }}. <a
                                            href="{{ ($data->amount != 0) & ($due_today != 0) ? route('update_payment', ['id' => base64_encode($data->id)]) : route('update_before_release', ['id' => base64_encode($data->id)]) }}">Click
                                            here to pay</a></p>
                                @endif
                            </div>
                        @endif

                        <div class="modal-body" id="admission_form">
                            {{-- lodaing spinner --}}
                            <div class="overlay-wrapper hidden" id="overlay-wrapper1">
                                <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                </div>
                            </div>
                            {{-- end loading spinner --}}
                            <form action="{{ route('release') }}" method="POST" id="form">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="corpse_id" id="corpse_id" value="{{ $data->id }}">
                                <input type="hidden" name="rack_id" id="rack_id" value="{{ $data->rack_id }}">

                                <div class="d-flex justify-content-between align-items-center bg-secondary my-1 p-2">
                                    <div class="col">
                                        <p class="font-weight-bold">Amount Paid: <br> N {{ number_format($data->amount_paid + $data->affixed_bill - $data->discount ?? 0, 2) }} </p>
                                       
                                    </div>
                                    <div class="col">
                                        <p class="font-weight-bold">Discount : <br> N {{ number_format($data->discount ?? 0, 2) }}</p>
                                        </p>
                                    </div>
                                    <div class="col">
                                        <p class="font-weight-bold">Affixed Bill : <br> N {{ number_format($data->affixed_bill ?? 0, 2) }}</p>
                                        </p>
                                    </div>
                                     <div class="col">
                                        <p class="font-weight-bold">From : <br> {{ $data->date_from?? '---' }}</p>
                                        </p>
                                    </div>
                                      <div class="col">
                                        <p class="font-weight-bold">Days : <br> {{ $days_diff }}</p>
                                        </p>
                                    </div>
                                    <div class="col">
                                        <p title="{{ "You used N$daily_fee as the daily fee when you registered this corpse, so this due balance was calculated based on that"}}" class="font-weight-bold text-warning">Due today <span title="{{"You used N$daily_fee as the daily fee when you registered this corpse, so this due balance was calculated based on that"}}" class="info">ℹ️</span>: <br> N {{ number_format($due_today ?? 0, 2) }} <sub>Daily Fee</sub></p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center bg-secondary my-1 p-2">
                                    <hr style="color: white; height:10px; align-self:baseline" >
                                     @forelse ($corpse_payment as $payment)
                                       <div class="col">
                                        <p class="font-weight-bold">{{  $payment->service->name?? 'Affixed Bill' }} : <br> N {{ number_format($payment->amount?? 0, 2) }} <sub>(Paid)</sub></p>
                                        </p>
                                    </div>  
                                     @empty
                                        <div class="col">
                                        <p class="font-weight-bold">No Payment data</p>
                                        
                                        <div class="d-flex justify-content-between align-items-center b my-1 p-2">
                                            <div class="col">
                                            <p class="font-weight-bold">Date Received : <br> {{ $data->date_received?? '---' }}</p>
                                           </div>
                                            <div class="col">
                                            <p class="font-weight-bold">No of days from Date Received : <br> {{ $optional_from_date_received?? '---' }}</p>
                                           </div>
                                        </div>

                                
                                    </div> 
                                     @endforelse
                                </div>
                                 <div class="d-flex justify-content-end align-items-center bg-link card my-1 p-2">
                                    <span> 
                                        <a class="btn btn-info m-1 w-100" href="{{ route('update_payment', ['id' => base64_encode($data->id)]) }}">Update Payement</a>
                                    </span>
                                 </div>
                                <div class="form-group">
                                    <label>Name of Deceased:</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="name" id="name"
                                            value="{{ $data->name ?? old('name') }}"
                                            class="form-control datetimepicker-input" placeholder="Name of Deceased"
                                            required readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date Admitted:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="date" name="date_admit" id="date_admit"
                                                    value="{{ $data->date_received ?? $data->from }}"
                                                    class="form-control datetimepicker-input"
                                                    placeholder="Name of Deceased" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date Discharge:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="date" name="date_discharged" id="date_discharged"
                                                    value="{{ old('date_discharged') }}"
                                                    class="form-control datetimepicker-input"
                                                    placeholder="Name of Deceased" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Address of Deceased:</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="address" id="address"
                                            value="{{ $data->address ?? old('address') }}"
                                            class="form-control datetimepicker-input" placeholder="Address of Deceased"
                                            required readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Age of Deceased:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="number" name="age" id="age"
                                                    value="{{ $data->age ?? old('age') }}"
                                                    class="form-control datetimepicker-input" placeholder="76" required
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of Death:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="date" name="date" id="date"
                                                    value="{{ $data->date_of_death ?? old('date') }}"
                                                    class="form-control datetimepicker-input" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Name of Collector:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="collector" id="collector"
                                                    value="{{ old('collector') }}"
                                                    class="form-control datetimepicker-input" placeholder="John Doe"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Relationship:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="relationship" id="relationship"
                                                    value="{{ old('relationship') }}"
                                                    class="form-control datetimepicker-input" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Address of Collector: </label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="collector_address" id="collector_address"
                                                    value="{{ old('collector_address') }}"
                                                    class="form-control datetimepicker-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Phone: </label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="collector_phone" id="collector_phone"
                                                    value="{{ old('collector_phone') }}"
                                                    class="form-control datetimepicker-input" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Interment Address:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="interment_address" id="interment_address"
                                                    value="{{ old('interment_address') }}"
                                                    class="form-control datetimepicker-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>LGA: </label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="interment_lga" id="interment_lga"
                                                    value="{{ old('interment_lga') }}"
                                                    class="form-control datetimepicker-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Drivers Name:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="driver_name" id="driver_name"
                                                    value="{{ old('driver_name') }}"
                                                    class="form-control datetimepicker-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehicle Number:</label>
                                            <div class="input-group date" id="reservationdate"
                                                data-target-input="nearest">
                                                <input type="text" name="vehicle_number" id="vehicle_number"
                                                    value="{{ old('vehicle_number') }}"
                                                    class="form-control datetimepicker-input" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <a href="{{ url()->previous() }}" class="btn btn-default">Back</a>

                                    @if ($release == 'no')
                                    <a href="{{ route('get_corpse', ['id' => base64_encode($data->id)]) }}"
                                        class="btn btn-warning text-white font-weight-bold">Go to Corpse file</a>
                                        @endif
                                        
                                        
                                        @if ($release == 'no')
                                        <p class="text-danger font-weight-bold">You need to correct something before releasing this corpse. However, if you are sure that everything is fine, you can proceed with the release (this action will be saved for future reference)</p>
                                        @endif
                                        <button type="button" onclick="submitForm()"
                                            class="btn btn-primary w-25">Release</button>
                                

                                </div>
                            </form>
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
        document.addEventListener("DOMContentLoaded", function(event) {
            document.getElementById('date_from').valueAsDate = new Date();
        });

        function loading() {
            $('.card').find('#overlay-wrapper').css('display', 'block');
        }

        function showPrev() {
            $('#admission_form').attr('hidden', false);
            $('#admission_form2').attr('hidden', true);
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
                $('.card').find('#overlay-wrapper1').css('display', 'block');
                // $("#admission_form").find('form').submit();
                // event.preventDefault();
                var formData = new FormData($('#form')[0]);
                console.log('fofof')
                $.ajax({
                    url: "{{ route('release') }}",
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
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('release_list') }}"
                            }
                        });

                        // $('#admission_form').attr('hidden', true);
                        // $('#admission_form2').attr('hidden', false);
                        // $('#admission_form').find('#admission_id').val(response?.data.id);
                        // $('#admission_form2').find('#admission_id2').val(response?.data.id);

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
            $(function() {
                $('.card').find('#overlay-wrapper').css('display', 'none');
                $('.card').find('#overlay-wrapper1').css('display', 'none');
                $('#admission_form').attr('hidden', false);
                // $('#admission_form2').attr('hidden', false);


            });
        });
    </script>
@endsection
@endsection
