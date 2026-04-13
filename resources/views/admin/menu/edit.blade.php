@extends('admin.admin-layout')

@section('page-title', 'Edit Menu Item')

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit"></i> Edit Menu Item
            </div>
            <div class="card-body">
                <form action="{{ route('admin.menu.update', $id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Item Name *</label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            placeholder="e.g., Choco Marble Donut"
                            value="{{ old('name', $item['name']) }}"
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
                                value="{{ old('price', $item['price']) }}"
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
                                    <option value="{{ $category }}" {{ old('category', $item['category']) === $category ? 'selected' : '' }}>
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
                            value="{{ old('img', $item['img']) }}"
                            required
                        >
                        <small class="text-muted">Image should be placed in public/images/</small>
                        @error('img')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-dunkin">
                            <i class="fas fa-save"></i> Update Item
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
                <i class="fas fa-info-circle"></i> Current Item
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $item['name'] }}</p>
                <p><strong>Category:</strong> {{ ucfirst($item['category']) }}</p>
                <p><strong>Price:</strong> ₱{{ number_format($item['price'], 2) }}</p>
                <p><strong>Image:</strong> {{ $item['img'] }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-danger">
                <i class="fas fa-trash"></i> Delete Item
            </div>
            <div class="card-body">
                <p><small>Click the button below to delete this item permanently.</small></p>
                <form action="{{ route('admin.menu.destroy', $id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this item?')">
                        <i class="fas fa-trash"></i> Delete Item
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
