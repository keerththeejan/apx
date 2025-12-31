<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceVisibilityController extends Controller
{
    public function toggle(Service $service)
    {
        if (!\Illuminate\Support\Facades\Schema::hasColumn('services','is_visible')) {
            return back()->with('status','Visibility column missing. Run migrations.');
        }
        $service->is_visible = !$service->is_visible;
        $service->save();
        return back()->with('status', 'Service visibility updated');
    }
}
