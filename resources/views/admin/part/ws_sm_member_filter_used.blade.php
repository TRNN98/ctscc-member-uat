<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="sparkline13-list shadow-reset">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1>สมาชิกอนุญาตใช้งาน</h1>
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="row">
                            <div class="col-lg-12 text-left">
                                <label>
                                    สถานะ Web Member :
                                </label>
                                &nbsp;
                                <b>
                                    {{-- <u> --}}
                                    {!! $member_maintenance == 1
                                        ? '<span style="color:MediumSeaGreen;">เปิดใช้งานProduction(สถานะปกติสามารถใช้งานได้ทุกสิทธิ์)</span>'
                                        : '<span style="color:orange;">เปิดใช้งานSoftlaunch(อนุญาตผู้มีสิทธิ์เท่านั้นสามารถใช้งานได้)</span>' !!}
                                    {{-- </u> --}}
                                </b>
                            </div>
                            <div class="col-lg-12 text-left">
                                <label>
                                    สถานะ FollowME :
                                </label>
                                &nbsp;
                                <b>

                                    {!! $FollowMEsoftlaunch == 1
                                        ? '<span style="color:orange;">เปิดใช้งานSoftlaunch(อนุญาตผู้มีสิทธิ์เท่านั้นสามารถใช้งานได้)</span>'
                                        : '<span style="color:MediumSeaGreen;">เปิดใช้งานProduction(สถานะปกติสามารถใช้งานได้ทุกสิทธิ์)</span>' !!}

                                </b>
                            </div>
                            <div class="col-lg-12 text-left">
                                <label>
                                    สถานะ Promoney :
                                </label>
                                &nbsp;
                                <b>

                                    {!! $Promoneysoftlaunch == 1
                                        ? '<span style="color:orange;">เปิดใช้งานSoftlaunch(อนุญาตผู้มีสิทธิ์เท่านั้นสามารถใช้งานได้)</span>'
                                        : '<span style="color:MediumSeaGreen;">เปิดใช้งานProduction(สถานะปกติสามารถใช้งานได้ทุกสิทธิ์)</span>' !!}

                                </b>
                            </div>
                        </div>
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <button class="btn btn-success" data-target="#ModalAddData2"
                                data-toggle="modal">เพิ่มเลขสมาชิก</button>
                            <table width="100%" id="table_mem2" data-show-pagination-switch="true"
                                data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                data-resizable="true" {{-- data-cookie="true" --}} {{-- data-cookie-id-table="saveId" --}}
                                data-click-to-select="true">
                                <thead>
                                    <tr>
                                        <th width="20%" data-field="membership_no" data-sortable="true">รหัสสมาชิก
                                        </th>
                                        <th width="20%" data-field="member_name" data-sortable="true">ชื่่อ - สกุล
                                        </th>
                                        <th width="20%" data-field="web_member_active" data-sortable="true">
                                            Softlaunch(WebMember)</th>
                                        <th width="20%" data-field="followme_active" data-sortable="true">
                                            Softlaunch(FollowME)</th>
                                        <th data-field="promoney_active" data-sortable="true">Softlaunch(Promoney)</th>
                                        {{-- <th data-field="register_active" data-sortable="true">การลงทะเบียนสมาชิก</th> --}}

                                        <th width="10%" data-field="update"></th>
                                        <th width="10%" data-field="delete"></th>
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



