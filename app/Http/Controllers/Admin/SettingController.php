<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index()
    {
        $settings = $this->settingsMap();
        // ensure defaults exist in DB
        $this->ensureDefaults($settings);
        return view('admin.settings.index', ['settings' => $settings]);
    }

    public function footer()
    {
        $settings = $this->settingsMap();
        // ensure defaults exist in DB
        $this->ensureDefaults($settings);
        return view('admin.settings.footer', ['settings' => $settings]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['nullable','string','max:120'],
            'tagline' => ['nullable','string','max:200'],
            'site_default_theme' => ['nullable','in:dark,light'],
            'header_bg_color' => ['nullable','regex:/^#?[0-9a-fA-F]{3,8}$/'],
            'header_border_color' => ['nullable','string','max:60'],
            'header_link_color' => ['nullable','regex:/^#?[0-9a-fA-F]{3,8}$/'],
            'header_text_color' => ['nullable','regex:/^#?[0-9a-fA-F]{3,8}$/'],
            'header_tagline_color' => ['nullable','regex:/^#?[0-9a-fA-F]{3,8}$/'],
            'header_brand_font_size' => ['nullable','integer','min:12','max:96'],
            'header_tagline_font_size' => ['nullable','integer','min:10','max:48'],
            'header_brand_font_weight' => ['nullable','in:100,200,300,400,500,600,700,800,900'],
            'header_brand_font_style' => ['nullable','in:normal,italic'],
            'contact_email' => ['nullable','email','max:120'],
            'contact_phone' => ['nullable','string','max:60'],
            'address' => ['nullable','string','max:500'],
            'logo_url' => ['nullable','string','max:2000'],
            'logo_file' => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:4096'],
            'footer_logo_url' => ['nullable','string','max:2000'],
            'footer_logo_file' => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:4096'],
            'default_theme' => ['sometimes','required','in:dark,slate,indigo,emerald,rose,amber,sky,violet'],
            'footer_text' => ['nullable','string','max:500'],
            'footer_newsletter' => ['nullable','string','max:500'],
            'footer_hours' => ['nullable','string','max:200'],
            'footer_about_title' => ['nullable','string','max:120'],
            'footer_about_text' => ['nullable','string','max:1000'],
            'footer_about_link_label' => ['nullable','string','max:60'],
            'footer_about_link_url' => ['nullable','string','max:2000'],
            'footer_show_social' => ['nullable','boolean'],
            'footer_bg_color' => ['nullable','regex:/^#?[0-9a-fA-F]{3,8}$/'],
            'footer_text_color' => ['nullable','regex:/^#?[0-9a-fA-F]{3,8}$/'],
            'footer_link_color' => ['nullable','regex:/^#?[0-9a-fA-F]{3,8}$/'],
            'banner_auto_rotate' => ['nullable','boolean'],
            'banner_rotate_interval_sec' => ['nullable','integer','min:2','max:30'],
        ]);

        // If a logo image was uploaded, store it under public/uploads/logos and override logo_url
        if ($request->hasFile('logo_file') && $request->file('logo_file')->isValid()) {
            $dir = public_path('uploads/logos');
            if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
            $ext = $request->file('logo_file')->getClientOriginalExtension() ?: 'png';
            $name = 'logo_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)),0,8).'.'.$ext;
            $request->file('logo_file')->move($dir, $name);
            $publicPath = '/public/uploads/logos/'.$name;
            $data['logo_url'] = $publicPath;
        }

        // Footer logo upload
        if ($request->hasFile('footer_logo_file') && $request->file('footer_logo_file')->isValid()) {
            $dir = public_path('uploads/logos');
            if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
            $ext = $request->file('footer_logo_file')->getClientOriginalExtension() ?: 'png';
            $name = 'footer_logo_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)),0,8).'.'.$ext;
            $request->file('footer_logo_file')->move($dir, $name);
            $publicPath = '/public/uploads/logos/'.$name;
            $data['footer_logo_url'] = $publicPath;
        }

        // Coerce booleans
        $data['footer_show_social'] = $request->boolean('footer_show_social');
        $data['banner_auto_rotate'] = $request->boolean('banner_auto_rotate');
        if (!isset($data['banner_rotate_interval_sec']) || $data['banner_rotate_interval_sec'] === '') {
            $data['banner_rotate_interval_sec'] = 5;
        }
        $data['banner_rotate_interval_sec'] = (int) $data['banner_rotate_interval_sec'];
        // Normalize colors to start with '#'
        foreach (['header_bg_color','header_link_color','header_text_color','header_tagline_color','footer_bg_color','footer_text_color','footer_link_color'] as $ckey) {
            if (!empty($data[$ckey])) {
                $val = ltrim((string)$data[$ckey], '#');
                $data[$ckey] = '#'.$val;
            }
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $prev = url()->previous();
        $redirectTo = Str::contains($prev, ['/admin/footer', 'admin/footer'])
            ? route('admin.settings.footer')
            : route('admin.settings.index');

        return redirect($redirectTo)->with('status', 'Settings saved');
    }

    private function settingsMap(): array
    {
        $rows = Setting::query()->get()->keyBy('key');
        return [
            'site_name' => $rows['site_name']->value ?? '',
            'tagline' => $rows['tagline']->value ?? '',
            'site_default_theme' => $rows['site_default_theme']->value ?? 'dark',
            'header_bg_color' => $rows['header_bg_color']->value ?? '#0b1220',
            'header_border_color' => $rows['header_border_color']->value ?? 'rgba(148,163,184,.12)',
            'header_link_color' => $rows['header_link_color']->value ?? '#94a3b8',
            'header_text_color' => $rows['header_text_color']->value ?? '#e2e8f0',
            'header_tagline_color' => $rows['header_tagline_color']->value ?? '#94a3b8',
            'header_brand_font_size' => (int)($rows['header_brand_font_size']->value ?? 16),
            'header_tagline_font_size' => (int)($rows['header_tagline_font_size']->value ?? 14),
            'header_brand_font_weight' => (string)($rows['header_brand_font_weight']->value ?? '800'),
            'header_brand_font_style' => (string)($rows['header_brand_font_style']->value ?? 'normal'),
            'contact_email' => $rows['contact_email']->value ?? null,
            'contact_phone' => $rows['contact_phone']->value ?? null,
            'address' => $rows['address']->value ?? null,
            'logo_url' => $rows['logo_url']->value ?? null,
            'footer_logo_url' => $rows['footer_logo_url']->value ?? null,
            'default_theme' => $rows['default_theme']->value ?? 'dark',
            'footer_text' => $rows['footer_text']->value ?? 'All rights reserved.',
            'footer_newsletter' => $rows['footer_newsletter']->value ?? 'Subscribe to get updates about new services and offers.',
            'footer_hours' => $rows['footer_hours']->value ?? null,
            'footer_about_title' => $rows['footer_about_title']->value ?? 'About',
            'footer_about_text' => $rows['footer_about_text']->value ?? null,
            'footer_about_link_label' => $rows['footer_about_link_label']->value ?? null,
            'footer_about_link_url' => $rows['footer_about_link_url']->value ?? null,
            'footer_show_social' => (bool)($rows['footer_show_social']->value ?? true),
            'footer_bg_color' => $rows['footer_bg_color']->value ?? '#0b1220',
            'footer_text_color' => $rows['footer_text_color']->value ?? '#94a3b8',
            'footer_link_color' => $rows['footer_link_color']->value ?? '#cbd5e1',
            'banner_auto_rotate' => (bool)(optional($rows['banner_auto_rotate'])->value ?? true),
            'banner_rotate_interval_sec' => (int)(optional($rows['banner_rotate_interval_sec'])->value ?? 5),
        ];
    }

    private function ensureDefaults(array $settings): void
    {
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
