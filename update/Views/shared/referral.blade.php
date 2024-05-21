<form id="ref">
    <h3 id="head">Referral ?</h3>
    <div class="row m-4 bg-light" id="ref_over">
        {{-- lodaing spinner --}}
        <div class="overlay-wrapper" hidden id="overlay-ref">
            <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>
        </div>
        {{-- end loading spinner --}}
        <input type="hidden" name="ref_corpse_id" value="{{ $ref_corpse_id }}">
        <div class="col-md-6">
            <div class="form-group">
                <label>Please Select a referral:</label><br>
                <div class="input-group date">
                    <select class="form-control" name="referral_id" id="referral_id" style="width: 100%;">
                        <option value="">Select</option>
                        @forelse (\DB::table('referrals')->latest()->get() as $item)
                            <option value="{{ $item->id ?? '' }}">{{ $item->name ?? '-' }}</option>
                        @empty
                            <option value="">No referral available</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Status:</label><br>
                <div class="input-group date">
                    <select class="form-control" name="ref_status" id="ref_status" style="width: 100%;">
                        <option value="">Select</option>
                        <option value="paid">Paid</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Enter Referral Amount and click "Save"</label><br>
                <div class="input-group date">
                    <input type="number" name="ref_amount" id="ref_amount" value="{{ old('ref_amount') }}"
                        class="form-control datetimepicker-input" data-target="#reservationdate" placeholder="500" />
                </div>
            </div>
            <div class="form-group">
                <br>
                <button type="button" onclick="save()" class="btn btn-primary w-25 ml-4">Save</button>
            </div>
        </div>
    </div>
    <script>
        function save() {
            $('#ref_over').find('#overlay-ref').attr('hidden', false);
            // $("#ref").find('form').submit();
            event.preventDefault();
            let corpse_id = $('#admission_id3').val();
            let referral_id = $('#referral_id').val();
            let ref_status = $('#ref_status').val();
            let ref_amount = $('#ref_amount').val();

            if (referral_id == '' || ref_amount == '' || ref_status == '') {
                alert('Fill All Inputs')
                $('#ref_over').find('#overlay-ref').attr('hidden', true);
                return;
            }
            $.ajax({
                url: "{{ route('add_ref_details') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    corpse_id: corpse_id || "{{ $ref_corpse_id }}",
                    referral_id: referral_id,
                    status: ref_status,
                    amount: ref_amount,
                },
                success: function(response) {
                    console.log(response);
                    $('#ref_over').find('#overlay-ref').attr('hidden', true);
                    Swal.fire({
                        title: `Successfull !!`,
                        text: `${response.success?? 'Data Saved Successfully!'}`,
                        icon: 'success',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK!'
                    });
                    $('#ref_over').attr('hidden', true);
                    $('#head').attr('hidden', true);
                    $('#ref_modal').modal('hide');
                    if (location.href.includes('get_corpse') && location.search.includes('id=')) {
                        location.reload();
                    }

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
                    $('#ref_over').find('#overlay-ref').attr('hidden', true);

                }
            });
        }
    </script>
</form>
