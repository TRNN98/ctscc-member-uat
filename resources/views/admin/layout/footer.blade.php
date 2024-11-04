<!-- Footer Start-->
<!-- <br>
  <br>
  <br> -->
<div id="footer" class="footer-copyright-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-copy-right">
                    <p>Copyright © 2020 All Right Reserved SSCBD@SO-AT Solution.co.,ltd.@2020 ENhance Security for Web
                        Application Systems.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End-->


<!-- jquery
		============================================ -->
<script src="{{ asset('admin/js/vendor/jquery-1.11.3.min.js') }}"></script>

<script>
    //--setup ajax--//
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<!-- bootstrap JS
		============================================ -->
<script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
<!-- meanmenu JS
		============================================ -->
<script src="{{ asset('admin/js/jquery.meanmenu.js') }}"></script>
<!-- mCustomScrollbar JS
		============================================ -->
<script src="{{ asset('admin/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<!-- sticky JS
		============================================ -->
<script src="{{ asset('admin/js/jquery.sticky.js') }}"></script>
<!-- scrollUp JS
		============================================ -->
<script src="{{ asset('admin/js/jquery.scrollUp.min.js') }}"></script>
<!-- scrollUp JS
        ============================================ -->
<script src="{{ asset('admin/js/wow/wow.min.js') }}"></script>
<!-- modal JS
        ============================================ -->
<script src="{{ asset('admin/js/modal-active.js') }}"></script>
<!-- form validate JS
		============================================ -->
<script src="{{ asset('admin/js/jquery.form.min.js') }}"></script>
<script src="{{ asset('admin/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/js/form-active.js') }}"></script>
<!-- counterup JS
        ============================================ -->
<script src="{{ asset('admin/js/counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('admin/js/counterup/waypoints.min.js') }}"></script>
<script src="{{ asset('admin/js/counterup/counterup-active.js') }}"></script>
<!-- peity JS
        ============================================ -->
<script src="{{ asset('admin/js/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('admin/js/peity/peity-active.js') }}"></script>
<!-- sparkline JS
        ============================================ -->
<script src="{{ asset('admin/js/sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('admin/js/sparkline/sparkline-active.js') }}"></script>
{{-- <!-- c3 JS
        ============================================ -->
<script src="{{ asset('admin/js/c3-charts/d3.min.js') }}"></script>
<script src="{{ asset('admin/js/c3-charts/c3.min.js') }}"></script> --}}

<!-- imageupload
      ============================================= -->
<script src="{{ asset('admin/js/image-uploader.min.js') }}"></script>

<!--  dropzone JS
        ============================================ -->
<script src="{{ asset('admin/js/dropzone.js') }}"></script>

<!-- data table JS
        ============================================ -->
{{-- <script src="{{ asset('admin/js/data-table/tableExport.js') }}"></script>
<script src="{{ asset('admin/js/data-table/data-table-active.js') }}"></script>
<script src="{{ asset('admin/js/data-table/bootstrap-editable.js') }}"></script>
<script src="{{ asset('admin/js/data-table/bootstrap-table-resizable.js') }}"></script>
<script src="{{ asset('admin/js/data-table/colResizable-1.5.source.js') }}"></script>
<script src="{{ asset('admin/js/data-table/bootstrap-table-export.js') }}"></script> --}}

<script src="{{ asset('admin/dist/data-table/bootstrap-table.min.js') }}"></script>

<script src="{{ asset('admin/js/jquery.tablednd.min.js') }}"></script>
<script src="{{ asset('admin/js/data-table/tableExport.js') }}"></script>
{{-- <script src="{{ asset('admin/js/data-table/data-table-active.js') }}"></script> --}}
{{-- <script src="{{ asset('admin/js/data-table/colResizable-1.5.source.js') }}"></script> --}}
<script src="{{ asset('admin/dist/data-table/extensions/resizableColumns/jquery.resizableColumns.min.js') }}"></script>
<script src="{{ asset('admin/dist/data-table/extensions/x-editable/bootstrap-editable.min.js') }}"></script>

{{-- <script src="{{ asset('admin/js/data-table/bootstrap-table-editable.js') }}"></script> --}}
<script src="{{ asset('admin/dist/data-table/extensions/editable/bootstrap-table-editable.min.js') }}"></script>
<script src="{{ asset('admin/dist/data-table/extensions/reorder-rows/bootstrap-table-reorder-rows.min.js') }}"></script>
<script src="{{ asset('admin/dist/data-table/extensions/resizable/bootstrap-table-resizable.min.js') }}"></script>
<script src="{{ asset('admin/dist/data-table/extensions/export/bootstrap-table-export.min.js') }}"></script>
<script src="{{ asset('admin/dist/data-table/extensions/cookie/bootstrap-table-cookie.min.js') }}"></script>
<script src="{{ asset('admin/dist/data-table/extensions/auto-refresh/bootstrap-table-auto-refresh.min.js') }}"></script>
<script src="{{ asset('admin/dist/data-table/locale/bootstrap-table-th-TH.min.js') }}"></script>

<!-- datapicker JS
    ============================================ -->
<script src="{{ asset('admin/js/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('admin/js/datapicker/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('admin/js/datapicker/bootstrap-datepicker.th.min.js') }}"></script>
<script src="{{ asset('admin/js/datapicker/datepicker-active.js') }}"></script>

<!-- input-mask JS
    ============================================ -->
<script src="{{ asset('admin/js/input-mask/jasny-bootstrap.min.js') }}"></script>

<!-- notification
        ============================================ -->
<script src="{{ asset('admin/js/Lobibox.js') }}"></script>
{{-- <script type="text/javascript">
    Lobibox.notify("success", {
                    msg: "Lorem ipsum dolor sit amet against apennine any created, spend loveliest, building stripes."
                });
</script> --}}
@include('includes.messages')

<!-- duallistbox JS
    ============================================ -->
    <script src="{{ asset('admin/js/duallistbox/jquery.bootstrap-duallistbox.js') }}"></script>
    <script src="{{ asset('admin/js/duallistbox/duallistbox.active.js') }}"></script>

<!-- main JS
        ============================================ -->
<script src="{{ asset('admin/js/main.js') }}"></script>

{{-- @yield('scripts') --}}
@stack('scripts')
