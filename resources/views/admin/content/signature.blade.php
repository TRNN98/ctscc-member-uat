<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3">
            <label class="login2 pull-right pull-right-pro">ลายเซ็น : </label>
        </div>
        <div class="col-lg-7">
            @php
            $dataCut = explode('_',$table['Note']);
            @endphp
            <div class="col-lg-6">
                <div class="col-lg-4">
                    <input type="radio" name="level" id="manager" onchange="chkradio(this,$('#staff'));" value="manager"
                        required @if ( $dataCut[0]=='manager' ) checked @endif>
                    <label for="manager">ผู้จัดการ</label>
                </div>
                <div class="col-lg-4">
                    <input type="radio" name="level" id="staff" onchange="chkradio(this,$('#manager'));" value="staff"
                        required @if ( $dataCut[0]=='staff' ) checked @endif>
                    <label for="staff">เจ้าหน้าที่</label>
                </div>
                <input type="hidden" class="form-control" name="QNote1" value="{{ $dataCut[0] }}">
                <script>
                    function chkradio(inp,etc)
                    {
                        if($(inp).prop('checked',true)){
                            $(etc).prop('checked',false)
                            $('input[name="QNote1"]').val($(inp).val());
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</div>
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-3">
            <label class="login2 pull-right pull-right-pro">การแสดงผลในใบเสร็จ : </label>
        </div>
        <div class="col-lg-7">
            <div class="col-lg-6">
                <div class="col-lg-4">
                    <input type="radio" name="show" id="open" value="open" onchange="chkradio2(this,$('#close'));"
                        required @if ( $dataCut[1]=='open' ) checked @endif>
                    <label for="open">เปิด</label>
                </div>
                <div class="col-lg-4">
                    <input type="radio" name="show" id="close" value="close" onchange="chkradio2(this,$('#open'));"
                        required @if ( $dataCut[1]=='close' ) checked @endif>
                    <label for="close">ปิด</label>
                </div>
                <input type="hidden" class="form-control" name="QNote2" value="{{ $dataCut[1] }}">
                <input type="hidden" class="form-control" name="QNote" value="{{ $table['Note'] }}">
            </div>
            <script>
                function chkradio2(inp,etc)
                {
                    if($(inp).prop('checked',true)){
                        $(etc).prop('checked',false)
                        $('input[name="QNote2"]').val($(inp).val());
                    }
                }
                $('#f1').submit(function(){
                    $('input[name="QNote"]').val($('input[name="QNote1"]').val()+'_'+$('input[name="QNote2"]').val());
                    // return false;
                });
            </script>
        </div>
    </div>
</div>
