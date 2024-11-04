{{-- nonce="AoBTSiglzlIL4tMM4HUKNQ==" --}}
{{-- nonce="I3bLp1RiV7CG5ZzqIYWoJg==" --}}
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-right pull-right-pro">&#3652;&#3615;&#3621;&#3660;
                <font color="#0066FF">
                    (doc,xls,ppt,pdf)
                </font> :
            </label>
        </div>
        <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
            <div class="file-upload-inner ts-forms">
                <div class="input prepend-big-btn">

                    <a class="file-button" style="cursor: pointer;" name="file_upload" id="file_upload"
                        data-input="show_file_upload">
                        Browse

                    </a>
                    @if ($ndata)
                        <a href="{{ $ndata }}" target="_blank">
                            <input readonly type="text" id="show_file_upload" name="show_file_upload"
                                placeholder="no file selected" value="{{ $ndata }}">
                        </a>
                    @else
                        <input readonly type="text" id="show_file_upload" name="show_file_upload"
                            placeholder="no file selected">
                    @endif
                    <i class="fa fa-remove logoset"
                        onclick="$('#file_upload').val(''); $('#show_file_upload').val('');"></i>
                </div>
                <input type="hidden" name="hf_file_upload" id="hf_file_upload" value="<?php if ($ndata) {
                    echo $ndata;
                } ?>" />
            </div>
        </div>
    </div>
</div>



@push('scripts')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}" nonce="AoBTSiglzlIL4tMM4HUKNQ==">
    </script>
    <script type="text/javascript" nonce="I3bLp1RiV7CG5ZzqIYWoJg==">
        $('#file_upload').filemanager('file');
    </script>
@endpush
