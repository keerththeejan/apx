<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\Request;

class HomeBannerController extends Controller
{
    public function edit()
    {
        $banner = HomeBanner::first();
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'eyebrow' => ['nullable','string','max:255'],
            'title_line1' => ['nullable','string','max:255'],
            'title_line2' => ['nullable','string','max:255'],
            'subtitle' => ['nullable','string','max:500'],
            'bg_image_url' => ['nullable','string','max:2000'],
            'primary_text' => ['nullable','string','max:50'],
            'primary_url' => ['nullable','string','max:255'],
            'secondary_text' => ['nullable','string','max:50'],
            'secondary_url' => ['nullable','string','max:255'],
        ]);

        $banner = HomeBanner::first();
        if (!$banner) { $banner = new HomeBanner(); }
        $banner->fill($data);
        $banner->save();

        return redirect()->route('admin.banner.edit')->with('status','Banner updated');
    }
}
