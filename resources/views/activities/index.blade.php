@extends('layouts.public')

@push('head')
  @php
    $seoSiteName = optional(\App\Models\Setting::where('key','site_name')->first())->value ?: 'Parcel Transport';
    $seoTitle = 'Daily Activities | ' . $seoSiteName;
    $seoDesc = 'Latest daily activities and updates from ' . $seoSiteName . '. Logistics, shipping, and parcel delivery news.';
    $seoKw = optional(\App\Models\Setting::where('key','meta_keywords')->first())->value;
    $seoImg = optional(\App\Models\Setting::where('key','og_image')->first())->value;
  @endphp
  @include('partials.seo-meta', ['seoTitle' => $seoTitle, 'seoDescription' => $seoDesc, 'seoKeywords' => $seoKw, 'seoImage' => $seoImg, 'seoSiteName' => $seoSiteName])
@endpush

@push('styles')
  <style>
    :root { --act-border: rgba(148,163,184,.12); }
    .activities-wrap { width: 100%; max-width: 1200px; margin: 0 auto; padding: 24px var(--content-gutter, 24px); min-width: 0; box-sizing: border-box }
    .activities-top { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 24px; flex-wrap: wrap }
    .activities-top h1 { margin: 0; font-size: clamp(24px, 4vw, 32px); font-weight: 800; }
    .activities-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; min-width: 0 }
    .act-card { background: var(--card); border: 1px solid var(--act-border); border-radius: 16px; overflow: hidden; transition: box-shadow .25s ease, transform .2s ease }
    .act-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,.2); transform: translateY(-2px) }
    body[data-theme="light"] .act-card { background: #fff; border-color: rgba(15,23,42,.08); box-shadow: 0 2px 12px rgba(0,0,0,.04) }
    body[data-theme="light"] .act-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,.1) }
    .act-card .card-img-top { width: 100%; height: 180px; object-fit: cover; display: block; background: #0b1220 }
    .act-card .card-body { padding: 20px }
    .act-card .card-title { margin: 0 0 8px; font-size: 1.1rem; font-weight: 700; line-height: 1.35; color: var(--text) }
    .act-card .act-meta { color: var(--muted); font-size: 13px; margin-bottom: 10px; font-weight: 500 }
    .act-card .card-text { margin: 0; color: var(--muted); font-size: 14px; line-height: 1.55 }
    .clamp2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden }
    .clamp2.expanded { display: block; -webkit-line-clamp: unset; overflow: visible }
    .act-card .act-readmore { padding: 0; border: 0; background: none; color: #93c5fd; font-weight: 600; font-size: 14px; cursor: pointer; text-decoration: none; display: inline-block; margin-top: 6px }
    .act-card .act-readmore:hover { text-decoration: underline; color: #60a5fa }
    .act-btn-back { border-radius: 12px; padding: 10px 18px; font-weight: 600 }
    .act-empty-card { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 280px; text-align: center; color: var(--muted) }
    .act-empty-card .card-title { font-size: 1.25rem }
    .activities-pager { margin-top: 28px }
    .activities-pager nav { display: flex; justify-content: center; flex-wrap: wrap }
    .activities-pager nav a, .activities-pager nav span { display: inline-flex; align-items: center; justify-content: center; min-width: 40px; padding: 10px 14px; margin: 0 3px; border-radius: 10px; border: 1px solid rgba(148,163,184,.2); background: rgba(15,23,42,.4); color: var(--text); text-decoration: none; font-weight: 600; font-size: 14px; transition: all .2s }
    .activities-pager nav a:hover { background: rgba(148,163,184,.15); border-color: rgba(148,163,184,.3) }
    .activities-pager nav span[aria-current="page"] { background: var(--blue); border-color: transparent; color: #fff }
    body[data-theme="light"] .activities-pager nav a, body[data-theme="light"] .activities-pager nav span { background: rgba(15,23,42,.06); border-color: rgba(15,23,42,.12); color: var(--text) }
    body[data-theme="light"] .activities-pager nav span[aria-current="page"] { background: var(--blue); color: #fff }
    @media (min-width: 1400px) { .activities-grid { grid-template-columns: repeat(4, 1fr) } }
    @media (max-width: 992px) { .activities-grid { grid-template-columns: repeat(2, 1fr); gap: 20px } .activities-wrap { padding: 20px var(--content-gutter, 20px) } }
    @media (max-width: 768px) { .activities-wrap { padding: 16px var(--content-gutter, 16px) } .activities-grid { gap: 16px } .act-card .card-img-top { height: 160px } .act-card .card-body { padding: 16px } .act-card .card-title { font-size: 1rem } }
    @media (max-width: 576px) { .activities-grid { grid-template-columns: 1fr; gap: 20px } .activities-top { flex-direction: column; align-items: flex-start } .activities-wrap { padding: 14px var(--content-gutter, 14px) } .act-card .card-img-top { height: 200px } .act-card .card-body { padding: 14px } }
    @media (max-width: 400px) { .activities-wrap { padding: 12px var(--content-gutter, 12px) } }
  </style>
@endpush

@section('content')
  @php
    $toUrl = function ($p) {
      if (empty($p)) return null;
      $p = trim((string) $p);
      if (\Illuminate\Support\Str::startsWith($p, ['http://','https://','data:'])) return $p;
      $path = ltrim($p, '/');
      if (\Illuminate\Support\Str::startsWith($path, 'uploads/')) { $path = 'public/'.$path; }
      return asset($path);
    };
  @endphp
  <div class="activities-wrap">
    <div class="activities-top">
      <h1>Daily Activities</h1>
      <a class="btn btn-outline-secondary act-btn-back" href="{{ url('/') }}">Back to Home</a>
    </div>

    <div class="activities-grid">
      @forelse($activities as $a)
        <article class="act-card card">
          @if(!empty($a->image_url))
            <img src="{{ $toUrl($a->image_url) }}" class="card-img-top" alt="{{ $a->title }}">
          @else
            <img src="https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=1200&auto=format&fit=crop" class="card-img-top" alt="{{ $a->title }}">
          @endif
          <div class="card-body">
            <h3 class="card-title">{{ $a->title }}</h3>
            <div class="act-meta">{{ $a->activity_date ? $a->activity_date->format('M j, Y') : '' }}</div>
            @php
              $bodyText = trim((string)($a->body ?? ''));
              $hasMore = \Illuminate\Support\Str::length($bodyText) > 220;
            @endphp
            <p class="card-text clamp2 js-clamp">{{ $bodyText }}</p>
            @if($hasMore)
              <button type="button" class="act-readmore js-readmore" tabindex="0">Read more</button>
            @endif
          </div>
        </article>
      @empty
        <div class="act-card card act-empty-card">
          <div class="card-body">
            <h3 class="card-title">No posts yet</h3>
            <p class="card-text mb-0">No activities found.</p>
          </div>
        </div>
      @endforelse
    </div>

    @if($activities->hasPages())
      <div class="activities-pager">
        {!! $activities->withQueryString()->links() !!}
      </div>
    @endif
  </div>
@endsection

@push('scripts')
  <script>
    (function(){
      function initReadMore() {
        document.querySelectorAll('.js-readmore').forEach(function(btn) {
          if (btn._readmoreInit) return;
          btn._readmoreInit = true;
          btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var cardBody = btn.closest('.card-body');
            if (!cardBody) return;
            var p = cardBody.querySelector('.js-clamp');
            if (!p) return;
            var expanded = p.classList.toggle('expanded');
            btn.textContent = expanded ? 'Show less' : 'Read more';
          });
          btn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
              e.preventDefault();
              btn.click();
            }
          });
        });
      }
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initReadMore);
      } else {
        initReadMore();
      }
    })();
  </script>
@endpush
