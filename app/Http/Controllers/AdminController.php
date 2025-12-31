<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Feature;
use App\Models\Quote;

class AdminController extends Controller
{
    public function index()
    {
        $defaultTheme = optional(Setting::query()->where('key','default_theme')->first())->value ?? 'dark';
        $features = Feature::orderBy('sort_order')->orderBy('id')->paginate(10);
        $newQuotes = Quote::where('status','new')->count();
        $recentQuotes = Quote::latest()->take(5)->get();
        return view('admin.dashboard', [
            'defaultTheme' => $defaultTheme,
            'features' => $features,
            'newQuotes' => $newQuotes,
            'recentQuotes' => $recentQuotes,
        ]);
    }
}
