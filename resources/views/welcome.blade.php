<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Helios Server Management Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Adminator CSS bundle (includes Bootstrap, icons, etc.) -->
    <!-- Adjust the path to match your Adminator installation -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Google Charts -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <style>
        /* --- Small overrides for our dashboard --- */

        /* Give the main content a bit of padding like Adminator demos */
        .main-content {
            padding: 24px;
        }

        /* Scrollable log table areas */
        .log-table-wrapper {
            max-height: 230px;
            overflow-y: auto;
        }

        /* Sticky headers inside scrollable log tables */
        .log-table-wrapper table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #f5f6f7; /* Adminator light gray */
            box-shadow: 0 1px 0 rgba(209, 213, 219, 0.9);
        }

        /* Badge coloring for log levels, using Adminator-ish palette */
        .badge-level-info {
            background-color: #17a2b8;
            color: #fff;
        }
        .badge-level-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-level-error {
            background-color: #dc3545;
            color: #fff;
        }

        .maintenance-active {
            color: #ffc107;
            font-weight: 600;
        }
        .maintenance-inactive {
            color: #28a745;
            font-weight: 600;
        }

        /* Make tables a bit compact */
        table.table {
            font-size: 12px;
        }

        .table thead {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        /* Web requests chart size */
        #requestsChart {
            width: 100%;
            height: 320px;
        }
    </style>
</head>
<body class="app">

<!-- =============== Sidebar =============== -->
<div class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <div class="peers ai-c fxw-nw">
                <div class="peer peer-greed">
                    <a class="sidebar-link td-n" href="#">
                        <div class="peers ai-c fxw-nw">
                            <div class="peer">
                                <div class="logo p-10">
                                    <span class="fsz-sm fw-600 c-white">HE</span>
                                </div>
                            </div>
                            <div class="peer peer-greed">
                                <h5 class="lh-1 mB-0 text-white">Helios</h5>
                                <small class="c-light">Server Portal</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <ul class="sidebar-menu scrollable pos-r">
            <li class="nav-item mT-30">
                <a class="sidebar-link active" href="#">
                    <span class="icon-holder">
                        <i class="c-blue-500 ti-home"></i>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="sidebar-link" href="#">
                    <span class="icon-holder">
                        <i class="c-deep-purple-500 ti-server"></i>
                    </span>
                    <span class="title">Servers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="sidebar-link" href="#">
                    <span class="icon-holder">
                        <i class="c-amber-500 ti-notepad"></i>
                    </span>
                    <span class="title">Logs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="sidebar-link" href="#">
                    <span class="icon-holder">
                        <i class="c-red-500 ti-settings"></i>
                    </span>
                    <span class="title">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- =============== Page Container =============== -->
