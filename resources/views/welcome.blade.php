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
        
    </div>
@endsection
