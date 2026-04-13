@extends('layout')

@section('content')
<style>
.checkout-shell {
    padding: 3rem 0 4rem;
}

.checkout-hero {
    border-radius: 32px;
    background: linear-gradient(120deg, rgba(255,60,125,0.95), rgba(255,125,0,0.95));
    padding: 3rem;
    color: #fff;
    box-shadow: 0 40px 80px rgba(255,90,121,0.35);
}

.timeline-step {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
}

.timeline-dot {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    background: rgba(255,255,255,0.25);
    color: #fff;
}

.timeline-step.active .timeline-dot {
    background: #fff;
    color: var(--dunkin-orange);
}

.checkout-card {
    border-radius: 28px;
    border: none;
    box-shadow: 0 30px 70px rgba(0,0,0,0.08);
}

.checkout-card form input,
.checkout-card form textarea {
    border-radius: 16px;
    border: 1px solid rgba(0,0,0,0.08);
    padding: 0.9rem 1rem;
}

.order-list div {
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.order-list div:last-child {
    border-bottom: none;
}
</style>

@php
    $itemCount = collect($cart)->sum(fn ($item) => $item['qty']);
@endphp

<div class="container checkout-shell">
    <div class="checkout-hero mb-4">
        <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between">
            <div>
                <div class="timeline-step text-white-50 mb-1">
                    <span class="timeline-dot">1</span>
                    Review Cart
                </div>
                <div class="timeline-step active mb-1">
                    <span class="timeline-dot">2</span>
                    Pickup Details
                </div>
                <div class="timeline-step text-white-50">
                    <span class="timeline-dot">3</span>
                    Receipt
                </div>
                <h2 class="fw-bold mt-3">Almost there!</h2>
                <p class="mb-0">Confirm your pickup details and we will craft your order fresh.</p>
            </div>
            <div class="text-end">
                <p class="mb-1 text-white-50">Items</p>
                <h1 class="display-4 fw-bold">{{ $itemCount }}</h1>
            </div>
        </div>
    </div>
<div class="container py-5">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card checkout-card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Order Items</h4>
                    @foreach ($cart as $item)
                    <div class="d-flex justify-content-between border-bottom py-3">
                        <div>
                            <strong>{{ $item['name'] }}</strong>
                            <p class="mb-0 text-muted">Qty: {{ $item['qty'] }}</p>
                        </div>
                        <span class="fw-bold">₱{{ number_format($item['price'] * $item['qty'], 2) }}</span>
                    </div>
                    @endforeach
                    <div class="d-flex justify-content-between pt-3">
                        <span class="text-muted">Total Items</span>
                        <span>{{ $itemCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Grand Total</span>
                        <span class="fw-bold">₱{{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card checkout-card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Pickup Details</h4>

                    <form action="{{ route('checkout.store') }}" method="POST" class="d-grid gap-3">
                        @csrf
                        <div>
                            <label class="form-label">Full Name</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="form-control" required>
                        </div>
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        </div>
                        <div>
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
                        </div>
                        <div>
                            <label class="form-label">Pickup Time</label>
                            <input type="time" name="pickup_time" value="{{ old('pickup_time') }}" class="form-control" required>
                        </div>
                        <div>
                            <label class="form-label">Notes (optional)</label>
                            <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-dunkin w-100">Place Order</button>
                        <a href="{{ route('cart') }}" class="btn btn-outline-secondary w-100">Back to Cart</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection