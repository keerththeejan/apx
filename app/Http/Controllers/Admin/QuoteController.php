<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\Service;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Quote::query()->latest();
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($service = $request->get('service_id')) {
            $query->where('service_id', $service);
        }
        $quotes = $query->paginate(10);
        $services = Service::orderBy('title')->get(['id','title']);
        return view('admin.quotes.index', compact('quotes','services'));
    }

    public function show(Quote $quote)
    {
        return view('admin.quotes.show', compact('quote'));
    }

    public function edit(Quote $quote)
    {
        $services = Service::orderBy('title')->get(['id','title']);
        return view('admin.quotes.edit', compact('quote','services'));
    }

    public function update(Request $request, Quote $quote)
    {
        $data = $request->validate([
            'status' => 'required|string|in:new,in_progress,closed',
            'notes' => 'nullable|string',
            'service_id' => 'nullable|integer|exists:services,id',
        ]);
        $quote->update($data);
        return redirect()->route('admin.quotes.show', $quote)->with('status', 'Quote updated successfully.');
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('admin.quotes.index')->with('status', 'Quote deleted.');
    }
}
