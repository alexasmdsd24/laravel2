<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $jsonPath = storage_path('app/menu.json');
        $menuCount = 0;
        $stats = [];

        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $items = json_decode($json, true) ?? [];
            $menuCount = count($items);

            // Count by category
            $stats = array_reduce($items, function ($carry, $item) {
                $category = $item['category'] ?? 'other';
                $carry[$category] = ($carry[$category] ?? 0) + 1;
                return $carry;
            }, []);
        }

        return view('admin.dashboard', compact('menuCount', 'stats'));
    }
}
