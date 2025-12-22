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
            'contact_email' => ['nullable','email','max:120'],
            'contact_phone' => ['nullable','string','max:60'],
            'address' => ['nullable','string','max:500'],
            'default_theme' => ['required','in:dark,slate,indigo,emerald,rose,amber,sky,violet'],
        ]);

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
            'contact_email' => $rows['contact_email']->value ?? null,
            'contact_phone' => $rows['contact_phone']->value ?? null,
            'address' => $rows['address']->value ?? null,
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
