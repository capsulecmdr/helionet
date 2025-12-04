<aside id="helios-sidebar" class="helios-sidebar">
    <!-- Brand -->
    <div class="flex items-center mb-8 gap-3">
        <div class="helios-logo-wrap">
            <img src="{{ asset('Logo_I_rnd.png') }}"
                 alt="HelioNET logo"
                 class="helios-logo-img">
        </div>
        <div class="leading-tight">
            <div class="text-sm font-semibold tracking-wide text-slate-100">
                HelioNET
            </div>
            <div class="text-[0.65rem] uppercase tracking-[0.16em] text-slate-400">
                Server Platform
            </div>
        </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1">
        <ul class="space-y-1 text-xs">
            <li>
                <a href="{{ route('control-deck.dashboard') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg
                          {{ request()->routeIs('control-deck.dashboard') 
                                ? 'bg-cyan-400/90 text-slate-950 font-semibold tracking-wide shadow-lg shadow-cyan-500/30'
                                : 'hover:bg-slate-800/70 transition-colors' }}">
                    <span class="text-base leading-none">▤</span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('control-deck.users') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg
                          {{ request()->routeIs('control-deck.users') 
                                ? 'bg-cyan-400/90 text-slate-950 font-semibold tracking-wide shadow-lg shadow-cyan-500/30'
                                : 'hover:bg-slate-800/70 transition-colors' }}">
                    <span class="text-base leading-none">🛰</span>
                    <span>Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('control-deck.plugins') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg
                          {{ request()->routeIs('control-deck.plugins') 
                                ? 'bg-cyan-400/90 text-slate-950 font-semibold tracking-wide shadow-lg shadow-cyan-500/30'
                                : 'hover:bg-slate-800/70 transition-colors' }}">
                    <span class="text-base leading-none">📡</span>
                    <span>Plugins</span>
                </a>
            </li>
            <li>
                <a href="{{ route('control-deck.settings') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg
                          {{ request()->routeIs('control-deck.settings') 
                                ? 'bg-cyan-400/90 text-slate-950 font-semibold tracking-wide shadow-lg shadow-cyan-500/30'
                                : 'hover:bg-slate-800/70 transition-colors' }}">
                    <span class="text-base leading-none">⚙</span>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar footer -->
    <div class="mt-6 text-[0.65rem] text-slate-500 uppercase tracking-[0.16em]">
        HelioNET Platform<br>
        Control Deck
    </div>
</aside>
