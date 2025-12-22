<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class AdminController extends Controller
{
    public function index()
    {
        $defaultTheme = optional(Setting::query()->where('key','default_theme')->first())->value ?? 'dark';
        return view('admin.dashboard', ['defaultTheme' => $defaultTheme]);
    }
}
