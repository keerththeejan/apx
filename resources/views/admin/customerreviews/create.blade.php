@extends('admin.layout')

@section('title', 'Add Customer Review - Admin')

@section('content')
  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; gap:8px; align-items:center; margin-bottom:12px">
    <a class="btn" href="{{ route('admin.customerreviews.index') }}">Back</a>
    <h2 style="margin:0">Add Customer Review</h2>
  </div>

  <form method="POST" action="{{ route('admin.customerreviews.store') }}">
    @csrf

    <label for="customer_name">Customer name</label>
    <input id="customer_name" type="text" name="customer_name" value="{{ old('customer_name') }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)" required>

    <label for="role_or_company">Role / Company (optional)</label>
    <input id="role_or_company" type="text" name="role_or_company" value="{{ old('role_or_company') }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)" placeholder="e.g. Logistics Manager">

    <label for="review_text">Review text</label>
    <textarea id="review_text" name="review_text" class="input" style="min-height:120px; padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)" required>{{ old('review_text') }}</textarea>

    <label for="rating">Rating (1–5 stars, optional)</label>
    <select id="rating" name="rating" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">
      <option value="">— No rating —</option>
      @for($i = 1; $i <= 5; $i++)
        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} ★</option>
      @endfor
    </select>

    <label for="sort_order">Sort order</label>
    <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">

    <label style="display:flex; align-items:center; gap:8px; margin-top:10px">
      <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', true) ? 'checked' : '' }}>
      <span>Visible on site</span>
    </label>

    <div class="actions" style="margin-top:12px; display:flex; gap:8px">
      <button class="btn" type="submit">Save Review</button>
      <a class="btn" href="{{ route('admin.customerreviews.index') }}">Cancel</a>
    </div>
  </form>
@endsection
