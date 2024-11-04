<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="/" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name') }}</title> --}}
    <title>สหกรณ์ออมทรัพย์ครูชุมพร จำกัด</title>

    {{-- Icon --}}
    <link rel="icon" href="{{ asset('info/assets/index/logo2.png') }}" type="image/x-icon" sizes="32x32">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" />

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
    </script>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300&display=swap" rel="stylesheet">--}}
    <style>
        body{
            font-family: 'THSarabunNew', sans-serif !important;
        }
    </style>
</head>

<body itemscope>
    <main id="app"></main>

    <!-- Scripts -->
    <script src="{{ mix('/js/app.js') }}"></script>

</body>

</html>
