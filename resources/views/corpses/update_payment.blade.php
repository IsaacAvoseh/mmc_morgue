@extends('layout.main')


@section('content')
@section('title', 'Corpse - UPDATE PAYMENT')
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
                         <div class="align-self-start">
                            <a class="btn btn-default" href="{{ url()->previous() }}">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                        <div class="row justify-content-center">
                            <p class="h5">UPDATE PAYMENT</p>
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

                        {{-- Payment --}}

                        <div class="modal-body" id="admission_form3">
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
            Swal.fire({
                icon: 'warning',
                title: `Loading...`,
                text: `Loading...Please wait...`,
                showConfirmButton: false,
                timer: 2000
            })

            setTimeout(() => {
                $('#date_to').focus().trigger('change')
            }, 2000);
        });

        function loading() {
            $('.card').find('#overlay-wrapper').css('display', 'block');
        }

        $(function() {
            $('.card').find('#overlay-wrapper').css('display', 'none');
            $('.card').find('#overlay-wrapper1').css('display', 'none');
            $('.card').find('#overlay-wrapper2').css('display', 'none');
            $('.card').find('#overlay-wrapper3').css('display', 'none');
            // $('#admission_form').attr('hidden', false);
            // $('#admission_form2').attr('hidden', false);


        });
    </script>
@endsection
@endsection
