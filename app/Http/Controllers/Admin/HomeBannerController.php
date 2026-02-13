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
            $err = $request->file('bg_image_file')->getError();
            $msg = $request->file('bg_image_file')->getErrorMessage();
            if (in_array($err, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
                $msg = 'The image is too large. Use an image under 20 MB (it will be compressed after upload). Increase upload_max_filesize and post_max_size in php.ini if needed.';
            } elseif ($err === UPLOAD_ERR_NO_FILE) {
                $msg = 'No file was uploaded.';
            }
            return redirect()->back()->withErrors(['bg_image_file' => $msg])->withInput();
        }

        $data = $this->validateBanner($request);
        try {
            $this->handleImageUpload($request, $data);
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['bg_image_file' => $e->getMessage()])->withInput();
        }
        $this->parseImageUrls($request, $data);
        $this->mergeOptionalFields($request, $data);
        $data['is_active'] = $request->boolean('is_active');

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
        $urls = $banner->bg_image_urls_for_edit;
        $bgImageUrlsForEdit = is_array($urls) ? implode("\n", array_map('trim', $urls)) : '';
        return view('admin.banner.edit', compact('banner', 'hasEyebrow', 'hasTitle1', 'hasTitle2', 'hasSubtitle', 'bgImageUrlsForEdit'));
    }

    public function update(Request $request, HomeBanner $banner)
    {
        if ($request->hasFile('bg_image_file') && !$request->file('bg_image_file')->isValid()) {
            $err = $request->file('bg_image_file')->getError();
            $msg = $request->file('bg_image_file')->getErrorMessage();
            if (in_array($err, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true)) {
                $msg = 'The image is too large. Use an image under 20 MB (it will be compressed after upload). Increase upload_max_filesize and post_max_size in php.ini if needed.';
            } elseif ($err === UPLOAD_ERR_NO_FILE) {
                $msg = 'No file was uploaded.';
            }
            return redirect()->back()->withErrors(['bg_image_file' => $msg])->withInput();
        }

        $data = $this->validateBanner($request);
        try {
            $this->handleImageUpload($request, $data);
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['bg_image_file' => $e->getMessage()])->withInput();
        }
        $this->parseImageUrls($request, $data);
        $this->mergeOptionalFields($request, $data);
        $data['is_active'] = $request->boolean('is_active');

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
        $rules = [
            'name' => ['nullable', 'string', 'max:120'],
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'title_line1' => ['nullable', 'string', 'max:255'],
            'title_line2' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'bg_image_url' => ['nullable', 'string', 'max:2000'],
            'bg_image_urls' => ['nullable', 'string', 'max:8000'],
            'bg_image_file' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
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
            'is_active' => ['nullable', 'boolean'],
        ];
        $messages = [
            'bg_image_file.image' => 'The file must be an image (JPG, PNG or WebP).',
            'bg_image_file.mimes' => 'The file must be JPG, PNG or WebP.',
            'bg_image_file.max' => 'The image must be under 20 MB. If upload still fails, increase upload_max_filesize and post_max_size in php.ini.',
        ];
        return $request->validate($rules, $messages);
    }

    private function handleImageUpload(Request $request, array &$data): void
    {
        if (!$request->hasFile('bg_image_file') || !$request->file('bg_image_file')->isValid()) {
            return;
        }
        $uploadsDir = public_path('uploads');
        $dir = $uploadsDir . DIRECTORY_SEPARATOR . 'banners';
        if (!is_dir($uploadsDir)) {
            @mkdir($uploadsDir, 0775, true);
        }
        if (!is_dir($dir)) {
            if (!@mkdir($dir, 0775, true)) {
                throw new \RuntimeException('Could not create uploads/banners folder. Check folder permissions.');
            }
        }
        $ext = Str::lower($request->file('bg_image_file')->getClientOriginalExtension() ?: 'jpg');
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            $ext = 'jpg';
        }
        $name = 'banner_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)), 0, 8).'.'.$ext;
        $fullPath = $dir . DIRECTORY_SEPARATOR . $name;
        try {
            $request->file('bg_image_file')->move($dir, $name);
            $data['bg_image_url'] = 'uploads/banners/'.$name;
            try {
                $this->compressBannerImage($fullPath);
            } catch (\Throwable $e) {
                // Keep uploaded file even if compression fails
            }
        } catch (\Throwable $e) {
            if (!isset($data['bg_image_url'])) {
                throw new \RuntimeException('Could not save the uploaded image. Check that the uploads/banners folder exists and is writable.', 0, $e);
            }
            throw $e;
        }
    }

    /**
     * Compress and optionally resize banner image after upload to reduce file size.
     * Max dimensions: 2400×1350; JPEG quality 82. Uses GD if available.
     */
    private function compressBannerImage(string $path): void
    {
        if (!function_exists('getimagesize') || !function_exists('imagecreatetruecolor')) {
            return;
        }
        $info = @getimagesize($path);
        if (!$info || !isset($info[0], $info[1], $info[2])) {
            return;
        }
        $width = (int) $info[0];
        $height = (int) $info[1];
        $mime = $info['mime'] ?? '';
        $maxWidth = 2400;
        $maxHeight = 1350;
        $targetQuality = 82;

        $src = null;
        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                $src = @imagecreatefromjpeg($path);
                break;
            case IMAGETYPE_PNG:
                $src = @imagecreatefrompng($path);
                break;
            case IMAGETYPE_WEBP:
                if (function_exists('imagecreatefromwebp')) {
                    $src = @imagecreatefromwebp($path);
                }
                break;
            default:
                return;
        }
        if (!$src) {
            return;
        }

        $ratio = min($maxWidth / $width, $maxHeight / $height, 1);
        $newWidth = (int) round($width * $ratio);
        $newHeight = (int) round($height * $ratio);
        if ($newWidth >= $width && $newHeight >= $height) {
            $newWidth = $width;
            $newHeight = $height;
        }

        $dst = imagecreatetruecolor($newWidth, $newHeight);
        if (!$dst) {
            imagedestroy($src);
            return;
        }
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($src);

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if ($ext === 'png') {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            imagepng($dst, $path, 8);
        } elseif ($ext === 'webp' && function_exists('imagewebp')) {
            imagewebp($dst, $path, $targetQuality);
        } else {
            imagejpeg($dst, $path, $targetQuality);
        }
        imagedestroy($dst);
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
        foreach (['eyebrow','eyebrow_color','title_line1','title_color','title_line2','title_line2_color','subtitle','subtitle_color','is_active'] as $key) {
            $data[$key] = array_key_exists($key, $data) ? $data[$key] : $request->input($key);
        }
    }
}
