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
        /* Page background */
        body {
            background: #E9EDF5 !important;
            color: #374151 !important;
            font-family: 'Inter', sans-serif;
        }

        /* NAVBAR */
        .navbar {
            background: #FFFFFF !important;
            border-bottom: 1px solid #D9DFEA;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-weight: 600;
            color: #4A6CF7 !important;
        }

        /* CARDS */
        .card {
            background: #FFFFFF;
            border: 1px solid #D9DFEA;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
        }

        .card-header {
            background: transparent;
            border-bottom: none;
            padding-bottom: 0;
            font-weight: 600;
            color: #374151;
            font-size: 1.05rem;
        }

        /* HEADINGS */
        h5, h6 {
            font-weight: 600;
        }

        /* BADGES */
        .badge {
            font-weight: 500;
            border-radius: 10px;
            padding: 4px 10px;
        }

        .badge-level-info {
            background-color: #4A6CF7 !important;
            color: #fff;
        }

        .badge-level-warning {
            background-color: #F59E0B !important;
            color: #fff;
        }

        .badge-level-error {
            background-color: #EF4444 !important;
            color: #fff;
        }

        /* TABLES */
        table.table tr td {
            color: #4B5563;
        }

        table.table-hover tbody tr:hover {
            background: rgba(74,108,247,0.06);
        }

        /* BUTTONS */
        .btn {
            border-radius: 12px;
            font-weight: 500;
        }

        .btn-outline-warning {
            border-color: #F59E0B;
            color: #F59E0B;
        }

        .btn-outline-warning:hover {
            background: #F59E0B;
            color: #fff;
        }

        /* MAINTENANCE STATUS COLORS */
        .maintenance-active {
            color: #F59E0B !important;
            font-weight: 600;
        }

        .maintenance-inactive {
            color: #22C55E !important;
            font-weight: 600;
        }

        /* LOG SCROLL WRAPPER */
        .log-table-wrapper {
            max-height: 240px;
            overflow-y: auto;
            border-radius: 12px;
        }

        /* LINKS */
        a {
            color: #4A6CF7;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
        #requestsChart {
            background: transparent !important;
            border-radius: 18px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark mb-4">
    <div class="container-fluid">
        <span class="navbar-brand fw-semibold">Helios Server Management</span>
    </div>
</nav>

<div class="container-fluid mb-4">
    <!-- Top row: system info + maintenance -->
    <div class="row g-3 mb-3">
        <!-- System info -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>System Information</span>
                    <span class="badge bg-secondary">Host</span>
                </div>
                <div class="card-body">
                    <dl class="row mb-2">
                        <dt class="col-5 text-muted">Hostname</dt>
                        <dd class="col-7" id="hostnameValue">—</dd>

                        <dt class="col-5 text-muted">External IP</dt>
                        <dd class="col-7" id="externalIpValue">—</dd>

                        <dt class="col-5 text-muted">Helios App URL</dt>
                        <dd class="col-7">
                            <a href="#" id="appUrlValue" class="link-info link-underline-opacity-0 link-underline-opacity-50-hover">
                                —
                            </a>
                        </dd>
                    </dl>
                    <small class="text-muted">Values currently use demo data; will be wired to backend later.</small>
                </div>
            </div>
        </div>

        <!-- Maintenance status -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Laravel Maintenance Status</span>
                    <span class="badge bg-info text-dark">Application</span>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <p class="mb-1 text-muted">Current status:</p>
                        <h5 id="maintenanceStatusLabel" class="maintenance-inactive mb-2">
                            Maintenance mode: Inactive
                        </h5>
                        <p class="mb-2">
                            <span class="text-muted">Last check:</span>
                            <span id="maintenanceLastChecked">—</span>
                        </p>
                    </div>
                    <div>
                        <button class="btn btn-outline-warning btn-sm" id="maintenanceToggleBtn" type="button">
                            Toggle Maintenance (placeholder)
                        </button>
                        <div class="form-text text-muted mt-1">
                            This button only updates the UI for now. Later it can call a backend endpoint to run
                            <code>php artisan down</code>/<code>up</code>.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick stats (optional helper) -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Quick Request Stats (48h)</span>
                    <span class="badge bg-primary">Traffic</span>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-2">
                        <div class="col-4">
                            <div class="fw-semibold" id="statTotalRequests">—</div>
                            <div class="text-muted small">Total</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-semibold" id="statAvgRequests">—</div>
                            <div class="text-muted small">Avg/hr</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-semibold" id="statPeakRequests">—</div>
                            <div class="text-muted small">Peak/hr</div>
                        </div>
                    </div>
                    <small class="text-muted">
                        Demo values derived from the chart dataset. Replace with backend metrics later.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Middle row: web requests chart -->
    <div class="row g-3 mb-3">
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Web Server Requests (Last 48 Hours)</span>
                    <span class="badge bg-success">Chart</span>
                </div>
                <div class="card-body">
                    <div id="requestsChart" style="width: 100%; height: 320px;"></div>
                    <small class="text-muted">
                        Based on a generated time series for now. Later, wire this to real Apache/Laravel metrics.
                    </small>
                </div>
            </div>
        </div>

        <!-- Laravel / Apache errors (48h) summary tables -->
        <div class="col-xl-4">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Laravel Error Events (Last 48h)</span>
                    <span class="badge bg-danger">Errors</span>
                </div>
                <div class="card-body log-table-wrapper p-0">
                    <table class="table table-sm table-striped table-hover mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th style="width: 40%;">Time</th>
                            <th style="width: 60%;">Message</th>
                        </tr>
                        </thead>
                        <tbody id="laravelErrorsBody">
                        <!-- filled by JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Apache Error Events (Last 48h)</span>
                    <span class="badge bg-danger">Errors</span>
                </div>
                <div class="card-body log-table-wrapper p-0">
                    <table class="table table-sm table-striped table-hover mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th style="width: 40%;">Time</th>
                            <th style="width: 60%;">Message</th>
                        </tr>
                        </thead>
                        <tbody id="apacheErrorsBody">
                        <!-- filled by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom row: full recent logs -->
    <div class="row g-3">
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent Laravel Logs (Last ~30 Events)</span>
                    <span class="badge bg-secondary">Application Logs</span>
                </div>
                <div class="card-body log-table-wrapper p-0">
                    <table class="table table-sm table-striped table-hover mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th style="width: 25%;">Time</th>
                            <th style="width: 15%;">Level</th>
                            <th style="width: 60%;">Message</th>
                        </tr>
                        </thead>
                        <tbody id="laravelLogsBody">
                        <!-- filled by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent Apache Logs (Last ~30 Events)</span>
                    <span class="badge bg-secondary">Web Server Logs</span>
                </div>
                <div class="card-body log-table-wrapper p-0">
                    <table class="table table-sm table-striped table-hover mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th style="width: 25%;">Time</th>
                            <th style="width: 15%;">Level</th>
                            <th style="width: 60%;">Message</th>
                        </tr>
                        </thead>
                        <tbody id="apacheLogsBody">
                        <!-- filled by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

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
            span.classList.add('badge', 'text-dark', 'rounded-pill', 'fw-semibold', 'small');

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

        // If none, show a friendly empty state row
        if (events.length === 0) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 2;
            td.classList.add('text-muted', 'small');
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
            legend: { position: 'bottom', textStyle: { color: '#e5e7eb' } },
            backgroundColor: '#020617',
            chartArea: {
                left: 60, top: 10, right: 20, bottom: 50
            },
            hAxis: {
                textStyle: { color: '#9ca3af' },
                gridlines: { color: '#1f2933' }
            },
            vAxis: {
                title: 'Requests',
                titleTextStyle: { color: '#9ca3af' },
                textStyle: { color: '#9ca3af' },
                gridlines: { color: '#1f2933' },
                minValue: 0
            },
            series: {
                0: { curveType: 'function' }
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
