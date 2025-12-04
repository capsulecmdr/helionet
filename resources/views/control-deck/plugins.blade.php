@extends('control-deck.layout')

@section('title', 'HelioNET Control Deck — Plugins')
@section('topbar-title', 'Plugin Management')

@section('content')
    <section class="helios-card">
        <div class="helios-card-header-accent-line"></div>
        <div class="helios-card-header">
            <div class="helios-chip helios-chip--cyan">📡</div>
            <h2 class="helios-card-header-title">Plugins</h2>
        </div>
        <div class="helios-card-body">
            <p class="text-[0.75rem] text-slate-300 mb-2">
                This panel will orchestrate HelioNET packages, status, and lifecycle.
            </p>
            <p class="text-[0.7rem] text-slate-400">
                Later we can surface the dynamic package loader state, install/uninstall actions,
                and health status for core / community / custom plugins.
            </p>
        </div>
    </section>
@endsection
