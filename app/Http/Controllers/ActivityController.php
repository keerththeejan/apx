<?php

namespace App\Http\Controllers;

use App\Models\DailyActivity;
use App\Models\NavLink;
use App\Models\Service;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $activities = DailyActivity::where('is_visible', true)
            ->orderByDesc('activity_date')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(12);

        $navLinks = NavLink::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->get();
        $services = Service::when(\Illuminate\Support\Facades\Schema::hasColumn('services', 'is_visible'), fn ($q) => $q->where('is_visible', true))
            ->orderBy('sort_order')->orderBy('id')->take(5)->get();

        return view('activities.index', compact('activities', 'navLinks', 'services'));
    }
}
