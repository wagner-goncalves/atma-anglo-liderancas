<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}" translate="no">

<head>
    @include('layouts.head')
</head>

<body class="bg-banner">
    <div id="app" style="background-color: white">

        @include('layouts.menu')

        <main class="">
            @yield('content')
        </main>

        @include('layouts.footer')

    </div>

</body>

</html>
