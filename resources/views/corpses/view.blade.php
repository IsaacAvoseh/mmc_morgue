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
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-center">
                            <p class="h5">{{ $data->name?? 'Corpse' }}</p>
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

                        <div class="modal-body" id="admission_form">

                           
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

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<!-- SweetAlert2 -->
<script src="/plugins/sweetalert2/sweetalert2.min.js"></script>

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
        $(function() {
            $('.card').find('#overlay-wrapper').css('display', 'none');
            $('.card').find('#overlay-wrapper1').css('display', 'none');
            $('#admission_form').attr('hidden', false);
            // $('#admission_form2').attr('hidden', false);

        });
    });
</script>
@endsection
