<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Helionet')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Core CSS --}}
    <link rel="stylesheet" href="{{ asset('css/forge-bootstrap.css') }}">

    {{-- Page / plugin style stack --}}
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100 forge-body">

    <div class="d-flex flex-column min-vh-100">

        {{-- =======================
            TOP BAR
        ======================== --}}
        <header class="forge-topbar d-flex align-items-center px-3 py-2 border-bottom">
            <div class="flex-grow-1 d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-light">☰</button>
                <span class="h5 mb-0">Helionet</span>
            </div>

            <div>
                <span class="text-muted small">
                    {{ auth()->user()->name ?? 'User' }}
                </span>
            </div>
        </header>

        <div class="flex-grow-1 d-flex">

            {{-- =======================
                SIDEBAR
            ======================== --}}
            <aside class="forge-sidebar border-end p-3" style="width: 240px;">
                <nav class="nav flex-column">
                    <a class="nav-link" href="#">Dashboard</a>
                    <a class="nav-link" href="#">Markets</a>
                    <a class="nav-link" href="#">Intel</a>
                    <a class="nav-link" href="#">Settings</a>
                </nav>
            </aside>

            {{-- =======================
                MAIN CONTENT
            ======================== --}}
            <main class="flex-grow-1 d-flex flex-column">

                {{-- Page header (optional) --}}
                @hasSection('page-header')
                    <div class="forge-page-header px-3 py-2 border-bottom">
                        @yield('page-header')
                    </div>
                @endif

                {{-- Flash messages --}}
                @if(session('status'))
                    <div class="alert alert-info m-3">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Page content --}}
                <div class="forge-page-content p-3 flex-grow-1">
                    @yield('content')
                </div>
            </main>
        </div>

        {{-- =======================
            FOOTER
        ======================== --}}
        <footer class="forge-footer text-center py-2 border-top small text-muted">
            Helionet © {{ date('Y') }}
        </footer>

    </div>

    {{-- Core JS --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Page / plugin script stack --}}
    @stack('scripts')

</body>
</html>
