<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Helios Server Management Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Metro UI 5 CSS -->
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/current/metro.css">
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/current/icons.css">

    <!-- Google Charts -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <style>
    </style>
</head>
<body class="h-vh-100">

<div
    class="navview h-100"
    data-role="navview"
    data-expand="md"
    data-toggle="#sidebar-toggle"
>
    <!-- Sidebar -->
    <div class="navview-pane">
        <div class="p-4 d-flex flex-align-center">
            <div class="brand-logo mr-3">H</div>
            <div>
                <div class="brand-text">Helios</div>
                <div class="brand-subtext">Server Portal</div>
            </div>
        </div>

        <ul class="navview-menu mt-2">
            <li class="item active">
                <a href="#">
                    <span class="icon"><span class="mif-home"></span></span>
                    <span class="caption">Dashboard</span>
                </a>
            </li>
            <li class="item">
                <a href="#">
                    <span class="icon"><span class="mif-display"></span></span>
                    <span class="caption">Servers</span>
                </a>
            </li>
            <li class="item">
                <a href="#">
                    <span class="icon"><span class="mif-file-text"></span></span>
                    <span class="caption">Logs</span>
                </a>
            </li>
            <li class="item">
                <a href="#">
                    <span class="icon"><span class="mif-cogs"></span></span>
                    <span class="caption">Settings</span>
                </a>
            </li>
        </ul>

        <div class="pos-absolute pos-bottom-left p-4 text-small fg-gray">
            Helios Platform · v0.1
        </div>
    </div>

    <!-- Content -->
    <div class="navview-content h-100 d-flex flex-column">

        <!-- Top bar -->
        <header class="app-bar bg-white fg-dark px-4 py-2 d-flex flex-align-center flex-justify-between">
            <div class="d-flex flex-column">
                <span class="app-title">Server Management</span>
                <span class="app-subtitle">
                    Monitor Laravel &amp; Apache health for this Helios instance.
                </span>
            </div>

            <div class="d-none d-md-flex flex-align-center flex-gap-4">
                <div class="d-none d-md-block">
                    <div class="text-right">
                        <div class="text-bold text-small">Admin</div>
                        <div class="text-muted text-small">Helios Operator</div>
                    </div>
                </div>
                <div class="avatar" style="background: linear-gradient(135deg,#22c55e,#16a34a);">
                    <span class="fg-white">A</span>
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="content p-4 fg-dark">
            <div class="grid">

                <!-- Top row -->
                <div class="row flex-justify-between mb-3">
                    <!-- System Info -->
                    <div class="cell-md-4 mb-3">
                        <div class="card helios-card">
                            <div class="card-header d-flex flex-justify-between flex-align-center">
                                <div>
                                    <div class="helios-card-title">System Information</div>
                                    <div class="helios-card-subtitle">Host and platform details</div>
                                </div>
                                <span class="helios-chip">Host</span>
                            </div>
                            <div class="card-content p-3">
                                <dl class="d-flex flex-column mb-3">
                                    <div class="d-flex flex-justify-between mb-1">
                                        <dt class="text-small fg-gray">Hostname</dt>
                                        <dd class="text-small" id="hostnameValue">—</dd>
                                    </div>
                                    <div class="d-flex flex-justify-between mb-1">
                                        <dt class="text-small fg-gray">External IP</dt>
                                        <dd class="text-small" id="externalIpValue">—</dd>
                                    </div>
                                    <div class="d-flex flex-justify-between mb-1">
                                        <dt class="text-small fg-gray">Helios App URL</dt>
                                        <dd class="text-small">
                                            <a href="#" id="appUrlValue">—</a>
                                        </dd>
                                    </div>
                                </dl>
                                <div class="text-small fg-gray">
                                    Values use generated demo data; later wire these to your backend configuration.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Maintenance -->
                    <div class="cell-md-4 mb-3">
                        <div class="card helios-card h-100">
                            <div class="card-header d-flex flex-justify-between flex-align-center">
                                <div>
                                    <div class="helios-card-title">Maintenance Mode</div>
                                    <div class="helios-card-subtitle">Laravel application state</div>
                                </div>
                                <span class="helios-chip">Application</span>
                            </div>
                            <div class="card-content p-3 d-flex flex-column h-100">
                                <div class="mb-3">
                                    <div class="text-small fg-gray">Current status</div>
                                    <h5 id="maintenanceStatusLabel" class="maintenance-inactive mt-1 mb-1">
                                        Maintenance mode: Inactive
                                    </h5>
                                    <div class="text-small">
                                        <span class="fg-gray">Last check:&nbsp;</span>
                                        <span id="maintenanceLastChecked">—</span>
                                    </div>
                                </div>
                                <div class="mt-auto">
                                    <button
                                        class="button outline warning small"
                                        id="maintenanceToggleBtn"
                                        type="button"
                                    >
                                        Toggle Maintenance (placeholder)
                                    </button>
                                    <div class="text-small mt-2 fg-gray">
                                        This only updates the UI. Later, connect it to an endpoint that runs
                                        <code>php artisan down</code>/<code>up</code>.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick stats -->
                    <div class="cell-md-4 mb-3">
                        <div class="card helios-card h-100">
                            <div class="card-header d-flex flex-justify-between flex-align-center">
                                <div>
                                    <div class="helios-card-title">Request Summary (48h)</div>
                                    <div class="helios-card-subtitle">Traffic snapshot (demo data)</div>
                                </div>
                                <span class="helios-chip">Traffic</span>
                            </div>
                            <div class="card-content p-3">
                                <div class="grid">
                                    <div class="row mb-2">
                                        <div class="cell-4">
                                            <div class="helios-stat-box text-center">
                                                <div class="helios-stat-label">Total</div>
                                                <div class="helios-stat-value" id="statTotalRequests">—</div>
                                            </div>
                                        </div>
                                        <div class="cell-4">
                                            <div class="helios-stat-box text-center">
                                                <div class="helios-stat-label">Avg / hr</div>
                                                <div class="helios-stat-value" id="statAvgRequests">—</div>
                                            </div>
                                        </div>
                                        <div class="cell-4">
                                            <div class="helios-stat-box text-center">
                                                <div class="helios-stat-label">Peak / hr</div>
                                                <div class="helios-stat-value" id="statPeakRequests">—</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-small fg-gray">
                                    Stats are computed from the same dataset that drives the web request chart.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Middle row -->
                <div class="row mb-3">
                    <!-- Chart -->
                    <div class="cell-xl-8 mb-3">
                        <div class="card helios-card h-100">
                            <div class="card-header d-flex flex-justify-between flex-align-center">
                                <div>
                                    <div class="helios-card-title">Web Server Requests (Last 48 Hours)</div>
                                    <div class="helios-card-subtitle">Demo time-series</div>
                                </div>
                                <span class="helios-chip">Chart</span>
                            </div>
                            <div class="card-content p-3">
                                <div id="requestsChart"></div>
                                <div class="text-small fg-gray mt-2">
                                    Once connected, feed real Apache or reverse-proxy metrics into this chart.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Error panels -->
                    <div class="cell-xl-4 mb-3">
                        <div class="card helios-card mb-3">
                            <div class="card-header d-flex flex-justify-between flex-align-center">
                                <div>
                                    <div class="helios-card-title">Laravel Error Events</div>
                                    <div class="helios-card-subtitle">Last 48 hours</div>
                                </div>
                                <span class="helios-chip" style="background:#fee2e2;color:#b91c1c;">Errors</span>
                            </div>
                            <div class="card-content p-0">
                                <div class="log-table-wrapper">
                                    <table class="table compact striped">
                                        <thead>
                                        <tr>
                                            <th style="width:40%;">Time</th>
                                            <th style="width:60%;">Message</th>
                                        </tr>
                                        </thead>
                                        <tbody id="laravelErrorsBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card helios-card">
                            <div class="card-header d-flex flex-justify-between flex-align-center">
                                <div>
                                    <div class="helios-card-title">Apache Error Events</div>
                                    <div class="helios-card-subtitle">Last 48 hours</div>
                                </div>
                                <span class="helios-chip" style="background:#fee2e2;color:#b91c1c;">Errors</span>
                            </div>
                            <div class="card-content p-0">
                                <div class="log-table-wrapper">
                                    <table class="table compact striped">
                                        <thead>
                                        <tr>
                                            <th style="width:40%;">Time</th>
                                            <th style="width:60%;">Message</th>
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
                <div class="row">
                    <div class="cell-xl-6 mb-3">
                        <div class="card helios-card h-100">
                            <div class="card-header d-flex flex-justify-between flex-align-center">
                                <div>
                                    <div class="helios-card-title">Recent Laravel Logs</div>
                                    <div class="helios-card-subtitle">Last ~30 events (demo)</div>
                                </div>
                                <span class="helios-chip">Application Logs</span>
                            </div>
                            <div class="card-content p-0">
                                <div class="log-table-wrapper">
                                    <table class="table compact striped">
                                        <thead>
                                        <tr>
                                            <th style="width:25%;">Time</th>
                                            <th style="width:15%;">Level</th>
                                            <th style="width:60%;">Message</th>
                                        </tr>
                                        </thead>
                                        <tbody id="laravelLogsBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cell-xl-6 mb-3">
                        <div class="card helios-card h-100">
                            <div class="card-header d-flex flex-justify-between flex-align-center">
                                <div>
                                    <div class="helios-card-title">Recent Apache Logs</div>
                                    <div class="helios-card-subtitle">Last ~30 events (demo)</div>
                                </div>
                                <span class="helios-chip">Web Server Logs</span>
                            </div>
                            <div class="card-content p-0">
                                <div class="log-table-wrapper">
                                    <table class="table compact striped">
                                        <thead>
                                        <tr>
                                            <th style="width:25%;">Time</th>
                                            <th style="width:15%;">Level</th>
                                            <th style="width:60%;">Message</th>
                                        </tr>
                                        </thead>
                                        <tbody id="apacheLogsBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- /grid -->
        </main>
    </div>
</div>

<!-- Metro JS -->
<script src="https://cdn.metroui.org.ua/current/metro.js"></script>

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

    // Web requests (48 hours)
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
    // DOM rendering helpers
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
            span.classList.add('tag', 'small');
            if (ev.level === 'INFO') span.classList.add('level-info');
            else if (ev.level === 'WARNING') span.classList.add('level-warning');
            else span.classList.add('level-error');
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
            td.classList.add('fg-gray', 'text-small');
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
