@extends('control-deck.layout')

@section('title', 'HelioNET Control Deck — Dashboard')
@section('topbar-title', 'Server Dashboard')

@section('content')

    {{-- Top row --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- System Info --}}
        <section class="helios-card">
            <div class="helios-card-header-accent-line"></div>
            <div class="helios-card-header">
                <div class="helios-chip helios-chip--cyan">i</div>
                <h2 class="helios-card-header-title">System Information</h2>
            </div>
            <div class="helios-card-body space-y-3">
                <div>
                    <div class="helios-label">Hostname</div>
                    <div id="info-hostname" class="mt-0.5 font-mono text-[0.8rem] text-slate-100"></div>
                </div>
                <div>
                    <div class="helios-label">External IP</div>
                    <div id="info-external-ip" class="mt-0.5 font-mono text-[0.8rem] text-slate-100"></div>
                </div>
                <div>
                    <div class="helios-label">HelioNET App URL</div>
                    <div id="info-app-url" class="mt-0.5 font-mono text-[0.8rem] text-space-accent"></div>
                </div>
            </div>
        </section>

        {{-- Maintenance --}}
        <section class="helios-card">
            <div class="helios-card-header-accent-line"></div>
            <div class="helios-card-header">
                <div class="helios-chip helios-chip--purple">⚙</div>
                <h2 class="helios-card-header-title">Laravel Maintenance</h2>
            </div>
            <div class="helios-card-body space-y-3">
                <div>
                    <div class="helios-label mb-0.5">Status</div>
                    <div id="maintenance-status" class="font-semibold text-[0.85rem]"></div>
                </div>
                <div>
                    <button id="toggle-maintenance"
                            type="button"
                            class="inline-flex items-center px-3 py-1.5 text-[0.7rem] font-semibold uppercase tracking-[0.14em] bg-cyan-400 hover:bg-cyan-300 text-slate-950 rounded-md transition-colors">
                        Toggle Maintenance (UI only)
                    </button>
                </div>
                <p class="text-[0.65rem] text-slate-400 leading-snug">
                    Wire into HelioNET to call <code class="font-mono text-slate-200">php artisan up</code> /
                    <code class="font-mono text-slate-200">down</code>.
                </p>
            </div>
        </section>

        {{-- 48h summary --}}
        <section class="helios-card">
            <div class="helios-card-header-accent-line"></div>
            <div class="helios-card-header">
                <div class="helios-chip helios-chip--cyan">📈</div>
                <h2 class="helios-card-header-title">48h Request Summary</h2>
            </div>
            <div class="helios-card-body space-y-3">
                <div class="flex justify-between gap-4">
                    <div>
                        <div class="helios-label">Total Requests</div>
                        <div id="summary-total" class="mt-1 text-xl font-semibold text-slate-50"></div>
                    </div>
                    <div>
                        <div class="helios-label">Peak / hr</div>
                        <div id="summary-peak" class="mt-1 text-xl font-semibold text-slate-50"></div>
                    </div>
                    <div>
                        <div class="helios-label">Errors (sim)</div>
                        <div id="summary-errors" class="mt-1 text-xl font-semibold text-amber-300"></div>
                    </div>
                </div>
                <p class="text-[0.65rem] text-slate-400">
                    Simulated metrics. Replace with Apache / ingress data.
                </p>
            </div>
        </section>

    </div>

    {{-- Chart + HTTP status distribution --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Web Requests chart --}}
        <section class="helios-card lg:col-span-2">
            <div class="helios-card-header-accent-line"></div>
            <div class="helios-card-header">
                <div class="helios-chip helios-chip--cyan">▶</div>
                <h2 class="helios-card-header-title">Web Requests (Last 48 Hours)</h2>
            </div>
            <div class="helios-card-body">
                <div id="web_requests_chart" class="mb-2"></div>
                <p class="text-[0.65rem] text-slate-400">
                    Hourly request counts (mock data). Wire to your telemetry later.
                </p>
            </div>
        </section>

        {{-- HTTP Status distribution (unsuccessful codes) --}}
        <section class="helios-card">
            <div class="helios-card-header-accent-line"></div>
            <div class="helios-card-header">
                <div class="helios-chip helios-chip--red">◎</div>
                <h2 class="helios-card-header-title">HTTP Status Distribution (4xx/5xx)</h2>
            </div>
            <div class="helios-card-body">
                <div id="http_status_chart" class="mb-2"></div>
                <p class="text-[0.65rem] text-slate-400">
                    Counts of unsuccessful responses by status code (simulated).
                </p>
            </div>
        </section>

    </div>

    {{-- Recent logs --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- Recent Laravel logs --}}
        <section class="helios-card">
            <div class="helios-card-header-accent-line"></div>
            <div class="helios-card-header">
                <div class="helios-chip helios-chip--purple">L</div>
                <h2 class="helios-card-header-title">Recent Laravel Logs (Last 30 Events)</h2>
            </div>
            <div class="helios-card-body">
                <div class="helios-log-table-wrapper">
                    <table class="helios-log-table">
                        <thead>
                        <tr>
                            <th>Time</th>
                            <th>Level</th>
                            <th>Message</th>
                        </tr>
                        </thead>
                        <tbody id="laravel-logs-body"></tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Recent Apache logs --}}
        <section class="helios-card">
            <div class="helios-card-header-accent-line"></div>
            <div class="helios-card-header">
                <div class="helios-chip helios-chip--cyan">A</div>
                <h2 class="helios-card-header-title">Recent Apache Logs (Last 30 Events)</h2>
            </div>
            <div class="helios-card-body">
                <div class="helios-log-table-wrapper">
                    <table class="helios-log-table">
                        <thead>
                        <tr>
                            <th>Time</th>
                            <th>Level</th>
                            <th>Message</th>
                        </tr>
                        </thead>
                        <tbody id="apache-logs-body"></tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>

    {{-- Apache & Laravel errors (48h) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- Apache Errors (48h) --}}
        <section class="helios-card">
            <div class="helios-card-header-accent-line"></div>
            <div class="helios-card-header">
                <div class="helios-chip helios-chip--red">!</div>
                <h2 class="helios-card-header-title">Apache Errors (48h)</h2>
            </div>
            <div class="helios-card-body">
                <div class="helios-log-table-wrapper">
                    <table class="helios-log-table">
                        <thead>
                        <tr>
                            <th>Time</th>
                            <th>Level</th>
                            <th>Message</th>
                        </tr>
                        </thead>
                        <tbody id="apache-errors-48h-body"></tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Laravel Errors (48h) --}}
        <section class="helios-card">
            <div class="helios-card-header-accent-line"></div>
            <div class="helios-card-header">
                <div class="helios-chip helios-chip--red">!</div>
                <h2 class="helios-card-header-title">Laravel Errors (48h)</h2>
            </div>
            <div class="helios-card-body">
                <div class="helios-log-table-wrapper">
                    <table class="helios-log-table">
                        <thead>
                        <tr>
                            <th>Time</th>
                            <th>Level</th>
                            <th>Message</th>
                        </tr>
                        </thead>
                        <tbody id="laravel-errors-48h-body"></tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>

