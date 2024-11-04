{{-- container --}}
<div class="container usercontrolbox ">

    <div class="row mg-b-30">
        <div class="col-md-1"></div>
        <div class="col-md-3">
            <form action="{{ route('ws_manu.store') }}" method="POST">
                @csrf
                <h2>เพิ่มเมนู</h2>
                <hr class="usr">
                <div class="form-group-inner">
                    <label>ชนิดของเมนู : </label>
                    <div class="form-select-list">
                        <select name="is_parent" id="is_parent" class="form-control custom-select-value"
                            onchange="parent()" required>
                            <option value="" disabled selected>-- เลือกกลุ่ม --</option>
                            <option value="0">เมนูหลัก</option>
                            <option value="1">เมนูย่อย</option>
                        </select>
                    </div>
                </div>
                <div class="form-group-inner">
                    <label>ชื่อเมนู : </label>
                    <input type="text" class="form-control" name="manu_name" required>
                </div>
                <div class="form-group-inner">
                    <label>Url : </label>
                    <input type="text" class="form-control" name="manu_url" id="manu_url" disabled>
                </div>
                <input type="submit" class="btn btn-primary" name="btn_add_manu" value="เพิ่มเมนู" />
            </form>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-6">
            <h2>รายการ เมนู</h2>
            <hr class="usr">
            <div style="padding-top:25px;">
                <table id="TbManu" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อเมนู</th>
                            <th>ชนิดเมนู</th>
                            <th>url</th>
                            <th width="100"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_manu as $key => $manu)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $manu->manu_name }}</td>
                            <td>
                                @if ($manu->is_parent == '0')
                                เมนูหลัก
                                @else
                                เมนูย่อย
                                @endif
                            </td>
                            <td>{{ $manu->url }}</td>
                            <td>
                                <button class="btnedit_manu" data-toggle="modal" data-target="#ModalDataEdit{{ $key }}"><i class="fa fa-edit"></i></button>
                                <button class="btndel_manu"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        
                        {{--------------- ModalDataEdit ------------------------}}
                        <div id="ModalDataEdit{{ $key }}" class="modal modal-adminpro-general modal-zoomInDown fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-close-area modal-close-df">
                                        <a class="close" data-dismiss="modal"><i class="fa fa-close"></i></a>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formAddData" action="{{ route('ws_manu.update',[$manu->seq]) }}" method="POST">
                                            {{ method_field('PUT') }}
                                            @csrf
                                            <div class="modal-login-form-inner">
                                                <div class="form-group-inner">
                                                    <h2>เพิ่มข้อมูล</h2>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <input type="text" name="menu_name" class="form-control" value="{{$manu->manu_name}}">
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <select name="is_parent" id="" class="form-control">
                                                                        <option @if ($manu->is_parent == '1') selected @endif value="1">เมนูย่อย</option>
                                                                        <option @if ($manu->is_parent == '0') selected @endif value="0">เมนูหลัก</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <input type="text" name="url" class="form-control" value="{{ $manu->url }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 mg-t-30 ">
                                                            <hr>
                                                            <button type="submit"
                                                                name="submitManu"
                                                                style="background: linear-gradient(to bottom, #ff9966 0%, #d75151 100%); "
                                                                class="pull-right btn btn-warning login-submit-cs" id="btnAddCategory">
                                                                แก้ไข <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>{{-- //modal-body--}}
                                </div>
                            </div>
                        </div>
                        {{-- ------------------------------------------ --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mg-b-30">
        <div class="col-md-1"></div>
        <div class="col-md-3">
            <form action="{{ route('ws_manu.store') }}" method="POST">
                @csrf
                <h2>เพิ่มเมนูย่อย</h2>
                <hr class="usr">
                <div class="form-group-inner">
                    <label>เมนูหลัก : </label>
                    <div class="form-select-list">
                        <select name="manu_id" id="manu_id" class="form-control custom-select-value" required>
                            <option value="" disabled selected>-- เลือกเมนูหลัก --</option>
                            @foreach ($list_sel_manu as $manu)
                            <option value="{{ $manu->seq }}">{{ $manu->manu_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group-inner">
                    <label>ชื่อเมนูย่อย : </label>
                    <div class="form-select-list">
                        <select name="cat_id" id="cat_id" class="form-control custom-select-value" required>
                            <option value="" disabled selected>-- เลือกเมนูหลัก --</option>
                            @foreach ($list_cat as $cat)
                            <option value="{{ $cat->seq }}">{{ $cat->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group-inner">
                    <label>Url : </label>
                    <input type="text" class="form-control" name="sub_manu_url">
                </div>
                <input class="btn btn-primary" type="submit" name="btn_add_submanu" value="เพิ่มเมนูย่อย" />
            </form>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-6">
            <h2>รายการ เมนูย่อย</h2>
            <hr class="usr">
            <div style="padding-top:25px;">
                <table id="TbGroup" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อเมนู</th>
                            <th>เมนูหลัก</th>
                            <th>url</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_sub_manu as $key => $sub_manu)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $sub_manu->manu_name }}</td>
                            <td>{{ $sub_manu->description }}</td>
                            <td>{{ $sub_manu->url }}</td>
                            <td>
                                <button class="btnedit_submanu" data-toggle="modal" data-target="#ModalDataEdit2{{ $key }}"><i class="fa fa-edit"></i></button>
                                <button class="btndel_submanu" data-id="{{ $sub_manu->seq }}"><i class="fa fa-remove"></i></button>
                            </td>
                        </tr>
                        {{--------------- ModalDataEdit ------------------------}}
                        <div id="ModalDataEdit2{{ $key }}" class="modal modal-adminpro-general modal-zoomInDown fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-close-area modal-close-df">
                                        <a class="close" data-dismiss="modal"><i class="fa fa-close"></i></a>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formAddData" action="{{ route('ws_manu.update',[$sub_manu->seq]) }}" method="POST">
                                            {{ method_field('PUT') }}
                                            @csrf
                                            <div class="modal-login-form-inner">
                                                <div class="form-group-inner">
                                                    <h2>เพิ่มข้อมูล</h2>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-lg-4">เมนูหลัก :
                                                                    <select name="menu_id" class="form-control custom-select-value" required>
                                                                        <option value="" disabled>-- เลือกเมนูหลัก --</option>
                                                                        @foreach ($list_sel_manu as $manu)
                                                                        <option @if ($sub_manu->manu_name == $manu->manu_name) selected @endif value="{{ $sub_manu->seq }}">{{ $manu->manu_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-4">ชื่อเมนูย่อย :
                                                                    <select name="cat_id" id="cat_id" class="form-control custom-select-value" required>
                                                                        <option value="" disabled>-- เลือกเมนูย่อย --</option>
                                                                        @foreach ($list_cat as $cat)
                                                                        <option @if ($sub_manu->description == $cat->description) selected @endif value="{{ $cat->seq }}">{{ $cat->description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-4">url:
                                                                    <input type="text" name="url" class="form-control" value="{{ $sub_manu->url }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 mg-t-30 ">
                                                            <hr>
                                                            <button type="submit"
                                                                name="submitSubManu"
                                                                style="background: linear-gradient(to bottom, #ff9966 0%, #d75151 100%); "
                                                                class="pull-right btn btn-warning login-submit-cs" id="btnAddCategory">
                                                                แก้ไข <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>{{-- //modal-body--}}
                                </div>
                            </div>
                        </div>
                        {{-- ------------------------------------------ --}}
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
    function parent() {
        var val = document.getElementById("is_parent").value;
        // console.log(val);
        if (val == '0') {
            document.getElementById("manu_url").disabled = false;
        }else{
            document.getElementById("manu_url").disabled = true;
        }
    }

    //--setup ajax--//
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
$(document).ready(function(){
    //--- Delete user---//
    $('#TbManu').on('click','.btndel_manu',function(){

        var cof = confirm('ยืนยันการลบข้อมูล ?');

        if(cof == true)
        {
            $(this).closest('tr').fadeOut(1200);

            //get username in table
            var seq = $(this).parent().siblings().eq(0).text();

            //set name table
            var tb = 'www_ucf_manu';

            //set field name
            var field = 'seq';
            // alert(username+tb+field);
            DeleteDataUserControl(seq,tb,field);
        }
    });

    //--- Delete Submanu---//
    $('#TbGroup').on('click','.btndel_submanu',function(){

        var cof = confirm('ยืนยันการลบข้อมูล ?');

        if(cof == true)
        {
            $(this).closest('tr').fadeOut(1200);

            //get seq in table
            var seq = $(this).data('id');

            //set name table
            var tb = 'www_ucf_sub_manu';

            //set field name
            var field = 'seq';

            DeleteDataUserControl(seq,tb,field);
        }
    });
});

    //--- ฟังก์ชั่น ลบข้อมูลของ user และ group ---//
    function DeleteDataUserControl(pk,tablename,fieldname)
    {
            $.ajax({
                url:'{{ route("admin.manu.delete") }}',
                method:'POST',
                data:{pk:pk,tablename:tablename,fieldname:fieldname},
                success:function(response)
                {
                    Lobibox.notify("success", {
                        msg: "ลบข้อมูลสำเร็จ"
                    });
                }
            });
    }
    //---END ฟังก์ชั่น ลบข้อมูลของ user และ group ---//


</script>
@endpush
{{-- End Script --}}
