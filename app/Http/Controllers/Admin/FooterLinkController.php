<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use Illuminate\Http\Request;

class FooterLinkController extends Controller
{
    public function index()
    {
        $links = FooterLink::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.footerlinks.index', compact('links'));
    }

    public function create()
    {
        return view('admin.footerlinks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => ['required','string','max:120'],
            'url' => ['required','string','max:2000'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['nullable','boolean'],
        ]);
        $data['is_visible'] = $request->boolean('is_visible');
        FooterLink::create($data);
        return redirect()->route('admin.footerlinks.index')->with('status','Footer link created');
    }

    public function edit(FooterLink $footer_link)
    {
        return view('admin.footerlinks.edit', ['link' => $footer_link]);
    }

    public function update(Request $request, FooterLink $footer_link)
    {
        $data = $request->validate([
            'label' => ['required','string','max:120'],
            'url' => ['required','string','max:2000'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_visible' => ['nullable','boolean'],
        ]);
        $data['is_visible'] = $request->boolean('is_visible');
        $footer_link->update($data);
        return redirect()->route('admin.footerlinks.index')->with('status','Footer link updated');
    }

    public function destroy(FooterLink $footer_link)
    {
        $footer_link->delete();
        return redirect()->route('admin.footerlinks.index')->with('status','Footer link deleted');
    }
}
