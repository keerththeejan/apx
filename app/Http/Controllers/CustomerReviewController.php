<?php

namespace App\Http\Controllers;

use App\Models\CustomerReview;
use Illuminate\Http\Request;

class CustomerReviewController extends Controller
{
    /**
     * Show the "Add your review" form (separate page).
     */
    public function create()
    {
        return view('reviews.create');
    }

    /**
     * Store a customer review (public form submission).
     * New reviews are saved with is_visible = false for admin approval.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'role_or_company' => ['nullable', 'string', 'max:120'],
            'review_text' => ['required', 'string', 'max:2000'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $data['is_visible'] = false;
        $data['sort_order'] = 0;
        CustomerReview::create($data);

        return redirect()->route('reviews.create')->with('review_submitted', true);
    }
}
