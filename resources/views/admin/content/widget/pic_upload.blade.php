{{-- D0kKiuz3uoOJd37iMmf7nQ==" --}}
{{-- nonce="viIFiVi1F4tDKRs7j3Erjg==" --}}
{{-- !! new file manager --}}
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
            <label class="login2 pull-right pull-right-pro">รูปภาพหน้าปก
                <font color="#0066FF"> (jpg,png,gif,bmp)</font> :
            </label>
        </div>
        <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
            <div class="file-upload-inner ts-forms">
                <div class="input prepend-small-btn">
                    <a class="file-button" style="cursor: pointer;" name="pic_upload" id="pic_upload"
                        data-input="show_pic_upload">
                        Browse
                    </a>

                    @if ($nphoto)
                        <a href="{{ $nphoto }}" target="_blank">
                            <input readonly type="text" id="show_pic_upload" name="show_pic_upload"
                                placeholder="no file selected" value="{{ $nphoto }}">
                        </a>
                    @else
                        <input readonly type="text" id="show_pic_upload" name="show_pic_upload"
                            placeholder="no file selected">
                    @endif
                    <i class="fa fa-remove logoset"
                        onclick="$('#pic_upload').val(''); $('#show_pic_upload').val(''); "></i>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                    <input type="hidden" name="hf_pic_upload" id="hf_pic_upload" value="<?php if ($nphoto) {
                        echo $nphoto;
                    } ?>" />
                </div>
            </div>
        </div>
    </div>
</div>
<font color="#FF0000" size="2">
    *กรุณาละเว้นชื่อไฟล์ที่เป็นภาษาไทยหรืออักขระพิเศษต่างๆ
    (*,'+-%#@!&gt;&lt;?)</font>

@push('scripts')
    <script type="text/javascript" src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"
        nonce="D0kKiuz3uoOJd37iMmf7nQ=="></script>
    <script type="text/javascript" nonce="viIFiVi1F4tDKRs7j3Erjg==">
        $('#pic_upload').filemanager('image');
    </script>
@endpush
