<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryItemController extends Controller
{
    public function index()
    {
        $items = GalleryItem::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image_url' => ['required','string','max:2000'],
            'label' => ['nullable','string','max:120'],
            'date_label' => ['nullable','string','max:24'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);
        GalleryItem::create($data);
        return redirect()->route('admin.gallery.index')->with('status','Gallery item created');
    }

    public function edit(GalleryItem $gallery)
    {
        return view('admin.gallery.edit', ['item' => $gallery]);
    }

    public function update(Request $request, GalleryItem $gallery)
    {
        $data = $request->validate([
            'image_url' => ['required','string','max:2000'],
            'label' => ['nullable','string','max:120'],
            'date_label' => ['nullable','string','max:24'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);
        $gallery->update($data);
        return redirect()->route('admin.gallery.index')->with('status','Gallery item updated');
    }

    public function destroy(GalleryItem $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('status','Gallery item deleted');
    }
}
