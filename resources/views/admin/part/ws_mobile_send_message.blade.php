<!-- duallistbox CSS
    ============================================ -->
{{-- <link rel="stylesheet" href="{{ asset('admin/css/duallistbox/bootstrap-duallistbox.min.css') }}"> --}}
<link href="{{ asset('admin/librarys//multi-select/css/multi-select.css') }}" rel="stylesheet">
<script>
    function chkForm() {
        if (!$('.radioSearch').is(':checked')) {
            alert('กรุณาเลือก รูปแบบการส่ง');
            return false;
        }
        // if ($('select[name="dual_select[]_helper2"]').has('option').length == 0 && !$('[value="search_all"]').is(
        //         ':checked')) {
        //     alert('กรุณาเลือกสมาชิกที่ต้องการส่งข้อความ');
        //     return false;
        // }
        // if ($('select[name="membership_no"]').has('option').length == 0 && $('select[name="member_group"]').has('option').length == 0 ) {
        //     alert('กรุณาเลือกสมาชิกที่ต้องการส่งข้อความ');
        //     return false;
        // }
    }

    function HideBox() {
        $('.box1').hide();
        $('.box2').hide();
    }

    function ShowBox() {
        $('.box1').show();
        $('.box2').show();
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<div class="container-fluid mg-b-15">
    <div class="breadcome-list shadow-reset">
        <form id="fsend" action="{{ route('mobile_send_message.store') }}" method="POST" onsubmit="return chkForm();">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="login2 pull-right pull-right-pro" id="Header">หัวเรื่อง : </label>
                            </div>
                            <div class="col-md-7" id="textInputGroup">
                                <input type="text" class="form-control" id ="QTitle" name="QTitle" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group-inner">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="login2 pull-right pull-right-pro" id="description">รายละเอียด : </label>
                            </div>
                            <div class="col-md-7">
                                <textarea style="resize: none;" cols="100" rows="20" id="QNote" name="QNote" class="form-control"
                                    required></textarea>
                            </div>
                        </div>
                    </div>
                    {{-- @include('admin.content.widget.file_upload', ['ndata' => ''])
                        @include('admin.content.widget.pic_upload', ['nphoto' => '']) --}}
                    <hr>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="login2 pull-right pull-right-pro" style="padding: 3px 7px;">รูปแบบการส่ง :
                                </label>
                            </div>
                            <div class="col-md-7">
                                <div class="demo-radio-button">
                                    <input name="radioMemGroup" id="radioMemGroup" class="radioSearch" type="radio"
                                        value="membership" />
                                    <label for="radio_1">เลือกตามทะเบียนสมาชิกรายตัว</label>
                                    <input name="radioMemGroup" id="radioMemGroup" class="radioSearch" type="radio"
                                        value="member_group" />
                                    <label for="radio_2">เลือกตามรายหน่วย</label>
                                    <div>&nbsp; </div>
                                    <input name="radioMemGroup" id="radioMemGroup" class="radioSearch"type="radio"
                                        value="member_external_import" />
                                    <label for="radio_3">เลือกตามไฟล์เรียกเข้า</label>
                                    {{-- <input class="radio-checked radioSearch" type="radio" value="search_all"
                                        id="radioMemGroup" name="radioMemGroup"><label
                                        for="radio_4">เลือกทั้งหมด</label> --}}
                                    &nbsp;&nbsp;
                                    {{-- display:none; --}}

                                    {{-- ส่วนของการแสดงผลถัดไป เมื่อกดปุ่มเลือกตามไฟล์เรียกเข้าโดย track จาก value member_external_import ในการแสดงส่วนนี้ออกมา --}}
                                    <style>
                                        table {
                                            width: 100%;
                                            border-collapse: collapse;
                                        }

                                        th,
                                        td {
                                            padding: 8px;
                                            text-align: left;
                                            border-bottom: 1px solid #ddd;
                                        }

                                        th {
                                            font-weight: bold;
                                        }

                                        tr:first-child th {
                                            background-color: #f2f2f2;
                                        }

                                        .file-preview-container {
                                            width: 100%;
                                            margin-top: 20px;
                                            max-height: 250px;
                                            /* Added max-height to limit the container height */
                                            overflow-y: auto;
                                            /* Added overflow-y to enable vertical scrolling */
                                        }

                                        .loading-screen {
                                            position: fixed;
                                            top: 0;
                                            left: 0;
                                            width: 100%;
                                            height: 100%;
                                            background-color: rgba(0, 0, 0, 0.5);
                                            display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            z-index: 9999;
                                        }

                                        .loading-content {
                                            display: flex;
                                            flex-direction: column;
                                            align-items: center;
                                            color: white;
                                        }

                                        .spinner {
                                            width: 40px;
                                            height: 40px;
                                            border: 3px solid #fff;
                                            border-radius: 50%;
                                            border-top-color: transparent;
                                            animation: spin 1s infinite ease-in-out;
                                        }

                                        @keyframes spin {
                                            0% {
                                                transform: rotate(0deg);
                                            }

                                            100% {
                                                transform: rotate(360deg);
                                            }
                                        }

                                        .loading-text {
                                            margin-top: 10px;
                                        }

                                        .hidden {
                                            display: none;
                                        }
                                    </style>

                                    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
                                    <div id="member_external_import" style="display: none;">
                                        <div>
                                            <h4 style="color: red">* รับเฉพาะไฟล์ .xlsx</h4>
                                        </div>
                                        <form enctype="multipart/form-data">
                                            @csrf
                                            <label for="fileInput" class="btn btn-warning">
                                                <input type="file" id="fileInput" accept=".xlsx">
                                            </label>
                                            <button type="button" class="btn btn-primary"
                                                data-target="#fileUpload_excel" onclick="validateFileDocumentExcel();">
                                                อัพโหลดไฟล์
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="clearFilePreview();">
                                                Clear
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Place the file preview container outside of the member_external_import div -->
                                    <div class="file-preview-container">
                                        <!-- Add a container for the file preview -->
                                        <div id="filePreviewContainer"></div>
                                    </div>

                                    <script>
                                        var filePreviewContainer = document.getElementById('filePreviewContainer');
                                        var fileInput = document.getElementById('fileInput');

                                        function validateFileDocumentExcel() {
                                            var file = fileInput.files[0];

                                            if (file) {
                                                var reader = new FileReader();
                                                reader.onload = function(e) {
                                                    var filePreview = document.createElement('div');
                                                    filePreview.innerHTML = '<strong>File Preview:</strong><br>';

                                                    if (file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                                                        var table = document.createElement('table');
                                                        table.classList.add('preview-table');
                                                        var data = new Uint8Array(e.target.result);

                                                        var workbook = parseXlsFile(data);
                                                        var worksheet = workbook.Sheets[workbook.SheetNames[0]];
                                                        var jsonData = XLSX.utils.sheet_to_json(worksheet, {
                                                            header: 1
                                                        });

                                                        var headers = ['ลำดับ', 'รหัสสมาชิก', 'หัวเรื่อง', 'ข้อความ'];
                                                        var headerRow = document.createElement('tr');

                                                        for (var k = 0; k < headers.length; k++) {
                                                            var headerCell = document.createElement('th');
                                                            headerCell.textContent = headers[k];
                                                            headerRow.appendChild(headerCell);
                                                        }

                                                        table.appendChild(headerRow);

                                                        var isValidFile = true;

                                                        for (var i = 0; i < jsonData.length; i++) {
                                                            var row = document.createElement('tr');
                                                            var rowType = i === 0 ? 'td' : 'td';

                                                            var cell0 = document.createElement(rowType); // Added cell for row count
                                                            var cell1 = document.createElement(rowType);
                                                            var cell2 = document.createElement(rowType);
                                                            var cell3 = document.createElement(rowType);

                                                            var number = jsonData[i][0];
                                                            var header = jsonData[i][1];
                                                            var message = jsonData[i][2];






                                                            // Check if the first column has a 6-digit number
                                                            //   var isNumberValid = /^\d{5}$/.test(number);

                                                            //   if (isNumberValid) {
                                                            // 	cell1.textContent = number;
                                                            //   } else {
                                                            // 	cell1.style.backgroundColor = 'red';
                                                            // 	isValidFile = false;
                                                            //   }

                                                            cell1.textContent = number;

                                                            cell2.textContent = header;

                                                            cell3.textContent = message;

                                                            cell0.textContent = i + 1; // Set the row count

                                                            row.appendChild(cell0);
                                                            row.appendChild(cell1);
                                                            row.appendChild(cell2);
                                                            row.appendChild(cell3);
                                                            table.appendChild(row);
                                                        }

                                                        if (isValidFile) {
                                                            filePreview.appendChild(table);

                                                            $(".alternate-submit-button").click(function() {
                                                                var $button = $(this);
                                                                var $loadingScreen = $('.loading-screen');
                                                                // Add loading screen
                                                                $loadingScreen.removeClass('hidden');
                                                                $button.attr('disabled', 'disabled');
                                                                let URL = "{{ url('mobile_send_message') }}"
                                                                $.ajax({
                                                                    url: URL,
                                                                    method: 'POST',
                                                                    data: {
                                                                        data: jsonData
                                                                    },
                                                                    success: function(response) {
                                                                        // Remove loading screen
                                                                        $loadingScreen.addClass('hidden');
                                                                        $button.removeAttr('disabled');
                                                                        alert("ส่งไปยังรายการรออนุมัติสำเร็จ!");
                                                                        window.location.reload();

                                                                    },
                                                                    error: function(xhr, status, error) {

                                                                        alert(
                                                                            `มีข้อผิดพลาดเกิดขึ้น\nError : ${error}\nStatus : ${status}\nxhr : ${xhr}}`
                                                                            );
                                                                        window.location.reload();
                                                                    }
                                                                })
                                                            });

                                                        } else {
                                                            filePreview.innerHTML =
                                                                '<span style="color: red">Format ไฟล์ไม่ถูกต้อง. ตรวจสอบว่า column แรกของไฟล์ xlsx มีรหัสสมาชิก 6 หลักหรือไม่</span>';
                                                        }
                                                    } else {
                                                        filePreview.innerHTML =
                                                            '<span style="color: red">ไฟล์นี้ไม่ถูกรองรับ(โปรดใช้ไฟล์ .xlsx)</span>';
                                                    }

                                                    clearFilePreview();
                                                    filePreviewContainer.appendChild(filePreview);
                                                };

                                                reader.readAsArrayBuffer(file);
                                            }
                                        }

                                        function parseXlsFile(data) {
                                            // Custom logic to parse .xls file
                                            // Implement your own code here to parse the .xls file format
                                            // This is just a placeholder implementation to show the general structure

                                            // Example implementation using xlsx library for .xls files
                                            var workbook = XLSX.read(data, {
                                                type: 'array'
                                            });

                                            return workbook;
                                        }

                                        function clearFilePreview() {
                                            filePreviewContainer.innerHTML = '';
                                            fileInput.value = ''; // Clear the file input value
                                        }
                                    </script>

                                    {{-- เคลียค่า filePreviewContainer ทุกครั้งที่ select ตัวเลือกอื่น --}}
                                    <script>
                                        $(document).ready(function() {
                                            // When the radio button with value "member_external_import" is clicked
                                            $('input[name="radioMemGroup"][value="member_external_import"]').click(function() {
                                                // Hide the input field
                                                $('#QNote').hide();
                                                // Hide the description field
                                                $('#description').hide();
                                                // Disable the required attribute of the input field
                                                $('#QNote').prop('required', false);
                                                // Hide the original submit button
                                                $('#Header').hide();

                                                $('#QTitle').hide();

                                                $('.submit-button').hide();
                                                // Show the alternate submit button
                                                $('.alternate-submit-button').show();

                                            });

                                            // When any other radio button is clicked
                                            $('input[name="radioMemGroup"]').not('[value="member_external_import"]').click(function() {
                                                // Show the input field
                                                $('#QNote').show();
                                                // Show the description field
                                                $('#description').show();
                                                // Enable the required attribute of the input field
                                                $('#QNote').prop('required', true);

                                                $('#Header').show();

                                                $('#QTitle').show();
                                                // Show the submit button
                                                $('.submit-button').show();
                                                // Hide the alternate button
                                                $('.alternate-submit-button').hide();

                                            });
                                        });
                                        // Add event listeners to radio buttons
                                        var radioSearchButtons = document.querySelectorAll('.radioSearch');
                                        radioSearchButtons.forEach(function(button) {
                                            button.addEventListener('change', handleRadioSearchChange);
                                        });

                                        function handleRadioSearchChange() {
                                            // Clear the file preview container
                                            clearFilePreview();
                                        }
                                    </script>



                                </div>

                                <div class="">
                                    <div id="membership" style="display: none;">
                                        <div class="col-md-12">
                                            <select name="membership[]" class="form-control searchable"
                                                multiple="multiple" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                    <div id="member_group" style="display: none;">
                                        <div class="col-md-12">
                                            <select name="member_group[]" class="form-control searchable_memgroup"
                                                multiple='multiple' style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                    <!-- นำไฟล์เข้า -->
                                    {{-- <div id="member_external_import" style="display: none;">
                                <div class="col-md-12">
                                    <select name="member_external_import[]" class="form-control searchable_member_external_import" id="searchable_member_external_import" multiple='multiple' style="width: 100%;">
                                    </select>
                                </div>
                            </div> --}}

                                    {{-- <div id="member_external_import" style="display: none;">
                        <form 
                            enctype="multipart/form-data">
                            @csrf
                            <label for="" class="btn btn-warning">
                                <input type="file" name="excel_file" id="" value="" accept="" required>
                            </label>
                            <div> --}}
                                </div>
                                <!-- Basic Form End-->
                            </div>
                            <div class="form-group-inner login-btn-inner">
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-7">
                                        <div class="login-horizental cancel-wp pull-left">
                                            <button class="btn btn-md btn-danger login-submit-cs submit-button"
                                                type="submit" name="Submit" id="Submit"
                                                value="Submit">เพิ่มข้อมูล</button>
                                            <button
                                                class="btn btn-md btn-danger login-submit-cs alternate-submit-button"
                                                type="button" name="AlternateSubmit" id="AlternateSubmit"
                                                value="AlternateSubmit"
                                                style="display: none;">เพิ่มข้อมูลไฟล์</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </form>
    </div>
</div>
<script></script>

<!-- Basic Form End -->
<!-- --------------------------- Excel Manager ---------------------------------------------------------------------------------------------------- -->

<div class="modal fade" id="fileUpload_excel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Filemanager</h4>
            </div>
            <div class="modal-body" style="padding:0px; margin:0px;">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item"
                        src="filemanager/dialog.php?type=2&field_id=file_upload_excel&relative_url=1&fldr=data&lang=th_TH&&akey={{ md5(Auth::guard('admin')->user()->password) }}"
                        frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll;"
                        allowfullscreen></iframe>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------- -->

@push('scripts')
    <script src="{{ asset('admin/librarys/quicksearch/jquery.quicksearch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/librarys/multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $("input[name='file_upload_excel']").css({
                display: 'none'
            })

            function check() {
                // if(document.form1.lm_ucf_category.value==''){alert('กรุณาเลือกหมวด ! ');return false;}
                if (document.form1.QTitle.value == '') {
                    alert('กรุณากรอกหัวข้อเรื่อง ! ');
                    return false;
                }
                // if(document.form1.QNote.value == ''){alert('กรุณากรอกเนื้อหา ! ');return false;}
                if (document.form1.QName.value == '') {
                    alert('กรุณากรอกชื่อ ! ');
                    return false;
                }

            }

            // $('.radioSearch').change(function() {
            //     // checkbox membership_no
            //     if (this.value == 'search_memno') {

            //         ShowBox();

            //         $('select[name="dual_select[]"]').empty();
            //         var memno = $.parseJSON('<?php echo $search_memno; ?>');

            //         var optionMem = '';

            //         $.each(memno, function(i, val) {
            //             optionMem += `<option value="${val.membership_no}">${val
        //                                 .membership_no} ${val.member_name}</option>`;
            //         });

            //         $('select[name="dual_select[]"]').append(optionMem);
            //         $('select[name="dual_select[]"]').bootstrapDualListbox('refresh', true);

            //     }

            //     // checkbox member_group_no
            //     if (this.value == 'search_group') {

            //         ShowBox();

            //         $('select[name="dual_select[]"]').empty();
            //         var memgroup = $.parseJSON('<?php echo $search_group; ?>');

            //         var optionMem = '';

            //         $.each(memgroup, function(i, val) {
            //             optionMem += '<option value="' + val.MEMBER_GROUP_NO + '">' + val
            //                 .MEMBER_GROUP_NAME + '</option>';
            //         });

            //         $('select[name="dual_select[]"]').append(optionMem);
            //         $('select[name="dual_select[]"]').bootstrapDualListbox('refresh', true);

            //     }

            //     // checkbox mem All
            //     if (this.value == 'search_all') {
            //         HideBox();
            //     }

            // });


            $('.searchable').multiSelect({
                selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='ค้นหา'>",
                selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='ค้นหา'>",
                afterInit: function(ms) {
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e) {
                            var val = $(that.qs1).val();

                            var name = $('.searchable').prop('name');

                            // $('.searchable').multiSelect('addOption', { value: 'Hellfsdfo' , text: 'hfsdfe'});
                            // $('.searchable').multiSelect('addOption', { value: 'fdsf' , text: 'fsdaf'});
                            // $('.searchable').multiSelect('addOption', { value: 'fsdfsd' , text: 'aas'});
                            let URL = '{{ url('mobile_send_message/retreive') }}'
                            if (val != "" && val.length > 2) {
                                $.ajax({
                                        url: URL,
                                        type: 'POST',
                                        // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
                                        data: {
                                            action: name,
                                            search: val
                                        },
                                    })
                                    .done(function() {
                                        console.log("success");
                                    })
                                    .fail(function() {
                                        console.log("error");
                                    })
                                    .always(function(data) {

                                        for (var key in data.res) {

                                            if (data.res.hasOwnProperty(key)) {
                                                var obj = data.res[key];
                                                $('.searchable').multiSelect('addOption', {
                                                    value: obj.MEMBERSHIP_NO,
                                                    text: obj.TEXT
                                                });
                                            }
                                        }
                                        that.qs1.cache();
                                    });
                            }
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function() {
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function() {
                    this.qs1.cache();
                    this.qs2.cache();
                }
            });




            // ----------------------------------------------Search ตามหน่วยงาน---------------------------------------------------------------------------------
            $('.searchable_memgroup').multiSelect({
                selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='ค้นหา'>",
                selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='ค้นหา'>",
                afterInit: function(ms) {
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selection.ms-selected',
                        selectableString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selectable:not(.ms-selected)';
                    // console.log(that);
                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e) {
                            var val = $(that.qs1).val();
                            var name = $('.searchable_memgroup').prop('name');
                            let URL = '{{ url('mobile_send_message/retreive') }}'
                            // if (val != "" && val.length > 0) {
                            $.ajax({
                                    url: URL,
                                    type: 'POST',
                                    // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
                                    data: {
                                        action: name,
                                        search: val
                                    },
                                })
                                .done(function() {
                                    console.log("success");
                                })
                                .fail(function() {
                                    console.log("error");
                                })
                                .always(function(data) {
                                    // var data = $.parseJSON(data);

                                    for (var key in data.res) {

                                        if (data.res.hasOwnProperty(key)) {
                                            var obj = data.res[key];
                                            //   console.log(obj);
                                            $('.searchable_memgroup').multiSelect('addOption', {
                                                value: obj.MEMBER_GROUP_NO,
                                                text: obj.TEXT
                                            });
                                        }
                                    }
                                    that.qs1.cache();
                                });
                            // }
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function() {
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function() {
                    this.qs1.cache();
                    this.qs2.cache();
                }
            });



            //
            // ----------------------------------------Search ตามการนำไฟล์เข้า--------------------------------------------------------------------------------------------------

            // $('#searchable_member_external_import').multiSelect({
            // 	selectableHeader: "<input type='text' class=' search-input text-white btn btn-md btn-success rounded External_place' autocomplete='off' placeholder='ตกลง'>",
            // 	selectableFooter: "<a href='javascript:$(`#searchable_member_external_import`).multiSelect(`select_all`);' class=' search-input btn btn-success rounded btn-block' id='select-all'>เลือกทั้งหมด</a>",
            // 	selectionFooter:"<a href='javascript:$(`#searchable_member_external_import`).multiSelect(`deselect_all`);' class=' search-input btn btn-warning rounded btn-block' id='deselect-all'>ไม่เลือกทั้งหมด</a>",
            // 	selectionHeader: "<input type='text' class='form-control search-input External_place' autocomplete='off' placeholder='ค้นหา'>",
            // afterInit: function(ms){
            // 	var that = this,
            // 		$selectableSearch = that.$selectableUl.prev(),
            // 		$selectionSearch = that.$selectionUl.prev(),
            // 		$selectableall = that.$selectableContainer.prev(),
            // 		$selectionall = that.$selectionUl.prev(),
            // 		selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
            // 		selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected',
            // 		selectableallString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)'
            // 		;

            // 		// console.log(that.$selectableUl.prev());
            // 	that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
            // 	// that.qs1 = $('#prepend-big-btn')
            // 	.on('click', function(e){
            // console.log("HOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO");
            // var val = $('#prepend-big-btn-excel').val();
            // var name = $('#searchable_member_external_import').prop('name');
            // let data = {action: name ,search: val }
            // console.log(data);

            // let URL = '{{ url('mobile_send_message/retreive') }}'
            // // if (val != "" && val.length > 0) {
            // 	$.ajax({
            // 		// url: 'mobile_send_message/retreive',
            //         url: URL,
            // 		type: 'POST',
            // 		// dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
            // 		data: {action: name ,search: val },
            // 	})
            // 	.done(function() {
            // 		console.log("success");
            // 	})
            // 	.fail(function() {
            // 		console.log("error");
            // 	})
            // 	.always(function(data) {
            // 		// var data = $.parseJSON(data);
            // 		for (var key in data.res) {
            // 			if (data.res.hasOwnProperty(key)) {
            // 				var obj = data.res[key];
            // 				// console.log(obj);
            // 				// $('.searchable_member_external_import').multiSelect('refresh');
            // 		    	$('#searchable_member_external_import').multiSelect('addOption', { value: obj.MEMBERSHIP_NO , text: obj.TEXT });
            // 			}
            // 		}
            // 	 	that.qs1.cache();
            // 	});
            // 	if (e.which)
            // 	{
            // 		that.$selectableUl.focus();
            // 		return false;
            // 	}
            // 	});


            // 	// that.qs3 = selectableallString.quicksearch(selectableall).
            // 	// on('click',function(e)
            // 	// {
            // 	// 	$('.searchable_member_external_import').multiSelect('select_all');
            // 	// })

            // 		that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
            // 		.on('keydown', function(e){
            // 		if (e.which){
            // 			that.$selectionUl.focus();
            // 			return false;
            // 		}
            // 		});
            // 	},
            // 	afterSelect: function(){
            // 		this.qs1.cache();
            // 		this.qs2.cache();
            // 	},
            // 	afterDeselect: function(){
            // 		this.qs1.cache();
            // 		this.qs2.cache();
            // 	}
            // 	});

            // // $('#button_select_all').on('click',function(e)
            // // {
            // // 	alert('กำลังอยู่ระหว่างการพัฒนา');
            // // 	$('.searchable_member_external_import').multiSelect('select_all');
            // // });


            // 	$('#button_clear').on('click',function(event){
            // 		event.preventDefault();
            // 		$('#searchable_member_external_import').empty();
            // 		$('#searchable_member_external_import').multiSelect('refresh');
            // 		$('.searchable').empty();
            // 		$('.searchable').multiSelect('refresh');
            // 		$('.searchable_memgroup').empty();
            // 		$('.searchable_memgroup').multiSelect('refresh');
            // 	return false;
            // 	});
            // -----------------------------------------------------------------------------------------------------------------------------
            // $('.table')
            $('.demo-radio-button').on('change', '#radioMemGroup', function(event) {
                var id = $(this).attr('value');
                var el = $(this);
                // console.log(id,el)
                event.preventDefault();
                if (id == "membership") {
                    $('.searchable_memgroup').multiSelect('deselect_all');
                    $('.searchable_memgroup').multiSelect('refresh');

                    $('.searchable').multiSelect('deselect_all');
                    $('.searchable').multiSelect('refresh');

                    $('.searchable_member_external_import').multiSelect('deselect_all');
                    $('.searchable_member_external_import').multiSelect('refresh');

                    $('#membership').css({
                        display: 'block'
                    });
                    $('#member_group').css({
                        display: 'none'
                    });
                    $('#member_external_import').css({
                        display: 'none'
                    });

                } else if (id == "member_group") {
                    // console.log('hello member_group')
                    $('.searchable').multiSelect('deselect_all');
                    $('.searchable').multiSelect('refresh');

                    $('.searchable_member_external_import').multiSelect('deselect_all');
                    $('.searchable_member_external_import').multiSelect('refresh');

                    $('.searchable_memgroup').multiSelect('deselect_all');
                    $('.searchable_memgroup').multiSelect('refresh');

                    $('#membership').css({
                        display: 'none'
                    });
                    $('#member_group').css({
                        display: 'block'
                    });
                    $('#member_external_import').css({
                        display: 'none'
                    });
                } else if (id == "member_external_import") {
                    // console.log('hello member_external_import')
                    $('.searchable_memgroup').multiSelect('deselect_all');
                    $('.searchable_memgroup').multiSelect('refresh');

                    $('.searchable').multiSelect('deselect_all');
                    $('.searchable').multiSelect('refresh');

                    $('.searchable_member_external_import').multiSelect('deselect_all');
                    $('.searchable_member_external_import').multiSelect('refresh');

                    // document.getElementById("file_upload").style.display = "block";
                    // $('#file_upload').css({
                    // 	display: 'block'
                    // })

                    $("input[name='file_upload_excel']").css({
                        display: 'block'
                    })
                    $('#membership').css({
                        display: 'none'
                    });
                    $('#member_group').css({
                        display: 'none'
                    });
                    $('#member_external_import').css({
                        display: 'block'
                    });
                } else if (id == "search_all") {
                    $('.searchable_memgroup').multiSelect('deselect_all');
                    $('.searchable_memgroup').multiSelect('refresh');

                    $('.searchable').multiSelect('deselect_all');
                    $('.searchable').multiSelect('refresh');

                    $('.searchable_member_external_import').multiSelect('deselect_all');
                    $('.searchable_member_external_import').multiSelect('refresh');

                    // document.getElementById("file_upload").style.display = "block";
                    // $('#file_upload').css({
                    // 	display: 'block'
                    // })

                    $("input[name='file_upload_excel']").css({
                        display: 'none'
                    })
                    $('#membership').css({
                        display: 'none'
                    });
                    $('#member_group').css({
                        display: 'none'
                    });
                    $('#member_external_import').css({
                        display: 'none'
                    });
                }
            });

        });
    </script>
@endpush
