<div class="row">
    <div class="modal fade" id="affix_bill">
        {{-- lodaing spinner --}}
        <div class="overlay-wrapper" hidden id="overlay-ref">
            <div class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>
        </div>
        {{-- end loading spinner --}}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Affix a bill</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Amount:</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="number" name="affix_amount" id="affix_amount" min="0"
                                class="form-control datetimepicker-input" placeholder="e.g 600"
                                data-target="#reservationdate" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Select Payment Mode:</label><br>
                        <div class="input-group date">
                            <select class="form-control" name="affix_mode" id="affix_mode" style="width: 100%;"
                                required>
                                <option value="">Select</option>
                                <option value="cash">Cash</option>
                                <option value="tranfer">Transfer</option>
                                <option value="pos">POS</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="desc" id="desc"
                                class="form-control datetimepicker-input" placeholder="Description..."
                                data-target="#reservationdate" />
                        </div>
                    </div>
                    <button type="button" onclick="affix()" class="btn btn-primary w-100">
                        <i class="fa fa-plus"></i>
                        Add
                    </button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#affix_bill">
        <i class="fa fa-plus"></i>
        Affix a bill
    </button>
    <input type="number" class="form-control border-0 bg-transparent w-25" id="affixed_bill" name="affixed_bill" readonly/>
    <input type="text" hidden class="form-control border-0 bg-transparent form-control-sm" name="desc" />
</div>

<script>
    function affix() {
        let bill = $('#affix_amount').val();
        let affix_mode = $('#affix_mode').val();
        let affix_desc = $('#desc').val();
        let corpse_id = $('#admission_id3').val();
        if (bill == '' || affix_mode == '') {
            alert("Enter an amount or Select payment mode")
            return;
        } else {
            $('#affixed_bill').val(bill);
            $('#affix_bill').find('#overlay-ref').attr('hidden', false);
            $.ajax({
                url: "{{ route('affix_bill') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    corpse_id: corpse_id || "{{ $affix_corpse_id }}",
                    affixed_bill: bill,
                    mode: affix_mode,
                    desc: affix_desc,
                },
                success: function(response) {
                    console.log(response);
                    
                    Swal.fire({
                        title: `Successfull !!`,
                        text: `${response.success?? 'Data Saved Successfully!'}`,
                        icon: 'success',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK!'
                    });
                    if (location.href.includes('get_corpse') && location.search.includes('id=')) {
                        location.reload();
                    }
                    $('#affix_bill').modal('hide');
                    $('#affix_bill').find('#overlay-ref').attr('hidden', true);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#affix_amount').val('');
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
                    $('#affix_bill').find('#overlay-ref').attr('hidden', true);

                }
            });

        }
    }
</script>
