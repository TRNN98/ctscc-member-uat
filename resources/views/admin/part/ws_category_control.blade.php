<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="sparkline13-list shadow-reset">
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div class="modal-bootstrap modal-login-form pull-left">
                                <a class="zoomInDown mg-t" href="#" data-toggle="modal"
                                    data-target="#ModalAddData">เพิ่มข้อมูล &nbsp;<i class="fa fa-plus"></i></a>
                            </div>
                            <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                data-show-columns="true" data-show-pagination-switch="false" data-show-refresh="true"
                                data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="category">Category</th>
                                        <th data-field="description" data-editable="true">Description</th>
                                        <th data-field="hyperlink" data-editable="true">Hyperlink</th>
                                        <th data-field="contenttype" data-editable="true">Content Type</th>
                                        <th data-field="" data-editable="true">#</th>
                                        <th data-field="type" data-editable="true">Type</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="datafetch">
                                    @foreach ($datafetch as $rowcategory)
                                    <tr>
                                        <td data-name="category" class="category" data-type="text"
                                            data-pk="{{ $rowcategory->seq }}"> {{ $rowcategory->category }}</td>
                                        <td data-name="description" class="description" data-type="text"
                                            data-pk="{{ $rowcategory->seq }}"> {{ $rowcategory->description }} </td>
                                        <td data-name="hyper_link" class="hyper_link" data-type="text"
                                            data-pk="{{ $rowcategory->seq }}"> {{ $rowcategory->hyper_link }}</td>
                                        <td data-name="content_type" class="content_type" data-type="select"
                                            data-pk="{{ $rowcategory->seq }}"> {{ $rowcategory->content_type }}</td>
                                        @php
                                        if($rowcategory->status == 1){
                                        $txtstatus = 'ON';
                                        }else{
                                        $txtstatus = 'OFF';
                                        }
                                        @endphp
                                        <td data-name="status" class="status" data-type="select"
                                            data-pk="{{ $rowcategory->seq }}"> {{ $txtstatus }}</td>
                                        <td data-name="type" class="type" data-type="select"
                                            data-pk="{{ $rowcategory->seq }}"> {{ $rowcategory->type }} </td>
                                        <td><button id="btnDelete" class="btn btn-xs btn-danger"><i
                                                    class="fa fa-wrench "></i> Delete </button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Modal Add Data --}}
<div id="ModalAddData" class="modal modal-adminpro-general modal-zoomInDown fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-close-area modal-close-df">
                <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
            </div>
            <div class="modal-body">
                <form id="formAddData" action="{{ route('ws_category_control.store') }}" method="POST">
                    @csrf
                    <div class="modal-login-form-inner">
                        <div class="form-group-inner">
                            <h2>เพิ่มข้อมูล</h2>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                        <label>Category</label>
                                        <input name="addcategory" type="text" class="form-control" required>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                        <label>Description</label>
                                        <input name="adddescription" type="text" class="form-control" required>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                        <label>Hyper_link</label>
                                        <input name="addhyperlink" type="text" class="form-control">
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                        <label>Type</label>
                                        <div class="form-select-list">
                                            <select required class="form-control custom-select-value"
                                                name="addcontenttype">
                                                <option value="" selected disabled>-- เลือก content_type --</option>
                                                <option value="calender">calender</option>
                                                <option value="download_doc">download_doc</option>
                                                <option value="ebook">ebook</option>
                                                <option value="link_url">link_url</option>
                                                <option value="photo">photo</option>
                                                <option value="content">content</option>
                                                <option value="signature">signature</option>
                                                <option value="video">video</option>
                                                <option value="personnel">personnel</option>
                                                <option value="default">default</option>
                                            </select>
                                            <span style="color:red;" class="pull-right" id="errselect"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                        <label>Type</label>
                                        <div class="form-select-list">
                                            <select required class="form-control custom-select-value" name="addtype">
                                                <option value="" selected disabled>-- เลือก Type --</option>
                                                <option value="A">A</option>
                                                <option value="S">S</option>
                                                <option value="M">M</option>
                                                <option value="G">G</option>
                                                <option value="C">C</option>
                                                <option value="O">O</option>
                                                <option value="L">L</option>
                                            </select>
                                            <span style="color:red;" class="pull-right" id="errselect"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mg-t-30 ">
                                    <hr>
                                    <button type="submit"
                                        style="background: linear-gradient(to bottom, #ff9966 0%, #d75151 100%); "
                                        class="pull-right btn btn-warning login-submit-cs" id="btnAddCategory">
                                        ADD <i class="fa fa-plus"></i>
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
{{-- End Modal AddData --}}

