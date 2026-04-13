<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuAdminController extends Controller
{
    /**
     * Display all menu items
     */
    public function index()
    {
        $items = $this->getMenuItems();
        return view('admin.menu.index', compact('items'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = ['donuts', 'beverages', 'snacks', 'bundles'];
        return view('admin.menu.create', compact('categories'));
    }

    /**
     * Store new menu item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:9999.99',
            'category' => 'required|string|in:donuts,beverages,snacks,bundles',
            'img' => 'required|string|max:255',
        ]);

        $items = $this->getMenuItems();
        $items[] = $validated;
        $this->saveMenuItems($items);

        return redirect()->route('admin.menu.index')->with('success', 'Menu item created successfully!');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $items = $this->getMenuItems();
        $item = $items[$id] ?? null;

        if (!$item) {
            return redirect()->route('admin.menu.index')->with('error', 'Item not found!');
        }

        $categories = ['donuts', 'beverages', 'snacks', 'bundles'];
        return view('admin.menu.edit', compact('item', 'id', 'categories'));
    }

    /**
     * Update menu item
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:9999.99',
            'category' => 'required|string|in:donuts,beverages,snacks,bundles',
            'img' => 'required|string|max:255',
        ]);

        $items = $this->getMenuItems();

        if (!isset($items[$id])) {
            return redirect()->route('admin.menu.index')->with('error', 'Item not found!');
        }

        $items[$id] = $validated;
        $this->saveMenuItems($items);

        return redirect()->route('admin.menu.index')->with('success', 'Menu item updated successfully!');
    }

    /**
     * Delete menu item
     */
    public function destroy($id)
    {
        $items = $this->getMenuItems();

        if (!isset($items[$id])) {
            return redirect()->route('admin.menu.index')->with('error', 'Item not found!');
        }

        unset($items[$id]);
        $items = array_values($items); // Re-index array
        $this->saveMenuItems($items);

        return redirect()->route('admin.menu.index')->with('success', 'Menu item deleted successfully!');
    }

    /**
     * Get menu items from JSON file
     */
    private function getMenuItems()
    {
        $jsonPath = storage_path('app/menu.json');

        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            return json_decode($json, true) ?? [];
        }

        return [];
    }

    /**
     * Save menu items to JSON file
     */
    private function saveMenuItems($items)
    {
        $jsonPath = storage_path('app/menu.json');
        $json = json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents($jsonPath, $json);
    }
}
