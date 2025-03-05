<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{!! config('master.app.profile.description') !!}">
    <meta name="author" content="{!! config('master.app.profile.author') !!}">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <title>@stack('title',config('master.app.profile.name'))</title>
    <link rel="icon" href="{{ url(config('master.app.profile.template').config('master.app.profile.favicon'))}}">
    <link rel="stylesheet" href="{{ url(config('master.app.web.template').'/assets/vendor_components/bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url(config('master.app.web.template').'/css-lama/custom.css') }}">
</head>
<body class="hold-transition theme-primary bg-img" style="background-image: url({{ url(config('master.app.web.template').config('master.app.web.background'))}})">
@yield('content')
<script src="{{ url(config('master.app.web.template').'/js/vendors.min.js') }}"></script>
<script src="{{ url('js/auth.js?time='.time()) }}" type="application/javascript"></script>
@stack('scripts')
</body>
</html>
