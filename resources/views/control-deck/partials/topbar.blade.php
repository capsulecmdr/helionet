<header class="helios-topbar">
    <div class="flex items-center gap-3">
        <div class="w-1 h-7 bg-gradient-to-b from-cyan-400 to-fuchsia-500 rounded-full"></div>
        <div>
            <div class="text-xs uppercase tracking-[0.22em] text-slate-400">
                Control Deck
            </div>
            <div class="text-sm font-semibold text-slate-100">
                @yield('topbar-title', 'Server Dashboard')
            </div>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <button id="sidebarToggle"
                class="inline-flex items-center gap-1 px-3 py-1.5 text-[0.65rem] font-semibold uppercase tracking-[0.18em] border border-slate-700 bg-slate-900/70 hover:bg-slate-800 transition-colors">
            <span class="text-lg leading-none">☰</span>
            <span class="hidden sm:inline">Sidebar</span>
        </button>
        <div class="flex items-center gap-2 text-xs text-slate-300">
            <div class="relative">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-fuchsia-500 to-cyan-400 flex items-center justify-center text-slate-950 font-bold">
                    A
                </div>
                <div class="absolute -inset-0.5 rounded-full blur-md bg-cyan-400/40 -z-10 opacity-40"></div>
            </div>
            <div class="leading-none">
                <div class="font-medium">
                    {{ auth()->user()->name ?? 'admin' }}
                </div>
                <div class="text-[0.6rem] text-slate-400">
                    HelioNET Operator
                </div>
            </div>
        </div>
    </div>
</header>
