@extends('control-deck.layout')

@section('title', 'HelioNET Control Deck — Users')
@section('topbar-title', 'User Management')

@section('content')
    <section class="helios-card">
        <div class="helios-card-header-accent-line"></div>
        <div class="helios-card-header">
            <div class="helios-chip helios-chip--purple">🛰</div>
            <h2 class="helios-card-header-title">Users</h2>
        </div>
        <div class="helios-card-body">
            <p class="text-[0.75rem] text-slate-300 mb-2">
                This panel will manage HelioNET Control Deck operators, roles, and access.
            </p>
            <p class="text-[0.7rem] text-slate-400">
                For now this is a placeholder. Later we can list users, roles, and provide invite / revoke tooling.
            </p>
        </div>
    </section>
@endsection
