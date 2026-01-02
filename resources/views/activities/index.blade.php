<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daily Activities</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --bg: #0b1220; --card: #0f172a; --muted:#94a3b8; --text:#e2e8f0; --blue:#3b82f6; --border: rgba(148,163,184,.12); }
    * { box-sizing: border-box }
    body { margin:0; font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background: var(--bg); color: var(--text); }
    .hero-banner { position: relative; min-height: var(--banner-h, 360px); display:grid; place-items:center; text-align:center; }
    .hero-banner::before { content:""; position:absolute; inset:0; background: var(--hero-bg, url('https://images.unsplash.com/photo-1483683804023-6ccdb62f86ef?q=80&w=1600&auto=format&fit=crop')) var(--hero-pos, center) / var(--hero-size, cover) no-repeat; filter: brightness(.7); }
    .hero-banner::after { content:""; position:absolute; inset:0; background: linear-gradient(to bottom, rgba(2,6,23,.55), rgba(2,6,23,.45)); }
    .hero-content { position:relative; padding: 0 24px; width: 80%; max-width: var(--hero-content-w, 950px) }
    .hero-title { margin:0; font-size: clamp(26px, 4vw, 40px); line-height:1.1; font-weight:800; text-shadow: 0 2px 6px rgba(0,0,0,.35) }
    .hero-sub { margin:10px 0 0; color:#d1d5db; font-weight:500; opacity:.9 }

    .wrap { width: 100%; max-width: 1200px; margin: 0 auto; padding: 18px 24px; }
    .top { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom: 14px }
    .btn { display:inline-block; padding:10px 14px; border-radius:10px; border:1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.55); color:#fff; text-decoration:none; font-weight:600 }
    .grid { display:grid; grid-template-columns: repeat(3, 1fr); gap: 22px; }
    .card { background: rgba(15,23,42,.6); border:1px solid var(--border); border-radius:14px; overflow:hidden; }
    .card img { width:100%; height:150px; object-fit:cover; display:block; background:#0b1220 }
    .pad { padding:16px }
    .card h3 { margin:0 0 6px; font-size:18px }
    .meta { color: var(--muted); font-size:12px; margin-bottom:10px }
    .card p { margin:0; color: var(--muted); font-size:14px; line-height:1.5 }
    .clamp2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden }
    .clamp2.expanded { display:block; -webkit-line-clamp:unset; overflow:visible }
    .readmore { margin-top:8px; border:0; background:transparent; color:#93c5fd; font-weight:700; cursor:pointer; padding:0 }
    .readmore:hover { text-decoration: underline }
    .pager { margin-top: 16px; }
    .pager nav { display:flex; gap:8px; flex-wrap:wrap }
    .pager a, .pager span { padding:8px 10px; border-radius:10px; border:1px solid rgba(148,163,184,.18); color:#e2e8f0; text-decoration:none; background: rgba(15,23,42,.35) }
    .pager span[aria-current="page"] { background: var(--blue); border-color: transparent }
    @media (max-width: 1100px) { .grid { grid-template-columns: repeat(2, 1fr) } }
    @media (max-width: 620px) { .grid { grid-template-columns: 1fr } }
  </style>
</head>
<body>
  @php
    $toUrl = function ($p) {
      if (empty($p)) return null;
      $p = trim((string) $p);
      if (\Illuminate\Support\Str::startsWith($p, ['http://','https://','data:'])) return $p;
      $path = ltrim($p, '/');
      if (\Illuminate\Support\Str::startsWith($path, 'uploads/')) {
        $path = 'public/'.$path;
      }
      return asset($path);
    };
    $bannerBgSrc = null;
    if (isset($banner) && $banner && !empty($banner->bg_image_url)) {
      $bannerBgSrc = $toUrl($banner->bg_image_url);
    }
  @endphp

  <section class="hero-banner" style="{{ !empty($bannerBgSrc) ? "--hero-bg: url('".$bannerBgSrc."');" : '' }}{{ isset($banner) && $banner && !empty($banner->banner_height_px) ? "--banner-h: ".(int)$banner->banner_height_px."px;" : '' }}{{ isset($banner) && $banner && !empty($banner->bg_position) ? "--hero-pos: ".$banner->bg_position.";" : '' }}{{ isset($banner) && $banner && !empty($banner->bg_size) ? "--hero-size: ".$banner->bg_size.";" : '' }}{{ isset($banner) && $banner && !empty($banner->banner_content_max_width_px) ? "--hero-content-w: ".(int)$banner->banner_content_max_width_px."px;" : '' }}">
    <div class="hero-content">
      <h1 class="hero-title">Daily Activities</h1>
      <p class="hero-sub">{{ optional($banner)->subtitle ?? 'Latest updates and activities.' }}</p>
    </div>
  </section>

  <div class="wrap">
    <div class="top">
      <h1 style="margin:0">Daily Activities</h1>
      <a class="btn" href="{{ url()->previous() }}">Back</a>
    </div>

    <div class="grid">
      @forelse($activities as $a)
        <div class="card">
          @if(!empty($a->image_url))
            <img src="{{ $toUrl($a->image_url) }}" alt="{{ $a->title }}">
          @else
            <img src="https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=1200&auto=format&fit=crop" alt="{{ $a->title }}">
          @endif
          <div class="pad">
            <h3>{{ $a->title }}</h3>
            <div class="meta">{{ $a->activity_date ? $a->activity_date->format('Y-m-d') : '' }}</div>
            @php
              $bodyText = trim((string)($a->body ?? ''));
              $hasMore = \Illuminate\Support\Str::length($bodyText) > 220;
            @endphp
            <p class="clamp2 js-clamp">{{ $bodyText }}</p>
            @if($hasMore)
              <button type="button" class="readmore js-readmore">Read more</button>
            @endif
          </div>
        </div>
      @empty
        <div class="card">
          <img src="https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=1200&auto=format&fit=crop" alt="No posts">
          <div class="pad">
            <h3>No posts yet</h3>
            <div class="meta"> </div>
            <p>No activities found.</p>
          </div>
        </div>
      @endforelse
    </div>

    <div class="pager">
      {!! $activities->links() !!}
    </div>
  </div>

  <script>
    (function(){
      document.addEventListener('click', function(e){
        const btn = e.target && e.target.closest ? e.target.closest('.js-readmore') : null;
        if (!btn) return;
        const pad = btn.closest('.pad');
        if (!pad) return;
        const p = pad.querySelector('.js-clamp');
        if (!p) return;
        const expanded = p.classList.toggle('expanded');
        btn.textContent = expanded ? 'Show less' : 'Read more';
      });
    })();
  </script>
</body>
</html>
