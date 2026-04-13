@extends('layout')

@section('content')

@php
    $initialCart = session('cart', []);
    $initialCartItems = array_values($initialCart);
    $initialCartTotal = collect($initialCart)->sum(fn ($item) => $item['price'] * $item['qty']);
    $initialCartCount = collect($initialCart)->sum(fn ($item) => $item['qty']);
@endphp

<style>
.kiosk-hero {
    padding: 3rem 0 2rem;
}

.kiosk-hero h1 {
    font-family: 'Fredoka One', cursive;
    font-size: clamp(2.2rem, 4vw, 3.3rem);
    color: var(--dunkin-orange);
}

.kiosk-wrapper {
    min-height: calc(100vh - 160px);
}

.category-btn {
    border-radius: 999px;
    padding: 10px 22px;
    font-weight: 600;
    border: 2px solid var(--dunkin-orange);
    background: #fff;
    color: var(--dunkin-orange);
    transition: all 0.2s;
}

.category-btn.active,
.category-btn:hover {
    background: var(--dunkin-orange);
    color: #fff;
    box-shadow: 0 10px 20px rgba(255,60,125,0.2);
}


.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    gap: 1.5rem;
}

.menu-item {
    height: 100%;
}

.menu-item.is-hidden {
    display: none;
}

.menu-card {
    border-radius: 28px;
    background: #fff;
    border: none;
    box-shadow: 0 25px 60px rgba(0,0,0,0.08);
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex;
    flex-direction: column;
    height: 100%;
    padding: 0;
}

.menu-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 35px 80px rgba(0,0,0,0.12);
}

.menu-card img {
    border-radius: 24px;
    height: 210px;
    object-fit: cover;
    width: 100%;
}

.menu-card-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.menu-card-body h5 {
    min-height: 48px;
}

.menu-card-footer {
    margin-top: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price-tag {
    color: var(--dunkin-pink);
    font-weight: 700;
    font-size: 1.1rem;
}

.qty-box {
    background: #fff5ef;
    border-radius: 999px;
    padding: 6px 12px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    border: 1px solid rgba(255,125,0,0.2);
}

.qty-btn {
    border: none;
    background: transparent;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--dunkin-orange);
}

.cart-icon-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, var(--dunkin-pink), var(--dunkin-orange));
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 20px 35px rgba(255,60,125,0.35);
    color: #fff;
}

.cart-icon-btn svg {
    width: 26px;
    height: 26px;
    fill: currentColor;
}

.summary-card {
    border-radius: 28px;
    background: #fff;
    box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    position: sticky;
    top: 110px;
}

.cart-fab {
    position: fixed;
    bottom: 30px;
    right: 30px;
    border: none;
    border-radius: 999px;
    padding: 18px 28px;
    background: #ff3c7d;
    color: #fff;
    font-size: 1.1rem;
    font-weight: 700;
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    z-index: 60;
}

.cart-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.3);
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.2s;
    z-index: 90;
}

.cart-backdrop.active {
    opacity: 1;
    visibility: visible;
}

.cart-drawer {
    position: fixed;
    top: 0;
    right: 0;
    width: 410px;
    height: 100vh;
    background: #fff;
    box-shadow: -25px 0 60px rgba(0,0,0,0.15);
    transform: translateX(100%);
    transition: transform 0.3s ease;
    z-index: 95;
    display: flex;
    flex-direction: column;
    border-top-left-radius: 32px;
    border-bottom-left-radius: 32px;
}

.cart-drawer.open {
    transform: translateX(0);
}

.cart-drawer header,
.cart-drawer footer {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.cart-drawer footer {
    border-top: 1px solid rgba(0,0,0,0.05);
    border-bottom: none;
    position: sticky;
    bottom: 0;
    background: #fff;
    box-shadow: 0 -15px 30px rgba(0,0,0,0.08);
}

.cart-drawer-body {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem;
}

.cart-item-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.06);
}

