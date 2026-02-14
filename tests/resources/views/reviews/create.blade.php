<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php
    $seoSiteName = optional(\App\Models\Setting::where('key','site_name')->first())->value ?: 'Parcel Transport';
    $seoTitle = 'Add Your Review | ' . $seoSiteName;
    $seoDesc = 'Share your experience with ' . $seoSiteName . '. Leave a review for our parcel and logistics services.';
    $seoKw = optional(\App\Models\Setting::where('key','meta_keywords')->first())->value;
    $seoImg = optional(\App\Models\Setting::where('key','og_image')->first())->value;
  @endphp
  @include('partials.seo-meta', ['seoTitle' => $seoTitle, 'seoDescription' => $seoDesc, 'seoKeywords' => $seoKw, 'seoImage' => $seoImg, 'seoSiteName' => $seoSiteName])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --bg: #0b1220; --card: #0f172a; --muted: #94a3b8; --text: #e2e8f0; --blue: #3b82f6; --border: rgba(148,163,184,.12); }
    * { box-sizing: border-box }
    html { overflow-x: hidden }
    body { margin: 0; font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background: var(--bg); color: var(--text); overflow-x: hidden; min-width: 0 }
    .header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; padding: 14px 20px; background: var(--card); border-bottom: 1px solid var(--border); }
    .header h1 { margin: 0; font-size: clamp(18px, 3vw, 22px); font-weight: 800; }
    .btn { display: inline-block; padding: 10px 14px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.55); color: #fff; text-decoration: none; font-weight: 600; font-size: 14px; flex-shrink: 0 }
    .btn:hover { filter: brightness(1.1) }
    .wrap { max-width: 560px; margin: 0 auto; padding: 28px 24px; min-width: 0 }
    .review-add { padding: 0; background: transparent; border: none; border-radius: 0; max-width: none }
    .review-add h2 { margin: 0 0 8px; font-size: clamp(22px, 4vw, 28px); font-weight: 800; }
    .review-add .lead { color: var(--muted); margin: 0 0 20px; font-size: 15px; line-height: 1.5 }
    .review-add h3 { margin: 0 0 14px; font-size: 18px; font-weight: 700 }
    .review-add label { display: block; margin-bottom: 4px; color: var(--muted); font-size: 13px; font-weight: 600 }
    .review-add input, .review-add select, .review-add textarea { width: 100%; padding: 10px 12px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.6); color: var(--text); font-size: 15px; margin-bottom: 12px; box-sizing: border-box }
    .review-add textarea { min-height: 100px; resize: vertical }
    .review-add .review-submit { padding: 10px 18px; border-radius: 10px; border: 0; background: var(--blue); color: #fff; font-weight: 600; font-size: 15px; cursor: pointer }
    .review-add .review-submit:hover { filter: brightness(1.1) }
    .review-add .review-success { background: rgba(16,185,129,.15); color: #a7f3d0; border: 1px solid rgba(16,185,129,.35); padding: 10px 12px; border-radius: 10px; margin-bottom: 12px; font-size: 14px }
    .review-add .review-errors { background: rgba(239,68,68,.15); color: #fecaca; border: 1px solid rgba(239,68,68,.35); padding: 10px 12px; border-radius: 10px; margin-bottom: 12px; font-size: 14px; list-style: none; margin-left: 0; padding-left: 12px }
    @media (max-width: 576px) { .wrap { padding: 20px 16px } .header { padding: 12px 16px } }
  </style>
</head>
<body>
  <header class="header">
    <h1>Add your review</h1>
    <a class="btn" href="{{ url('/') }}">Home</a>
  </header>

  <main class="wrap">
    <section class="review-add" id="review-add" aria-label="Add your review">
      <h2>Add your review</h2>
      <p class="lead">Share your experience with us. Your review will be visible after approval.</p>
      @if(session('review_submitted'))
        <p class="review-success">Thank you! Your review has been submitted and will appear after approval.</p>
      @endif
      @if($errors->any())
        <ul class="review-errors">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      @endif
      <form action="{{ route('reviews.store') }}" method="POST">
        @csrf
        <label for="review_customer_name">Your name <span style="color:#ef4444">*</span></label>
        <input type="text" id="review_customer_name" name="customer_name" value="{{ old('customer_name') }}" placeholder="e.g. Sarah M." required maxlength="120">
        <label for="review_role">Role or company (optional)</label>
        <input type="text" id="review_role" name="role_or_company" value="{{ old('role_or_company') }}" placeholder="e.g. Small Business Owner" maxlength="120">
        <label for="review_rating">Rating</label>
        <select id="review_rating" name="rating" aria-label="Star rating">
          <option value="">— Select —</option>
          @for($i = 5; $i >= 1; $i--)
            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} ★</option>
          @endfor
        </select>
        <label for="review_text">Your review <span style="color:#ef4444">*</span></label>
        <textarea id="review_text" name="review_text" placeholder="Share your experience..." required maxlength="2000">{{ old('review_text') }}</textarea>
        <button type="submit" class="review-submit">Submit review</button>
      </form>
    </section>
  </main>
</body>
</html>
