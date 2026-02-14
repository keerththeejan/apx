<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email','max:255'],
        ]);

        NewsletterSubscription::firstOrCreate(['email' => strtolower($data['email'])]);

        return back()->with('status', 'Thanks! You\'re subscribed.');
    }
}
