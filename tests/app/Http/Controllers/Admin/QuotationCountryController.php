<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuotationCountry;
use Illuminate\Http\Request;

class QuotationCountryController extends Controller
{
    public function index()
    {
        $countries = QuotationCountry::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.quotationcountries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.quotationcountries.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'code' => ['nullable', 'string', 'max:20'],
            'rate_per_kg' => ['required', 'numeric', 'min:0'],
            'base_fee' => ['nullable', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['base_fee'] = $data['base_fee'] ?? 0;
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        QuotationCountry::create($data);
        return redirect()->route('admin.quotationcountries.index')->with('status', 'Country added.');
    }

    public function edit(QuotationCountry $quotation_country)
    {
        return view('admin.quotationcountries.edit', ['country' => $quotation_country]);
    }

    public function update(Request $request, QuotationCountry $quotation_country)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'code' => ['nullable', 'string', 'max:20'],
            'rate_per_kg' => ['required', 'numeric', 'min:0'],
            'base_fee' => ['nullable', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['base_fee'] = $data['base_fee'] ?? 0;
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $quotation_country->update($data);
        return redirect()->route('admin.quotationcountries.index')->with('status', 'Country updated.');
    }

    public function destroy(QuotationCountry $quotation_country)
    {
        $quotation_country->delete();
        return redirect()->route('admin.quotationcountries.index')->with('status', 'Country removed.');
    }
}
