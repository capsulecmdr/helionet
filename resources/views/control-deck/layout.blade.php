<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'HelioNET Control Deck')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HelioNET Control Deck theme -->
    <link rel="stylesheet" href="{{ asset('css/control-deck.css') }}">

    <!-- Tailwind (utility layout only) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Charts (used on Dashboard) -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    @stack('head')
</head>
<body>

<div class="helios-shell">
    @include('control-deck.partials.sidebar')

    <div class="helios-main">
        @include('control-deck.partials.topbar')

        <main class="flex-1 overflow-auto p-4">
            <div class="max-w-7xl mx-auto space-y-4">
                @yield('content')
            </div>
        </main>
    </div>
</div>

<!-- Toast root -->
<div id="helios-toast-root" class="helios-toast-container"></div>

<script>
    // =====================
    // Helios Toast Helpers
    // =====================
    let heliosToastId = 0;

    function heliosShowToast(options) {
        const {
            title = "Notice",
            message = "",
            type = "info",      // "info" | "success" | "warning" | "error"
            duration = 4000     // ms
        } = options || {};

        const container = document.getElementById("helios-toast-root");
        if (!container) return;

        const id = `helios-toast-${++heliosToastId}`;
        const toast = document.createElement("div");
        toast.id = id;

        const typeClass = `helios-toast--${type}`;

        // choose icon by type
        let icon = "ℹ";
        if (type === "success") icon = "✔";
        if (type === "warning") icon = "⚠";
        if (type === "error")   icon = "⨯";

        toast.className = `helios-toast ${typeClass}`;
        toast.innerHTML = `
          <div class="helios-toast-icon">${icon}</div>
          <div class="helios-toast-content">
            <div class="helios-toast-title">${title}</div>
            <div class="helios-toast-message">${message}</div>
          </div>
          <button class="helios-toast-close" aria-label="Dismiss toast">✕</button>
          <div class="helios-toast-progress"></div>
        `;

        // Close button
        toast.querySelector(".helios-toast-close").addEventListener("click", () => {
            heliosDismissToast(toast);
        });

        // Add to container (newest at top)
        container.prepend(toast);

        // Progress bar animation
        const progress = toast.querySelector(".helios-toast-progress");
        if (progress) {
            progress.style.transition = `transform ${duration}ms linear`;
            requestAnimationFrame(() => {
                progress.style.transform = "scaleX(0)";
            });
        }

        // Auto-dismiss
        if (duration > 0) {
            setTimeout(() => {
                heliosDismissToast(toast);
            }, duration);
        }

        return id;
    }

    function heliosDismissToast(toastEl) {
        if (!toastEl) return;
        toastEl.style.animation = "helios-toast-out 0.18s ease-in forwards";
        setTimeout(() => {
            if (toastEl && toastEl.parentNode) {
                toastEl.parentNode.removeChild(toastEl);
            }
        }, 200);
    }

    // Sidebar toggle wired globally for Control Deck
    document.addEventListener("DOMContentLoaded", () => {
        const toggle = document.getElementById("sidebarToggle");
        const sidebar = document.getElementById("helios-sidebar");

        if (toggle && sidebar) {
            toggle.addEventListener("click", (e) => {
                e.preventDefault();
                sidebar.classList.toggle("helios-sidebar-hidden");
            });
        }
    });
</script>

@stack('scripts')
</body>
</html>
