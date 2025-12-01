<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Helionet')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Core CSS framework + Helionet theme --}}
    <link rel="stylesheet" href="{{ asset('css/forge-boostrap.css') }}">
    {{-- Plugin / page-specific styles --}}
    @stack('styles')
</head>
<body class="hl-body">

    <div class="hl-app-shell">
        {{-- Top bar --}}
        @include('layouts.partials.topbar')

        <div class="hl-app-main">
            {{-- Sidebar --}}
            @include('layouts.partials.sidebar')

            {{-- Main content area --}}
            <main class="hl-app-content">
                {{-- Optional page header section --}}
                @hasSection('page-header')
                    <header class="hl-page-header">
                        @yield('page-header')
                    </header>
                @endif

                {{-- Flash / system messages --}}
                @includeWhen(session('status'), 'layouts.partials.flash')

                {{-- Primary page content --}}
                @yield('content')
            </main>
        </div>

        {{-- Footer --}}
        @include('layouts.partials.footer')
    </div>

    {{-- Core JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- Plugin / page-specific scripts --}}
    @stack('scripts')
</body>
</html>
