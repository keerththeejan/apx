<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyActivity;
use Illuminate\Http\Request;

class DailyActivityController extends Controller
{
    public function index()
    {
        $items = DailyActivity::orderByDesc('activity_date')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(12);

        return view('admin.activities.index', compact('items'));
    }

    public function toggleVisibility(DailyActivity $activity)
    {
        $activity->is_visible = !$activity->is_visible;
        $activity->save();

        return response()->json([
            'ok' => true,
            'id' => $activity->id,
            'is_visible' => (bool) $activity->is_visible,
        ]);
    }

    public function updateSortOrder(Request $request, DailyActivity $activity)
    {
        $data = $request->validate([
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $activity->sort_order = (int) $data['sort_order'];
        $activity->save();

        return response()->json([
            'ok' => true,
            'id' => $activity->id,
            'sort_order' => (int) $activity->sort_order,
        ]);
    }

    public function create()
    {
        return view('admin.activities.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'activity_date' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
            'image_url' => ['nullable', 'string', 'max:2000'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ]);

        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $dir = public_path('uploads/activities');
            if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
            $ext = $request->file('image_file')->getClientOriginalExtension() ?: 'jpg';
            $name = 'activity_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)), 0, 8).'.'.$ext;
            $request->file('image_file')->move($dir, $name);
            $data['image_url'] = '/public/uploads/activities/'.$name;
        }

        $data['is_visible'] = (bool)($data['is_visible'] ?? true);
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        DailyActivity::create($data);

        return redirect()->route('admin.activities.index')->with('status', 'Activity created');
    }

    public function edit(DailyActivity $activity)
    {
        return view('admin.activities.edit', ['item' => $activity]);
    }

    public function update(Request $request, DailyActivity $activity)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'activity_date' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
            'image_url' => ['nullable', 'string', 'max:2000'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ]);

        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            $dir = public_path('uploads/activities');
            if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
            $ext = $request->file('image_file')->getClientOriginalExtension() ?: 'jpg';
            $name = 'activity_'.date('Ymd_His').'_'.substr(bin2hex(random_bytes(4)), 0, 8).'.'.$ext;
            $request->file('image_file')->move($dir, $name);
            $data['image_url'] = '/public/uploads/activities/'.$name;
        }

        $data['is_visible'] = (bool)($data['is_visible'] ?? false);
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        $activity->update($data);

        return redirect()->route('admin.activities.index')->with('status', 'Activity updated');
    }

    public function destroy(DailyActivity $activity)
    {
        $activity->delete();

        // Renumber sort_order so remaining activities are 1, 2, 3, ...
        $remaining = DailyActivity::orderByDesc('activity_date')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();
        foreach ($remaining as $i => $item) {
            $item->sort_order = $i + 1;
            $item->save();
        }

        return redirect()->route('admin.activities.index')->with('status', 'Activity deleted');
    }
}
