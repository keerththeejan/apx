<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavLink;
use Illuminate\Http\Request;

class NavLinkController extends Controller
{
    public function index()
    {
        $links = NavLink::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.navlinks.index', compact('links'));
    }

    public function create()
    {
        return view('admin.navlinks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => ['required','string','max:80'],
            'icon' => ['nullable','string','max:20'],
            'url' => ['required','string','max:255'],
            'target' => ['nullable','in:_self,_blank'],
            'is_visible' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);
        $data['is_visible'] = (bool)($data['is_visible'] ?? false);
        NavLink::create($data);
        return redirect()->route('admin.navlinks.index')->with('status','Link created');
    }

    public function edit(NavLink $nav_link)
    {
        return view('admin.navlinks.edit', ['link' => $nav_link]);
    }

    public function update(Request $request, NavLink $nav_link)
    {
        $data = $request->validate([
            'label' => ['required','string','max:80'],
            'icon' => ['nullable','string','max:20'],
            'url' => ['required','string','max:255'],
            'target' => ['nullable','in:_self,_blank'],
            'is_visible' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);
        $data['is_visible'] = (bool)($data['is_visible'] ?? false);
        $nav_link->update($data);
        return redirect()->route('admin.navlinks.index')->with('status','Link updated');
    }

    public function destroy(NavLink $nav_link)
    {
        $nav_link->delete();
        return redirect()->route('admin.navlinks.index')->with('status','Link deleted');
    }

    public function moveUp(NavLink $nav_link)
    {
        $links = NavLink::orderBy('sort_order')->orderBy('id')->get();
        $pos = $links->search(fn ($l) => (int) $l->id === (int) $nav_link->id);
        if ($pos > 0) {
            $prev = $links[$pos - 1];
            $tmp = $nav_link->sort_order;
            $nav_link->update(['sort_order' => $prev->sort_order]);
            $prev->update(['sort_order' => $tmp]);
        }
        return redirect()->route('admin.navlinks.index')->with('status', 'Order updated');
    }

    public function moveDown(NavLink $nav_link)
    {
        $links = NavLink::orderBy('sort_order')->orderBy('id')->get();
        $pos = $links->search(fn ($l) => (int) $l->id === (int) $nav_link->id);
        if ($pos >= 0 && $pos < $links->count() - 1) {
            $next = $links[$pos + 1];
            $tmp = $nav_link->sort_order;
            $nav_link->update(['sort_order' => $next->sort_order]);
            $next->update(['sort_order' => $tmp]);
        }
        return redirect()->route('admin.navlinks.index')->with('status', 'Order updated');
    }
}
