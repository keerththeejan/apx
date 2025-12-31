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
            'default_theme' => ['required','in:dark,slate,indigo,emerald,rose,amber,sky,violet'],
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
            'default_theme' => $rows['default_theme']->value ?? 'dark',
        ];
    }

    private function ensureDefaults(array $settings): void
    {
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
