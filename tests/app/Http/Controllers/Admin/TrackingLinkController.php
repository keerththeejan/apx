<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrackingLink;
use Illuminate\Http\Request;

class TrackingLinkController extends Controller
{
    public function index()
    {
        $links = TrackingLink::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.trackinglinks.index', compact('links'));
    }

    public function create()
    {
        return view('admin.trackinglinks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'url_template' => ['required', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);
        $data['is_visible'] = $request->boolean('is_visible');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        TrackingLink::create($data);
        return redirect()->route('admin.trackinglinks.index')->with('status', 'Tracking link created.');
    }

    public function edit(TrackingLink $tracking_link)
    {
        return view('admin.trackinglinks.edit', ['link' => $tracking_link]);
    }

    public function update(Request $request, TrackingLink $tracking_link)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'url_template' => ['required', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);
        $data['is_visible'] = $request->boolean('is_visible');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $tracking_link->update($data);
        return redirect()->route('admin.trackinglinks.index')->with('status', 'Tracking link updated.');
    }

    public function destroy(TrackingLink $tracking_link)
    {
        $tracking_link->delete();
        return redirect()->route('admin.trackinglinks.index')->with('status', 'Tracking link deleted.');
    }
}
