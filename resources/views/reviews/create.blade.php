@extends('layouts.public')

@push('head')
  @php
    $seoSiteName = optional(\App\Models\Setting::where('key','site_name')->first())->value ?: 'Parcel Transport';
    $seoTitle = 'Add Your Review | ' . $seoSiteName;
    $seoDesc = 'Share your experience with ' . $seoSiteName . '. Leave a review for our parcel and logistics services.';
    $seoKw = optional(\App\Models\Setting::where('key','meta_keywords')->first())->value;
    $seoImg = optional(\App\Models\Setting::where('key','og_image')->first())->value;
  @endphp
  @include('partials.seo-meta', ['seoTitle' => $seoTitle, 'seoDescription' => $seoDesc, 'seoKeywords' => $seoKw ?? null, 'seoImage' => $seoImg ?? null, 'seoSiteName' => $seoSiteName])
@endpush

@push('styles')
  <style>
    .review-wrap { max-width: 560px; margin: 0 auto; padding: 24px var(--content-gutter, 24px); min-width: 0; box-sizing: border-box }
    .review-card { background: var(--card); border: 1px solid rgba(148,163,184,.12); border-radius: 16px; padding: 28px; box-shadow: 0 4px 20px rgba(0,0,0,.15) }
    body[data-theme="light"] .review-card { background: #fff; border-color: rgba(15,23,42,.08); box-shadow: 0 4px 20px rgba(0,0,0,.06) }
    .review-add h2 { margin: 0 0 8px; font-size: clamp(22px, 4vw, 28px); font-weight: 800; }
    .review-add .lead { color: var(--muted); margin: 0 0 24px; font-size: 15px; line-height: 1.5 }
    .review-add .form-control, .review-add .form-select { background: rgba(15,23,42,.6); border-color: rgba(148,163,184,.25); color: var(--text) }
    .review-add .form-control:focus, .review-add .form-select:focus { background: rgba(15,23,42,.7); border-color: var(--blue); color: var(--text); box-shadow: 0 0 0 3px rgba(59,130,246,.25) }
    .review-add .form-control::placeholder { color: var(--muted); opacity: .8 }
    body[data-theme="light"] .review-add .form-control, body[data-theme="light"] .review-add .form-select { background: rgba(15,23,42,.06); border-color: rgba(15,23,42,.15); color: var(--text) }
    body[data-theme="light"] .review-add .form-control:focus, body[data-theme="light"] .review-add .form-select:focus { background: rgba(15,23,42,.08); border-color: var(--blue) }
    .review-add .form-label { color: var(--muted); font-weight: 600; font-size: 14px }
    .review-add .review-submit { padding: 12px 24px; font-size: 16px; font-weight: 600; border-radius: 12px }
    .review-add .review-success { border-radius: 12px; padding: 14px 16px }
    .review-add .review-errors { border-radius: 12px; padding: 14px 16px; list-style: none; padding-left: 16px }
    .review-add .btn-outline-secondary { border-color: rgba(148,163,184,.3); color: var(--muted) }
    .review-add .btn-outline-secondary:hover { background: rgba(148,163,184,.15); border-color: rgba(148,163,184,.4); color: var(--text) }
    @media (max-width: 576px) { .review-wrap { padding: 20px var(--content-gutter, 16px) } .review-card { padding: 20px } }
  </style>
@endpush

@section('content')
  <div class="review-wrap">
    <section class="review-add" id="review-add" aria-label="Add your review">
      <div class="review-card">
        <h2>Add your review</h2>
        <p class="lead">Share your experience with us. Your review will be visible after approval.</p>
        @if(session('review_submitted'))
          <div class="alert alert-success review-success mb-4" role="alert">
            Thank you! Your review has been submitted and will appear after approval.
          </div>
        @endif
        @if($errors->any())
          <ul class="alert alert-danger review-errors mb-4">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        @endif
        <form action="{{ route('reviews.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="review_customer_name" class="form-label">Your name <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-lg" id="review_customer_name" name="customer_name" value="{{ old('customer_name') }}" placeholder="e.g. Sarah M." required maxlength="120">
          </div>
          <div class="mb-3">
            <label for="review_role" class="form-label">Role or company (optional)</label>
            <input type="text" class="form-control" id="review_role" name="role_or_company" value="{{ old('role_or_company') }}" placeholder="e.g. Small Business Owner" maxlength="120">
          </div>
          <div class="mb-3">
            <label for="review_rating" class="form-label">Rating</label>
            <select class="form-select" id="review_rating" name="rating" aria-label="Star rating">
              <option value="">— Select —</option>
              @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} ★</option>
              @endfor
            </select>
          </div>
          <div class="mb-4">
            <label for="review_text" class="form-label">Your review <span class="text-danger">*</span></label>
            <textarea class="form-control" id="review_text" name="review_text" rows="5" placeholder="Share your experience..." required maxlength="2000">{{ old('review_text') }}</textarea>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <button type="submit" class="btn btn-primary review-submit">Submit review</button>
            <a class="btn btn-outline-secondary" href="{{ url('/') }}">Back to Home</a>
          </div>
        </form>
      </div>
    </section>
  </div>
@endsection
