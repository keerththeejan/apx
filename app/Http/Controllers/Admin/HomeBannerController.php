<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeBannerController extends Controller
{
    public function index()
    {
        $banners = HomeBanner::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        $banner = new HomeBanner();
        $hasEyebrow = false;
        $hasTitle1 = false;
        $hasTitle2 = false;
        $hasSubtitle = false;
        return view('admin.banner.create', compact('banner', 'hasEyebrow', 'hasTitle1', 'hasTitle2', 'hasSubtitle'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('bg_image_file') && !$request->file('bg_image_file')->isValid()) {
            $msg = $request->file('bg_image_file')->getErrorMessage();
            if (in_array($request->file('bg_image_file')->getError(), [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
                $msg = 'The image is too large. Use an image under 6 MB.';
            }
            return redirect()->back()->withErrors(['bg_image_file' => $msg])->withInput();
        }

        $data = $this->validateBanner($request);
        $this->handleImageUpload($request, $data);
        $this->parseImageUrls($request, $data);
        $this->mergeOptionalFields($request, $data);

        $maxOrder = HomeBanner::max('sort_order') ?? 0;
        $data['sort_order'] = $maxOrder + 1;
        $data['name'] = $data['name'] ?? 'Banner ' . ($maxOrder + 1);

        $banner = HomeBanner::create($data);
        return redirect()->route('admin.banner.index')->with('status', 'Banner created');
    }

    public function edit(HomeBanner $banner)
    {
        $hasEyebrow = strlen(trim((string) ($banner->eyebrow ?? ''))) > 0;
        $hasTitle1 = strlen(trim((string) ($banner->title_line1 ?? ''))) > 0;
        $hasTitle2 = strlen(trim((string) ($banner->title_line2 ?? ''))) > 0;
        $hasSubtitle = strlen(trim((string) ($banner->subtitle ?? ''))) > 0;
        return view('admin.banner.edit', compact('banner', 'hasEyebrow', 'hasTitle1', 'hasTitle2', 'hasSubtitle'));
    }

    public function update(Request $request, HomeBanner $banner)
    {
        if ($request->hasFile('bg_image_file') && !$request->file('bg_image_file')->isValid()) {
            $msg = $request->file('bg_image_file')->getErrorMessage();
            if (in_array($request->file('bg_image_file')->getError(), [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
                $msg = 'The image is too large. Use an image under 6 MB.';
            }
            return redirect()->back()->withErrors(['bg_image_file' => $msg])->withInput();
        }

        $data = $this->validateBanner($request);
        $this->handleImageUpload($request, $data);
        $this->parseImageUrls($request, $data);
        $this->mergeOptionalFields($request, $data);

        $banner->fill($data);
        $banner->save();

        return redirect()->route('admin.banner.index')->with('status', 'Banner updated');
    }

    public function destroy(HomeBanner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.banner.index')->with('status', 'Banner deleted');
    }

    public function updateOrder(Request $request)
    {
        $request->validate(['order' => ['required', 'array'], 'order.*' => ['integer', 'exists:home_banners,id']]);
        foreach ($request->input('order', []) as $position => $id) {
            HomeBanner::where('id', $id)->update(['sort_order' => $position]);
        }
        return response()->json(['ok' => true]);
    }

    private function validateBanner(Request $request): array
    {
        return $request->validate([
            'name' => ['nullable', 'string', 'max:120'],
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'title_line1' => ['nullable', 'string', 'max:255'],
            'title_line2' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'bg_image_url' => ['nullable', 'string', 'max:2000'],
            'bg_image_urls' => ['nullable', 'string', 'max:8000'],
            'bg_image_file' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'banner_height_px' => ['nullable', 'integer', 'min:220', 'max:900'],
            'bg_position' => ['nullable', 'in:center,top,bottom,left,right'],
            'banner_content_max_width_px' => ['nullable', 'integer', 'min:680', 'max:1600'],
            'bg_size' => ['nullable', 'in:cover,contain'],
            'primary_text' => ['nullable', 'string', 'max:50'],
            'primary_url' => ['nullable', 'string', 'max:255'],
            'secondary_text' => ['nullable', 'string', 'max:50'],
            'secondary_url' => ['nullable', 'string', 'max:255'],
            'eyebrow_color' => ['nullable', 'string', 'max:20'],
            'title_color' => ['nullable', 'string', 'max:20'],
            'title_line2_color' => ['nullable', 'string', 'max:20'],
            'subtitle_color' => ['nullable', 'string', 'max:20'],
        ]);
    }

    private function handleImageUpload(Request $request, array &$data): void
    {
        if (!$request->hasFile('bg_image_file') || !$request->file('bg_image_file')->isValid()) {
            return;
        }
        $dir = public_path('uploads/banners');
        if (!is_dir($dir) && !@mkdir($dir, 0775, true)) {
            return;
        }
        $ext = Str::lower($request->file('bg_image_file')->getClientOriginalExtension() ?: 'jpg');
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            $ext = 'jpg';
        }
        $name = 'banner_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)), 0, 8).'.'.$ext;
        try {
            $request->file('bg_image_file')->move($dir, $name);
            $data['bg_image_url'] = 'uploads/banners/'.$name;
        } catch (\Throwable $e) {
            // leave $data['bg_image_url'] unchanged
        }
    }

    private function parseImageUrls(Request $request, array &$data): void
    {
        $urlsRaw = $request->input('bg_image_urls');
        $data['bg_image_urls'] = [];
        if (is_string($urlsRaw) && $urlsRaw !== '') {
            $data['bg_image_urls'] = array_values(array_filter(array_map('trim', explode("\n", $urlsRaw))));
        }
    }

    private function mergeOptionalFields(Request $request, array &$data): void
    {
        foreach (['eyebrow','eyebrow_color','title_line1','title_color','title_line2','title_line2_color','subtitle','subtitle_color'] as $key) {
            $data[$key] = array_key_exists($key, $data) ? $data[$key] : $request->input($key);
        }
    }
}