@endsection

@push('scripts')
<script>
    // Simulated system info
    const systemInfo = {
        hostname: "helios-core-01",
        externalIp: "203.0.113.42",
        appUrl: "https://helios.example.com"
    };

    const maintenance = { active: false };

    function generateWebRequestsData() {
        const now = new Date();
        const data = [];
        for (let i = 47; i >= 0; i--) {
            const d = new Date(now.getTime() - i * 60 * 60 * 1000);
            const label = d.getHours().toString().padStart(2, "0") + ":00";
            const count = 100 + Math.round(Math.random() * 400);
            data.push([label, count]);
        }
        return data;
    }

    const webRequestsData = generateWebRequestsData();

    const summary = (() => {
        const total = webRequestsData.reduce((s, r) => s + r[1], 0);
        const peak  = webRequestsData.reduce((m, r) => Math.max(m, r[1]), 0);
        const errors = Math.round(total * 0.02);
        return { total, peak, errors };
    })();

    function generateLogs(n, source) {
        const levels = ["INFO", "WARNING", "ERROR"];
        const now = new Date();
        const logs = [];
        for (let i = 0; i < n; i++) {
            const minutesAgo = i * 5;
            const d = new Date(now.getTime() - minutesAgo * 60 * 1000);
            const level = levels[Math.floor(Math.random() * levels.length)];
            logs.push({
                timestamp: d.toISOString().replace("T", " ").substring(0, 19),
                level,
                message: `${source} log event #${i + 1} (${level})`
            });
        }
        return logs;
    }

    const laravelLogsRecent = generateLogs(30, "Laravel");
    const apacheLogsRecent  = generateLogs(30, "Apache");

    const laravelErrors48h = laravelLogsRecent.filter(x => x.level === "ERROR").slice(0, 10);
    const apacheErrors48h  = apacheLogsRecent.filter(x => x.level === "ERROR").slice(0, 10);

    const httpStatusCounts = [
        ["Status", "Count"],
        ["400", 18],
        ["401", 7],
        ["403", 12],
        ["404", 35],
        ["500", 9],
        ["502", 6],
        ["503", 4]
    ];

    function setSystemInfo() {
        document.getElementById("info-hostname").textContent   = systemInfo.hostname;
        document.getElementById("info-external-ip").textContent = systemInfo.externalIp;
        document.getElementById("info-app-url").textContent     = systemInfo.appUrl;
    }

    function setMaintenanceStatus() {
        const el = document.getElementById("maintenance-status");
        if (maintenance.active) {
            el.textContent = "Maintenance Mode ACTIVE";
            el.className = "font-semibold text-amber-300 text-[0.85rem]";
        } else {
            el.textContent = "Maintenance Mode INACTIVE";
            el.className = "font-semibold text-emerald-300 text-[0.85rem]";
        }
    }

    function setSummaryStats() {
        document.getElementById("summary-total").textContent  = summary.total.toLocaleString();
        document.getElementById("summary-peak").textContent   = summary.peak.toLocaleString();
        document.getElementById("summary-errors").textContent = summary.errors.toLocaleString();
    }

    function renderLogRows(rows, tbodyId) {
        const tbody = document.getElementById(tbodyId);
        tbody.innerHTML = "";
        rows.forEach(r => {
            const tr = document.createElement("tr");

            const tdT = document.createElement("td");
            tdT.className = "py-1 pr-2 align-top whitespace-nowrap";
            tdT.textContent = r.timestamp;

            const tdL = document.createElement("td");
            tdL.className = "py-1 pr-2 align-top whitespace-nowrap";
            tdL.textContent = r.level;
            if (r.level === "INFO") tdL.classList.add("log-level-info");
            if (r.level === "WARNING") tdL.classList.add("log-level-warning");
            if (r.level === "ERROR") tdL.classList.add("log-level-error");

            const tdM = document.createElement("td");
            tdM.className = "py-1 align-top";
            tdM.textContent = r.message;

            tr.appendChild(tdT);
            tr.appendChild(tdL);
            tr.appendChild(tdM);
            tbody.appendChild(tr);
        });
    }

    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        drawWebRequestsChart();
        drawHttpStatusChart();
    }

    function drawWebRequestsChart() {
        const dt = new google.visualization.DataTable();
        dt.addColumn("string", "Hour");
        dt.addColumn("number", "Requests");
        dt.addRows(webRequestsData);

        const options = {
            backgroundColor: "transparent",
            legend: { position: "none" },
            hAxis: {
                textStyle: { color: "#E5E7EB", fontSize: 10 },
                slantedText: true,
                slantedTextAngle: 60
            },
            vAxis: {
                minValue: 0,
                textStyle: { color: "#E5E7EB" },
                gridlines: { color: "#1E293B" }
            },
            chartArea: {
                left: 50,
                top: 20,
                width: "80%",
                height: "70%"
            },
            colors: ["#38bdf8"]
        };

        const chart = new google.visualization.AreaChart(
            document.getElementById("web_requests_chart")
        );
        chart.draw(dt, options);
    }

    function drawHttpStatusChart() {
        const data = google.visualization.arrayToDataTable(httpStatusCounts);

        const options = {
            backgroundColor: "transparent",
            legend: { position: "none" },
            hAxis: {
                textStyle: { color: "#E5E7EB", fontSize: 10 }
            },
            vAxis: {
                minValue: 0,
                textStyle: { color: "#E5E7EB" },
                gridlines: { color: "#1E293B" }
            },
            chartArea: {
                left: 50,
                top: 20,
                width: "80%",
                height: "65%"
            },
            colors: ["#f97373"]
        };

        const chart = new google.visualization.ColumnChart(
            document.getElementById("http_status_chart")
        );
        chart.draw(data, options);
    }

    document.addEventListener("DOMContentLoaded", () => {
        setSystemInfo();
        setMaintenanceStatus();
        setSummaryStats();

        renderLogRows(laravelLogsRecent, "laravel-logs-body");
        renderLogRows(apacheLogsRecent,  "apache-logs-body");
        renderLogRows(laravelErrors48h,  "laravel-errors-48h-body");
        renderLogRows(apacheErrors48h,   "apache-errors-48h-body");

        const toggleBtn = document.getElementById("toggle-maintenance");
        if (toggleBtn) {
            toggleBtn.addEventListener("click", () => {
                maintenance.active = !maintenance.active;
                setMaintenanceStatus();

                if (maintenance.active) {
                    heliosShowToast({
                        title: "Maintenance Enabled",
                        message: "Laravel maintenance mode is now ACTIVE (UI only).",
                        type: "warning",
                        duration: 4500
                    });
                } else {
                    heliosShowToast({
                        title: "Maintenance Disabled",
                        message: "Laravel maintenance mode is now INACTIVE (UI only).",
                        type: "success",
                        duration: 3500
                    });
                }
            });
        }

        // Welcome toast
        heliosShowToast({
            title: "HelioNET Control Deck",
            message: "Dashboard loaded with simulated metrics. Wire up real data when ready.",
            type: "info",
            duration: 5000
        });

        window.addEventListener("resize", () => {
            drawCharts();
        });
    });
</script>
@endpush
