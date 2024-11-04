<script>
    function chkForm() {
        if ($('[name="checkboxList[]"]:checked').length == 0) {
            alert('กรุณาเลือกรายการ เพื่ออนุมัติ');
            return false;
        }
    }
</script>
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="sparkline13-list shadow-reset">
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <form id="ApproveMsg" action="{{ route('approve_mobile_message.store') }}" method="POST"
                                onsubmit="return chkForm();">
                                @csrf
                                <div class="row ">
                                    <h3>ค้นหารูปแบบการส่ง</h3>
                                    <input type="radio" name="selSearch" id="" value="memno" checked>
                                    ทะเบียนสมาชิก
                                    <input type="radio" name="selSearch" id="" value="group"> ตามรายหน่วย
                                    {{-- <input type="radio" name="selSearch" id="" value="all"> ส่งแบบทุกคน --}}
                                    <hr>
                                </div>
                                <table id="table_approveMsg" data-pagination="true" data-search="true"
                                    data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                    data-key-events="true" data-show-toggle="true" data-show-export="true"
                                    {{-- data-page-list="[5,15,10,25,50,200]" --}} {{-- data-page-list="[10, 25, 50, 100, 200, All]" --}}
                                    data-page-list="[50, 100, 200, 500, 1000, All]" {{-- data-page-size="50" --}}
                                    data-click-to-select="true" data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="checkboxStatus" class="text-primary">
                                                <input type="checkbox" class="checkboxListAll" /> เลือกทั้งหมด
                                            </th>
                                            <th data-field="img" data-sortable="true">&nbsp;</th>
                                            <th data-field="operate_date" data-sortable="true">วันที่</th>
                                            <th data-field="member_name" data-sortable="false">รหัสสมาชิก(รูปแบบการส่ง)
                                            </th>
                                            <th data-field="detail" data-sortable="false">รายละเอียดข้อความ</th>
                                            {{-- <th data-field="ndata" data-sortable="false">ลิงก์เอกสารแนบ</th> --}}
                                            <th data-field="status_confirm" data-sortable="true">สถานะการส่ง</th>
                                            {{-- <th data-field="status_read" data-sortable="false">สถานะการอ่าน</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <hr>
                                <button class="btn btn-danger" type="submit">อนุมัติข้อความที่เลือก</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {{-- <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script> --}}
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script> --}}
    <script>
        var $table = $('#table_approveMsg');

        function set() {

            var option = $('[name="selSearch"]:checked');

            if (option.val() == 'memno') {

                // $table.bootstrapTable('refresh', {
                //     url: "{{ url('approveMsg/feed_indexMemno') }}"
                // });

                $table.bootstrapTable('refreshOptions', {
                    url: "{{ url('approveMsg/feed_indexMemno') }}"
                });
                // url('approveMsg/feed_indexMemno')

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
                    sortName: "sc_confirm_register.membership_no",
                    sortOrder: "asc",
                    url: "{{ url('approveMsg/feed_indexMemno') }}",
                    smartDisplay: false,
                    // pageList: [50, 100, 250, 500, 'all'],
                    pageSize: 50,
                    // showJumpTo: true,
                    // showJumpToByPages: 5,
                    // queryParams : 'queryParams',
                    // ajax:'fetchdata'

                })

            } else if (option.val() == 'group') {

                $table.bootstrapTable('refresh', {
                    url: "{{ url('approveMsg/feed_indexGroup') }}"
                });
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
                    sortName: "sc_confirm_register.membership_no",
                    sortOrder: "asc",
                    url: "{{ url('approveMsg/feed_indexGroup') }}",
                    smartDisplay: false,
                    // showJumpTo: true,
                    // showJumpToByPages: 5,
                    pageSize: 50,
                    // queryParams : 'queryParams',
                    // ajax:'fetchdata'
                    pageList: [50, 100, 250, 500, 'all']
                })
            } else if (option.val() == 'all') {

                $table.bootstrapTable('refresh', {
                    url: "{{ url('approveMsg/feed_indexAll') }}"
                });
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
                    // sortName: "seq",
                    sortOrder: "asc",
                    url: "{{ url('approveMsg/feed_indexAll') }}",
                    smartDisplay: false,
                    // showJumpTo: true,
                    // showJumpToByPages: 5,
                    pageSize: 50,
                    // queryParams : 'queryParams',
                    // ajax:'fetchdata'
                    pageList: [50, 100, 250, 500, 'all']
                })

            }

            $('#sortStable').change(function() {
                $table.bootstrapTable('refreshOptions', {
                    sortStable: $('#sortStable').prop('checked')
                })
            })
        }

        set();

        $('[name="selSearch"]').change(function() {
            set();
        });

        $('.checkboxListAll').change(function() {
            // alert($(this).is(':checked'));
            if ($(this).is(':checked')) {
                $('#ApproveMsg [type="checkbox"]').prop('checked', true);
            } else {
                $('#ApproveMsg [type="checkbox"]').prop('checked', false);
            }
        });
    </script>
@endpush
