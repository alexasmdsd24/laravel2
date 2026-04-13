@extends('layout')

@section('content')

@php
    $isEmpty = empty($cart);
    $itemCount = collect($cart)->sum(fn ($item) => $item['qty']);
@endphp

<style>
.cart-shell {
    padding: 3rem 0;
}

.cart-hero {
    border-radius: 32px;
    background: linear-gradient(135deg, rgba(255,125,0,0.9), rgba(255,60,125,0.9));
    color: #fff;
    padding: 2.5rem;
    box-shadow: 0 30px 80px rgba(255,92,116,0.35);
}

.cart-card {
    border-radius: 24px;
    border: none;
    box-shadow: 0 25px 60px rgba(0,0,0,0.08);
}

.cart-item {
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1.3rem 0;
}

.cart-item:last-child {
    border-bottom: none;
}

.cart-summary {
    position: sticky;
    top: 110px;
}

.hero-progress {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
}

.progress-pill {
    padding: 0.35rem 1.25rem;
    border-radius: 999px;
    background: rgba(255,255,255,0.18);
    color: #fff;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.progress-pill.active {
    background: #fff;
    color: var(--dunkin-orange);
}

.progress-line {
    width: 45px;
    height: 3px;
    background: rgba(255,255,255,0.4);
    border-radius: 999px;
}

.qty-control {
    display: inline-flex;
    align-items: center;
    gap: 0.7rem;
    border: 1px solid rgba(0,0,0,0.08);
    border-radius: 999px;
    padding: 6px 14px;
}

.qty-control button {
    border: none;
    background: transparent;
    font-size: 1.2rem;
    color: var(--dunkin-orange);
    font-weight: 700;
}

.empty-card {
    border-radius: 24px;
    border: 2px dashed rgba(0,0,0,0.08);
    padding: 3rem 1rem;
}
</style>

<div class="container cart-shell">
    <div class="cart-hero mb-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-8">
                <div class="hero-progress mb-3">
                    <span class="progress-pill active">Review Cart</span>
                    <span class="progress-line"></span>
                    <span class="progress-pill text-white-50">Checkout</span>
                </div>
                <h2 class="fw-bold mt-3">Ready to serve smiles</h2>
                <p class="mb-0">Adjust quantities, remove items, or keep hunting for treats before you checkout.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('menu') }}" class="btn btn-light btn-lg">Add more items</a>
            </div>
        </div>
    </div>

    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

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
        <div class="col-lg-8">
            <div class="card cart-card">
                <div class="card-body">
                    @forelse($cart as $item)
                    <div class="cart-item d-flex flex-wrap gap-3 align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $item['name'] }}</h5>
                            <small class="text-muted">₱{{ number_format($item['price'], 2) }} each</small>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-flex align-items-center gap-2" data-auto-submit>
                                @csrf
                                @method('PATCH')
                                <div class="qty-control">
                                    <button type="button" class="qty-btn" data-direction="down">-</button>
                                    <input type="number" name="qty" min="1" value="{{ $item['qty'] }}" class="form-control form-control-sm border-0 text-center" style="width: 60px;">
                                    <button type="button" class="qty-btn" data-direction="up">+</button>
                                </div>
                            </form>
                            <div class="text-end">
                                <strong>₱{{ number_format($item['price'] * $item['qty'], 2) }}</strong>
                                <form action="{{ route('cart.destroy', $item['id']) }}" method="POST" class="mt-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-card text-center">
                        <h5 class="fw-bold mb-2">Nothing here yet</h5>
                        <p class="text-muted mb-4">Tap the button below and bring donuts into your life.</p>
                        <a href="{{ route('menu') }}" class="btn btn-dunkin">Browse Menu</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card cart-card cart-summary">
                <div class="card-body">
                    <h5 class="mb-3">Order summary</h5>
                    <div class="d-flex justify-content-between text-muted">
                        <span>Items</span>
                        <span>{{ $itemCount }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span>Total</span>
                        <span class="fs-4 fw-bold">₱{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-grid gap-2">
                        @auth
                            <a href="{{ route('checkout') }}" class="btn btn-dunkin @if($isEmpty) disabled @endif" @if($isEmpty) aria-disabled="true" @endif>Proceed to checkout</a>
                        @else
                            <div class="alert alert-info mb-3" role="alert">
                                <small><strong>Login required!</strong> Sign in or create an account to checkout.</small>
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-dunkin">Sign In to Checkout</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-dunkin">Create Account</a>
                        @endauth
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100" @if($isEmpty) disabled @endif>Clear cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-auto-submit]').forEach(form => {
        const qtyInput = form.querySelector('input[name="qty"]');
        const clampValue = () => {
            const current = parseInt(qtyInput.value, 10);
            if (isNaN(current) || current < 1) {
                qtyInput.value = 1;
            }
        };
        form.querySelectorAll('.qty-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const direction = btn.dataset.direction;
                if (direction === 'down') {
                    qtyInput.stepDown();
                } else {
                    qtyInput.stepUp();
                }
                clampValue();
                form.requestSubmit();
            });
        });
        qtyInput.addEventListener('change', () => {
            clampValue();
            form.requestSubmit();
        });
    });
});
</script>
@endpush

@endsection