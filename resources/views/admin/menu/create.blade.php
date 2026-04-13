@extends('admin.admin-layout')

@section('page-title', 'Create Menu Item')

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle"></i> Add New Menu Item
            </div>
            <div class="card-body">
                <form action="{{ route('admin.menu.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Item Name *</label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            placeholder="e.g., Choco Marble Donut"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price (₱) *</label>
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                max="9999.99"
                                class="form-control @error('price') is-invalid @enderror"
                                id="price"
                                name="price"
                                placeholder="0.00"
                                value="{{ old('price') }}"
                                required
                            >
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category *</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>
                                        {{ ucfirst($category) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="img" class="form-label">Image Filename *</label>
                        <input
                            type="text"
                            class="form-control @error('img') is-invalid @enderror"
                            id="img"
                            name="img"
                            placeholder="e.g., d1.png"
                            value="{{ old('img') }}"
                            required
                        >
                        <small class="text-muted">Image should be placed in public/images/</small>
                        @error('img')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dunkin">
                            <i class="fas fa-save"></i> Create Item
                        </button>
                        <a href="{{ route('admin.menu.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> Help
            </div>
            <div class="card-body">
                <p><strong>Categories:</strong></p>
                <ul>
                    <li><strong>Donuts</strong> - Donut products</li>
                    <li><strong>Beverages</strong> - Coffee & drinks</li>
                    <li><strong>Snacks</strong> - Quick snacks</li>
                    <li><strong>Bundles</strong> - Combo deals</li>
                </ul>
                <hr>
                <p><strong>Image Tips:</strong></p>
                <ul>
                    <li>Use existing image files</li>
                    <li>Store images in public/images/</li>
                    <li>Use PNG or JPG format</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
