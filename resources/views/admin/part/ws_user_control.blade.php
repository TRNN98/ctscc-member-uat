{{-- container --}}
<div class="container usercontrolbox ">
    <div class="row mg-b-30">
        <div class="col-md-1"></div>
        <div class="col-md-3">
            <form action="{{ route('ws_user_control.store') }}" method="POST">
                @csrf
                <h2>Add User</h2>
                <hr class="usr">
                <div class="form-group-inner">
                    <label>Username : </label>
                    <input type="text" class="form-control" name="tf_add_user_name" id="tf_add_user_name" required>
                </div>
                <div class="form-group-inner">
                    <label>Password : </label>
                    <input type="password" class="form-control" name="tf_add_user_passwd" id="textfield" required>
                </div>
                <div class="form-group-inner">
                    <label>Group : </label>
                    <div class="form-select-list">
                        <select name="lm_ucf_group" id="select" class="form-control custom-select-value" required>
                            <option value="" disabled selected>-- เลือกกลุ่ม --</option>
                            @foreach ($list_user_group as $user_group)
                            <option value="{{ $user_group->group_code }}">{{ $user_group->group_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group-inner">
                    <label>User Discription : </label>
                    <input type="text" name="tf_description" id="tf_description" class="form-control">
                </div>
                <input type="submit" class="btn" name="btn_add_user" id="btn_add_user" value="เพิ่มผู้ใช้" />
            </form>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-6">
            <h2>List User</h2>
            <hr class="usr">
            <div style="padding-top:25px;">
                <table id="TbUser" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Group</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $seq = 0;
                        @endphp

                        @foreach ($list_user as $rowuser)

                        @php
                        $seq++;
                        @endphp

                        <tr>
                            <td>{{ $seq }}</td>
                            <td>{{ $rowuser->username }}</td>
                            <td>{{ $rowuser->group_name }}</td>
                            <td><button class="btndel_user"><i class="fa fa-trash"></i></button></td>
                            <td hidden>
                                <input class="hidden" value="{{ $rowuser->seq }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mg-b-30">
        <div class="col-md-1"></div>
        <div class="col-md-3">
            <form action="{{ route('ws_user_control.store') }}" method="POST">
                @csrf
                <h2>Add User Group</h2>
                <hr class="usr">
                <div class="form-group-inner">
                    <label>Group No : </label>
                    <input type="text" class="form-control" name="tf_add_group_no" id="tf_add_group_no" required>
                </div>
                <div class="form-group-inner">
                    <label>Group Name : </label>
                    <input type="text" class="form-control" name="add_group_name" id="add_group_name" required>
                </div>
                <div class="form-group-inner">
                    <label>Group Description : </label>
                    <input type="text" class="form-control" name="add_group_des" id="add_group_des">
                </div>
                <input class="btn" type="submit" name="btn_add_group" id="btn_add_group" value="เพิ่มกลุ่ม" />
            </form>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-6">
            <h2>List Group</h2>
            <hr class="usr">
            <div style="padding-top:25px;">
                <table id="TbGroup" class="table table-bordered table-hover">
                    <tbody>
                        @foreach ($list_user_group as $row_group)
                        <tr>
                            <td>{{ $row_group->group_code }}</td>
                            <td>{{ $row_group->group_name }}</td>
                            <td><button class="btndel_group"><i class="fa fa-remove"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- end container --}}

{{-- CSS --}}
<style>
    #btn_add_user,
    #btn_add_group {
        background: linear-gradient(to bottom, #ff9966 0%, #d75151 100%);
        color: #fff;
    }

    .btndel_user,
    .btndel_group {
        border: none;
        background: no-repeat;
        color: red;
    }

    hr.usr {
        border: 1px dashed gray;
    }

    .usercontrolbox {
        border: 1px solid #8080801a;
        padding: 18px;
        margin-bottom: 25px;
        background: #fff;
    }
</style>
{{-- END CSS --}}

{{-- Js Script --}}
@push('scripts')

{{-- <script src="{{ asset('admin/js/Lobibox.js') }}"></script> --}}

<script>
    //--setup ajax--//
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

$(document).ready(function(){

    //--- Delete user---//
    $('#TbUser').on('click','.btndel_user',function(){

        var cof = confirm('ยืนยันการลบข้อมูล ?');

        if(cof == true)
        {
            //get username in table
            // var username = $(this).parent().siblings().eq(1).text();
            var seq = $(this).parent().next('td').find('.hidden:eq(0)').val();

            //set name table
            var tb = 'www_security_user';

            //set field name
            var field = 'username';

            // DeleteDataUserControl(username,tb,field);
            DeleteDataUserControl(seq,tb,field).then((result) => {
                $(this).closest('tr').fadeOut(1200);
            }).catch((err) => {
                Lobibox.notify("error", {
                    msg: "ลบข้อมูลไม่สำเร็จ"
                });
            });
        }



    });

    //--- Delete group---//
    $('#TbGroup').on('click','.btndel_group',function(){

        var cof = confirm('ยืนยันการลบข้อมูล ?');

        if(cof == true)
        {
            //get group code in table
            var groupcode = $(this).parent().siblings().eq(0).text();

            //set name table
            var tb = 'www_ucf_user_group';

            //set field name
            var field = 'group_code';

            DeleteDataUserControl(groupcode,tb,field).then((result) => {
                $(this).closest('tr').fadeOut(1200);
            }).catch((err) => {
                Lobibox.notify("error", {
                    msg: "ลบข้อมูลไม่สำเร็จ"
                });
            });
        }


    });
});

    //--- ฟังก์ชั่น ลบข้อมูลของ user และ group ---//
    function DeleteDataUserControl(pk,tablename,fieldname)
    {
        return new Promise(function (resolve, reject) {
            $.ajax({
                url:'{{ route("admin.usercontrol.delete") }}',
                method:'POST',
                data:{pk:pk,tablename:tablename,fieldname:fieldname},
                success:function(response)
                {
                    Lobibox.notify("success", {
                        msg: "ลบข้อมูลสำเร็จ"
                    });
                    resolve(response);
                },
                error: function(err) {
                    reject(err);
                }
            });
        });

    }
    //---END ฟังก์ชั่น ลบข้อมูลของ user และ group ---//
</script>
@endpush
{{-- End Script --}}
