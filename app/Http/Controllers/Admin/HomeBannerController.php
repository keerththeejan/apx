<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeBannerController extends Controller
{
    public function edit()
    {
        $banner = HomeBanner::first();
        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request)
    {
        // If a file was sent but failed to upload (e.g. too large for PHP), show a clear error before validation
        if ($request->hasFile('bg_image_file') && !$request->file('bg_image_file')->isValid()) {
            $code = $request->file('bg_image_file')->getError();
            $msg = $request->file('bg_image_file')->getErrorMessage();
            if ($code === UPLOAD_ERR_INI_SIZE || $code === UPLOAD_ERR_FORM_SIZE) {
                $msg = 'The image is too large. Use an image under 6 MB, or increase upload_max_filesize in PHP.';
            }
            return redirect()->back()->withErrors(['bg_image_file' => $msg])->withInput();
        }

        $data = $request->validate([
            'eyebrow' => ['nullable','string','max:255'],
            'title_line1' => ['nullable','string','max:255'],
            'title_line2' => ['nullable','string','max:255'],
            'subtitle' => ['nullable','string','max:500'],
            'bg_image_url' => ['nullable','string','max:2000'],
            'bg_image_urls' => ['nullable','string','max:8000'],
            'bg_image_file' => ['nullable','file','image','mimes:jpg,jpeg,png,webp','max:6144'],
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
            if (!is_dir($dir)) {
                if (!@mkdir($dir, 0775, true)) {
                    return redirect()->back()->withErrors(['bg_image_file' => 'Could not create upload folder. Check folder permissions.'])->withInput();
                }
            }
            $ext = Str::lower($request->file('bg_image_file')->getClientOriginalExtension() ?: 'jpg');
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $ext = 'jpg';
            }
            $name = 'banner_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)), 0, 8).'.'.$ext;
            try {
                $request->file('bg_image_file')->move($dir, $name);
            } catch (\Throwable $e) {
                return redirect()->back()->withErrors(['bg_image_file' => 'Could not save the image. Check that the uploads/banners folder is writable.'])->withInput();
            }
            $data['bg_image_url'] = 'uploads/banners/'.$name;
        }

        // Parse additional background image URLs (one per line) for auto-rotate
        $urlsRaw = $request->input('bg_image_urls');
        $data['bg_image_urls'] = [];
        if (is_string($urlsRaw) && $urlsRaw !== '') {
            $data['bg_image_urls'] = array_values(array_filter(array_map('trim', explode("\n", $urlsRaw))));
        }

        $banner = HomeBanner::first();
        if (!$banner) {
            $banner = new HomeBanner();
        }
        $banner->fill($data);
        $banner->save();

        return redirect()->route('admin.banner.edit')->with('status', 'Banner updated');
    }
}
