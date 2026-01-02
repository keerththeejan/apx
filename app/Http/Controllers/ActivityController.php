<?php

namespace App\Http\Controllers;

use App\Models\DailyActivity;
use App\Models\HomeBanner;
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

        $banner = HomeBanner::first();

        return view('activities.index', compact('activities','banner'));
    }
}