<div class="page-container">

    <!-- Top navbar -->
    <div class="header navbar">
        <div class="header-container">
            <ul class="nav-left">
                <li>
                    <a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);">
                        <i class="ti-menu"></i>
                    </a>
                </li>
                <li class="search-box">
                    <a class="search-toggle no-pdd-right" href="javascript:void(0);">
                        <i class="search-icon ti-search pdd-right-10"></i>
                        <i class="search-icon-close ti-close pdd-right-10"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-right">
                <li class="notifications dropdown">
                    <span class="badge badge-pill badge-danger">3</span>
                    <a href="#" class="dropdown-toggle no-after" data-toggle="dropdown">
                        <i class="ti-bell"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
                        <div class="peer mR-10">
                            <img class="w-2r bdrs-50p" src="https://via.placeholder.com/40" alt="">
                        </div>
                        <div class="peer">
                            <span class="fsz-sm c-grey-900">Admin</span>
                            <br>
                            <small class="fsz-xs c-grey-600">Helios Operator</small>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main content -->
    <main class="main-content bgc-grey-100">
        <div id="mainContent">
            <div class="row gap-20 masonry pos-r">

                <!-- Top row: system info, maintenance, quick stats -->
                <div class="masonry-sizer col-md-6 col-lg-4"></div>

                <!-- System Information -->
                <div class="masonry-item col-md-6 col-lg-4">
                    <div class="bd bgc-white p-20 mB-20">
                        <div class="peers ai-c jc-sb mB-10">
                            <div class="peer">
                                <h5 class="lh-1 mB-5">System Information</h5>
                                <small class="c-grey-600">Host and platform details</small>
                            </div>
                            <div class="peer">
                                <span class="badge badge-primary">Host</span>
                            </div>
                        </div>
                        <dl class="row mB-15">
                            <dt class="col-5 c-grey-600 fsz-sm">Hostname</dt>
                            <dd class="col-7 fsz-sm" id="hostnameValue">—</dd>

                            <dt class="col-5 c-grey-600 fsz-sm">External IP</dt>
                            <dd class="col-7 fsz-sm" id="externalIpValue">—</dd>

                            <dt class="col-5 c-grey-600 fsz-sm">Helios App URL</dt>
                            <dd class="col-7 fsz-sm">
                                <a href="#" id="appUrlValue">—</a>
                            </dd>
                        </dl>
                        <small class="c-grey-600">
                            Values are currently generated; later, wire them to your backend configuration.
                        </small>
                    </div>
                </div>

                <!-- Maintenance status -->
                <div class="masonry-item col-md-6 col-lg-4">
                    <div class="bd bgc-white p-20 mB-20">
                        <div class="peers ai-c jc-sb mB-10">
                            <div class="peer">
                                <h5 class="lh-1 mB-5">Maintenance Mode</h5>
                                <small class="c-grey-600">Laravel application state</small>
                            </div>
                            <div class="peer">
                                <span class="badge badge-info">Application</span>
                            </div>
                        </div>
                        <div class="mB-15">
                            <p class="mB-5 c-grey-600 fsz-sm">Current status</p>
                            <h5 id="maintenanceStatusLabel" class="maintenance-inactive mB-5">
                                Maintenance mode: Inactive
                            </h5>
                            <p class="mB-0 fsz-sm">
                                <span class="c-grey-600">Last check:&nbsp;</span>
                                <span id="maintenanceLastChecked">—</span>
                            </p>
                        </div>
                        <div>
                            <button
                                class="btn btn-outline-warning btn-sm mR-10"
                                id="maintenanceToggleBtn"
                                type="button"
                            >
                                Toggle Maintenance (placeholder)
                            </button>
                            <small class="c-grey-600 d-block mT-10 fsz-xs">
                                This only updates the UI. Later, connect to an endpoint that runs
                                <code>php artisan down</code>/<code>up</code>.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Quick request stats -->
                <div class="masonry-item col-md-6 col-lg-4">
                    <div class="bd bgc-white p-20 mB-20">
                        <div class="peers ai-c jc-sb mB-10">
                            <div class="peer">
                                <h5 class="lh-1 mB-5">Request Summary (48h)</h5>
                                <small class="c-grey-600">Traffic snapshot</small>
                            </div>
                            <div class="peer">
                                <span class="badge badge-success">Traffic</span>
                            </div>
                        </div>
                        <div class="row mB-10">
                            <div class="col-4">
                                <div class="bdT bdB bdR p-10 ta-c">
                                    <div class="c-grey-600 fsz-xs">Total</div>
                                    <div class="fw-600 fsz-md" id="statTotalRequests">—</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bdT bdB p-10 ta-c">
                                    <div class="c-grey-600 fsz-xs">Avg / hr</div>
                                    <div class="fw-600 fsz-md" id="statAvgRequests">—</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bdT bdB bdL p-10 ta-c">
                                    <div class="c-grey-600 fsz-xs">Peak / hr</div>
                                    <div class="fw-600 fsz-md" id="statPeakRequests">—</div>
                                </div>
                            </div>
                        </div>
                        <small class="c-grey-600 fsz-xs">
                            Stats are computed from the same dataset that drives the 48-hour web request chart.
                        </small>
                    </div>
                </div>

                <!-- Web Requests Chart -->
                <div class="masonry-item col-md-12 col-lg-8">
                    <div class="bd bgc-white p-20 mB-20">
                        <div class="peers ai-c jc-sb mB-10">
                            <div class="peer">
                                <h5 class="lh-1 mB-5">Web Server Requests (Last 48 Hours)</h5>
                                <small class="c-grey-600">Demo data for now</small>
                            </div>
                            <div class="peer">
                                <span class="badge badge-primary">Chart</span>
                            </div>
                        </div>
                        <div id="requestsChart"></div>
                        <small class="c-grey-600 fsz-xs">
                            Later, hook this to real Apache or reverse-proxy stats.
                        </small>
                    </div>
                </div>

                <!-- Error panels (Laravel / Apache) -->
                <div class="masonry-item col-md-12 col-lg-4">
                    <!-- Laravel errors -->
                    <div class="bd bgc-white p-20 mB-20">
                        <div class="peers ai-c jc-sb mB-10">
                            <div class="peer">
                                <h5 class="lh-1 mB-5">Laravel Error Events</h5>
                                <small class="c-grey-600">Last 48 hours</small>
                            </div>
                            <div class="peer">
                                <span class="badge badge-danger">Errors</span>
                            </div>
                        </div>
                        <div class="log-table-wrapper">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th style="width:40%;">Time</th>
                                    <th style="width:60%;">Message</th>
                                </tr>
                                </thead>
                                <tbody id="laravelErrorsBody">
                                <!-- JS fills -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Apache errors -->
                    <div class="bd bgc-white p-20 mB-20">
                        <div class="peers ai-c jc-sb mB-10">
                            <div class="peer">
                                <h5 class="lh-1 mB-5">Apache Error Events</h5>
                                <small class="c-grey-600">Last 48 hours</small>
                            </div>
                            <div class="peer">
                                <span class="badge badge-danger">Errors</span>
                            </div>
                        </div>
                        <div class="log-table-wrapper">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th style="width:40%;">Time</th>
                                    <th style="width:60%;">Message</th>
                                </tr>
                                </thead>
                                <tbody id="apacheErrorsBody">
                                <!-- JS fills -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Bottom row: full recent logs -->
                <div class="masonry-item col-md-12 col-lg-6">
                    <div class="bd bgc-white p-20 mB-20">
                        <div class="peers ai-c jc-sb mB-10">
                            <div class="peer">
                                <h5 class="lh-1 mB-5">Recent Laravel Logs</h5>
                                <small class="c-grey-600">Last ~30 events</small>
                            </div>
                            <div class="peer">
                                <span class="badge badge-secondary">App Logs</span>
                            </div>
                        </div>
                        <div class="log-table-wrapper">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th style="width:25%;">Time</th>
                                    <th style="width:15%;">Level</th>
                                    <th style="width:60%;">Message</th>
                                </tr>
                                </thead>
                                <tbody id="laravelLogsBody">
                                <!-- JS fills -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="masonry-item col-md-12 col-lg-6">
                    <div class="bd bgc-white p-20 mB-20">
                        <div class="peers ai-c jc-sb mB-10">
                            <div class="peer">
                                <h5 class="lh-1 mB-5">Recent Apache Logs</h5>
                                <small class="c-grey-600">Last ~30 events</small>
                            </div>
                            <div class="peer">
                                <span class="badge badge-secondary">Web Logs</span>
                            </div>
                        </div>
                        <div class="log-table-wrapper">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th style="width:25%;">Time</th>
                                    <th style="width:15%;">Level</th>
                                    <th style="width:60%;">Message</th>
                                </tr>
                                </thead>
                                <tbody id="apacheLogsBody">
                                <!-- JS fills -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div> <!-- /row -->
        </div>
    </main>
