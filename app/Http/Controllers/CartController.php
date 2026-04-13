<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);

        return view('cart', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',
        ]);

        $cart = $request->session()->get('cart', []);
        $id = $this->cartKey($validated['name']);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $validated['qty'];
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $validated['name'],
                'price' => $validated['price'],
                'qty' => $validated['qty'],
            ];
        }

        $request->session()->put('cart', $cart);

        return $this->respond($request, $cart, $validated['name'] . ' added to cart.');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $validated['qty'];
            $request->session()->put('cart', $cart);
        }

        return $this->respond($request, $cart, 'Cart updated.', 'cart');
    }

    public function destroy(Request $request, string $id)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $request->session()->put('cart', $cart);
        }

        return $this->respond($request, $cart, 'Item removed.', 'cart');
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Cart cleared.',
                'items' => [],
                'count' => 0,
                'total' => 0,
            ]);
        }

        return redirect()->route('cart')->with('status', 'Cart cleared.');
    }

    private function cartKey(string $name): string
    {
        return sha1(Str::lower($name));
    }

    private function respond(Request $request, array $cart, string $message, ?string $redirectRoute = null)
    {
        if ($request->wantsJson()) {
            $metrics = $this->cartMetrics($cart);

            return response()->json([
                'message' => $message,
                'items' => $metrics['items'],
                'count' => $metrics['count'],
                'total' => $metrics['total'],
            ]);
        }

        if ($redirectRoute) {
            return redirect()->route($redirectRoute)->with('status', $message);
        }

        return back()->with('status', $message);
    }

    private function cartMetrics(array $cart): array
    {
        $items = array_values($cart);
        $count = collect($cart)->sum(fn ($item) => $item['qty']);
        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);

        return compact('items', 'count', 'total');
    }
}
