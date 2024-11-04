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
                                        <th data-field="membership_id" data-sortable="true">รหัส</th>
                                        <th data-field="membership_no" data-sortable="true">รหัสสมาชิก</th>
                                        <th data-field="member_name" data-sortable="true">ชื่อ - สกุล</th>
                                        <th data-field="last_login" data-sortable="true">วันล็อคอินล่าสุด</th>
                                        <th data-field="mem_status" data-sortable="true">สถานะ</th>
                                        <th data-field="unlock" data-sortable="true">ปลดล็อค</th>

                                    </tr>
                                </thead>
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
                sortName: "sm_auth_pincode.date",
                sortOrder: "desc",
                url: "{{ url('ws_unlockpin/feed_index') }}",
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
                var membership_no = $(this).parent().siblings('td').eq(1).text();
                //get mem_status value
                var mem_status = $(this).val();
                var chk = confirm('ยืนยันการ..ปลดล็อค ?');
                var id = "none"
                if (chk == true) {
                    UpdateMemConfirm(membership_no, mem_status, id);
                    location.reload();
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
        function UpdateMemConfirm(membership_no, mem_status, id) {

            var url = '{{ route('ws_unlockpin.update', membership_no) }}';

            $.ajax({
                url: url,
                method: 'PUT',
                data: {
                    membership_no: membership_no,
                    mem_status: mem_status,
                    mem_id: id
                },
                unlock: function(data) {
                    Lobibox.notify("unlock", {
                        msg: "อัพเดทการปลดล็อคแล้ว"
                    });
                    location.reload();
                }
            });
        }
        /*********Function Update การอนุมัติ***********/
    </script>
@endpush
