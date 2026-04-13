@extends('admin.admin-layout')

@section('page-title', 'Dashboard')

@section('content')

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <div class="stat-number">{{ $menuCount }}</div>
            <div class="stat-label">Total Menu Items</div>
        </div>
    </div>

    @foreach(['donuts' => '🍩', 'beverages' => '☕', 'snacks' => '🍔', 'bundles' => '📦'] as $category => $emoji)
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number">{{ $stats[$category] ?? 0 }}</div>
                <div class="stat-label">{{ ucfirst($category) }}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clipboard-list"></i> Quick Actions
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.menu.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-eye"></i> View All Menu Items</span>
                        <span class="badge bg-dunkin rounded-pill">{{ $menuCount }}</span>
                    </a>
                    <a href="{{ route('admin.menu.create') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus-circle"></i> Add New Item
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> System Info
            </div>
            <div class="card-body">
                <p><strong>Menu Storage:</strong> JSON File (storage/app/menu.json)</p>
                <p><strong>Admin User:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Last Login:</strong> Just now</p>
            </div>
        </div>
    </div>
</div>

@endsection
