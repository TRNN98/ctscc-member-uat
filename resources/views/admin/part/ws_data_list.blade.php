<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="sparkline13-list shadow-reset">
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                                <a
                                    href="?page=ws_post&Category={{ Request::get('Category') }}&type={{ Request::get('type') }}">
                                    <button type="button" class="btn btn-custon-four btn-success"><span
                                            class="adminpro-icon adminpro-cloud-computing-down"></span>เพิ่มข้อมูล</button>
                                </a>
                            </div>
                            <table id="data_list" class="display table table-bordered dataTable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>[เลขที่]</th>
                                        <th>เรื่อง โดย [วันที่]</th>
                                        <th>ลำดับ</th>
                                        <th>แก้ไข</th>
                                        <th>ลบ</th>
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


@push('scripts')

<script type="text/javascript" src="{{ asset('admin/dist/DataTables/datatables.min.js') }}"></script>

<script>
    var $table = $('#data_list');

    $(document).ready(function() {
        var table = $table.DataTable({
            lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            processing: true,
            serverSide: true,
            dom: 'Bfrti<"row"<"col-sm-6 text-left"l><"col-sm-6"p>>',
            responsive: true,
            // "ordering": false,
            order: [[2, 'asc']],
            buttons: [
                'copy', 'excel', 'print',
            ],
            ajax: {
                url: "{{ route('ws_data_list.store') }}",
                type: "json",
                type: "POST",
                data:{
                    _token: "{{csrf_token()}}",
                    Category: "{{ Request::get('Category') }}",
                    type: "{{ Request::get('type') }}"
                },
            },
            columns: [
                { "data": "No" },
                { "data": "Question" },
                {
                    "data": "DataSort",
                    render: function(data, type, full, meta) {
                        if (data == null) {
                            return data;
                        }else{
                            return data+1;
                        }
                    },
                },
                {
                    "data": "edit",
                    orderable: false
                },
                {
                    "data": "delete",
                    orderable: false
                }
            ],
            rowReorder: {
                dataSrc: 'DataSort',
                // editor:  editor
            },
            columnDefs: [
                {  className: 'reorder', targets: 0 },
                // { targets: 2, visible: false }
            ],
        });

        table.on('row-reorder', function ( e, diff, edit ) {

            var myArray = [];

            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                var rowData = table.row(diff[i].node).data();
                myArray.push({
                    id: rowData.No,			// record id from datatable
                    position: diff[i].newData,		// new position
                    datasoft: rowData.DataSort
                });
            }

            var jsonString = JSON.stringify(myArray);

            $.ajax({
                type: "PUT",
                dataType: "json",
                url: "{{ route('ws_data_list.update', Request::get('Category')) }}",
                data: jsonString,
                success: function(response) {
                    if (response == "success") {
                        Lobibox.notify("success", {
                            msg: "แก้ไขข้อมูลสำเร็จ"
                        });
                        $table.DataTable().ajax.reload();

                    } else {
                        console.log(response);
                        Lobibox.notify("error", {
                            msg: "แก้ไขข้อมูลไม่สำเร็จ"
                        });
                        $table.DataTable().ajax.reload();
                    }
                }
            });
        });

    });

</script>

@endpush
