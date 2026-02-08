<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerReview;
use Illuminate\Http\Request;

class CustomerReviewController extends Controller
{
    public function index()
    {
        $reviews = CustomerReview::orderBy('sort_order')->orderBy('id')->paginate(15);
        return view('admin.customerreviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('admin.customerreviews.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'role_or_company' => ['nullable', 'string', 'max:120'],
            'review_text' => ['required', 'string', 'max:2000'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_visible'] = (bool) ($data['is_visible'] ?? true);
        CustomerReview::create($data);
        return redirect()->route('admin.customerreviews.index')->with('status', 'Review added.');
    }

    public function edit(CustomerReview $customer_review)
    {
        return view('admin.customerreviews.edit', ['review' => $customer_review]);
    }

    public function update(Request $request, CustomerReview $customer_review)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'role_or_company' => ['nullable', 'string', 'max:120'],
            'review_text' => ['required', 'string', 'max:2000'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_visible' => ['nullable', 'boolean'],
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_visible'] = (bool) ($data['is_visible'] ?? false);
        $customer_review->update($data);
        return redirect()->route('admin.customerreviews.index')->with('status', 'Review updated.');
    }

    public function destroy(CustomerReview $customer_review)
    {
        $customer_review->delete();
        return redirect()->route('admin.customerreviews.index')->with('status', 'Review deleted.');
    }
}
