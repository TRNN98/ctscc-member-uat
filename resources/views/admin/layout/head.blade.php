<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>admin</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- favicon
		============================================ -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/images/soat.png') }}">
<!-- Google Fonts
		============================================ -->
{{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i,800" rel="stylesheet"> --}}
<!-- Bootstrap CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
<!-- Bootstrap CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/font-awesome.min.css') }}">
<!-- adminpro icon CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/adminpro-custon-icon.css') }}">
<!-- meanmenu icon CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/meanmenu.min.css') }}">
<!-- mCustomScrollbar CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/jquery.mCustomScrollbar.min.css') }}">
<!-- animate CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/animate.css') }}">
<!-- jvectormap CSS
    ============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/jvectormap/jquery-jvectormap-2.0.3.css') }}">
<!-- data-table CSS
        ============================================ -->
<link href="{{ asset('admin/dist/data-table/extensions/x-editable/bootstrap-editable.css') }}" rel="stylesheet">
<link href="{{ asset('admin/dist/data-table/extensions/resizableColumns/jquery.resizableColumns.css') }}"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('admin/dist/data-table/bootstrap-table.min.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('admin/css/data-table/bootstrap-editable.css') }}"> --}}
<link rel="stylesheet"
    href="{{ asset('admin/dist/data-table/extensions/reorder-rows/bootstrap-table-reorder-rows.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/DataTables/datatables.min.css') }}" />

<!-- normalize CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/normalize.css') }}">
<!-- modals CSS
        ============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/modals.css') }}">
<!-- charts C3 CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/c3.min.css') }}">
<!-- forms CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/form/all-type-forms.css') }}">
<!-- notifications CSS
        ============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/Lobibox.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/notifications.css') }}">
<!-- style CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
<!-- responsive CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/responsive.css') }}">
<!-- form CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/form.css') }}">

<link rel="stylesheet" href="{{ asset('admin/css/dropzone.css') }}">
<!-- imageupload
      ============================================= -->
<link rel="stylesheet" href="{{ asset('admin/css/image-uploader.min.css') }}">

{{-- <!-- tinymce JS
        ============================================ -->
<script src="{{ asset('admin/js/tinymce/tinymce.min.js') }}"></script> --}}

<!-- datapicker CSS
		============================================ -->
<link rel="stylesheet" href="{{ asset('admin/css/datapicker/datepicker3.css') }}">

<!-- font
      ========================================== -->
<link href="{{ asset('info/html/frontend/font/style.css') }}" rel="stylesheet" type="text/css" />


{{-- <script src="{{ asset('admin/js/vendor/jquery-1.11.3.min.js') }}"></script> --}}

{{-- <script>
    //--setup ajax--//
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script> --}}

<!-- modernizr JS
		============================================ -->
<script src="{{ asset('admin/js/vendor/modernizr-2.8.3.min.js') }}"></script>

<style>
    body {
        font-family: 'THSarabunNew', sans-serif;
        font-weight: bold;
    }

    .logoset {
        position: absolute;
        right: 18px;
        top: 10px;
        color: red;
        font-size: 16px;
        cursor: pointer;
    }
</style>

@yield('styles')
