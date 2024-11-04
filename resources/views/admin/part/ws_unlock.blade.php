<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="sparkline13-list shadow-reset">
                    <div class="sparkline13-graph">
                        <h2 class="text-center">
                            ปลดล็อค
                        </h2>
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <table id="table_approve" {{-- data-sort-order="desc" --}} {{-- data-toggle="table"  --}} data-pagination="true"
                                data-search="true" data-show-columns="true" data-show-pagination-switch="true"
                                data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                {{-- data-cookie="true" --}} {{-- data-cookie-id-table="saveId"  --}} data-show-export="true"
                                data-click-to-select="true" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="id" hidden data-sortable="true">รหัส</th>
                                        <th data-field="mem_no" data-sortable="true">ทะเบียน</th>
                                        <th data-field="mem_name" data-sortable="true">ชื่อ - สกุล</th>
                                        {{-- <th data-field="password" data-sortable="true">รหัสผ่าน</th> --}}
                                        <th data-field="mem_id" data-sortable="true">ID Card</th>
                                        <th data-field="mem_platform" data-sortable="false">ระบบ</th>
                                        <th data-field="mem_model" data-sortable="false">รุ่น</th>
                                        <th data-field="mem_num" data-sortable="true">เบอร์</th>
                                        <th data-field="unlock" data-sortable="false">ปลดล็อค</th>
                                        {{-- <th data-field="cancel" data-sortable="false">ยกเลิก</th>
                                        <th data-field="delete" data-sortable="false">ลบ</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($approve_user as $row)
                                                    <tr>
                                                        <td>{{ $row->membership_no }}</td>

                                    @php
                                    $security_user = Auth::user()->group_code;
                                    @endphp

                                    @if (in_array($security_user, ['S', 'A']))

                                    <td class="linkbor">
                                        <a href="{{ url('member/mem') }}?membership_no={{ $row->membership_no }}"
                                            target="_blank" style="color: #ff935d;">
                                            {{ $row->prename." ".$row->member_name." ".$row->member_surname }}
                                        </a>
                                    </td>

                                    @else

                                    <td>{{ $row->prename." ".$row->member_name." ".$row->member_surname }}</td>

                                    @endif
                                    <td>{{ $row->mem_password }}</td>
                                    <td>{{ $row->mem_id }}</td>

                                    <td>
                                        @if ($row->mem_confirm == 1)
                                        <font color='blue'><b>อนุมัติแล้ว</b></font>
                                        @endif
                                        @if ($row->mem_confirm == 0)
                                        <font color='#FF0000'><b>ยังไม่อนุมัติ</b></font>
                                        @endif
                                        <input type="hidden" name="newconfirm" id="newconfirm"
                                            value=" {{ $row->mem_confirm }} ">
                                    </td>

                                    <td>
                                        @if ($row->mem_confirm == 1)
                                        <button id="btnok" class="btn btn-success" type="button" name="newconfirm"
                                            value="1" disabled>ยืนยัน</button>
                                        @else
                                        <button id="btnok" class="btn btn-success" type="button" name="newconfirm"
                                            value="1">ยืนยัน</button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->mem_confirm == 0)
                                        <button id="btncancel" class="btn btn-warning" type="button" name="newconfirm"
                                            value="0" disabled>ยกเลิก</button>
                                        @else
                                        <button id="btncancel" class="btn btn-warning" type="button" name="newconfirm"
                                            value="0">ยกเลิก</button>
                                        @endif

                                    </td>
                                    <td><button id="btndel" class="btn btn-danger" type="button" name="newconfirm"
                                            value="2">ลบ</button></td>
                                    </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    td.linkbor>a:hover {
        border-bottom: 2px dashed;
        color: orange;
        font-weight: 700;
    }
</style>

@push('scripts')
    {{-- <script src="{{ asset('admin/js/Lobibox.js') }}"></script> --}}

    <script>
        //--setup ajax
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        var $table = $('#table_approve')

        $(function() {
            $table.bootstrapTable({
                // data: data,
                pagination: true,
                search: true,
                showExport: true,
                showColumns: true,
                sortStable: true,
                sidePagination: 'server',
                striped: true,
                dataType: 'json',
                method: 'post',
                sortName: "sm_pro_device_regis.membership_no",
                sortOrder: "asc",
                url: "{{ url('ws_unlock/feed_index') }}",
                // queryParams : 'queryParams',
                // ajax:'fetchdata'
                pageList: [10, 30, 100, 'all']
            })

            $('#sortStable').change(function() {
                $table.bootstrapTable('refreshOptions', {
                    sortStable: $('#sortStable').prop('checked')
                })
            })
        })

        // function queryParams(params) {
        //     console.log('queryParams');
        //     return params
        // }

        $(document).ready(function() {

            // $('#table_approve').on('click','#btncancel',function(){
            //     //get membership_no
            //     var membership_no = $(this).parent().siblings('td').eq(0).text();
            //     //get mem_confirm value
            //     var mem_confirm = $(this).val();

            //     var chk = confirm('ยืนยันการ..ยกเลิก ?');

            //     if(chk == true){
            //         UpdateMemConfirm(membership_no,mem_confirm);
            //     }
            //     return false;
            // });

            $('#table_approve').on('click', '#btnok', function() {
                //get membership_no
                var id = $(this).parent().siblings('td').eq(0).text();
                //get mem_confirm value
                var status = $(this).val();

                var chk = confirm('ยืนยันการปลดล็อค ?');

                if (chk == true) {
                    UnlockMemConfirm(id, status);
                }
                return false;
            });

            // $('#table_approve').on('click','#btnok',function(){
            //     //get membership_no
            //     var membership_no = $(this).parent().siblings('td').eq(0).text();
            //     //get mem_confirm value
            //     var mem_confirm = $(this).val();

            //     var chk = confirm('ยืนยันการ..อนุมัติ ?');

            //     if(chk == true){
            //         UpdateMemConfirm(membership_no,mem_confirm);
            //     }
            //     return false;
            // });

            // $('#table_approve').on('click','#btndel',function(){
            //     //get membership_no
            //     var id = $(this).parent().siblings('td').eq(0).text();

            //     var url = '{{ route('admin.ws_unlock.delete_memconfirm') }}';

            //     var chk = confirm('ยืนยันการ..ลบ ?');

            //     if(chk == true){
            //         $.ajax({
            //             url:url,
            //             method:'POST',
            //             data:{id:id},
            //             success:function(data){
            //                 Lobibox.notify("success", {
            //                     msg: "ลบข้อมูลการอนุมัติสำเร็จ"
            //                 });
            //                 location.reload();
            //             }
            //         });
            //     }
            //     return false;
            // });

        });


        /*******Function Update การอนุมัติ************/
        function UnlockMemConfirm(id, status) {

            var url = '{{ route('ws_unlock.update', id) }}';

            $.ajax({
                url: url,
                method: 'PUT',
                data: {
                    id: id,
                    status: status
                },
                success: function(data) {
                    Lobibox.notify("success", {
                        msg: "ปลดล็อคเรียบร้อยแล้ว"
                    });
                    location.reload();
                }
            });
        }
        /*********Function Update การอนุมัติ***********/

        function openPassWord(eye) {
            if ($(eye).hasClass("fa-eye-slash") == true) {
                $(eye).removeClass("fa-eye-slash").addClass("fa-eye");
                $(eye).prev().hide();
                $(eye).next().show();
            } else {
                $(eye).removeClass("fa-eye").addClass("fa-eye-slash");
                $(eye).prev().show();
                $(eye).next().hide();
            }
        }
    </script>
@endpush