.cart-item-controls {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.status-chip {
    display: inline-flex;
    padding: 6px 16px;
    border-radius: 999px;
    background: rgba(255,125,0,0.15);
    color: var(--dunkin-orange);
    font-weight: 600;
    font-size: 0.9rem;
}

.kiosk-toast {
    position: fixed;
    top: 90px;
    right: 30px;
    background: #fff;
    padding: 1rem 1.5rem;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    display: none;
    z-index: 120;
    font-weight: 600;
}

.kiosk-toast.show {
    display: block;
}

@media (max-width: 992px) {
    .cart-drawer {
        width: 100%;
        border-radius: 0;
    }

    .summary-card {
        position: static;
    }

    .cart-fab {
        right: 15px;
        left: 15px;
        width: calc(100% - 30px);
        text-align: center;
    }
}
</style>

<div class="kiosk-wrapper">
    <div class="container-xl kiosk-hero">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <p class="status-chip mb-3">Touch to order • Fast pickup</p>
                <h1>Build your Dunkin’ delight</h1>
                <p class="lead text-muted">Tap your favorites, customize quantities, and breeze through checkout. Fresh donuts, bold brews, happy you.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <button class="btn btn-dunkin px-4 py-3" id="heroCheckout" data-cart-toggle>
                    View Cart & Checkout
                </button>
            </div>
        </div>
    </div>

    <div class="container-xl pb-5">
        <div class="row g-4">
            <div class="col-lg-9">
                <div class="d-flex gap-2 flex-wrap mb-4">
                    <button class="category-btn active" data-category="all">All</button>
                    <button class="category-btn" data-category="donuts">Donuts</button>
                    <button class="category-btn" data-category="beverages">Beverages</button>
                    <button class="category-btn" data-category="bundles">Bundles</button>
                    <button class="category-btn" data-category="snacks">Snacks</button>
                </div>

                <div class="menu-grid" id="menu-items">
                    @foreach($menu as $item)
                    <div class="menu-item" data-category="{{ $item['category'] }}">
                        <form method="POST" action="{{ route('cart.store') }}" class="menu-card menu-item-form">
                            @csrf
                            <input type="hidden" name="name" value="{{ $item['name'] }}">
                            <input type="hidden" name="price" value="{{ $item['price'] }}">
                            <input type="hidden" name="qty" value="1" class="qty-input">

                            <img src="{{ asset('images/' . $item['img']) }}"
                                 onerror="this.src='{{ asset('images/default.png') }}'"
                                 class="menu-card-img">

                            <div class="menu-card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="mb-1">{{ $item['name'] }}</h5>
                                        <p class="text-muted small text-uppercase mb-0">{{ ucfirst($item['category']) }}</p>
                                    </div>
                                    <span class="price-tag">₱{{ number_format($item['price'], 2) }}</span>
                                </div>

                                <div class="menu-card-footer">
                                    <div class="qty-box">
                                        <button type="button" class="qty-btn minus">-</button>
                                        <span class="qty px-1" data-qty-display>1</span>
                                        <button type="button" class="qty-btn plus">+</button>
                                    </div>
                                    <button type="submit" class="cart-icon-btn" aria-label="Add {{ $item['name'] }} to cart">
                                        <svg viewBox="0 0 24 24" role="img" aria-hidden="true">
                                            <path d="M7 4h-2l-1 2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h10v-2h-10l1.1-2h6.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1h-15.55l-.94-2zm-1 16c-1.1 0-2 .9-2 2s.9 2 2 2c1.09 0 2-.9 2-2s-.91-2-2-2zm12 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2c1.09 0 2-.9 2-2s-.91-2-2-2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-3">
                <div class="summary-card p-4" id="kioskSummary">
                    <h5 class="mb-3">Current Order</h5>
                    <div class="d-flex justify-content-between mb-1 text-muted">
                        <span>Items</span>
                        <strong data-summary-count>{{ $initialCartCount }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span>Total</span>
                        <strong class="fs-4" data-summary-total>₱{{ number_format($initialCartTotal, 2) }}</strong>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-secondary" data-cart-toggle id="summaryCartBtn">View cart details</button>
                        <a href="{{ route('checkout') }}" class="btn btn-dunkin @if($initialCartCount === 0) disabled @endif" id="summaryCheckoutBtn" @if($initialCartCount === 0) aria-disabled="true" @endif>Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button class="cart-fab" data-cart-toggle>
    Cart • <span data-cart-count>{{ $initialCartCount }}</span>
</button>

<div class="kiosk-toast" id="kioskToast"></div>

@endsection

@section('kiosk-panel')
<div class="cart-backdrop" id="cartBackdrop"></div>
<aside class="cart-drawer" id="cartDrawer">
    <header class="d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Your Cart</h5>
            <small class="text-muted" data-drawer-count>{{ $initialCartCount }} items</small>
        </div>
        <button class="btn btn-link text-decoration-none text-dark" data-cart-toggle>&times;</button>
    </header>
    <div class="cart-drawer-body" id="cartDrawerItems">
        <!-- items injected -->
    </div>
    <footer>
        <div class="d-flex justify-content-between mb-2">
            <span>Subtotal</span>
            <strong data-drawer-total>₱{{ number_format($initialCartTotal, 2) }}</strong>
        </div>
        <div class="d-grid gap-2">
            <a href="{{ route('checkout') }}" class="btn btn-dunkin @if($initialCartCount === 0) disabled @endif" id="drawerCheckout" @if($initialCartCount === 0) aria-disabled="true" @endif>Checkout</a>
            <button class="btn btn-outline-danger" id="drawerClearBtn">Clear cart</button>
        </div>
    </footer>
</aside>
@endsection

@push('scripts')
<script>
(function() {
    const initialCart = @json($initialCartItems);
    const routes = {
        store: "{{ route('cart.store') }}",
        update: "{{ url('/cart') }}/",
        destroy: "{{ url('/cart') }}/",
        clear: "{{ route('cart.clear') }}"
    };

    const cartState = {
        items: initialCart
    };

    const elements = {
        drawer: document.getElementById('cartDrawer'),
        backdrop: document.getElementById('cartBackdrop'),
        drawerItems: document.getElementById('cartDrawerItems'),
        drawerTotal: document.querySelector('[data-drawer-total]'),
        drawerCount: document.querySelector('[data-drawer-count]'),
        summaryCount: document.querySelector('[data-summary-count]'),
        summaryTotal: document.querySelector('[data-summary-total]'),
        checkoutButtons: [document.getElementById('summaryCheckoutBtn'), document.getElementById('drawerCheckout')],
        toast: document.getElementById('kioskToast'),
        cartCountBadges: document.querySelectorAll('[data-cart-count]')
    };

    const filters = {
        buttons: document.querySelectorAll('.category-btn'),
        items: document.querySelectorAll('.menu-item')
    };

    const csrf = window.csrfToken;

    function totals() {
        const count = cartState.items.reduce((sum, item) => sum + Number(item.qty), 0);
        const total = cartState.items.reduce((sum, item) => sum + Number(item.price) * Number(item.qty), 0);
        return { count, total };
    }

    function formatCurrency(value) {
        return '₱' + Number(value).toFixed(2);
    }

    function renderDrawer() {
        if (!elements.drawerItems) return;

        if (cartState.items.length === 0) {
            elements.drawerItems.innerHTML = '<div class="text-center text-muted py-5"><p class="mb-1">Your cart is empty</p><small>Add treats to get started.</small></div>';
            return;
        }

        elements.drawerItems.innerHTML = cartState.items.map(item => `
            <div class="cart-item-row" data-cart-item="${item.id}">
                <div>
                    <strong>${item.name}</strong>
                    <p class="mb-0 text-muted">₱${Number(item.price).toFixed(2)} each</p>
                </div>
                <div class="cart-item-controls">
                    <div class="qty-box">
                        <button type="button" class="qty-btn" data-cart-action="decrease" data-id="${item.id}">-</button>
                        <span>${item.qty}</span>
                        <button type="button" class="qty-btn" data-cart-action="increase" data-id="${item.id}">+</button>
                    </div>
                    <button class="btn btn-link text-danger p-0" data-cart-action="remove" data-id="${item.id}">Remove</button>
                </div>
            </div>
        `).join('');
    }

    function refreshUI(message) {
        const { count, total } = totals();
        elements.drawerCount && (elements.drawerCount.textContent = `${count} items`);
        elements.drawerTotal && (elements.drawerTotal.textContent = formatCurrency(total));
        elements.summaryCount && (elements.summaryCount.textContent = count);
        elements.summaryTotal && (elements.summaryTotal.textContent = formatCurrency(total));
        elements.cartCountBadges.forEach(el => el.textContent = count);

        elements.checkoutButtons.forEach(btn => {
            if (!btn) return;
            if (count === 0) {
                btn.classList.add('disabled');
                btn.setAttribute('aria-disabled', 'true');
            } else {
                btn.classList.remove('disabled');
                btn.removeAttribute('aria-disabled');
            }
        });

        renderDrawer();
        if (message) showToast(message);
    }

    function showToast(text, type = 'success') {
        if (!elements.toast) return;
        elements.toast.textContent = text;
        elements.toast.style.background = type === 'error' ? '#ffe1e8' : '#fff';
        elements.toast.style.color = type === 'error' ? '#c9184a' : '#311228';
        elements.toast.classList.add('show');
        setTimeout(() => elements.toast.classList.remove('show'), 2200);
    }

    function toggleDrawer(forceOpen = null) {
        if (!elements.drawer || !elements.backdrop) return;
        const shouldOpen = forceOpen !== null ? forceOpen : !elements.drawer.classList.contains('open');
        elements.drawer.classList.toggle('open', shouldOpen);
        elements.backdrop.classList.toggle('active', shouldOpen);
    }

    async function send(url, method, payload = {}) {
        const response = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
            body: method === 'GET' ? null : JSON.stringify(payload)
        });

        if (!response.ok) {
            const error = await response.json().catch(() => ({}));
            throw new Error(error.message || 'Action failed');
        }

        return response.json();
    }

    function syncFromResponse(data) {
        cartState.items = data.items || [];
        refreshUI(data.message);
    }

    function applyCategory(category) {
        let firstVisible = null;
        filters.items.forEach(item => {
            const matches = category === 'all' || item.dataset.category === category;
            item.classList.toggle('is-hidden', !matches);
            if (matches && !firstVisible) {
                firstVisible = item;
            }
        });

        if (firstVisible) {
            firstVisible.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });
        }
    }

    filters.buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            filters.buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            applyCategory(btn.dataset.category);
        });
    });

    document.querySelectorAll('.menu-item-form').forEach(form => {
        const qtyDisplay = form.querySelector('[data-qty-display]');
        const qtyInput = form.querySelector('.qty-input');
        const plus = form.querySelector('.plus');
        const minus = form.querySelector('.minus');

        plus.addEventListener('click', () => {
            const next = Number(qtyDisplay.textContent) + 1;
            qtyDisplay.textContent = next;
            qtyInput.value = next;
        });

        minus.addEventListener('click', () => {
            const current = Number(qtyDisplay.textContent);
            if (current > 1) {
                const next = current - 1;
                qtyDisplay.textContent = next;
                qtyInput.value = next;
            }
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const payload = {
                name: form.querySelector('[name="name"]').value,
                price: Number(form.querySelector('[name="price"]').value),
                qty: Number(qtyInput.value)
            };

            try {
                const data = await send(routes.store, 'POST', payload);
                form.querySelector('[data-qty-display]').textContent = 1;
                qtyInput.value = 1;
                syncFromResponse(data);
            } catch (error) {
                showToast(error.message, 'error');
            }
        });
    });

    elements.drawerItems?.addEventListener('click', async (event) => {
        const target = event.target.closest('[data-cart-action]');
        if (!target) return;

        const id = target.dataset.id;
        const item = cartState.items.find(entry => entry.id === id);
        if (!item) return;

        try {
            if (target.dataset.cartAction === 'remove') {
                const data = await send(routes.destroy + id, 'DELETE');
                syncFromResponse(data);
                return;
            }

            let nextQty = Number(item.qty);
            nextQty = target.dataset.cartAction === 'increase' ? nextQty + 1 : Math.max(1, nextQty - 1);

            const data = await send(routes.update + id, 'PATCH', { qty: nextQty });
            syncFromResponse(data);
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    document.getElementById('drawerClearBtn')?.addEventListener('click', async () => {
        try {
            const data = await send(routes.clear, 'DELETE');
            syncFromResponse(data);
        } catch (error) {
            showToast(error.message, 'error');
        }
    });

    document.querySelectorAll('[data-cart-toggle]').forEach(trigger => {
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            toggleDrawer();
        });
    });

    elements.backdrop?.addEventListener('click', () => toggleDrawer(false));

    renderDrawer();
    refreshUI();
    applyCategory(document.querySelector('.category-btn.active')?.dataset.category || 'all');
})();
</script>
@endpush