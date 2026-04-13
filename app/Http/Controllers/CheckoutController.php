<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        return $this->finalizeOrder($request, []);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'pickup_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string|max:500',
        ]);

        return $this->finalizeOrder($request, $validated);
    }

    public function receipt(Request $request)
    {
        $order = $request->session()->get('last_order');

        if (!$order) {
            return redirect()->route('menu');
        }

        return view('receipt', ['order' => $order]);
    }

    private function generateReference(): string
    {
        $seed = strtoupper(Str::random(4));
        return 'DDN-' . now()->format('Ymd') . '-' . $seed;
    }

    private function finalizeOrder(Request $request, array $payload)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('menu')->withErrors('Your cart is empty.');
        }

        $customer = [
            'customer_name' => $payload['customer_name'] ?? 'Guest Customer',
            'email' => $payload['email'] ?? 'guest@dunkin.local',
            'phone' => $payload['phone'] ?? 'N/A',
            'pickup_time' => $payload['pickup_time'] ?? now()->addMinutes(15)->format('H:i'),
            'notes' => $payload['notes'] ?? null,
        ];

        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);
        $order = [
            'reference' => $this->generateReference(),
            'total' => $total,
            'items' => array_values($cart),
            'customer' => $customer,
            'placed_at' => now()->format('M d, Y • h:i A'),
            'date' => now()->format('M d, Y'),
            'time' => now()->format('h:i A'),
            'pickup_time' => $customer['pickup_time'],
            'payment_method' => 'Card on kiosk'
        ];

        Log::info('Checkout submitted', $order);

        $request->session()->put('last_order', $order);
        $request->session()->forget('cart');

        return redirect()->route('checkout.receipt');
    }
}
