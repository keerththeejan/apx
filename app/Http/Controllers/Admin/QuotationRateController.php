<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dealer;
use App\Models\QuotationRate;
use Illuminate\Http\Request;

class QuotationRateController extends Controller
{
    public function index()
    {
        $rates = QuotationRate::with('dealers')->orderBy('sort_order')->orderBy('country')->orderBy('service')->orderBy('id')->get();
        return view('admin.quotationrates.index', compact('rates'));
    }

    public function create()
    {
        $dealers = Dealer::orderBy('sort_order')->orderBy('code')->get();
        return view('admin.quotationrates.create', compact('dealers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'country' => ['required', 'string', 'max:120'],
            'service' => ['required', 'string', 'max:120'],
            'customer_price' => ['required', 'numeric', 'min:0'],
            'dealer_price' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'dealer_ids' => ['nullable', 'array'],
            'dealer_ids.*' => ['integer', 'exists:dealers,id'],
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $dealerIds = $data['dealer_ids'] ?? [];
        unset($data['dealer_ids']);
        $rate = QuotationRate::create($data);
        $rate->dealers()->sync($dealerIds);
        return redirect()->route('admin.quotationrates.index')->with('status', 'Rate added.');
    }

    public function edit(QuotationRate $quotation_rate)
    {
        $rate = $quotation_rate->load('dealers');
        $dealers = Dealer::orderBy('sort_order')->orderBy('code')->get();
        return view('admin.quotationrates.edit', ['rate' => $rate, 'dealers' => $dealers]);
    }

    public function update(Request $request, QuotationRate $quotation_rate)
    {
        $data = $request->validate([
            'country' => ['required', 'string', 'max:120'],
            'service' => ['required', 'string', 'max:120'],
            'customer_price' => ['required', 'numeric', 'min:0'],
            'dealer_price' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'dealer_ids' => ['nullable', 'array'],
            'dealer_ids.*' => ['integer', 'exists:dealers,id'],
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $dealerIds = $data['dealer_ids'] ?? [];
        unset($data['dealer_ids']);
        $quotation_rate->update($data);
        $quotation_rate->dealers()->sync($dealerIds);
        return redirect()->route('admin.quotationrates.index')->with('status', 'Rate updated.');
    }

    public function destroy(QuotationRate $quotation_rate)
    {
        $quotation_rate->delete();
        return redirect()->route('admin.quotationrates.index')->with('status', 'Rate removed.');
    }
}
