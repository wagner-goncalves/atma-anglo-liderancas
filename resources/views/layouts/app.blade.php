<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}" translate="no">

<head>
    @include('layouts.head')
</head>

<body class="bg-banner">
    <div id="app" style="background-color: white">

        @include('layouts.menu')

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>

        @include('layouts.footer')

    </div>
</body>

</html>
