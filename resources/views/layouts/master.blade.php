<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | GreenHouse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    
<meta name='theme-color' content='#ffffff'/>

</head>

<body data-layout="detached" data-topbar="dark">
    <!-- Begin page -->
    <div class="container-fluid">
        <div id="layout-wrapper">
            @include('layouts.topbar')
            @include('layouts.sidebar')
            <div class="main-content">
                <div class="page-content">
                    @yield('content')
                </div>
                @include('layouts.footer')
            </div>

        </div>
    </div>

    @include('layouts.right-sidebar')
    @include('layouts.vendor-scripts')
    @if (\Session::has('success'))
        <script>
            Swal.fire(
                '',
                '{{ \Session::get('success') }}',
                'success'
            )
        </script>
    @endif
    @if (\Session::has('info'))
        <script>
            Swal.fire(
                '',
                '{{ \Session::get('info') }}',
                'info'
            )
        </script>
    @endif
    @if (\Session::has('error'))
        <script>
            Swal.fire(
                'Gabim!',
                '{{ \Session::get('error') }}',
                'info'
            )
        </script>
    @endif
    <script src="https://iot.future.al/sw.js"></script>
    @env('local')
    <!-- Local environment assets -->
   

@endenv

@env('production')
    <!-- Production environment assets -->
    <script src="https://iot.future.al/sw.js"></script>
@endenv


</script>

<script>

if (!navigator.serviceWorker.controller) {

navigator.serviceWorker.register('/sw.js').

then(function (reg) {

console.log('Service worker has been registered for scope: ' + reg.scope);

});

}

</script>
</body>

</html>
