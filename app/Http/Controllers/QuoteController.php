<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'service_id' => 'nullable|integer|exists:services,id',
            'phone' => 'nullable|string|max:100',
            'message' => 'required|string',
        ]);

        Quote::create($data);

        return back()->with('status', 'Thank you! Your quote request was submitted.');
    }
}
