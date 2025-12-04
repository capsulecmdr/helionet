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
        /* ---------------------------------
           Helios Soft Dashboard Theme
           (inspired by provided UI example)
        ------------------------------------ */

        /* Page background */
        body {
            background: #E9EDF5;
            color: #374151;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Inter", sans-serif;
        }

        /* Top app bar */
        .helios-topbar {
            background: #E9EDF5;
            border-bottom: none;
            padding: 18px 32px 0 32px;
        }

        .helios-topbar-inner {
            background: #FFFFFF;
            border-radius: 20px;
            padding: 10px 20px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .helios-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .helios-brand-icon {
            width: 32px;
            height: 32px;
            border-radius: 12px;
            background: radial-gradient(circle at 30% 30%, #4A6CF7, #1D4ED8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 700;
            font-size: 16px;
        }

        .helios-brand-text {
            font-weight: 600;
            font-size: 18px;
            color: #111827;
        }

        .helios-nav-links a {
            font-size: 14px;
            color: #6B7280;
            margin-right: 18px;
            text-decoration: none;
        }

        .helios-nav-links a.active {
            color: #111827;
            font-weight: 600;
        }

        .helios-nav-links a:hover {
            color: #111827;
        }

        .helios-search-wrapper {
            max-width: 360px;
            flex: 1;
            margin: 0 24px;
        }

        .helios-search {
            border-radius: 999px;
            border: 1px solid #E5E7EB;
            padding-left: 40px;
            font-size: 14px;
        }

        .helios-search:focus {
            box-shadow: 0 0 0 1px #4A6CF7;
            border-color: #4A6CF7;
        }

        .helios-search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: #9CA3AF;
        }

        .helios-user-badge {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .helios-user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: linear-gradient(135deg, #F97316, #F43F5E);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-weight: 600;
            font-size: 14px;
        }

        .helios-user-name {
            font-size: 14px;
            color: #111827;
            font-weight: 500;
        }

        .helios-user-role {
            font-size: 12px;
            color: #9CA3AF;
        }

        /* Main container */
        .helios-main {
            padding: 24px 32px 32px 32px;
        }

        /* Cards */
        .card {
            background: #FFFFFF;
            border-radius: 20px;
            border: 1px solid #D9DFEA;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
        }

        .card-header {
            background: transparent;
            border-bottom: none;
            padding: 18px 20px 4px 20px;
        }

        .card-header-title {
            font-weight: 600;
            font-size: 15px;
            color: #111827;
        }

        .card-header-subtitle {
            font-size: 12px;
            color: #9CA3AF;
        }

        .card-body {
            padding: 16px 20px 20px 20px;
        }

        .text-muted {
            color: #9CA3AF !important;
        }

        /* Info pills */
        .helios-pill {
            background: #EEF2FF;
            color: #4A6CF7;
            border-radius: 999px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 500;
        }

        /* Stat boxes in quick stats */
        .helios-stat-box {
            background: #F3F4F6;
            border-radius: 16px;
            padding: 10px 8px;
        }

        .helios-stat-label {
            font-size: 11px;
            color: #9CA3AF;
        }

        .helios-stat-value {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
        }

        /* Maintenance status */
        .maintenance-active {
            color: #F59E0B;
            font-weight: 600;
        }

        .maintenance-inactive {
            color: #22C55E;
            font-weight: 600;
        }

        .form-text {
            font-size: 11px;
        }

        /* Tables & log panels */
        .log-table-wrapper {
            max-height: 230px;
            overflow-y: auto;
            border-radius: 16px;
        }

        table.table {
            margin-bottom: 0;
            font-size: 12px;
        }

        .table thead {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #6B7280;
            background: #F3F4F6;
        }

        .table tbody tr td {
            border-color: #E5E7EB;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: #EEF2FF;
        }

        .badge {
            border-radius: 999px;
            padding: 3px 9px;
            font-size: 10px;
            font-weight: 500;
        }

        .badge-level-info {
            background-color: #4A6CF7;
            color: #FFFFFF;
        }

        .badge-level-warning {
            background-color: #F59E0B;
            color: #FFFFFF;
        }

        .badge-level-error {
            background-color: #EF4444;
            color: #FFFFFF;
        }

        /* Buttons */
        .btn {
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
        }

        .btn-outline-warning {
            border-color: #F59E0B;
            color: #F59E0B;
            background: #FFF7ED;
        }

        .btn-outline-warning:hover {
            background: #F59E0B;
            color: #ffffff;
        }

        /* Google Chart holder */
        #requestsChart {
            width: 100%;
            height: 320px;
        }

        /* Link style */
        a {
            color: #4A6CF7;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Small helper */
        dl.row dt {
            font-size: 12px;
        }

        dl.row dd {
            font-size: 13px;
        }

        /* Scrollbar subtle */
        .log-table-wrapper::-webkit-scrollbar {
            width: 6px;
        }
        .log-table-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }
        .log-table-wrapper::-webkit-scrollbar-thumb {
            background: #D1D5DB;
            border-radius: 999px;
        }
    </style>
</head>
<body>

<!-- TOP BAR -->
<header class="helios-topbar">
    <div class="helios-topbar-inner">
        <div class="helios-brand">
            <div class="helios-brand-icon">H</div>
            <div>
                <div class="helios-brand-text">Helios Platform</div>
                <div style="font-size:11px;color:#9CA3AF;">Server Management Portal</div>
            </div>
        </div>

        <div class="helios-nav-links d-none d-md-block">
            <a href="#" class="active">Dashboard</a>
            <a href="#">Servers</a>
            <a href="#">Logs</a>
            <a href="#">Settings</a>
        </div>

        <div class="helios-search-wrapper d-none d-md-block position-relative">
            <span class="helios-search-icon">
                🔍
            </span>
            <input type="text" class="form-control helios-search" placeholder="Search servers, logs, actions...">
        </div>

        <div class="helios-user-badge">
            <div class="text-end d-none d-sm-block">
                <div class="helios-user-name">Admin</div>
                <div class="helios-user-role">Helios Operator</div>
            </div>
            <div class="helios-user-avatar">A</div>
        </div>
    </div>
</header>

<!-- MAIN CONTENT -->
<main class="helios-main">
    <div class="container-fluid">

        <!-- Top Row: System Info / Maintenance / Quick Stats -->
        <div class="row g-3 mb-3">
            <!-- System Info Card -->
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-header-title">System Information</div>
                            <div class="card-header-subtitle">Host and platform details</div>
                        </div>
                        <span class="helios-pill">Host</span>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-3">
                            <dt class="col-5 text-muted">Hostname</dt>
                            <dd class="col-7" id="hostnameValue">—</dd>

                            <dt class="col-5 text-muted">External IP</dt>
                            <dd class="col-7" id="externalIpValue">—</dd>

                            <dt class="col-5 text-muted">Helios App URL</dt>
                            <dd class="col-7">
                                <a href="#" id="appUrlValue">
                                    —
                                </a>
                            </dd>
                        </dl>
                        <small class="text-muted">
                            Values are generated as demo data; wire these to your backend configuration later.
                        </small>
                    </div>
                </div>
            </div>

            <!-- Maintenance Status Card -->
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-header-title">Maintenance Mode</div>
                            <div class="card-header-subtitle">Laravel application state</div>
                        </div>
                        <span class="helios-pill">Application</span>
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
                                This only updates the UI for now. Later, connect it to an endpoint that runs
                                <code>php artisan down</code> / <code>up</code>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats (Traffic) -->
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-header-title">Request Summary (48h)</div>
                            <div class="card-header-subtitle">Traffic snapshots from demo data</div>
                        </div>
                        <span class="helios-pill">Traffic</span>
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
                            Stats computed from the same dataset driving the web request chart.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle Row: Web Requests Chart + Error Panels -->
        <div class="row g-3 mb-3">
            <!-- Web Requests Chart -->
            <div class="col-xl-8">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-header-title">Web Server Requests (Last 48 Hours)</div>
                            <div class="card-header-subtitle">Demo time-series data</div>
                        </div>
                        <span class="helios-pill">Chart</span>
                    </div>
                    <div class="card-body">
                        <div id="requestsChart"></div>
                        <small class="text-muted">
                            Once connected, feed real Apache or reverse-proxy metrics into this chart.
                        </small>
                    </div>
                </div>
            </div>

            <!-- Error Events (Laravel & Apache) -->
            <div class="col-xl-4">
                <!-- Laravel Errors -->
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-header-title">Laravel Error Events</div>
                            <div class="card-header-subtitle">Last 48 hours</div>
                        </div>
                        <span class="helios-pill" style="background:#FEE2E2;color:#B91C1C;">Errors</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="log-table-wrapper">
                            <table class="table table-sm table-hover">
                                <thead>
                                <tr>
                                    <th style="width:40%;">Time</th>
                                    <th style="width:60%;">Message</th>
                                </tr>
                                </thead>
                                <tbody id="laravelErrorsBody">
                                <!-- Filled by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Apache Errors -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-header-title">Apache Error Events</div>
                            <div class="card-header-subtitle">Last 48 hours</div>
                        </div>
                        <span class="helios-pill" style="background:#FEE2E2;color:#B91C1C;">Errors</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="log-table-wrapper">
                            <table class="table table-sm table-hover">
                                <thead>
                                <tr>
                                    <th style="width:40%;">Time</th>
                                    <th style="width:60%;">Message</th>
                                </tr>
                                </thead>
                                <tbody id="apacheErrorsBody">
                                <!-- Filled by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Row: Full Recent Logs -->
        <div class="row g-3">
            <!-- Laravel Logs -->
            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-header-title">Recent Laravel Logs</div>
                            <div class="card-header-subtitle">Last ~30 events (demo)</div>
                        </div>
                        <span class="helios-pill">Application Logs</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="log-table-wrapper">
                            <table class="table table-sm table-hover">
                                <thead>
                                <tr>
                                    <th style="width:25%;">Time</th>
                                    <th style="width:15%;">Level</th>
                                    <th style="width:60%;">Message</th>
                                </tr>
                                </thead>
                                <tbody id="laravelLogsBody">
                                <!-- Filled by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apache Logs -->
            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <div class="card-header-title">Recent Apache Logs</div>
                            <div class="card-header-subtitle">Last ~30 events (demo)</div>
                        </div>
                        <span class="helios-pill">Web Server Logs</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="log-table-wrapper">
                            <table class="table table-sm table-hover">
                                <thead>
                                <tr>
                                    <th style="width:25%;">Time</th>
                                    <th style="width:15%;">Level</th>
                                    <th style="width:60%;">Message</th>
                                </tr>
                                </thead>
                                <tbody id="apacheLogsBody">
                                <!-- Filled by JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Bootstrap JS bundle -->
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

    // Web request series for last 48h
    const webRequestSeries = [];
    for (let h = 47; h >= 0; h--) {
        const t = hoursAgo(h);
        // Fake traffic curve: busier in "daytime"
        const base = 40 + 30 * Math.sin((h / 48) * 2 * Math.PI);
        const noise = Math.round(Math.random() * 20);
        const value = Math.max(5, Math.round(base + noise));
        webRequestSeries.push({ timestamp: t, count: value });
    }

    // Generic log generator
    function generateLogEvents(source, count) {
        const levels = ['INFO', 'WARNING', 'ERROR'];
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
            events.push({
                timestamp: ts,
                level,
                message: msg
            });
        }

        // Sort newest first
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
    // DOM population helpers
    // -------------------------

    function renderEnvInfo() {
        document.getElementById('hostnameValue').textContent = demoEnv.hostname;
        document.getElementById('externalIpValue').textContent = demoEnv.externalIp;

        const appUrlAnchor = document.getElementById('appUrlValue');
        appUrlAnchor.textContent = demoEnv.appUrl;
        appUrlAnchor.href = demoEnv.appUrl;

        const lastChecked = document.getElementById('maintenanceLastChecked');
        lastChecked.textContent = formatDateTime(demoEnv.maintenanceLastChecked);

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
        btn.addEventListener('click', function () {
            // Placeholder behavior: flip the local value only
            demoEnv.maintenanceMode = !demoEnv.maintenanceMode;
            demoEnv.maintenanceLastChecked = new Date();
            updateMaintenanceStatusUI();
            document.getElementById('maintenanceLastChecked').textContent =
                formatDateTime(demoEnv.maintenanceLastChecked);

            // TODO: replace with backend call that toggles real maintenance mode
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

            if (ev.level === 'INFO') {
                span.classList.add('badge-level-info');
            } else if (ev.level === 'WARNING') {
                span.classList.add('badge-level-warning');
            } else {
                span.classList.add('badge-level-error');
            }
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

        if (events.length === 0) {
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
        const avg = Math.round(total / webRequestSeries.length);
        const peak = Math.max(...webRequestSeries.map(p => p.count));

        document.getElementById('statTotalRequests').textContent = total.toLocaleString();
        document.getElementById('statAvgRequests').textContent = avg.toLocaleString();
        document.getElementById('statPeakRequests').textContent = peak.toLocaleString();
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
            legend: { position: 'bottom', textStyle: { color: '#6B7280' } },
            backgroundColor: 'transparent',
            chartArea: {
                left: 60, top: 20, right: 20, bottom: 50
            },
            hAxis: {
                textStyle: { color: '#9CA3AF', fontSize: 10 },
                gridlines: { color: '#E5E7EB' }
            },
            vAxis: {
                title: 'Requests',
                titleTextStyle: { color: '#9CA3AF', fontSize: 11 },
                textStyle: { color: '#6B7280', fontSize: 10 },
                gridlines: { color: '#E5E7EB' },
                minValue: 0
            },
            series: {
                0: {
                    curveType: 'function',
                    color: '#4A6CF7'
                }
            }
        };

        const chart = new google.visualization.LineChart(
            document.getElementById('requestsChart')
        );
        chart.draw(dataTable, options);
    }

    google.charts.setOnLoadCallback(drawRequestsChart);

    // -------------------------
    // Initialize dashboard
    // -------------------------

    document.addEventListener('DOMContentLoaded', function () {
        renderEnvInfo();
        attachMaintenanceToggle();
        renderQuickStats();

        // Recent logs (~30 events)
        renderLogsTable(laravelLogEvents, 'laravelLogsBody', 30);
        renderLogsTable(apacheLogEvents,  'apacheLogsBody', 30);

        // Error logs (48h)
        renderErrorTable(laravelErrorEvents, 'laravelErrorsBody', 15);
        renderErrorTable(apacheErrorEvents,  'apacheErrorsBody', 15);
    });
</script>

</body>
</html>
