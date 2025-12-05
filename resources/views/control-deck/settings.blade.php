@extends('control-deck.layout')

@section('title', 'HelioNET Control Deck — Settings')
@section('topbar-title', 'Platform Settings')

@section('content')
    <section class="helios-card">
        <div class="helios-card-header-accent-line"></div>
        <div class="helios-card-header">
            <div class="helios-chip helios-chip--red">⚙</div>
            <h2 class="helios-card-header-title">Settings</h2>
        </div>
        <div class="helios-card-body space-y-3">
            <p class="text-[0.75rem] text-slate-300">
                Central configuration for the HelioNET server platform.
            </p>
            <p class="text-[0.7rem] text-slate-400">
                In future iterations this can expose app URL, logging targets, maintenance controls,
                and other platform-level options.
            </p>
        </div>
    </section>
@endsection