{{-- Modal Add Data --}}
<div id="ModalAddData2" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-close-area modal-close-df">
                <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
            </div>
            <div class="modal-body">
                <form id="formAddData" action="{{ route('ws_sm_member_filter_used.store') }}" method="POST">
                    @csrf
                    <div class="modal-login-form-inner">
                        <div class="form-group-inner">
                            <h2>เพิ่มเลขสมาชิก</h2>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>เลขสมาชิก</label>
                                        <input name="addMemNo" type="text" class="form-control" maxlength="7"
                                            onblur="Wordcount(this);" onkeypress="isInputNumber(event)" required>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <label>Softlaunch(Web Member)</label>
                                        <select class="form-control" name="web_member_active">
                                            <option style="color: red;" value="0">
                                                ไม่อนุญาตใช้งาน
                                            </option>
                                            <option style="color: green;" value="1" selected>
                                                อนุญาตใช้งาน
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <label>Softlaunch(FollowMe)</label>
                                        <select class="form-control" name="followme_active">
                                            <option style="color: red;" value="0">
                                                ไม่อนุญาตใช้งาน
                                            </option>
                                            <option style="color: green;" value="1" selected>
                                                อนุญาตใช้งาน
                                            </option>
                                        </select>
                                    </div>
                                    {{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <label>Softlaunch(Promoney)</label>
                                        <select class="form-control" name="promoney_active">
                                            <option style="color: red;" value="0">
                                                ไม่อนุญาตใช้งาน
                                            </option>
                                            <option style="color: green;" value="1" selected>
                                                อนุญาตใช้งาน
                                            </option>
                                        </select>
                                    </div> --}}
                                </div>
                                <div class="col-lg-12 mg-t-30 ">
                                    <hr>
                                    <button type="submit"
                                        style="background: linear-gradient(to bottom, #ff9966 0%, #d75151 100%); "
                                        class="pull-right btn btn-warning login-submit-cs" id="btnAddCategory">
                                        เพิ่ม <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>{{-- //modal-body --}}
        </div>
    </div>
</div>
{{-- End Modal AddData --}}

<style>
    .linkbor:hover {
        border-bottom: 2px dashed;
        color: orange;
        font-weight: 700;
    }
</style>

@push('scripts')
    <script>
        var $table = $('#table_mem2')

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
                sortOrder: "asc",
                url: "{{ url('ws_sm_member_filter_used/feed_index') }}",
                queryParams: 'queryParams',
                // ajax:'fetchdata'
            })

            $('#sortStable').change(function() {
                $table.bootstrapTable('refreshOptions', {
                    sortStable: $('#sortStable').prop('checked')
                })
            })
        })

        function queryParams(params) {
            console.log('queryParams');
            return params
        }

        $('#table_mem2').on('click', '#btndelMem', function() {

            var membership_no = $(this).parent().siblings('td').eq(0).text();

            var conff = confirm('ยืนยันการลบข้อมูล ?');

            var url = '{{ route('ws_sm_member_filter_used.del') }}';

            if (conff == true) {

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        membership_no: membership_no
                    },
                    success: function(data) {
                        // console.log(data);
                        // if($dat)
                        // Lobibox.notify("success", {
                        //     msg: "ลบข้อมูลการอนุมัติสำเร็จ"
                        // });
                        // location.reload();
                        if (data.code == "DEL200SUCCESS") {
                            Lobibox.notify("success", {
                                msg: data.message
                            });
                        } else {
                            Lobibox.notify("error", {
                                msg: data.message
                            });
                        }
                        $table.bootstrapTable('refresh');
                    }
                });

            }

        });


        $('#table_mem2').on('click', '#btnupdateMem', function() {

            var membership_no = $(this).parent().siblings('td').eq(0).text();
            var web_member_active = $(this).parent().siblings('td').eq(2).find("select").val();
            var followme_active = $(this).parent().siblings('td').eq(3).find("select").val();
            var promoney_active = $(this).parent().siblings('td').eq(4).find("select").val();

            // console.log(membership_no, promoney_active, web_member_active)
            // var conff = confirm('ยืนยันการปรับข้อมูล ?');
            var conff = true;
            var url = '{{ route('ws_sm_member_filter_used.update') }}';

            if (conff == true) {

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        membership_no: membership_no,
                        promoney_active: promoney_active,
                        followme_active: followme_active,
                        web_member_active: web_member_active,
                    },
                    success: function(data) {
                        // console.log(data);
                        if (data.code == "UP200SUCCESS") {
                            Lobibox.notify("success", {
                                msg: data.message
                            });
                        } else {
                            Lobibox.notify("error", {
                                msg: data.message
                            });
                        }
                        $table.bootstrapTable('refresh');
                        // location.reload();
                    }
                });

            }

        });
        // -----------------------

        function Wordcount(el) {
            let newWrd;
            let txtbox = $(el);
            let Wrdlen = $(el).val().length;
            if (Wrdlen == 1) {
                newWrd = '0000' + txtbox.val();
                txtbox.val(newWrd);
            }
            if (Wrdlen == 2) {
                newWrd = '000' + txtbox.val();
                txtbox.val(newWrd);
            }
            if (Wrdlen == 3) {
                newWrd = '00' + txtbox.val();
                txtbox.val(newWrd);
            }
            if (Wrdlen == 4) {
                newWrd = '0' + txtbox.val();
                txtbox.val(newWrd);
            }
            // if (Wrdlen == 5) {
            //     newWrd = '00' + txtbox.val();
            //     txtbox.val(newWrd);
            // }
            // if (Wrdlen == 6) {
            //     newWrd = '0' + txtbox.val();
            //     txtbox.val(newWrd);
            // }


        }

        function isInputNumber(e) {
            var char = String.fromCharCode(e.which);
            if (!(/[0-9a-zA-Z\u0E00-\u0E7F]/.test(char))) {
                e.preventDefault();
            }
        }
    </script>
@endpush
