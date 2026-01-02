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
            'bg_image_file' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:6144'],
            'banner_height_px' => ['nullable','integer','min:220','max:900'],
            'bg_position' => ['nullable','in:center,top,bottom,left,right'],
            'banner_content_max_width_px' => ['nullable','integer','min:680','max:1600'],
            'bg_size' => ['nullable','in:cover,contain'],
            'primary_text' => ['nullable','string','max:50'],
            'primary_url' => ['nullable','string','max:255'],
            'secondary_text' => ['nullable','string','max:50'],
            'secondary_url' => ['nullable','string','max:255'],
        ]);

        // If an image was uploaded, store it under public/uploads/banners and override bg_image_url
        if ($request->hasFile('bg_image_file') && $request->file('bg_image_file')->isValid()) {
            $dir = public_path('uploads/banners');
            if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
            $ext = $request->file('bg_image_file')->getClientOriginalExtension() ?: 'jpg';
            $name = 'banner_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)),0,8).'.'.$ext;
            $request->file('bg_image_file')->move($dir, $name);
            $data['bg_image_url'] = '/public/uploads/banners/'.$name;
        }

        $banner = HomeBanner::first();
        if (!$banner) { $banner = new HomeBanner(); }
        $banner->fill($data);
        $banner->save();

        return redirect()->route('admin.banner.edit')->with('status','Banner updated');
    }
}
