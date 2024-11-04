<div class="container mg-b-30">
    {{-- @if (session('success') == 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว')
                <script> alert('เปลี่ยนรหัสผ่านเรียบร้อยแล้ว') </script>
            @endif
            @if (session('success') == 'เปลี่ยนรหัสผ่านไม่สำเร็จ !')
                <script> alert('เปลี่ยนรหัสผ่านไม่สำเร็จ') </script>
            @endif
            @if (session('success') == 'รหัสผ่านเดิม ไม่ถูกต้อง !')
                <script> alert('รหัสผ่านเดิม ไม่ถูกต้อง !') </script>
            @endif --}}
    <form action="{{ route('admin.changepassnewpassword') }}" method="POST" id="changepass"
        onsubmit="return validate_change_pass();">
        <div class="sparkline9-list shadow-reset mg-t-30">
            <div class="sparkline9-hd">
            </div>
            <div class="sparkline9-graph">
                <div id="pwd-container4">
                    <div class="form-group-inner">
                        <label class="pull-left" for="old_password">
                            <i class="fa fa-key fa-fw"></i>
                            รหัสผ่านเดิม
                        </label>
                        <input type="password" class="form-control" name="old_password" id="old_password"
                            placeholder="รหัสผ่านเดิม">
                    </div>
                    <div class="form-group-inner">
                        <label class="pull-left" for="new_password">
                            <i class="fa fa-lock fa-fw"></i>
                            รหัสผ่านใหม่
                        </label>
                        <input type="password" class="form-control" name="new_password" id="new_password"
                            placeholder="รหัสผ่านใหม่">
                    </div>
                    <div class="form-group-inner">
                        <label class="pull-left" for="confirmpass">
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            ยืนยันรหัสผ่าน
                        </label>
                        <input type="password" class="form-control example4" name="confirmpass" id="confirmpass"
                            placeholder="ยืนยันรหัสผ่าน">
                    </div>
                    <div class="form-group">
                        {{-- <input type="hidden" name="username" value="{{ Auth::user()->username }}"> --}}
                        <button class="btn btn-success" type="submit">ตกลง</button>
                        {{-- @if (Auth::user()->username == 'soat')
                                    <button class="btn btn-success" type="button" onclick="test();">test</button>
                                @endif --}}
                    </div>
                </div>
            </div>
        </div>
        @csrf
    </form>
</div>


@push('scripts')
<script src="{{ asset('js/md5.min.js') }}"></script>
{{-- <script src="{{ asset('coop/librarys/bootstrap/js/bootstrap-notify.min.js') }}" type="text/javascript"></script>
--}}
<script language="javascript">
    function validate_change_pass()
    {
        if(changepass.old_password.value == ""){alert('กรุณาระบุรหัสผ่านเดิม !'); changepass.old_password.focus()  ; return false ;}
        if(changepass.new_password.value == ""){alert('กรุณาระบุรหัสผ่านใหม่ !'); changepass.new_password.focus()  ; return false ;}
        // if(md5(changepass.old_password.value) != '{{ Auth::user()->password }}'){f_mes('ระบุรหัสผ่านเดิมไม่ถูกต้อง !',function () { changepass.old_password.focus() });  return false ;}
        if(changepass.confirmpass.value != changepass.new_password.value){alert('กรุณายืนยันรหัสผ่านใหม่ให้ถูกต้อง !'); changepass.confirmpass.focus()  ; return false ;}
        else{return true;}
    }
    function f_mes(mes){
        $.notify({message:mes},{ type: 'danger',  placement: { from: 'top', align: 'center' },close: false,
          template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert"> ' +
          '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>'+
            '<span data-notify="message">{2}</span>' +
        '</div>'
        });
    }
</script>
@endpush
