<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Helios Server Management Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >

    <!-- Google Charts -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <style>
        /* ----------------------------------------------------
           Homebrew "Adminator-like" shell
           - Dark left sidebar
           - Light content area
           - Card-based dashboard
        ----------------------------------------------------- */

        :root {
            --helios-sidebar-width: 260px;
            --helios-primary: #2563eb;
            --helios-primary-soft: #dbeafe;
            --helios-bg: #f3f4f6;
            --helios-text-main: #111827;
            --helios-text-muted: #6b7280;
        }

        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Inter", sans-serif;
            background: var(--helios-bg);
            color: var(--helios-text-main);
        }

        /* Layout wrapper */
        .helios-shell {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .helios-sidebar {
            width: var(--helios-sidebar-width);
            background: linear-gradient(180deg, #020617 0%, #111827 100%);
            color: #e5e7eb;
            display: flex;
            flex-direction: column;
            padding: 18px 16px;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .helios-sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
            padding: 0 4px;
        }

        .helios-sidebar-glyph {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: radial-gradient(circle at 30% 30%, #38bdf8, #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            color: #f9fafb;
        }

        .helios-sidebar-title {
            font-weight: 600;
            font-size: 18px;
        }

        .helios-sidebar-subtitle {
            font-size: 11px;
            color: #9ca3af;
        }

        .helios-nav-section-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6b7280;
            margin: 8px 0 4px 6px;
        }

        .helios-sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .helios-sidebar-nav li {
            margin-bottom: 4px;
        }

        .helios-sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 10px;
            color: #e5e7eb;
            font-size: 14px;
            text-decoration: none;
        }

        .helios-sidebar-link span.icon {
            width: 22px;
            text-align: center;
            font-size: 14px;
            opacity: 0.9;
        }

        .helios-sidebar-link:hover {
            background: rgba(148, 163, 184, 0.18);
            color: #f9fafb;
        }

        .helios-sidebar-link.active {
            background: rgba(37, 99, 235, 0.25);
            color: #eff6ff;
        }

        .helios-sidebar-footer {
            margin-top: auto;
            font-size: 11px;
            color: #6b7280;
            padding: 8px 4px 0 4px;
            border-top: 1px solid rgba(55, 65, 81, 0.7);
        }

        /* Main area */
        .helios-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* Top bar */
        .helios-topbar {
            padding: 14px 24px 10px 24px;
            border-bottom: 1px solid #e5e7eb;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .helios-topbar-title {
            font-size: 18px;
            font-weight: 600;
        }

        .helios-topbar-subtitle {
            font-size: 12px;
            color: var(--helios-text-muted);
        }

        .helios-search-wrapper {
            max-width: 320px;
            flex: 1;
            margin: 0 24px;
            position: relative;
        }

        .helios-search {
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            padding-left: 36px;
            font-size: 13px;
        }

        .helios-search:focus {
            box-shadow: 0 0 0 1px var(--helios-primary);
            border-color: var(--helios-primary);
        }

        .helios-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            color: #9ca3af;
        }

        .helios-user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .helios-user-info {
            text-align: right;
        }

        .helios-user-name {
            font-size: 13px;
            font-weight: 500;
        }

        .helios-user-role {
            font-size: 11px;
            color: var(--helios-text-muted);
        }

        .helios-user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ecfdf5;
            font-size: 14px;
            font-weight: 600;
        }

        /* Content body */
        .helios-content {
            padding: 20px 24px 28px 24px;
            background: var(--helios-bg);
            flex: 1;
            overflow-y: auto;
        }

        /* Cards */
        .card {
            border-radius: 18px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.08);
        }

        .card-header {
            background: transparent;
            border-bottom: none;
            padding: 16px 18px 4px 18px;
        }

        .card-header-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--helios-text-main);
        }

        .card-header-subtitle {
            font-size: 12px;
            color: var(--helios-text-muted);
        }

        .card-body {
            padding: 14px 18px 18px 18px;
        }

        .helios-chip {
            border-radius: 999px;
            padding: 2px 9px;
            font-size: 11px;
            font-weight: 500;
            background: var(--helios-primary-soft);
            color: var(--helios-primary);
        }

        /* Stats boxes */
        .helios-stat-box {
            background: #f9fafb;
            border-radius: 14px;
            padding: 8px 6px;
        }

        .helios-stat-label {
            font-size: 11px;
            color: var(--helios-text-muted);
        }

        .helios-stat-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--helios-text-main);
        }

        .maintenance-active {
            color: #f59e0b;
            font-weight: 600;
        }

        .maintenance-inactive {
            color: #22c55e;
            font-weight: 600;
        }

        .form-text {
            font-size: 11px;
        }

        /* Log tables */
        .log-table-wrapper {
            max-height: 240px;
            overflow-y: auto;
            border-radius: 14px;
        }

        table.table {
            font-size: 12px;
            margin-bottom: 0;
        }

        .table thead {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--helios-text-muted);
            background: #f3f4f6;
        }

        .table tbody tr td {
            border-color: #e5e7eb;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background: #eff6ff;
        }

        /* Sticky headers in scrollable log tables */
        .log-table-wrapper table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #f3f4f6;
            box-shadow: 0 1px 0 rgba(209, 213, 219, 0.9);
        }

        /* Badges for levels */
        .badge {
            border-radius: 999px;
            font-size: 10px;
            padding: 3px 8px;
            font-weight: 500;
        }

        .badge-level-info {
            background-color: #38bdf8;
            color: #0f172a;
        }

        .badge-level-warning {
            background-color: #facc15;
            color: #111827;
        }

        .badge-level-error {
            background-color: #f97373;
            color: #111827;
        }

        /* Chart container */
        #requestsChart {
            width: 100%;
            height: 320px;
        }

        /* Links */
        a {
            color: var(--helios-primary);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        dl.row dt {
            font-size: 12px;
            color: var(--helios-text-muted);
        }

        dl.row dd {
            font-size: 13px;
        }

        /* Small scrollbars for log areas */
        .log-table-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .log-table-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        .log-table-wrapper::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 999px;
        }

        /* Responsive tweak – collapse sidebar on very small widths */
        @media (max-width: 768px) {
            .helios-shell {
                flex-direction: column;
            }
            .helios-sidebar {
                width: 100%;
                height: auto;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                padding: 10px 16px;
            }
            .helios-main {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="helios-shell">
    <!-- Sidebar -->
    <aside class="helios-sidebar">
        <div>
            <div class="helios-sidebar-brand">
                <div class="helios-sidebar-glyph">H</div>
                <div>
                    <div class="helios-sidebar-title">Helios</div>
                    <div class="helios-sidebar-subtitle">Server Portal</div>
                </div>
            </div>

            <div class="helios-nav-section-label">Overview</div>
            <ul class="helios-sidebar-nav mb-3">
                <li>
                    <a href="#" class="helios-sidebar-link active">
                        <span class="icon">🏠</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="helios-sidebar-link">
                        <span class="icon">🖥️</span>
                        <span>Servers</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="helios-sidebar-link">
                        <span class="icon">📜</span>
                        <span>Logs</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="helios-sidebar-link">
                        <span class="icon">⚙️</span>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="helios-sidebar-footer">
            <div>Helios Platform</div>
            <div>v0.1 · Admin shell</div>
        </div>
    </aside>

    <!-- Main area -->
    <div class="helios-main">
        <!-- Top bar -->
        <header class="helios-topbar">
            <div>
                <div class="helios-topbar-title">Server Management</div>
                <div class="helios-topbar-subtitle">
                    Monitor Laravel & Apache health for this Helios instance.
                </div>
            </div>

            <div class="helios-search-wrapper d-none d-md-block">
                <span class="helios-search-icon">🔍</span>
                <input
                    type="text"
                    class="form-control helios-search"
                    placeholder="Search servers, logs, actions..."
                >
            </div>

            <div class="helios-user-chip">
                <div class="helios-user-info d-none d-sm-block">
                    <div class="helios-user-name">Admin</div>
                    <div class="helios-user-role">Helios Operator</div>
                </div>
                <div class="helios-user-avatar">A</div>
            </div>
        </header>

        <!-- Content -->
        <main class="helios-content">
            <div class="container-fluid">
                <!-- Top row -->
                <div class="row g-3 mb-3">
                    <!-- System information -->
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="card-header-title">System Information</div>
                                    <div class="card-header-subtitle">Host and platform details</div>
                                </div>
                                <span class="helios-chip">Host</span>
                            </div>
                            <div class="card-body">
                                <dl class="row mb-3">
                                    <dt class="col-5">Hostname</dt>
                                    <dd class="col-7" id="hostnameValue">—</dd>

                                    <dt class="col-5">External IP</dt>
                                    <dd class="col-7" id="externalIpValue">—</dd>

                                    <dt class="col-5">Helios App URL</dt>
                                    <dd class="col-7">
                                        <a href="#" id="appUrlValue">—</a>
                                    </dd>
                                </dl>
                                <small class="text-muted">
                                    Values use generated data; wire to your backend configuration later.
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Maintenance status -->
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="card-header-title">Maintenance Mode</div>
                                    <div class="card-header-subtitle">Laravel application state</div>
                                </div>
                                <span class="helios-chip">Application</span>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="mb-3">
                                    <p class="mb-1 text-muted">Current status</p>
                                    <h5 id="maintenanceStatusLabel" class="maintenance-inactive mb-2">
                                        Maintenance mode: Inactive
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-muted">Last check:&nbsp;</span>
                                        <span id="maintenanceLastChecked">—</span>
                                    </p>
                                </div>
                                <div>
                                    <button
                                        class="btn btn-outline-warning btn-sm"
                                        id="maintenanceToggleBtn"
                                        type="button"
                                    >
                                        Toggle Maintenance (placeholder)
                                    </button>
                                    <div class="form-text mt-2">
                                        This only updates the UI. Later, connect it to an endpoint
                                        that runs <code>php artisan down</code>/<code>up</code>.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick stats -->
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="card-header-title">Request Summary (48h)</div>
                                    <div class="card-header-subtitle">Traffic snapshot from demo data</div>
                                </div>
                                <span class="helios-chip">Traffic</span>
                            </div>
                            <div class="card-body">
                                <div class="row g-2 mb-3">
                                    <div class="col-4">
                                        <div class="helios-stat-box text-center">
                                            <div class="helios-stat-label">Total</div>
                                            <div class="helios-stat-value" id="statTotalRequests">—</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="helios-stat-box text-center">
                                            <div class="helios-stat-label">Avg / hr</div>
                                            <div class="helios-stat-value" id="statAvgRequests">—</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="helios-stat-box text-center">
                                            <div class="helios-stat-label">Peak / hr</div>
                                            <div class="helios-stat-value" id="statPeakRequests">—</div>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted">
                                    Stats derive from the same dataset driving the web request chart.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Middle row -->
                <div class="row g-3 mb-3">
                    <!-- Chart -->
                    <div class="col-xl-8">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="card-header-title">Web Server Requests (Last 48 Hours)</div>
                                    <div class="card-header-subtitle">Demo time-series</div>
                                </div>
                                <span class="helios-chip">Chart</span>
                            </div>
                            <div class="card-body">
                                <div id="requestsChart"></div>
                                <small class="text-muted">
                                    Later, feed real Apache / reverse-proxy metrics into this chart.
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Error panels -->
                    <div class="col-xl-4">
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="card-header-title">Laravel Error Events</div>
                                    <div class="card-header-subtitle">Last 48 hours</div>
                                </div>
                                <span class="helios-chip" style="background:#fee2e2;color:#b91c1c;">Errors</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="log-table-wrapper">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th style="width: 40%;">Time</th>
                                            <th style="width: 60%;">Message</th>
                                        </tr>
                                        </thead>
                                        <tbody id="laravelErrorsBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="card-header-title">Apache Error Events</div>
                                    <div class="card-header-subtitle">Last 48 hours</div>
                                </div>
                                <span class="helios-chip" style="background:#fee2e2;color:#b91c1c;">Errors</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="log-table-wrapper">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th style="width: 40%;">Time</th>
                                            <th style="width: 60%;">Message</th>
                                        </tr>
                                        </thead>
                                        <tbody id="apacheErrorsBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom row: full logs -->
                <div class="row g-3">
                    <div class="col-xl-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="card-header-title">Recent Laravel Logs</div>
                                    <div class="card-header-subtitle">Last ~30 events</div>
                                </div>
                                <span class="helios-chip">Application Logs</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="log-table-wrapper">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th style="width: 25%;">Time</th>
                                            <th style="width: 15%;">Level</th>
                                            <th style="width: 60%;">Message</th>
                                        </tr>
                                        </thead>
                                        <tbody id="laravelLogsBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="card-header-title">Recent Apache Logs</div>
                                    <div class="card-header-subtitle">Last ~30 events</div>
                                </div>
                                <span class="helios-chip">Web Server Logs</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="log-table-wrapper">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th style="width: 25%;">Time</th>
                                            <th style="width: 15%;">Level</th>
                                            <th style="width: 60%;">Message</th>
                                        </tr>
                                        </thead>
                                        <tbody id="apacheLogsBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
></script>

<script>
    // -------------------------
    // Demo data generation
    // -------------------------
    const now = new Date();

    function hoursAgo(hours) {
        return new Date(now.getTime() - hours * 60 * 60 * 1000);
    }

    function formatDateTime(dt) {
        return dt.toLocaleString(undefined, {
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    const demoEnv = {
        hostname: 'helios-dev01',
        externalIp: '203.0.113.42',
        appUrl: 'https://dev.helionet.local',
        maintenanceMode: false,
        maintenanceLastChecked: now
    };

    const webRequestSeries = [];
    for (let h = 47; h >= 0; h--) {
        const t = hoursAgo(h);
        const base = 40 + 30 * Math.sin((h / 48) * 2 * Math.PI);
        const noise = Math.round(Math.random() * 20);
        const value = Math.max(5, Math.round(base + noise));
        webRequestSeries.push({ timestamp: t, count: value });
    }

    function generateLogEvents(source, count) {
        const laravelMessages = [
            'User login successful',
            'Scheduled job completed',
            'Cache cleared',
            'Database connection established',
            'Route cache refreshed',
            'Queue worker restarted',
            'CSRF token mismatch',
            'Exception: ModelNotFoundException',
            'Exception: QueryException',
            'Health check endpoint responded 200'
        ];
        const apacheMessages = [
            'GET / HTTP/1.1 200',
            'GET /favicon.ico 404',
            'GET /helios/dashboard 200',
            'POST /api/login 302',
            'GET /api/status 200',
            'GET /nonexistent 404',
            'OPTIONS /api/metrics 204',
            'Client closed connection',
            'upstream timed out',
            'SSL handshake completed'
        ];
        const messages = source === 'laravel' ? laravelMessages : apacheMessages;

        const events = [];
        for (let i = 0; i < count; i++) {
            const hoursBack = Math.random() * 48;
            const ts = hoursAgo(hoursBack);
            const levelPick = Math.random();
            const level =
                levelPick < 0.65 ? 'INFO' :
                levelPick < 0.9 ? 'WARNING' : 'ERROR';

            const msg = messages[Math.floor(Math.random() * messages.length)];
            events.push({ timestamp: ts, level, message: msg });
        }
        events.sort((a, b) => b.timestamp - a.timestamp);
        return events;
    }

    const laravelLogEvents = generateLogEvents('laravel', 80);
    const apacheLogEvents  = generateLogEvents('apache', 80);

    function getErrorEvents(events) {
        const cutoff = hoursAgo(48);
        return events.filter(e => e.level === 'ERROR' && e.timestamp >= cutoff);
    }

    const laravelErrorEvents = getErrorEvents(laravelLogEvents);
    const apacheErrorEvents  = getErrorEvents(apacheLogEvents);

    // -------------------------
    // DOM population
    // -------------------------
    function renderEnvInfo() {
        document.getElementById('hostnameValue').textContent = demoEnv.hostname;
        document.getElementById('externalIpValue').textContent = demoEnv.externalIp;

        const appUrlAnchor = document.getElementById('appUrlValue');
        appUrlAnchor.textContent = demoEnv.appUrl;
        appUrlAnchor.href = demoEnv.appUrl;

        document.getElementById('maintenanceLastChecked').textContent =
            formatDateTime(demoEnv.maintenanceLastChecked);

        updateMaintenanceStatusUI();
    }

    function updateMaintenanceStatusUI() {
        const label = document.getElementById('maintenanceStatusLabel');
        if (demoEnv.maintenanceMode) {
            label.textContent = 'Maintenance mode: Active';
            label.classList.remove('maintenance-inactive');
            label.classList.add('maintenance-active');
        } else {
            label.textContent = 'Maintenance mode: Inactive';
            label.classList.remove('maintenance-active');
            label.classList.add('maintenance-inactive');
        }
    }

    function attachMaintenanceToggle() {
        const btn = document.getElementById('maintenanceToggleBtn');
        btn.addEventListener('click', () => {
            demoEnv.maintenanceMode = !demoEnv.maintenanceMode;
            demoEnv.maintenanceLastChecked = new Date();
            updateMaintenanceStatusUI();
            document.getElementById('maintenanceLastChecked').textContent =
                formatDateTime(demoEnv.maintenanceLastChecked);
        });
    }

    function renderLogsTable(events, tbodyId, limit) {
        const tbody = document.getElementById(tbodyId);
        tbody.innerHTML = '';
        events.slice(0, limit).forEach(ev => {
            const tr = document.createElement('tr');

            const tdTime = document.createElement('td');
            tdTime.textContent = formatDateTime(ev.timestamp);
            tr.appendChild(tdTime);

            const tdLevel = document.createElement('td');
            const span = document.createElement('span');
            span.classList.add('badge');
            if (ev.level === 'INFO') span.classList.add('badge-level-info');
            else if (ev.level === 'WARNING') span.classList.add('badge-level-warning');
            else span.classList.add('badge-level-error');
            span.textContent = ev.level;
            tdLevel.appendChild(span);
            tr.appendChild(tdLevel);

            const tdMsg = document.createElement('td');
            tdMsg.textContent = ev.message;
            tr.appendChild(tdMsg);

            tbody.appendChild(tr);
        });
    }

    function renderErrorTable(events, tbodyId, limit) {
        const tbody = document.getElementById(tbodyId);
        tbody.innerHTML = '';
        events.slice(0, limit).forEach(ev => {
            const tr = document.createElement('tr');

            const tdTime = document.createElement('td');
            tdTime.textContent = formatDateTime(ev.timestamp);
            tr.appendChild(tdTime);

            const tdMsg = document.createElement('td');
            tdMsg.textContent = ev.message;
            tr.appendChild(tdMsg);

            tbody.appendChild(tr);
        });

        if (!events.length) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 2;
            td.classList.add('text-muted');
            td.style.fontSize = '12px';
            td.textContent = 'No error events found in the last 48 hours.';
            tr.appendChild(td);
            tbody.appendChild(tr);
        }
    }

    function renderQuickStats() {
        const total = webRequestSeries.reduce((sum, p) => sum + p.count, 0);
        const avg   = Math.round(total / webRequestSeries.length);
        const peak  = Math.max(...webRequestSeries.map(p => p.count));

        document.getElementById('statTotalRequests').textContent = total.toLocaleString();
        document.getElementById('statAvgRequests').textContent   = avg.toLocaleString();
        document.getElementById('statPeakRequests').textContent  = peak.toLocaleString();
    }

    // -------------------------
    // Google Chart: Requests
    // -------------------------
    google.charts.load('current', {packages: ['corechart']});

    function drawRequestsChart() {
        const dataTable = new google.visualization.DataTable();
        dataTable.addColumn('datetime', 'Time');
        dataTable.addColumn('number', 'Requests');

        webRequestSeries.forEach(point => {
            dataTable.addRow([point.timestamp, point.count]);
        });

        const options = {
            legend: { position: 'bottom', textStyle: { color: '#6b7280' } },
            backgroundColor: 'transparent',
            chartArea: { left: 60, top: 20, right: 16, bottom: 50 },
            hAxis: {
                textStyle: { color: '#6b7280', fontSize: 10 },
                gridlines: { color: '#e5e7eb' }
            },
            vAxis: {
                title: 'Requests',
                titleTextStyle: { color: '#6b7280', fontSize: 11 },
                textStyle: { color: '#6b7280', fontSize: 10 },
                gridlines: { color: '#e5e7eb' },
                minValue: 0
            },
            series: {
                0: { curveType: 'function', color: '#2563eb' }
            }
        };

        const chart = new google.visualization.LineChart(
            document.getElementById('requestsChart')
        );
        chart.draw(dataTable, options);
    }

    google.charts.setOnLoadCallback(drawRequestsChart);

    // -------------------------
    // Init
    // -------------------------
    document.addEventListener('DOMContentLoaded', () => {
        renderEnvInfo();
        attachMaintenanceToggle();
        renderQuickStats();

        renderLogsTable(laravelLogEvents, 'laravelLogsBody', 30);
        renderLogsTable(apacheLogEvents,  'apacheLogsBody', 30);

        renderErrorTable(laravelErrorEvents, 'laravelErrorsBody', 15);
        renderErrorTable(apacheErrorEvents,  'apacheErrorsBody', 15);
    });
</script>

</body>
</html>
