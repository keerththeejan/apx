<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    /** Preset icon options for social links (value => label). */
    public static function iconOptions(): array
    {
        return [
            '' => '— Select icon —',
            '📷' => 'Instagram (📷)',
            '📘' => 'Facebook (📘)',
            '🐦' => 'Twitter / X (🐦)',
            '💼' => 'LinkedIn (💼)',
            '▶️' => 'YouTube (▶️)',
            '💬' => 'WhatsApp (💬)',
            '🎵' => 'TikTok (🎵)',
            '📌' => 'Pinterest (📌)',
            '📧' => 'Email (📧)',
            '🔗' => 'Link (🔗)',
            '_other' => '— Other / Custom (type below) —',
        ];
    }

    public function index()
    {
        $links = SocialLink::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.sociallinks.index', compact('links'));
    }

    public function create()
    {
        $iconOptions = static::iconOptions();
        return view('admin.sociallinks.create', compact('iconOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => ['required','string','max:120'],
            'url' => ['required','url','max:2000'],
            'icon' => ['nullable','string','max:20'],
            'icon_custom' => ['nullable','string','max:20'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['nullable','boolean'],
        ]);
        $data['is_visible'] = (bool)($data['is_visible'] ?? true);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $icon = $data['icon'] ?? '';
        $data['icon'] = ($icon !== '' && $icon !== '_other') ? $icon : ($data['icon_custom'] ?? null);
        unset($data['icon_custom']);
        SocialLink::create($data);
        return redirect()->route('admin.sociallinks.index')->with('status','Social link added');
    }

    public function edit(SocialLink $social_link)
    {
        $iconOptions = static::iconOptions();
        return view('admin.sociallinks.edit', ['link' => $social_link, 'iconOptions' => $iconOptions]);
    }

    public function update(Request $request, SocialLink $social_link)
    {
        $data = $request->validate([
            'label' => ['required','string','max:120'],
            'url' => ['required','url','max:2000'],
            'icon' => ['nullable','string','max:20'],
            'icon_custom' => ['nullable','string','max:20'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['nullable','boolean'],
        ]);
        $data['is_visible'] = (bool)($data['is_visible'] ?? true);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $icon = $data['icon'] ?? '';
        $data['icon'] = ($icon !== '' && $icon !== '_other') ? $icon : ($data['icon_custom'] ?? null);
        unset($data['icon_custom']);
        $social_link->update($data);
        return redirect()->route('admin.sociallinks.index')->with('status','Social link updated');
    }

    public function destroy(SocialLink $social_link)
    {
        $social_link->delete();
        return redirect()->route('admin.sociallinks.index')->with('status','Social link deleted');
    }
}
