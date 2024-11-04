<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="sparkline13-list shadow-reset">
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <table
                                id="table_approve"
                                {{-- data-sort-order="desc" --}}
                                {{-- data-toggle="table"  --}}
                                data-pagination="true"
                                data-search="true"
                                data-show-columns="true"
                                {{-- data-show-pagination-switch="true" --}}
                                data-show-refresh="true"
                                data-key-events="true"
                                data-show-toggle="true"
                                {{-- data-cookie="true" --}}
                                {{-- data-cookie-id-table="saveId"  --}}
                                data-show-export="true"
                                data-click-to-select="true"
                                data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="sc_confirm_register.membership_no" data-sortable="true">รหัส</th>
                                        <th data-field="member_name" data-sortable="false">ชื่อ - สกุล</th>
                                        {{-- <th data-field="password" data-sortable="true">รหัสผ่าน</th> --}}
                                        <th data-field="sm_mem_m_membership_registered.id_card" data-sortable="true">ID Card</th>
                                        <th data-field="sc_confirm_register.mem_confirm" data-sortable="true">สถานะ</th>
                                        <th data-field="success" data-sortable="false">ยืนยัน</th>
                                        <th data-field="cancel" data-sortable="false">ยกเลิก</th>
                                        <th data-field="delete" data-sortable="false">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($approve_user as $row)
                                                    <tr>
                                                        <td>{{ $row->membership_no }}</td>

                                    @php
                                    $security_user = Auth::user()->group_code;
                                    @endphp

                                    @if(in_array($security_user,array("S","A")))

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
                                        @if ( $row->mem_confirm == 1 )
                                        <font color='blue'><b>อนุมัติแล้ว</b></font>
                                        @endif
                                        @if ( $row->mem_confirm == 0 )
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
            // showPaginationSwitch:true,
            striped : true,
            dataType: 'json',
            method: 'post',
            sortName: "sc_confirm_register.membership_no",
            sortOrder:"asc",
            url: "{{ url('approve/feed_index') }}",
            // queryParams : 'queryParams',
        })

        $('#sortStable').change(function () {
            $table.bootstrapTable('refreshOptions', {
            sortStable: $('#sortStable').prop('checked')
            })
        })
    })

    // function queryParams(params) {
    //     console.log('queryParams');
    //     return params
    // }

    $(document).ready(function(){

        $('#table_approve').on('click','#btncancel',function(){
            //get membership_no
            var membership_no = $(this).parent().siblings('td').eq(0).text();
            //get mem_confirm value
            var mem_confirm = $(this).val();

            var chk = confirm('ยืนยันการ..ยกเลิก ?');

            if(chk == true){
                UpdateMemConfirm(membership_no,mem_confirm);
            }
            return false;
        });

        $('#table_approve').on('click','#btnok',function(){
            //get membership_no
            var membership_no = $(this).parent().siblings('td').eq(0).text();
            //get mem_confirm value
            var mem_confirm = $(this).val();

            var chk = confirm('ยืนยันการ..อนุมัติ ?');

            if(chk == true){
                UpdateMemConfirm(membership_no,mem_confirm);
            }
            return false;
        });

        $('#table_approve').on('click','#btndel',function(){
            //get membership_no
            var membership_no = $(this).parent().siblings('td').eq(0).text();

            var url = '{{ route("admin.approve.delete_memconfirm") }}';

            var chk = confirm('ยืนยันการ..ลบ ?');

            if(chk == true){
                $.ajax({
                    url:url,
                    method:'POST',
                    data:{membership_no:membership_no},
                    success:function(data){
                        Lobibox.notify("success", {
                            msg: "ลบข้อมูลการอนุมัติสำเร็จ"
                        });
                        location.reload();
                    }
                });
            }
            return false;
        });
        
        $('button[name="paginationSwitch"]').click(function(){
            alert();
        });

    });


/*******Function Update การอนุมัติ************/
    function UpdateMemConfirm(membership_no,mem_confirm){

        var url = '{{ route("approve.update",membership_no) }}';

        $.ajax({
            url:url,
            method:'PUT',
            data:{membership_no:membership_no,mem_confirm:mem_confirm},
            success:function(data){
                Lobibox.notify("success", {
                    msg: "อัพเดทการอนุมัติแล้ว"
                });
                location.reload();
            }
        });
    }
/*********Function Update การอนุมัติ***********/
</script>
@endpush
