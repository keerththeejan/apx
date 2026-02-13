<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::orderBy('sort_order')->orderBy('id')->paginate(12);
        return view('admin.features.index', compact('features'));
    }

    public function create()
    {
        return view('admin.features.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icon' => ['nullable','string','max:10'],
            'icon_image_url' => ['nullable','string','max:2000'],
            'icon_image_file' => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:4096'],
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['nullable','boolean'],
        ]);

        // Handle icon image upload if provided; store under public/uploads/features
        if ($request->hasFile('icon_image_file') && $request->file('icon_image_file')->isValid()) {
            $dir = public_path('uploads/features');
            if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
            $ext = $request->file('icon_image_file')->getClientOriginalExtension() ?: 'png';
            $name = 'feature_icon_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)),0,8).'.'.$ext;
            $request->file('icon_image_file')->move($dir, $name);
            $data['icon_image_url'] = '/uploads/features/'.$name;
        }

        $data['is_visible'] = (bool)($data['is_visible'] ?? true);
        Feature::create($data);
        return redirect()->route('admin.features.index')->with('status','Feature created');
    }

    public function edit(Feature $feature)
    {
        return view('admin.features.edit', compact('feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $data = $request->validate([
            'icon' => ['nullable','string','max:10'],
            'icon_image_url' => ['nullable','string','max:2000'],
            'icon_image_file' => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:4096'],
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['nullable','boolean'],
        ]);

        if ($request->hasFile('icon_image_file') && $request->file('icon_image_file')->isValid()) {
            $dir = public_path('uploads/features');
            if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
            $ext = $request->file('icon_image_file')->getClientOriginalExtension() ?: 'png';
            $name = 'feature_icon_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)),0,8).'.'.$ext;
            $request->file('icon_image_file')->move($dir, $name);
            $data['icon_image_url'] = '/uploads/features/'.$name;
        }

        $data['is_visible'] = (bool)($data['is_visible'] ?? false);
        $feature->update($data);
        return redirect()->route('admin.features.index')->with('status','Feature updated');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();

        // Renumber sort_order so remaining features are 1, 2, 3, ...
        $remaining = Feature::orderBy('sort_order')->orderBy('id')->get();
        foreach ($remaining as $i => $f) {
            $f->sort_order = $i + 1;
            $f->save();
        }

        return redirect()->route('admin.features.index')->with('status','Feature deleted');
    }

    public function toggleVisibility(Feature $feature)
    {
        $feature->is_visible = !$feature->is_visible;
        $feature->save();
        return back()->with('status', 'Visibility updated');
    }
}
