<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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
            'site_name' => ['required','string','max:120'],
            'tagline' => ['nullable','string','max:200'],
            'contact_email' => ['nullable','email','max:120'],
            'contact_phone' => ['nullable','string','max:60'],
            'address' => ['nullable','string','max:500'],
            'logo_url' => ['nullable','string','max:2000'],
            'logo_file' => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:4096'],
            'footer_logo_url' => ['nullable','string','max:2000'],
            'footer_logo_file' => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:4096'],
            'default_theme' => ['required','in:dark,slate,indigo,emerald,rose,amber,sky,violet'],
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
        ]);

        // If a logo image was uploaded, store it under public/uploads/logos and override logo_url
        if ($request->hasFile('logo_file') && $request->file('logo_file')->isValid()) {
            $dir = public_path('uploads/logos');
            if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
            $ext = $request->file('logo_file')->getClientOriginalExtension() ?: 'png';
            $name = 'logo_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)),0,8).'.'.$ext;
            $request->file('logo_file')->move($dir, $name);
            $publicPath = '/uploads/logos/'.$name;
            $data['logo_url'] = $publicPath;
        }

        // Footer logo upload
        if ($request->hasFile('footer_logo_file') && $request->file('footer_logo_file')->isValid()) {
            $dir = public_path('uploads/logos');
            if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
            $ext = $request->file('footer_logo_file')->getClientOriginalExtension() ?: 'png';
            $name = 'footer_logo_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)),0,8).'.'.$ext;
            $request->file('footer_logo_file')->move($dir, $name);
            $publicPath = '/uploads/logos/'.$name;
            $data['footer_logo_url'] = $publicPath;
        }

        // Coerce booleans
        $data['footer_show_social'] = $request->boolean('footer_show_social');
        // Normalize colors to start with '#'
        foreach (['footer_bg_color','footer_text_color','footer_link_color'] as $ckey) {
            if (!empty($data[$ckey])) {
                $val = ltrim((string)$data[$ckey], '#');
                $data[$ckey] = '#'.$val;
            }
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.settings.index')->with('status', 'Settings saved');
    }

    private function settingsMap(): array
    {
        $rows = Setting::query()->get()->keyBy('key');
        return [
            'site_name' => $rows['site_name']->value ?? 'Parcel Transport',
            'tagline' => $rows['tagline']->value ?? 'Safe Transportation & Logistics',
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
        ];
    }

    private function ensureDefaults(array $settings): void
    {
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
