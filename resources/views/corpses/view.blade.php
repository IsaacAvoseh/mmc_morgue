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

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Details:</h6>
                                <p><strong>Place of Death:</strong> {{ $data->place_of_death?? '-' }}</p>
                                <p><strong>Sex:</strong> {{ $data->sex?? '-' }}</p>
                                <p><strong>Age:</strong> {{ $data->age?? '-' }}</p>
                                <p><strong>Address:</strong> {{ $data->address?? '-' }}</p>
                                <p><strong>Date of Death:</strong> {{ $data->date_of_death?? '-' }}</p>
                                <p><strong>Time of Death:</strong> {{ $data->time_of_death?? '-' }}</p>
                                <p><strong>Date Received:</strong> {{ $data->date_received?? '-' }}</p>
                                <p><strong>Time Received:</strong> {{ $data->time_received?? '-' }}</p>
                                <p><strong>No. of Days:</strong> {{ $data->no_of_days?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Family Representatives:</h6>
                                <p><strong>Name:</strong> {{ $data->family_rep1_name?? '-' }}</p>
                                <p><strong>Address:</strong> {{ $data->family_rep1_address?? '-' }}</p>
                                <p><strong>Phone:</strong> {{ $data->family_rep1_phone?? '-' }}</p>
                                <p><strong>Relationship:</strong> {{ $data->family_rep1_rel?? '-' }}</p>
                                <hr>
                                <p><strong>Name:</strong> {{ $data->family_rep2_name?? '-' }}</p>
                                <p><strong>Address:</strong> {{ $data->family_rep2_address?? '-' }}</p>
                                <p><strong>Phone:</strong> {{ $data->family_rep2_phone?? '-' }}</p>
                                <p><strong>Relationship:</strong> {{ $data->family_rep2_rel?? '-' }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                        <h6>Other Details:</h6>
                        <p><strong>Items Collected By:</strong> {{ $data->items_collected_by?? '-' }}</p>
                        <p><strong>Items Collected Phone:</strong> {{ $data->items_collected_phone?? '-' }}</p>
                        <p><strong>Status:</strong> {{ $data->status?? '-' }}</p>
                        <p><strong>Rack ID:</strong> {{ \App\Models\Rack::find($data->rack_id)->name ?? '-' }}</p>
                        <p><strong>Paid:</strong> {{ $data->paid?? '-' }}</p>
                        <p><strong>Amount:</strong> N{{ number_format($data->amount, 2)?? '0' }}</p>
                        <p><strong>Date From:</strong> {{ $data->date_from }}</p>
                        <p><strong>Date To:</strong> {{ $data->date_to?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <p><strong>Uploaded Files</strong></p>
                                @forelse ($files as $file)
                                <div class="row w-100">
                                    <p> <b>{{ $file->document->name?? '-' }}</b> <a href="{{  asset('storage/app/'.$file->path) }}" download="{{ $file->document->name}}" >Download</a> </p>
                                @empty
                                    <p> <br> <b>No file uploaded</b></p>
                                </div>
                                @endforelse
                            </div>
                             {{-- <a class="btn btn-default" href="{{route('update_payment', ['id' => base64_encode($data->id)]) }}">Click here to pay</a> --}}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <a class="btn btn-success m-2" href="{{ route('release', ['id' => base64_encode($data->id)]) }}"> <i class="fa fa-sign-out-alt"></i> Release</a>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-secondary" onclick="printCard()"> <i class="fa fa-print"></i> Print</button>
                            <a class="btn btn-primary m-2" href="{{ route('edit_corpse', ['id' => base64_encode($data->id)]) }}"> <i class="fa fa-pen"></i> Edit</a>
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
