<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::orderBy('sort_order')->orderBy('id')->get();
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
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);
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
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);
        $feature->update($data);
        return redirect()->route('admin.features.index')->with('status','Feature updated');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return redirect()->route('admin.features.index')->with('status','Feature deleted');
    }
}
