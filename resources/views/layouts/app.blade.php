{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Helionet')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Core CSS framework + Helionet theme --}}
    <link rel="stylesheet" href="{{ asset('css/forge-bootstrap.css') }}">

    {{-- Plugin / page-specific styles --}}
    @stack('styles')
</head>
<body class="forge-body d-flex flex-column min-vh-100">

    <div id="app" class="d-flex flex-column min-vh-100">

        {{-- Top bar --}}
        @include('layouts.partials.topbar')

        <div class="flex-grow-1 d-flex">

            {{-- Sidebar --}}
            @include('layouts.partials.sidebar')

            {{-- Main content area --}}
            <main class="flex-grow-1 d-flex flex-column">
                {{-- Optional page header section --}}
                @hasSection('page-header')
                    <header class="forge-page-header border-bottom px-3 py-2">
                        @yield('page-header')
                    </header>
                @endif

                {{-- Flash / system messages --}}
                @includeWhen(session('status'), 'layouts.partials.flash')

                {{-- Primary page content --}}
                <div class="forge-page-content p-3 flex-grow-1">
                    @yield('content')
                </div>
            </main>
        </div>

        {{-- Footer --}}
        @include('layouts.partials.footer')
    </div>

    {{-- Core JS (Bootstrap bundle, app scripts, etc.) --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Plugin / page-specific scripts --}}
    @stack('scripts')
</body>
</html>
