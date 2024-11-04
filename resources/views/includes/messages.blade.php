@if (count($errors) > 0)
  @foreach ($errors->all() as $error)

    <link rel="stylesheet" href="{{ asset('admin/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/notifications.css') }}">

    <script src="{{ asset('admin/js/Lobibox.js') }}"></script>
            <script type="text/javascript">
                Lobibox.notify("error", {
                    msg: "{{ $error }}"
                });
        </script>
  @endforeach
@endif

@if (session()->has('message'))

    <link rel="stylesheet" href="{{ asset('admin/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/notifications.css') }}">

	<script src="{{ asset('admin/js/Lobibox.js') }}"></script>
            <script type="text/javascript">
                Lobibox.notify("success", {
                    msg: "{{ session('message') }}"
                });
        </script>
@endif


@if (session()->has('danger'))

    <link rel="stylesheet" href="{{ asset('admin/css/Lobibox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/notifications.css') }}">

	<script src="{{ asset('admin/js/Lobibox.js') }}"></script>
            <script type="text/javascript">
                Lobibox.notify("error", {
                    msg: "{{ session('danger') }}"
                });
        </script>
@endif

