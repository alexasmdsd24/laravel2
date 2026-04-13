@extends('layout')

@section('content')
@php
    $items = $order['items'];
    $count = collect($items)->sum(fn ($item) => $item['qty']);
@endphp

<style>
.receipt-shell {
    padding: 4rem 0 5rem;
}

.receipt-card {
    max-width: 720px;
    margin: 0 auto;
    background: #fff;
    border-radius: 32px;
    box-shadow: 0 40px 90px rgba(0,0,0,0.12);
    overflow: hidden;
    animation: fadeIn 0.5s ease;
}

.receipt-header {
    background: linear-gradient(135deg, rgba(255,60,125,0.95), rgba(255,125,0,0.95));
    color: #fff;
    padding: 2.5rem;
    text-align: center;
}

.receipt-body {
    padding: 2.5rem;
}

.receipt-row {
    display: flex;
    justify-content: space-between;
    padding: 0.8rem 0;
    border-bottom: 1px dashed rgba(0,0,0,0.08);
}

.receipt-row:last-child {
    border-bottom: none;
}

.receipt-row strong {
    font-size: 1rem;
}

.thankyou-panel {
    background: #fff6f0;
    padding: 2rem;
    text-align: center;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="container receipt-shell">
    <div class="receipt-card">
        <div class="receipt-header">
            <p class="mb-2 text-uppercase">Order Confirmed</p>
            <h1 class="fw-bold mb-3">{{ $order['reference'] }}</h1>
            <p class="mb-0">{{ $order['date'] }} • {{ $order['time'] }}</p>
        </div>
        <div class="receipt-body">
            <div class="mb-4">
                <h5 class="fw-bold">Pickup Details</h5>
                <p class="mb-1">{{ $order['customer']['customer_name'] }}</p>
                <small class="text-muted">{{ $order['customer']['email'] }} • {{ $order['customer']['phone'] }}</small><br>
                <small class="text-muted">Pickup at {{ $order['pickup_time'] }}</small>
            </div>

            @if(!empty($order['customer']['notes']))
            <div class="mb-4">
                <h6 class="fw-bold">Special Instructions</h6>
                <p class="mb-0">{{ $order['customer']['notes'] }}</p>
            </div>
            @endif

            <div class="mb-4">
                <h5 class="fw-bold">Order Items ({{ $count }})</h5>
                @foreach($items as $item)
                <div class="receipt-row">
                    <div>
                        <strong>{{ $item['name'] }}</strong>
                        <p class="mb-0 text-muted">Qty {{ $item['qty'] }}</p>
                    </div>
                    <span>₱{{ number_format($item['price'] * $item['qty'], 2) }}</span>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between mb-1 text-muted">
                <span>Payment Method</span>
                <span>{{ ucfirst($order['payment_method']) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-4 text-muted">
                <span>Order Placed</span>
                <span>{{ $order['placed_at'] }}</span>
            </div>
            <div class="d-flex justify-content-between fs-4 fw-bold">
                <span>Total</span>
                <span>₱{{ number_format($order['total'], 2) }}</span>
            </div>
        </div>
        <div class="thankyou-panel">
            <h4 class="fw-bold mb-2">Thank you!</h4>
            <p class="mb-0">Your Dunkin’ treats will be ready shortly. Present this receipt at pickup.</p>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
        <button class="btn btn-outline-secondary" onclick="window.print()">Print receipt</button>
        <a href="{{ route('menu') }}" class="btn btn-dunkin">Back to menu</a>
    </div>
</div>
@endsection