</div> <!-- /page-container -->

<!-- Adminator JS bundle (includes jQuery, Bootstrap, etc.) -->
<script src="assets/js/vendor.js"></script>
<script src="assets/js/app.js"></script>

<script>
    // -------------------------
    // Demo data generation (unchanged)
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
            if (ev.level === 'INFO')      span.classList.add('badge-level-info');
            else if (ev.level === 'WARNING') span.classList.add('badge-level-warning');
            else                           span.classList.add('badge-level-error');
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
            td.textContent = 'No error events found in the last 48 hours.';
            td.classList.add('c-grey-600', 'fsz-xs');
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

    // Google chart
    google.charts.load('current', {packages: ['corechart']});

    function drawRequestsChart() {
        const dataTable = new google.visualization.DataTable();
        dataTable.addColumn('datetime', 'Time');
        dataTable.addColumn('number', 'Requests');

        webRequestSeries.forEach(point => {
            dataTable.addRow([point.timestamp, point.count]);
        });

        const options = {
            legend: { position: 'bottom', textStyle: { color: '#6c757d' } },
            backgroundColor: 'transparent',
            chartArea: { left: 60, top: 10, right: 20, bottom: 50 },
            hAxis: {
                textStyle: { color: '#6c757d', fontSize: 10 },
                gridlines: { color: '#e9ecef' }
            },
            vAxis: {
                title: 'Requests',
                titleTextStyle: { color: '#6c757d', fontSize: 11 },
                textStyle: { color: '#6c757d', fontSize: 10 },
                gridlines: { color: '#e9ecef' },
                minValue: 0
            },
            series: {
                0: { curveType: 'function', color: '#17a2b8' }
            }
        };

        const chart = new google.visualization.LineChart(
            document.getElementById('requestsChart')
        );
        chart.draw(dataTable, options);
    }
    google.charts.setOnLoadCallback(drawRequestsChart);

    // Init
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
