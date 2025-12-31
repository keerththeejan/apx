<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpItem;
use Illuminate\Http\Request;

class HelpItemController extends Controller
{
    public function index()
    {
        $items = HelpItem::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.helpitems.index', compact('items'));
    }

    public function create()
    {
        return view('admin.helpitems.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'icon' => ['nullable','string','max:10'],
            'title' => ['required','string','max:120'],
            'description' => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);
        HelpItem::create($data);
        return redirect()->route('admin.helpitems.index')->with('status','Help item created');
    }

    public function edit(HelpItem $help_item)
    {
        return view('admin.helpitems.edit', ['item' => $help_item]);
    }

    public function update(Request $request, HelpItem $help_item)
    {
        $data = $request->validate([
            'icon' => ['nullable','string','max:10'],
            'title' => ['required','string','max:120'],
            'description' => ['nullable','string'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);
        $help_item->update($data);
        return redirect()->route('admin.helpitems.index')->with('status','Help item updated');
    }

    public function destroy(HelpItem $help_item)
    {
        $help_item->delete();
        return redirect()->route('admin.helpitems.index')->with('status','Help item deleted');
    }
}
