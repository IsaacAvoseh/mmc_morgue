@extends('layout.main')


@section('content')
@section('title', 'Corpse Details')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <p id="test">
        </p>
        <div class="row">
            <div class="col-12">
                <!-- /.modal-dialog -->
                {{-- Add new Modal name, start and end date --}}
                <div class="modal fade" id="ref_modal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                {{-- <h4 class="modal-title">New Referral</h4> --}}
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @include('shared.referral', ['ref_corpse_id' => $data->id])
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                {{-- add new modal --}}
                <div class="card" id="print-card">
                    <div class="card-header d-flex flex-wrap justify-content-between bg-light">
                        <div class="align-self-start">
                            <a class="btn btn-default" href="{{ url()->previous() }}">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                        <div class="d-flex justify-content-center flex-grow-1">
                            <p class="h5">{{ $data->name ?? 'Corpse' }}</p>
                        </div>
                        <div class="d-flex align-items-center">
                            {{-- Loading spinner --}}
                            <div class="overlay-wrapper hidden" id="overlay-wrapper">
                                <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
                            </div>
                            {{-- End loading spinner --}}
                            @include('shared.affix_bill', ['affix_corpse_id' => $data->id])
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Details:</h6>
                                <p><strong>Place of Death:</strong> {{ $data->place_of_death ?? '-' }}</p>
                                <p><strong>Sex:</strong> {{ $data->sex ?? '-' }}</p>
                                <p><strong>Age:</strong> {{ $data->age ?? '-' }}</p>
                                <p><strong>Address:</strong> {{ $data->address ?? '-' }}</p>
                                <p><strong>Date of Death:</strong> {{ $data->date_of_death ?? '-' }}</p>
                                <p><strong>Time of Death:</strong> {{ $data->time_of_death ?? '-' }}</p>
                                <p><strong>Date Received:</strong> {{ $data->date_received ?? '-' }}</p>
                                <p><strong>Time Received:</strong> {{ $data->time_received ?? '-' }}</p>
                                <p><strong>No. of Days:</strong> {{ $data->no_of_days ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Family Representatives:</h6>
                                <p><strong>Name:</strong> {{ $data->family_rep1_name ?? '-' }}</p>
                                <p><strong>Address:</strong> {{ $data->family_rep1_address ?? '-' }}</p>
                                <p><strong>Phone:</strong> {{ $data->family_rep1_phone ?? '-' }}</p>
                                <p><strong>Relationship:</strong> {{ $data->family_rep1_rel ?? '-' }}</p>
                                <hr>
                                <p><strong>Name:</strong> {{ $data->family_rep2_name ?? '-' }}</p>
                                <p><strong>Address:</strong> {{ $data->family_rep2_address ?? '-' }}</p>
                                <p><strong>Phone:</strong> {{ $data->family_rep2_phone ?? '-' }}</p>
                                <p><strong>Relationship:</strong> {{ $data->family_rep2_rel ?? '-' }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Other Details:</h6>
                                <p><strong>Items Collected By:</strong> {{ $data->items_collected_by ?? '-' }}</p>
                                <p><strong>Items Collected Phone:</strong> {{ $data->items_collected_phone ?? '-' }}</p>
                                <p><strong>Status:</strong> {{ $data->status ?? '-' }}</p>
                                <p><strong>Rack ID:</strong> {{ \App\Models\Rack::find($data->rack_id)->name ?? '-' }}
                                </p>
                                <p><strong>Paid:</strong> {{ $data->paid ?? '-' }}</p>
                                <p><strong>Total:</strong> N{{ number_format($data->amount, 2) ?? '0' }}</p>
                                <p><strong>Amount Paid:</strong> N{{ number_format($data->amount_paid, 2) ?? '0' }}</p>
                                <p><strong>Discount:</strong> N{{ number_format($data->discount, 2) ?? '0' }}</p>
                                <p><strong>Affixed Bill:</strong> N{{ number_format($data->affixed_bill, 2) ?? '0' }}</p>
                                <p><strong>Date From:</strong> {{ $data->date_from }}</p>
                                <p><strong>Date To:</strong> {{ $data->date_to ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <p><strong>Uploaded Files</strong></p>
                                    @forelse ($files as $file)
                                        <div class="row w-100 flex-column">
                                            <p> <b>{{ $file->document->name ?? '-' }}</b> <a
                                                    href="{{ asset('storage/app/' . $file->path) }}"
                                                    download="{{ $file->document->name }}">Download</a> </p>
                                        @empty
                                            <p> <br> <b>No file uploaded</b></p>
                                        </div>
                                    @endforelse
                                    <hr>
                                    <div class="row flex-column">
                                        <h3>Referred by: <a
                                                href="{{ route('referral', ['id' => $referral ? base64_encode($referral->referral->id) ?? '' : '']) }}">
                                                {{ $referral ? $referral->referral->name ?? '---' : '--' }} </a></h3>


                                        <button type="button" class="btn btn-primary w-25 btn-sm" data-toggle="modal"
                                            data-target="#ref_modal">
                                            <i class="fa fa-plus"></i>
                                            Update Referral
                                        </button>
                                    </div>
                                </div>
                                {{-- <a class="btn btn-default" href="{{route('update_payment', ['id' => base64_encode($data->id)]) }}">Click here to pay</a> --}}
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a class="btn btn-success m-1 w-100"
                                        href="{{ route('release', ['id' => base64_encode($data->id)]) }}"> <i
                                            class="fa fa-sign-out-alt"></i> Release</a>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-primary m-1 w-100"
                                        href="{{ route('edit_corpse', ['id' => base64_encode($data->id)]) }}"> <i
                                            class="fa fa-pen"></i> Edit</a>
                                    <button class="btn btn-secondary w-100" onclick="printCard()"> <i
                                            class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
    </script>
@endsection
@endsection
