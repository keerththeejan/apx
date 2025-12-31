<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Feature;

class AdminController extends Controller
{
    public function index()
    {
        $defaultTheme = optional(Setting::query()->where('key','default_theme')->first())->value ?? 'dark';
        $features = Feature::orderBy('sort_order')->orderBy('id')->paginate(10);
        return view('admin.dashboard', [
            'defaultTheme' => $defaultTheme,
            'features' => $features,
        ]);
    }
}
