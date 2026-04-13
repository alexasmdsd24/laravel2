<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index()
    {
        $menu = [];
        $jsonPath = storage_path('app/menu.json');

        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $menu = json_decode($json, true) ?? [];
        } else {
            Log::warning('Menu JSON not found.', ['path' => $jsonPath]);
        }

        return view('menu', compact('menu'));
    }
}