@extends('layout.main')


@section('content')
@section('title', 'Corpse - FILE & PAYMENT')
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
                            <p class="h5">UPDATE: FILE UPLOAD & PAYMENT</p>
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
                        <div class="col">
                            <input type="text" name="name" id="name" value="{{ $data->name }}"
                                class="form-control datetimepicker-input" placeholder="Name of Deceased" readonly>
                        </div>

                        {{-- FIle Upload --}}
                        @if ($file_message != 'no')
                            <div class="modal-body" id="admission_form2" {{ $file_message == 'no' ? 'hidden' : '' }}>
                                {{-- lodaing spinner --}}
                                <div class="overlay-wrapper hidden" id="overlay-wrapper2">
                                    <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                {{-- end loading spinner --}}
                                <form enctype="multipart/form-data" id="form2">
                                    @csrf
                                    <input type="hidden" value="{{ $data->id }}" name="admission_id"
                                        id="admission_id2">
                                    {{-- <input type="hidden" name="admission_id" id="admission_id2"> --}}
                                    <p class="">Please Upload the following files</p>
                                    <a onclick="showPrev" class="btn btn-default mb-4"> <i class="fas fa-file-alt"></i>
                                        FILE UPLOAD
                                    </a>
                                    <div class="row">
                                        @forelse ($files as $key => $file)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ $file->name ?? 'File' }} <span class="text-danger" >{{ $file->required == 'yes' ? '***' : '' }}</span></label>
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
                                                <p></p>
                                                <button type="button" onclick="submitFileForm()"
                                                    class="btn btn-primary w-25">Upload & Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                        <hr>
                        <hr>
                        <hr>
                        {{-- Payment --}}
                        @if ($payment_message != 'no')
                            <div class="modal-body" id="admission_form3" {{ $payment_message == 'no' ? 'hidden' : '' }}>
                                {{-- lodaing spinner --}}
                                <div class="overlay-wrapper hidden" id="overlay-wrapper3">
                                    <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>
                                {{-- end loading spinner --}}
                               
                                  @include('shared.payment', [
                                'ref_corpse_id' => session()->get('ref_corpse_id'),
                            ])

                            </div>
                        @endif
                        <style>
                            .my-toast-class {
                                font-size: 14px;
                                padding: 10px 20px;
                            }
                        </style>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="col-md-12" id="done">
                    <div class="modal-footer justify-content-between">
                        <p></p>
                        <a href="{{ route('release', ['id' => base64_encode($data->id)]) }}"
                            class="btn btn-primary w-25">Click here to Continue </a>
                    </div>
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

    document.addEventListener("DOMContentLoaded", function(event) {
    $('.fee-checkbox').prop('checked', true);
        Swal.fire({
            icon: 'warning',
            title: `Loading...`,
            text: `Loading...Please wait...`,
            showConfirmButton: false,
            timer: 3000
        })
        setTimeout(() => {
            document.getElementById('date_to').valueAsDate = new Date();
            $('#date_to').trigger('change')
        }, 3000);
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
            // $('#admission_form3').attr('hidden', false);

        });
</script>
@endsection
@endsection
