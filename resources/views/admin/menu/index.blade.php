@extends('admin.admin-layout')

@section('page-title', 'Manage Menu')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.menu.create') }}" class="btn btn-dunkin">
        <i class="fas fa-plus"></i> Add New Item
    </a>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Menu Items
    </div>
    <div class="card-body">
        @if(empty($items))
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 2rem; color: #ccc;"></i>
                <p class="mt-3 text-muted">No menu items yet. <a href="{{ route('admin.menu.create') }}">Create one</a></p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $index => $item)
                            <tr>
                                <td>
                                    <strong>{{ $item['name'] }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-category badge-{{ $item['category'] }}">
                                        {{ ucfirst($item['category']) }}
                                    </span>
                                </td>
                                <td>
                                    <strong>₱{{ number_format($item['price'], 2) }}</strong>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $item['img'] }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.menu.edit', $index) }}" class="btn btn-dunkin-outline">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.menu.destroy', $index) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
