<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    <meta name='theme-color' content='#6777ef'/>

<!-- <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
<link rel="manifest" href="{{ asset('/manifest.json') }}"> -->
@env('local')
    <!-- Local environment assets -->
    <!-- Uncomment these if you need to load them in the local environment -->
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
@endenv

@env('production')
    <!-- Production environment assets -->
    <link rel='apple-touch-icon' href='https://iot.future.al/logo.png'>
    <link rel='manifest' href='https://iot.future.al/manifest.json'>
@endenv

    @include('layouts.head-css')
</head>

<body>

    @yield('content')

    @include('layouts.vendor-scripts')
</body>

</html>
