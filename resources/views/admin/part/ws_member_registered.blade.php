<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="sparkline13-list shadow-reset">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1>สมาชิกในระบบ</h1>
                            <div class="sparkline13-outline-icon">
                                <span class="sparkline13-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                <span><i class="fa fa-wrench"></i></span>
                                <span class="sparkline13-collapse-close"><i class="fa fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <table id="table_mem"
                                data-show-pagination-switch="false"
                                data-show-refresh="true"
                                data-key-events="true"
                                data-show-toggle="true"
                                data-resizable="true"
                                {{-- data-cookie="true" --}}
                                {{-- data-cookie-id-table="saveId" --}}
                                data-click-to-select="true">
                                <thead>
                                    <tr>
                                        <th data-field="membership_no" data-sortable="true">รหัสสมาชิก</th>
                                        <th data-field="member_name" data-sortable="true">ชื่่อ - สกุล</th>
                                        <th data-field="date_of_birth" data-sortable="true">วัน/เดือน/ปี เกิด</th>
                                        <th data-field="id_card" data-sortable="true">ID Card</th>
                                        <th data-field="email" data-sortable="true">อีเมล</th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Static Table End -->

<style>
    .linkbor:hover {
        border-bottom: 2px dashed;
        color: orange;
        font-weight: 700;
    }
</style>

@push('scripts')

<script>
    var $table = $('#table_mem')

    $(function() {
        $table.bootstrapTable({
            // data: data,
            pagination: true,
            search: true,
            showExport: true,
            showColumns: true,
            sortStable: true,
            autoRefresh: true,
            sidePagination: 'server',
            dataType: 'json',
            method: 'post',
            sortName: "membership_no",
            sortOrder:"asc",
            url: "{{ url('ws_member_registered/feed_index') }}",
            // queryParams : 'queryParams',
            // ajax:'fetchdata'
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

</script>

@endpush
