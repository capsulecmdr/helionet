<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Helios Server Management Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Metro UI 5 (core + icons) -->
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/current/metro.css">
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/current/icons.css">

    <!-- Google Charts -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <style>
        body {
            background-color: #f5f5f5;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-content {
            flex: 1;
        }

        /* Log tables */
        .log-table-wrapper {
            max-height: 260px;
            overflow-y: auto;
        }

        .log-table-wrapper table {
            font-size: 12px;
            margin-bottom: 0;
        }

        .log-table-wrapper thead th {
            position: sticky;
            top: 0;
            z-index: 1;
            background: #f3f3f3;
        }

        /* Small scrollbar (optional) */
        .log-table-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .log-table-wrapper::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        /* Status colors */
        .maintenance-active {
            color: #f39c12;
            font-weight: 600;
        }
        .maintenance-inactive {
            color: #27ae60;
            font-weight: 600;
        }

        #requestsChart {
            width: 100%;
            height: 320px;
        }
    </style>
</head>
<body>

<div class="page-wrapper">

    <!-- Top App Bar (Metro UI) -->
    <div data-role="app-bar" data-expand="true">
        <a href="#" class="brand">
            <span class="caption">Helios</span>
        </a>

        <ul class="app-bar-menu">
            <li class="active"><a href="#">Dashboard</a></li>
            <li><a href="#">Servers</a></li>
            <li><a href="#">Logs</a></li>
            <li><a href="#">Settings</a></li>
        </ul>

        <div class="app-bar-item">
            <span class="mif-user"></span>
            <span class="ml-1">Admin</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="page-content">
        <div class="container mt-4 mb-4">
            <div class="grid">

                <!-- Top row: system info, maintenance, stats -->
                <div class="row mb-3">

                    <!-- System Information -->
                    <div class="cell-md-4 mb-2">
                        <div class="card">
                            <div class="card-header">
                                <span class="title">System Information</span>
                            </div>
                            <div class="card-content">
                                <table class="table compact">
                                    <tbody>
                                    <tr>
                                        <td>Hostname</td>
                                        <td id="hostnameValue">—</td>
                                    </tr>
                                    <tr>
                                        <td>External IP</td>
                                        <td id="externalIpValue">—</td>
                                    </tr>
                                    <tr>
                                        <td>Helios App URL</td>
                                        <td>
                                            <a href="#" id="appUrlValue">—</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="text-small fg-gray mt-2">
                                    All values are mocked; wire these to config/server APIs later.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Maintenance Mode -->
                    <div class="cell-md-4 mb-2">
                        <div class="card">
                            <div class="card-header">
                                <span class="title">Laravel Maintenance Mode</span>
                            </div>
                            <div class="card-content">
                                <div class="mb-2">
                                    <div class="text-small fg-gray">Current status</div>
                                    <div id="maintenanceStatusLabel" class="maintenance-inactive">
                                        Maintenance mode: Inactive
                                    </div>
                                </div>
                                <div class="mb-2 text-small">
                                    <span class="fg-gray">Last check:&nbsp;</span>
                                    <span id="maintenanceLastChecked">—</span>
                                </div>
                                <button class="button warning outline small" id="maintenanceToggleBtn" type="button">
                                    Toggle Maintenance (placeholder)
                                </button>
                                <div class="text-small fg-gray mt-2">
                                    This button only flips the UI. Later, call an endpoint that runs
                                    <code>php artisan down</code>/<code>up</code>.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Request Summary -->
                    <div class="cell-md-4 mb-2">
                        <div class="card">
                            <div class="card-header">
                                <span class="title">Request Summary (Last 48h)</span>
                            </div>
                            <div class="card-content">
                                <div class="grid">
                                    <div class="row">
                                        <div class="cell-4">
                                            <div class="border bd-default p-2 text-center">
                                                <div class="text-small fg-gray">Total</div>
                                                <div id="statTotalRequests" class="text-bold">—</div>
                                            </div>
                                        </div>
                                        <div class="cell-4">
                                            <div class="border bd-default p-2 text-center">
                                                <div class="text-small fg-gray">Avg / hr</div>
                                                <div id="statAvgRequests" class="text-bold">—</div>
                                            </div>
                                        </div>
                                        <div class="cell-4">
                                            <div class="border bd-default p-2 text-center">
                                                <div class="text-small fg-gray">Peak / hr</div>
                                                <div id="statPeakRequests" class="text-bold">—</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-small fg-gray mt-2">
                                    Stats are calculated from the same dataset used for the chart below.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Middle row: chart + error summaries -->
                <div class="row mb-3">

                    <!-- Web Requests Chart -->
                    <div class="cell-xl-8 mb-2">
                        <div class="card">
                            <div class="card-header">
                                <span class="title">Web Server Requests (Last 48 Hours)</span>
                            </div>
                            <div class="card-content">
                                <div id="requestsChart"></div>
                                <div class="text-small fg-gray mt-2">
                                    Later you can feed this from Apache / Nginx / proxy metrics or a Helios metric store.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Error Events (Laravel + Apache) -->
                    <div class="cell-xl-4 mb-2">
                        <div class="card mb-2">
                            <div class="card-header">
                                <span class="title">Laravel Error Events (48h)</span>
                            </div>
                            <div class="card-content p-0">
                                <div class="log-table-wrapper">
                                    <table class="table compact striped">
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
                            <div class="card-header">
                                <span class="title">Apache Error Events (48h)</span>
                            </div>
                            <div class="card-content p-0">
                                <div class="log-table-wrapper">
                                    <table class="table compact striped">
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

                <!-- Bottom row: detailed logs -->
                <div class="row">

                    <!-- Recent Laravel Logs -->
                    <div class="cell-xl-6 mb-2">
                        <div class="card">
                            <div class="card-header">
                                <span class="title">Recent Laravel Logs (~30 events)</span>
                            </div>
                            <div class="card-content p-0">
                                <div class="log-table-wrapper">
                                    <table class="table compact striped">
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

                    <!-- Recent Apache Logs -->
                    <div class="cell-xl-6 mb-2">
                        <div class="card">
                            <div class="card-header">
                                <span class="title">Recent Apache Logs (~30 events)</span>
                            </div>
                            <div class="card-content p-0">
                                <div class="log-table-wrapper">
                                    <table class="table compact striped">
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

            </div> <!-- /grid -->
        </div> <!-- /container -->
    </div> <!-- /page-content -->

</div> <!-- /page-wrapper -->

<!-- Metro UI JS -->
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

    // Web requests for last 48h
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
    // UI helpers
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
            tdLevel.textContent = ev.level;
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
            legend: { position: 'bottom' },
            backgroundColor: 'transparent',
            chartArea: { left: 60, top: 20, right: 16, bottom: 50 },
            hAxis: {
                textStyle: { fontSize: 10 },
                gridlines: { color: '#e5e5e5' }
            },
            vAxis: {
                title: 'Requests',
                titleTextStyle: { fontSize: 11 },
                textStyle: { fontSize: 10 },
                gridlines: { color: '#e5e5e5' },
                minValue: 0
            },
            series: {
                0: { curveType: 'function', color: '#2196f3' }
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
