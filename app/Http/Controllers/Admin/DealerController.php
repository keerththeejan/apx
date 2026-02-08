<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dealer;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    public function index()
    {
        $dealers = Dealer::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.dealers.index', compact('dealers'));
    }

    public function create()
    {
        return view('admin.dealers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:60', 'unique:dealers,code'],
            'name' => ['nullable', 'string', 'max:120'],
            'discount_percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        Dealer::create($data);
        return redirect()->route('admin.dealers.index')->with('status', 'Dealer created.');
    }

    public function edit(Dealer $dealer)
    {
        return view('admin.dealers.edit', compact('dealer'));
    }

    public function update(Request $request, Dealer $dealer)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:60', 'unique:dealers,code,' . $dealer->id],
            'name' => ['nullable', 'string', 'max:120'],
            'discount_percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $dealer->update($data);
        return redirect()->route('admin.dealers.index')->with('status', 'Dealer updated.');
    }

    public function destroy(Dealer $dealer)
    {
        $dealer->delete();
        return redirect()->route('admin.dealers.index')->with('status', 'Dealer removed.');
    }
}
