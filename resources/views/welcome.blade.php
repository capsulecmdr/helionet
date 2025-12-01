{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard | Helionet')

@section('page-header')
    <div class="hl-page-title">
        <h1>Dashboard</h1>
        <p class="hl-page-subtitle">
            High-level overview of your Helionet instance.
        </p>
    </div>
@endsection

@push('page-actions')
    <button class="hl-btn hl-btn-primary">
        Refresh
    </button>
@endpush

@section('content')
    <div class="hl-grid hl-grid-2">
        <x-card title="Cluster Status">
            Cluster health, workers, queues…
        </x-card>

        <x-card title="Recent Activity">
            Logs, admin events, plugin events…
        </x-card>
    </div>
@endsection