<style>
    td {
        cursor: pointer;
    }

    td:hover {
        /*font-size: 16px;*/
        font-weight: 800;
        color: #ff8244;
        border-bottom: dashed;
        border-width: 2px;
        border-color: #ff8244;
    }
</style>

@push('scripts')

{{-- <script src="{{ asset('admin/js/Lobibox.js') }}"></script> --}}

<script>
    //--setup ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


$(document).ready(function(){

    $('#table').on('click','#btnDelete',function(){

        var pk = $(this).parent().siblings('td').data('pk');
        var record = $(this).closest('tr');
        var chk = confirm('ยืนยันการลบข้อมูล ?');

        if(chk == true){
            $.ajax({
                url:'{{ route("admin.category.deletedata") }}',
                method:'POST',
                data:{id:pk},
                success:function(data){
                    // console.log(data.success);
                    record.fadeOut(1800);
                    Lobibox.notify("success", {
                        msg: "ลบข้อมูลสำเร็จ"
                    });
                }
            });
        }
        return false;

    });

    $('#datafetch').editable({
        selector: 'td.category',
        url:'{{ route("admin.category.update") }}',
        type: 'text',
        title: 'Enter category',
        dataType:'json',
        validate: function(value) {
            if($.trim(value) == '') {
                return 'โปรดกรอกข้อมูล';
            }
        }
    });

    $('#datafetch').editable({
        selector: 'td.description',
        url:'{{ route("admin.category.update") }}',
        type: 'text',
        title: 'Enter description',
        dataType:'json',
        validate: function(value) {
            if($.trim(value) == '') {
                return 'โปรดกรอกข้อมูล';
            }
        }
    });

    $('#datafetch').editable({
        selector: 'td.hyper_link',
        url:'{{ route("admin.category.update") }}',
        type: 'text',
        title: 'Enter hyper_link',
        dataType:'json'
    });


    $('#datafetch').editable({
        selector: 'td.type',
        url:'{{ route("admin.category.update") }}',
        type: 'select',
        value:'default',
        source: [
              {value:'default',text:'-- เลือกType --',disabled:true},
              {value: 'A', text: 'A'},
              {value: 'S', text: 'S'},
              {value: 'M', text: 'M'},
              {value: 'G', text: 'G'},
              {value: 'C', text: 'C'},
              {value: 'O', text: 'O'},
              {value: 'L', text: 'L'},

           ]
    });

    $('#datafetch').editable({
        selector: 'td.content_type',
        url:'{{ route("admin.category.update") }}',
        type: 'select',
        value:'default',
        source: [
              {value:'default',text:'-- เลือก Content Type --',disabled:true},
              {value: 'calender', text: 'calender'},
              {value: 'download_doc', text: 'download_doc'},
              {value: 'ebook', text: 'ebook'},
              {value: 'link_url', text: 'link_url'},
              {value: 'photo', text: 'photo'},
              {value: 'content', text: 'content'},
              {value: 'signature', text: 'signature'},
              {value: 'video', text: 'video'},
              {value: 'personnel', text: 'personnel'},
              {value: 'default', text: 'default'},

           ]
    });

    $('#datafetch').editable({
        selector: 'td.status',
        type:'select',
        url:'{{ route("admin.category.update") }}',
        value:'default',
        source: [
              {value:'default',text:'-- เลือกสถานะ --',disabled:true},
              {value: 0, text: 'OFF'},
              {value: 1, text: 'ON'}
           ]
    });
});

</script>

@endpush
