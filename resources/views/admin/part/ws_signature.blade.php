<div class="basic-form-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="sparkline13-list shadow-reset">
                    <div class="sparkline13-hd">
                        <div class="all-form-element-inner align-content-center">
                        {{-- Start form --}}
                            <form action="{{ route('ws_signature.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                {{-- {{ dump($signature[0]) }} --}}
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="login2 pull-right">ลายเซ็น ({{ $position[0] }}) : </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="btn btn-default pull-right">
                                                อัพโหลด
                                                <input type="file" name="pic_signature[]" id="" onchange="previewImg(this);" style="display:none;">
                                            </label>
                                            <div class="img-preview" style="border:1px solid #eee;width:100%;">
                                                <img src="{{ asset('mediafiles/picture/'.$signature[0]) }}" alt="" style="width:100%;height:auto;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="login2 pull-right">ชื่อ : </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="name[]" value="{{ $name[0] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="login2 pull-right">ตำแหน่ง : </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="position[]" value="{{ $position[0] }}">
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-bottom:1px solid #3333332b">
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="login2 pull-right">ลายเซ็น ({{ $position[1] }}) : </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="btn btn-default pull-right">
                                                อัพโหลด
                                                <input type="file" name="pic_signature[]" id="" onchange="previewImg(this);" style="display:none;">
                                            </label>
                                            <div class="img-preview" style="border:1px solid #eee;width:100%;">
                                                <img src="{{ asset('mediafiles/picture/'.$signature[1]) }}" alt="" style="width:100%;height:auto;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="login2 pull-right">ชื่อ : </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="name[]" class="form-control" value="{{ $name[1] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="login2 pull-right">ตำแหน่ง : </label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="position[]" value="{{ $position[1] }}">
                                        </div>
                                    </div>
                                </div>
                                <hr style="border-bottom:1px solid #3333332b">
                                <div class="form-group-inner">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label> </label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="login-btn-inner">
                                                <input type="hidden" name="No[]" value="{{ $No[0] }}">
                                                <input type="hidden" name="No[]" value="{{ $No[1] }}">
                                                <button type="submit" class="btn btn-sm btn-primary login-submit-cs" name="SubmitSignature">บันทึก</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        {{-- End form --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function previewImg(input)
    {
        
        if(input.files && input.files[0])
        {

            var reader = new FileReader();
            reader.onload = function(e)
            {
                $(input).parent().next().children().attr('src',e.target.result);   		
            } 

            reader.readAsDataURL(input.files[0]);

        }
    }
</script>
