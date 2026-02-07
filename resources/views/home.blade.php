<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Parcel Transport • Home</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --bg: #0b1220; --card: #0f172a; --muted:#94a3b8; --text:#e2e8f0; --brand:#1e293b; --blue:#3b82f6; }
    body[data-theme="light"] { --bg:#f8fafc; --card:#ffffff; --muted:#475569; --text:#0f172a; --brand:#e2e8f0; --blue:#2563eb }
    * { box-sizing: border-box }
    html, body { height: 100% }
    body { margin:0; font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; background: var(--bg); color: var(--text); }
    .topbar { background: var(--header-bg, var(--bg)); border-bottom: 1px solid var(--header-border, rgba(148,163,184,.12)); position: sticky; top:0; z-index:10 }
    .nav { position:relative; max-width: 1200px; margin: 0 auto; padding: 10px 24px; display:flex; align-items:center; justify-content:space-between; gap:14px }
    .brand { display:flex; align-items:center; justify-content:flex-start; gap:10px; font-weight:800; text-align:left; margin-right:auto; margin-left:-2in }
    .brand img { width:4in; height:auto; max-height:1.5in; border-radius:8px; object-fit:contain; border:1px solid rgba(148,163,184,.25); display:block }
    .brand span { line-height:1.05; color: var(--header-text, var(--text)); font-size: var(--brand-size, 16px); font-weight: var(--brand-weight, 800); font-style: var(--brand-style, normal) }
    .brand small { color: var(--header-tagline, var(--muted)); font-weight:600; display:block; line-height:1.1; font-size: var(--tagline-size, 14px) }
    .links { display:flex; align-items:center; gap:22px }
    .links a { color: var(--header-link, var(--muted)); text-decoration:none; font-weight:600 }
    .links a:hover { color: var(--header-text, var(--text)) }
    .hamb { display:none; background: rgba(17,24,39,.6); color: var(--header-text, #e2e8f0); border:1px solid var(--header-border, rgba(148,163,184,.25)); padding:8px 10px; border-radius:10px; font-weight:700 }
    .themebtn { display:inline-block; background: rgba(17,24,39,.6); color: var(--header-text, #e2e8f0); border:1px solid var(--header-border, rgba(148,163,184,.25)); padding:8px 10px; border-radius:10px; font-weight:700; cursor:pointer }
    body[data-theme="light"] .hamb,
    body[data-theme="light"] .themebtn { background: rgba(226,232,240,.85); color: var(--header-text, var(--text)) }
    @media (max-width: 720px){
      .links { position:absolute; right:24px; top:calc(100% + 8px); z-index:50; background: var(--header-bg, #0b1220); border:1px solid var(--header-border, rgba(148,163,184,.12)); border-radius:12px; padding:10px; display:none; flex-direction:column; gap:6px; min-width: 200px; box-shadow: 0 16px 40px rgba(0,0,0,.35) }
      .links a { margin:6px 0 0 0 }
      .links.open { display:flex }
      .hamb { display:inline-block }
      .themebtn { display:none }
      .brand img { width:4in; height:auto; max-height:1.5in; border-radius:7px; object-fit:contain }
      .brand small { display:none }
    }
    .icon { width:18px; height:18px; opacity:.9; vertical-align:-3px; margin-right:6px }
    .hero-banner { position: relative; min-height: var(--banner-h, clamp(560px, 72vh, 900px)); display:grid; place-items:center; text-align:center; overflow: hidden; }
    .hero-banner__slides { position: absolute; inset: 0; z-index: 0; }
    .hero-banner__slide { position: absolute; inset: 0; background-position: var(--hero-pos, center); background-size: var(--hero-size, cover); background-repeat: no-repeat; opacity: 0; transition: opacity 0.6s ease; filter: brightness(.7); }
    .hero-banner__slide.active { opacity: 1; z-index: 1; }
    .hero-banner__overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(2,6,23,.55), rgba(2,6,23,.45)); z-index: 2; pointer-events: none; }
    .hero-content { position: relative; z-index: 3; padding: 0 24px; width: 80%; max-width: var(--hero-content-w, 950px) }
    .hero-banner__arrow { position: absolute; top: 50%; transform: translateY(-50%); z-index: 4; width: 48px; height: 48px; border-radius: 50%; background: rgba(0,0,0,.4); color: #fff; border: 1px solid rgba(255,255,255,.3); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 24px; line-height: 1; transition: background .2s, color .2s; user-select: none; }
    .hero-banner__arrow:hover { background: rgba(0,0,0,.6); color: #fff; }
    .hero-banner__arrow.prev { left: 16px; }
    .hero-banner__arrow.next { right: 16px; }
    .hero-banner__dots { position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 4; display: flex; gap: 10px; align-items: center; justify-content: center; }
    .hero-banner__dot { width: 10px; height: 10px; border-radius: 50%; background: rgba(255,255,255,.5); border: 1px solid rgba(255,255,255,.6); cursor: pointer; transition: background .2s, transform .2s; }
    .hero-banner__dot:hover { background: rgba(255,255,255,.8); }
    .hero-banner__dot.active { background: #fff; transform: scale(1.2); }
    .hero-banner--single .hero-banner__arrow, .hero-banner--single .hero-banner__dots { display: none; }
    /* Title Line 1 color & shadow used for Eyebrow, Title, Subtitle */
    .hero-content .eyebrow,
    .hero-content .title,
    .hero-content .subtitle { color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,.9), 0 4px 12px rgba(0,0,0,.7), 0 0 40px rgba(0,0,0,.5); }
    .eyebrow { font-size: clamp(13px, 2vw, 16px); font-weight:700; letter-spacing:.08em; text-transform:uppercase; margin:0; }
    .title { margin:10px 0 0; font-size: clamp(28px, 5vw, 44px); line-height:1.1; font-weight:800; }
    .subtitle { margin-top:12px; font-size: clamp(16px, 2.2vw, 19px); font-weight:600; line-height:1.35; }
    .hero-banner .actions { display:none; }
    .actions { margin-top:22px; display:flex; gap:12px; justify-content:center; flex-wrap:wrap }
    .btn { padding:10px 16px; border-radius:10px; border:1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.55); backdrop-filter: blur(4px); color:#fff; text-decoration:none; font-weight:600 }
    .btn.primary { background: var(--blue); border-color: transparent }

    body[data-theme="light"] .eyebrow { color: var(--text); opacity: 1 }
    body[data-theme="light"] .subtitle { color: var(--text); opacity: .85 }
    body[data-theme="light"] .btn { background: rgba(226,232,240,.85); color: var(--text); border-color: rgba(15,23,42,.15) }
    body[data-theme="light"] .btn.primary { color: #fff; border-color: transparent }

    .section { width: 80%; max-width: none; margin: 0 auto; padding: 28px 0 }
    .features { display:grid; grid-template-columns: repeat(4, 1fr); gap: 22px; margin-top: 22px }
    .feature-card { background: rgba(15,23,42,.6); border:1px solid rgba(148,163,184,.12); border-radius:14px; padding:18px; text-align:left }
    .feature-card .ic { width:40px; height:40px; border-radius:10px; display:grid; place-items:center; background: rgba(30,64,175,.25); color:#93c5fd; margin-bottom:10px }
    .feature-card .ic img { width:100%; height:100%; border-radius:10px; object-fit:cover; display:block }
    .feature-card h3 { margin:6px 0 6px; font-size:18px }
    .feature-card p { margin:0; color:#94a3b8; font-size:14px; line-height:1.5 }
    body[data-theme="light"] .feature-card { background: rgba(255,255,255,.9); border-color: rgba(15,23,42,.12) }
    body[data-theme="light"] .feature-card p { color: var(--muted) }

    .track-section { padding: 28px 0 }
    .track-wrap { margin-top: 16px; max-width: 560px }
    .track-input { width: 100%; padding: 12px 14px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.6); color: var(--text); font-size: 16px }
    .track-buttons { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px }
    .track-provider { margin: 0 }
    .track-empty { color: var(--muted); font-size: 14px }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0 }

    .activities { display:grid; grid-template-columns: repeat(3, 1fr); gap: 22px; margin-top: 22px }
    .activity-card { background: rgba(15,23,42,.6); border:1px solid rgba(148,163,184,.12); border-radius:14px; overflow:hidden; text-align:left }
    .activity-card img { width:100%; height:160px; object-fit:cover; display:block; background:#0b1220 }
    .activity-card .pad { padding:16px }
    .activity-card h3 { margin:0 0 6px; font-size:18px }
    .activity-card .meta { color:#94a3b8; font-size:12px; margin-bottom:10px }
    .activity-card p { margin:0; color:#94a3b8; font-size:14px; line-height:1.5 }
    body[data-theme="light"] .activity-card { background: rgba(255,255,255,.9); border-color: rgba(15,23,42,.12) }
    body[data-theme="light"] .activity-card .meta,
    body[data-theme="light"] .activity-card p { color: var(--muted) }
    .clamp2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden }
    .clamp2.expanded { display:block; -webkit-line-clamp:unset; overflow:visible }
    .readmore { margin-top:8px; border:0; background:transparent; color:#93c5fd; font-weight:700; cursor:pointer; padding:0 }
    .readmore:hover { text-decoration: underline }

    .services { display:grid; grid-template-columns: 360px 1fr; gap: 22px; align-items:stretch; margin-top: 28px }
    .tabs { background: rgba(15,23,42,.6); border:1px solid rgba(148,163,184,.12); border-radius:14px; padding:10px; display:flex; flex-direction:column; gap:10px }
    .tab { display:flex; align-items:center; gap:10px; padding:12px 14px; border-radius:10px; color:#e5e7eb; background: rgba(2,6,23,.35); border:1px solid rgba(148,163,184,.12) }
    .tab .ti { width:28px; height:28px; display:grid; place-items:center; border-radius:8px; background: rgba(51,65,85,.55) }
    .tab.active { background:#ef4444; border-color:#ef4444; color:#fff }
    .preview { position:relative; border-radius:14px; overflow:hidden; border:1px solid rgba(148,163,184,.12) }
    .preview img { width:100%; height:100%; object-fit:cover; display:block; filter:saturate(1.05) }
    .check-card { position:absolute; right:14px; top:14px; background: rgba(239,68,68,.95); color:#fff; padding:12px 14px; border-radius:12px; width: 210px; box-shadow: 0 10px 30px rgba(239,68,68,.35) }
    .check-card li { list-style:none; margin:6px 0 }
    .check-card li::before { content:"✓ "; margin-right:6px }
    .footer { width: 100%; margin: 32px 0 0; padding: 0; color: var(--muted); font-size:14px }
    .footer-inner { max-width: 1200px; margin: 0 auto; padding: 22px 24px }
    .footer form, .footer input { display:none }
    @media (max-width: 1100px) { .features { grid-template-columns: repeat(2, 1fr) } .services { grid-template-columns: 1fr } }
    @media (max-width: 1100px) { .activities { grid-template-columns: repeat(2, 1fr) } }
    @media (max-width: 620px) { .features { grid-template-columns: 1fr } }
    @media (max-width: 620px) { .activities { grid-template-columns: 1fr } }

    /* Why section */
    .why { position:relative; padding: 42px 0; }
    .why .wrap { width: 80%; max-width: none; margin:0 auto; position:relative }
    .why::before{ content:""; position:absolute; inset:0; background: url('https://images.unsplash.com/photo-1567446537708-ac4aa75c9c28?q=80&w=1800&auto=format&fit=crop') center/cover no-repeat; filter: brightness(.45); }
    .why::after{ content:""; position:absolute; inset:0; background: linear-gradient(180deg, rgba(2,6,23,.3), rgba(2,6,23,.6)); }
    .why h2 { position:relative; text-align:center; font-size:22px; font-weight:800; margin: 6px 0 8px }
    .why p.lead { position:relative; text-align:center; color:#cbd5e1; margin:0 0 16px }
    .why-grid { position:relative; display:grid; grid-template-columns: 1fr 340px 1fr; gap: 22px; align-items:center }
    .glass { background: rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.25); backdrop-filter: blur(6px); border-radius:16px; overflow:hidden }
    .glass img { display:block; width:100%; height:100%; object-fit:cover }
    .benefits { display:grid; gap:14px }
    .benefit { display:flex; align-items:flex-start; gap:10px; color:#e5e7eb }
    .dot { width:14px; height:14px; border-radius:999px; background:#ef4444; margin-top:6px; box-shadow:0 0 0 3px rgba(239,68,68,.25) }
    .benefit h4 { margin:0; font-size:16px }
    .benefit p { margin:2px 0 0; color:#cbd5e1; font-size:14px }
    @media (max-width: 1100px) { .why-grid { grid-template-columns: 1fr } }

    /* Quote section */
    .quote-wrap { width: 80%; max-width: none; margin: 0 auto 18px; padding: 0 }
    .quote { display:grid; grid-template-columns: 1fr 1fr; gap:0; border-radius:16px; overflow:hidden; border:1px solid rgba(148,163,184,.12) }
    .best { background: #0f2530; padding:24px }
    .best small { color:#ef4444; font-weight:800 }
    .best h3 { margin:4px 0 10px; font-size:28px }
    .best ul { margin:12px 0 0; padding-left:0 }
    .best li { list-style:none; color:#cbd5e1; margin:8px 0 }
    .best li::before { content:"✓"; color:#10b981; margin-right:8px }
    .best .media { display:flex; gap:10px; margin-top:12px; align-items:center }
    .best .media img { width:68px; height:44px; border-radius:10px; object-fit:cover; border:1px solid rgba(148,163,184,.18) }
    .form { background:#ef4444; padding:22px }
    .form h4 { margin:0 0 12px; color:#fff; font-size:18px }
    .card-form { background:#06202a; padding:16px; border-radius:12px; border:1px solid rgba(0,0,0,.2) }
    .row { display:grid; grid-template-columns: 1fr 1fr; gap:10px }
    .input, .select, .textarea { width:100%; padding:10px 12px; border-radius:8px; border:1px solid rgba(148,163,184,.25); background:#0b1a21; color:#e5e7eb }
    .textarea { min-height:90px; resize:vertical }
    .chips { display:flex; gap:14px; margin:8px 0 }
    .chip { display:flex; align-items:center; gap:6px; color:#e5e7eb }
    .chip input { accent-color:#ef4444 }
    .submit { margin-top:10px; width:100%; padding:10px 14px; border-radius:10px; background:#0b1220; color:#fff; border:1px solid rgba(255,255,255,.2); font-weight:700 }
    @media (max-width: 1000px) { .quote { grid-template-columns: 1fr } .row { grid-template-columns: 1fr } }
    /* Gallery */
    .gallery { width: 80%; max-width: none; margin: 12px auto 0; padding: 0 0 8px; overflow-x:hidden }
    .gallery-track { display:flex; gap:16px; flex-wrap: wrap }
    .gcard { position:relative; width:240px; height:140px; border-radius:14px; overflow:hidden; border:1px solid rgba(148,163,184,.12); background:#0b1220 }
    .gcard img { width:100%; height:100%; object-fit:cover; display:block }
    .gcard .meta { position:absolute; left:8px; top:8px; background:#111827; color:#fff; font-weight:800; padding:4px 8px; border-radius:10px; display:flex; align-items:center; gap:6px }
    .gcard .meta .d { background:#ef4444; color:#fff; width:30px; height:30px; border-radius:10px; display:grid; place-items:center; font-size:12px; line-height:1 }
    .gcard .meta .t { font-size:12px; color:#e5e7eb; display:flex; flex-direction:column; line-height:1.1 }

    /* Help + Quote section */
    .helpwrap { width: 80%; max-width: none; margin: 18px auto; padding: 0 }
    @media (max-width: 980px){ .section, .footer, .why .wrap, .quote-wrap, .gallery, .helpwrap { width: 100%; padding-left:24px; padding-right:24px } .why { padding-left:24px; padding-right:24px } }
    .helpgrid { display:grid; grid-template-columns: 1fr 1fr; gap:0; border:1px solid rgba(148,163,184,.12); border-radius:16px; overflow:hidden }
    .help { background:#0f172a; padding:22px }
    .help h3 { margin:0 0 6px; font-size:22px }
    .help p { margin:0 0 12px; color:#94a3b8 }
    .help .item { display:flex; align-items:center; gap:10px; padding:12px; border-radius:10px; border:1px solid rgba(148,163,184,.15); background:#0b1220; color:#e5e7eb; margin-bottom:10px }
    .help .item .ic { width:34px; height:34px; border-radius:8px; display:grid; place-items:center; background:#0f2530 }
    .getquote { background:#ef4444; padding:22px }
    .getquote h4 { margin:0 0 6px; color:#fff; font-size:22px }
    .getquote p { margin:0 0 12px; color:#fde68a }
    .getquote .form2 { background:#061c24; padding:16px; border-radius:12px }
    .getquote .row2 { display:grid; grid-template-columns: 1fr 1fr; gap:10px }
    .getquote .input, .getquote .select, .getquote .textarea { width:100%; padding:10px 12px; border-radius:8px; border:1px solid rgba(255,255,255,.25); background:#0b1a21; color:#fff }
    .getquote .textarea { min-height:90px }
    .getquote .submit { margin-top:10px; width:100%; padding:10px 14px; border-radius:10px; background:#0b1220; color:#fff; border:1px solid rgba(255,255,255,.25); font-weight:800 }
    @media (max-width: 1000px) { .helpgrid { grid-template-columns: 1fr } .getquote .row2 { grid-template-columns: 1fr } }
  </style>
</head>
<body>
  @php
    $cfgName = isset($siteName) ? $siteName : optional(\App\Models\Setting::where('key','site_name')->first())->value;
    $cfgLogo = isset($logoUrl) ? $logoUrl : optional(\App\Models\Setting::where('key','logo_url')->first())->value;
    $cfgTag  = optional(\App\Models\Setting::where('key','tagline')->first())->value;
    $cfgFooter = optional(\App\Models\Setting::where('key','footer_text')->first())->value;
    $cfgSiteTheme = optional(\App\Models\Setting::where('key','site_default_theme')->first())->value;
    $cfgHeaderBg = optional(\App\Models\Setting::where('key','header_bg_color')->first())->value;
    $cfgHeaderBorder = optional(\App\Models\Setting::where('key','header_border_color')->first())->value;
    $cfgHeaderLink = optional(\App\Models\Setting::where('key','header_link_color')->first())->value;
    $cfgHeaderText = optional(\App\Models\Setting::where('key','header_text_color')->first())->value;
    $cfgHeaderTagline = optional(\App\Models\Setting::where('key','header_tagline_color')->first())->value;
    $cfgBrandSize = optional(\App\Models\Setting::where('key','header_brand_font_size')->first())->value;
    $cfgBrandWeight = optional(\App\Models\Setting::where('key','header_brand_font_weight')->first())->value;
    $cfgBrandStyle = optional(\App\Models\Setting::where('key','header_brand_font_style')->first())->value;
    $cfgTaglineSize = optional(\App\Models\Setting::where('key','header_tagline_font_size')->first())->value;
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
    $logoSrc = null;
    if (!empty($cfgLogo)) {
      $logoSrc = $toUrl($cfgLogo);
    }
    $bannerBgSrc = null;
    $bannerImages = [];
    if (isset($banner) && $banner) {
      if (!empty($banner->bg_image_url)) {
        $u = $toUrl($banner->bg_image_url);
        if ($u) { $bannerImages[] = $u; $bannerBgSrc = $u; }
      }
      if (!empty($banner->bg_image_urls) && is_array($banner->bg_image_urls)) {
        foreach ($banner->bg_image_urls as $u) {
          $u = trim((string)$u);
          if ($u !== '') { $u2 = $toUrl($u); if ($u2) $bannerImages[] = $u2; }
        }
      }
      if ($bannerBgSrc === null && count($bannerImages) > 0) { $bannerBgSrc = $bannerImages[0]; }
    }
    $bannerAutoRotate = filter_var(optional(\App\Models\Setting::where('key','banner_auto_rotate')->first())->value ?? true, FILTER_VALIDATE_BOOLEAN);
    $bannerRotateIntervalSec = (int)(optional(\App\Models\Setting::where('key','banner_rotate_interval_sec')->first())->value ?? 5);
    if ($bannerRotateIntervalSec < 2) $bannerRotateIntervalSec = 2;
    if ($bannerRotateIntervalSec > 30) $bannerRotateIntervalSec = 30;
  @endphp

  <header class="topbar" style="{{ !empty($cfgHeaderBg) ? '--header-bg: '.$cfgHeaderBg.';' : '' }}{{ !empty($cfgHeaderBorder) ? '--header-border: '.$cfgHeaderBorder.';' : '' }}{{ !empty($cfgHeaderLink) ? '--header-link: '.$cfgHeaderLink.';' : '' }}{{ !empty($cfgHeaderText) ? '--header-text: '.$cfgHeaderText.';' : '' }}{{ !empty($cfgHeaderTagline) ? '--header-tagline: '.$cfgHeaderTagline.';' : '' }}{{ !empty($cfgBrandSize) ? '--brand-size: '.(int)$cfgBrandSize.'px;' : '' }}{{ !empty($cfgTaglineSize) ? '--tagline-size: '.(int)$cfgTaglineSize.'px;' : '' }}{{ !empty($cfgBrandWeight) ? '--brand-weight: '.$cfgBrandWeight.';' : '' }}{{ !empty($cfgBrandStyle) ? '--brand-style: '.$cfgBrandStyle.';' : '' }}">
    <div class="nav">
      <div class="brand">
        @if($logoSrc)
          <img src="{{ $logoSrc }}" alt="Logo">
        @else
          <span>📦</span>
        @endif
        <span>{{ $cfgName ?? 'Parcel Transport' }}</span>
        <small>{{ $cfgTag ?? 'Safe Transportation & Logistics' }}</small>
      </div>
      <div style="display:flex; align-items:center; gap:10px">
        <button id="theme-toggle" class="themebtn" type="button" aria-label="Toggle theme">Theme</button>
        <button class="hamb" type="button" aria-expanded="false" aria-controls="primary-links">Menu</button>
      </div>
      <div id="primary-links" class="links">
        @if(isset($navLinks) && $navLinks->count())
          @foreach($navLinks as $nl)
            <a href="{{ $nl->url }}" @if($nl->target) target="{{ $nl->target }}" rel="noopener" @endif>
              @if(!empty($nl->icon))<span style="margin-right:6px">{{ $nl->icon }}</span>@endif{{ $nl->label }}
            </a>
          @endforeach
        @else
          <a href="/">Home</a>
          <a href="#track">Track</a>
          <a href="#book">Book</a>
        @endif
        <a href="{{ route('login') }}"> Login</a>
      </div>
    </div>
  </header>

  @php
    $heroPos = isset($banner) && $banner && !empty($banner->bg_position) ? $banner->bg_position : 'center';
    $heroSize = isset($banner) && $banner && !empty($banner->bg_size) ? $banner->bg_size : 'cover';
    $defaultSlideUrl = 'https://images.unsplash.com/photo-1483683804023-6ccdb62f86ef?q=80&w=1600&auto=format&fit=crop';
    $sliderImages = count($bannerImages) > 0 ? $bannerImages : [$defaultSlideUrl];
    $isSingleSlide = count($sliderImages) < 2;
  @endphp
  <section id="hero-banner" class="hero-banner {{ $isSingleSlide ? 'hero-banner--single' : '' }}" data-banner-images="{{ json_encode($sliderImages) }}" data-banner-auto-rotate="{{ $bannerAutoRotate ? '1' : '0' }}" data-banner-interval="{{ $bannerRotateIntervalSec }}" style="{{ isset($banner) && $banner && !empty($banner->banner_height_px) ? "--banner-h: ".(int)$banner->banner_height_px."px;" : '' }}{{ isset($banner) && $banner && !empty($banner->banner_content_max_width_px) ? "--hero-content-w: ".(int)$banner->banner_content_max_width_px."px;" : '' }} --hero-pos: {{ $heroPos }}; --hero-size: {{ $heroSize }};">
    <div class="hero-banner__slides">
      @foreach($sliderImages as $i => $imgUrl)
        <div class="hero-banner__slide {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}" style="background-image: url('{{ e($imgUrl) }}');"></div>
      @endforeach
    </div>
    <div class="hero-banner__overlay"></div>
    <div class="hero-content">
      <div class="eyebrow">{{ optional($banner)->eyebrow ?? 'Safe Transportation & Logistics' }}</div>
      <h1 class="title">{{ optional($banner)->title_line1 ?? 'Adaptable coordinated factors' }}<br>{{ optional($banner)->title_line2 ?? 'Quick Conveyance' }}</h1>
      <p class="subtitle">{{ optional($banner)->subtitle ?? 'Reliable logistics solutions for every shipment. From pick-up to delivery, track and manage your parcels with ease.' }}</p>
    </div>
    @if(!$isSingleSlide)
      <button type="button" class="hero-banner__arrow prev" aria-label="Previous slide">‹</button>
      <button type="button" class="hero-banner__arrow next" aria-label="Next slide">›</button>
      <div class="hero-banner__dots" role="tablist" aria-label="Banner slides">
        @foreach($sliderImages as $i => $imgUrl)
          <button type="button" class="hero-banner__dot {{ $i === 0 ? 'active' : '' }}" role="tab" aria-label="Slide {{ $i + 1 }}" data-index="{{ $i }}"></button>
        @endforeach
      </div>
    @endif
  </section>

  <main>
    <section class="section" aria-label="Features">
      <div class="features">
        @if(isset($features) && $features->count())
          @foreach($features as $f)
            <div class="feature-card">
              <div class="ic">
                @if(!empty($f->icon_image_url))
                  <img src="{{ $toUrl($f->icon_image_url) }}" alt="{{ $f->title }} icon">
                @else
                  {{ $f->icon ?? '•' }}
                @endif
              </div>
              <h3>{{ $f->title }}</h3>
              <p>{{ $f->description }}</p>
            </div>
          @endforeach
        @else
          <div class="feature-card">
            <div class="ic">✈️</div>
            <h3>Air Freight</h3>
            <p>Efficient and reliable air freight solutions for your business needs.</p>
          </div>
          <div class="feature-card">
            <div class="ic">⚓</div>
            <h3>Ocean Freight</h3>
            <p>Comprehensive ocean freight services worldwide.</p>
          </div>
          <div class="feature-card">
            <div class="ic">🚚</div>
            <h3>Land Transport</h3>
            <p>Efficient land transportation solutions for all your needs.</p>
          </div>
          <div class="feature-card">
            <div class="ic">🏬</div>
            <h3>Warehousing</h3>
            <p>Secure storage and inventory management.</p>
          </div>
        @endif
      </div>
    </section>

    <section id="track" class="section track-section" aria-label="Track your parcel">
      <h2 style="margin:0">Track your parcel</h2>
      <p style="color:var(--muted); margin:8px 0 14px">Enter your tracking number and choose a carrier to open their tracking page.</p>
      <div class="track-wrap">
        <label for="tracking_number" class="sr-only">Tracking number</label>
        <input type="text" id="tracking_number" class="track-input" placeholder="Tracking number" autocomplete="off">
        <div class="track-buttons">
          @forelse(isset($trackingLinks) ? $trackingLinks : [] as $link)
            <button type="button" class="btn track-provider" data-url-template="{{ e($link->url_template) }}" title="Opens in new tab">{{ $link->name }}</button>
          @empty
            <span class="track-empty">Add tracking links in Admin (Parcel Tracking Links) to enable 3rd party tracking.</span>
          @endforelse
        </div>
      </div>
    </section>

    <section class="section" aria-label="Daily Activities">
      <h2 style="margin:0">Daily Activities</h2>
      <div class="activities">
        @if(isset($activities) && $activities->count())
          @foreach($activities as $a)
            <div class="activity-card">
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
                  $hasMore = \Illuminate\Support\Str::length($bodyText) > 140;
                @endphp
                <p class="clamp2 js-clamp">{{ $bodyText }}</p>
                @if($hasMore)
                  <button type="button" class="readmore js-readmore">Read more</button>
                @endif
              </div>
            </div>
          @endforeach
        @else
          <div class="activity-card">
            <img src="https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?q=80&w=1200&auto=format&fit=crop" alt="Activity">
            <div class="pad">
              <h3>No posts yet</h3>
              <div class="meta"> </div>
              <p>Add your first daily activity from the Admin panel.</p>
            </div>
          </div>
        @endif
      </div>
      <div style="margin-top:14px; display:flex; justify-content:center">
        <a class="btn" href="{{ route('activities.index') }}">More</a>
      </div>
    </section>

    <section class="section" aria-label="Services">
      <div class="services">
        @if(isset($services) && $services->count())
          @php $firstService = $services->first(); @endphp
          <div class="tabs" id="svc-tabs">
            @foreach($services as $i => $s)
              <div class="tab {{ $i === 0 ? 'active' : '' }}" data-idx="{{ $i }}">
                <span class="ti">{{ $s->icon ?? '•' }}</span> {{ $s->title }}
              </div>
            @endforeach
          </div>
          <div class="preview">
            <img id="svc-image" src="{{ !empty(optional($firstService)->image_url) ? $toUrl($firstService->image_url) : 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1600&auto=format&fit=crop' }}" alt="Service preview">
            <ul class="check-card" id="svc-check">
              @php $items = is_array(optional($firstService)->checklist ?? null) ? $firstService->checklist : ['Fast Delivery','Safety','Good Package','Privacy']; @endphp
              @foreach($items as $it)
                <li>{{ $it }}</li>
              @endforeach
            </ul>
          </div>

          @foreach($services as $i => $s)
            <template id="svc-data-{{ $i }}" data-image="{{ !empty($s->image_url) ? $toUrl($s->image_url) : '' }}">
              @if(is_array($s->checklist))
                @foreach($s->checklist as $it)
                  <li>{{ $it }}</li>
                @endforeach
              @endif
            </template>
          @endforeach
        @else
          <div class="tabs">
            <div class="tab active"><span class="ti">✈️</span> Air Transportation</div>
            <div class="tab"><span class="ti">🚆</span> Train Transportation</div>
            <div class="tab"><span class="ti">🚢</span> Cargo Ship Freight</div>
            <div class="tab"><span class="ti">⚓</span> Maritime Transportation</div>
            <div class="tab"><span class="ti">🛩️</span> Flight Transportation</div>
          </div>
          <div class="preview">
            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1600&auto=format&fit=crop" alt="Logistics truck on highway">
            <ul class="check-card">
              <li>Fast Delivery</li>
              <li>Safety</li>
              <li>Good Package</li>
              <li>Privacy</li>
            </ul>
          </div>
        @endif
      </div>
    </section>
  </main>



  <section class="gallery" aria-label="Latest logistics posts">
    <div class="gallery-track">
      @if(isset($gallery) && $gallery->count())
        @foreach($gallery as $g)
          <div class="gcard">
            <img src="{{ $toUrl($g->image_url) }}" alt="{{ $g->label ?? 'Gallery' }}">
            <div class="meta">
              <span class="d">{{ $g->date_label ?? '' }}</span>
              <span class="t">{{ $g->label ?? '' }}</span>
            </div>
          </div>
        @endforeach
      @else
        <div class="gcard"><img src="https://images.unsplash.com/photo-1607940237836-df510cf5b3c3?q=80&w=800&auto=format&fit=crop" alt="Logistics"><div class="meta"><span class="d">12<br>Dec</span><span class="t">Logistics</span></div></div>
        <div class="gcard"><img src="https://images.unsplash.com/photo-1578575437130-527eed3abbec?q=80&w=800&auto=format&fit=crop" alt="Warehouse"><div class="meta"><span class="d">18<br>Dec</span><span class="t">Warehouse</span></div></div>
        <div class="gcard"><img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=800&auto=format&fit=crop" alt="Shipping"><div class="meta"><span class="d">24<br>Nov</span><span class="t">Shipping</span></div></div>
      @endif
    </div>
  </section>

  <div class="helpwrap">
    <div class="helpgrid">
      <div class="help">
        <h3>Need Help With Your Shipping?</h3>
        <p>Our team is here to help with all your logistics needs. Contact us today for a free quote.</p>
        @if(isset($helpItems) && $helpItems->count())
          @foreach($helpItems as $hi)
            <div class="item"><span class="ic">{{ $hi->icon ?? '•' }}</span><div><strong>{{ $hi->title }}</strong><div style="color:#94a3b8">{{ $hi->description }}</div></div></div>
          @endforeach
        @else
          <div class="item"><span class="ic">📞</span><div><strong>Call Us Anytime</strong><div style="color:#94a3b8">+94 21 492 / 799</div></div></div>
          <div class="item"><span class="ic">✉️</span><div><strong>Email Us</strong><div style="color:#94a3b8">info@pt.com</div></div></div>
          <div class="item"><span class="ic">📍</span><div><strong>Visit Us</strong><div style="color:#94a3b8">Ariyalai Nagar, Kilinochchi, Sri Lanka</div></div></div>
        @endif
      </div>
      <div class="getquote">
        <h4>Get A Free Quote</h4>
        <p>Fill out the form below and our team will get back to you as soon as possible.</p>
        <form class="form2" action="{{ route('quote.store') }}" method="post">
          @csrf
          <div class="row2">
            <input class="input" type="text" name="name" placeholder="Your Name" required>
            <input class="input" type="email" name="email" placeholder="Your Email" required>
          </div>
          <div class="row2">
            <input class="input" type="text" name="subject" placeholder="Subject">
          </div>
          <div class="row2">
            <select class="select" name="service_id">
              <option value="" selected>Select Service</option>
              @isset($formServices)
                @foreach($formServices as $svc)
                  <option value="{{ $svc->id }}">{{ $svc->title }}</option>
                @endforeach
              @endisset
            </select>
          </div>
          <div class="row2">
            <textarea class="textarea" name="message" placeholder="Your Message" required></textarea>
          </div>
          <button type="submit" class="submit">Send Message</button>
        </form>
      </div>
    </div>
  </div>

  <footer class="footer">
    @php
      $aboutText = $cfgFooter ?? 'All rights reserved.'; // legacy footer text
      $contactEmail = optional(\App\Models\Setting::where('key','contact_email')->first())->value;
      $contactPhone = optional(\App\Models\Setting::where('key','contact_phone')->first())->value;
      $contactAddr  = optional(\App\Models\Setting::where('key','address')->first())->value;
      $footerLogo = optional(\App\Models\Setting::where('key','footer_logo_url')->first())->value;
      $footerNews = optional(\App\Models\Setting::where('key','footer_newsletter')->first())->value;
      $footerHours = optional(\App\Models\Setting::where('key','footer_hours')->first())->value;
      $aboutTitle = optional(\App\Models\Setting::where('key','footer_about_title')->first())->value ?? 'About';
      $aboutBody  = optional(\App\Models\Setting::where('key','footer_about_text')->first())->value;
      $aboutLinkLabel = optional(\App\Models\Setting::where('key','footer_about_link_label')->first())->value;
      $aboutLinkUrl   = optional(\App\Models\Setting::where('key','footer_about_link_url')->first())->value;
      $showSocial = (bool) (optional(\App\Models\Setting::where('key','footer_show_social')->first())->value ?? true);
      $ftBg = optional(\App\Models\Setting::where('key','footer_bg_color')->first())->value ?? '#0b1220';
      $ftText = optional(\App\Models\Setting::where('key','footer_text_color')->first())->value ?? '#94a3b8';
      $ftLink = optional(\App\Models\Setting::where('key','footer_link_color')->first())->value ?? '#cbd5e1';
      $footerLinks = collect();
      if (\Illuminate\Support\Facades\Schema::hasTable('footer_links')) {
        $footerLinks = \App\Models\FooterLink::where('is_visible',true)->orderBy('sort_order')->orderBy('id')->get();
      }
      $social = collect();
      if (\Illuminate\Support\Facades\Schema::hasTable('social_links')) {
        $social = \App\Models\SocialLink::where('is_visible',true)->orderBy('sort_order')->orderBy('id')->get();
      }

      $footerBgEffective = $ftBg ?: ($cfgHeaderBg ?: '#0b1220');
      $footerTextEffective = $ftText ?: '#94a3b8';
      $footerLinkEffective = $ftLink ?: '#cbd5e1';
      $footerBorderEffective = $cfgHeaderBorder ?: 'rgba(148,163,184,.12)';
    @endphp

    <div style="width:100%; margin:0; padding:0; background: {{ $footerBgEffective }}; color: {{ $footerTextEffective }}; border-top:1px solid {{ $footerBorderEffective }}">
      <div class="footer-inner">
      <div style="display:grid; grid-template-columns: 1.2fr 1fr 1fr; gap:22px; align-items:start">
        <div>
          <h4 style="margin:0 0 8px; color: {{ $footerTextEffective }}">{{ $aboutTitle }}</h4>
          @if(!empty($footerLogo))
            <div style="margin:6px 0 10px"><img src="{{ $toUrl($footerLogo) }}" alt="Footer Logo" style="width:120px; height:auto; border-radius:8px; border:1px solid rgba(148,163,184,.18)"></div>
          @endif
          @if(!empty($aboutBody))
            <p style="margin:0 0 10px; color: {{ $footerTextEffective }}">{{ $aboutBody }}</p>
          @else
            <p style="margin:0 0 10px; color: {{ $footerTextEffective }}">{{ $aboutText }}</p>
          @endif
          @if(!empty($aboutLinkLabel) && !empty($aboutLinkUrl))
            <div style="margin:8px 0 10px"><a href="{{ $aboutLinkUrl }}" style="color: {{ $footerLinkEffective }}; text-decoration:none">{{ $aboutLinkLabel }} →</a></div>
          @endif
          @if($showSocial)
            <div>
              @forelse($social as $s)
                <a href="{{ $s->url }}" target="_blank" rel="noopener" title="{{ $s->label }}" style="color: {{ $footerLinkEffective }}; text-decoration:none; border:1px solid rgba(148,163,184,.25); padding:6px 8px; border-radius:10px">{{ $s->icon ?? '🔗' }}</a>
              @empty
              @endforelse
            </div>
          @endif
        </div>

        <div>
          <h4 style="margin:0 0 8px; color: {{ $footerTextEffective }}">Services</h4>
          <ul style="list-style:none; margin:0; padding:0; color: {{ $footerTextEffective }}">
            @if(isset($services) && $services->count())
              @foreach($services as $svc)
                <li style="margin:6px 0"><a href="#" style="color: {{ $footerLinkEffective }}; text-decoration:none">{{ $svc->title }}</a></li>
              @endforeach
            @else
              <li style="margin:6px 0"><a href="#" style="color: {{ $footerLinkEffective }}; text-decoration:none">Air Freight</a></li>
              <li style="margin:6px 0"><a href="#" style="color: {{ $footerLinkEffective }}; text-decoration:none">Ocean Freight</a></li>
            @endif
          </ul>
        </div>

        <div>
          <h4 style="margin:0 0 8px; color: {{ $footerTextEffective }}">Quick Links</h4>
          <ul style="list-style:none; margin:0; padding:0; color: {{ $footerTextEffective }}">
            @forelse($footerLinks as $fl)
              <li style="margin:6px 0"><a href="{{ $fl->url }}" style="color: {{ $footerLinkEffective }}; text-decoration:none">{{ $fl->label }}</a></li>
            @empty
              <li style="margin:6px 0"><a href="#" style="color: {{ $footerLinkEffective }}; text-decoration:none">Privacy Policy</a></li>
              <li style="margin:6px 0"><a href="#" style="color: {{ $footerLinkEffective }}; text-decoration:none">Terms of Service</a></li>
            @endforelse
          </ul>
          <h4 style="margin:14px 0 8px; color: {{ $footerTextEffective }}">Contact Us</h4>
          <ul style="list-style:none; margin:0; padding:0; color: {{ $footerTextEffective }}">
            @if($contactAddr)<li style="margin:6px 0">📍 {{ $contactAddr }}</li>@endif
            @if($contactPhone)<li style="margin:6px 0">📞 {{ $contactPhone }}</li>@endif
            @if($contactEmail)<li style="margin:6px 0">✉️ {{ $contactEmail }}</li>@endif
            @if($footerHours)<li style="margin:6px 0">🕑 {{ $footerHours }}</li>@endif
          </ul>
        </div>
      </div>

      <div style="display:flex; align-items:center; justify-content:center; gap:14px; flex-wrap:wrap; margin-top:16px; padding-top:12px; border-top:1px solid rgba(148,163,184,.12); color: {{ $footerTextEffective }}">
        <div>© <span id="year"></span> {{ $cfgName ?? 'Parcel Transport' }}. {{ $aboutText }}</div>
      </div>
      </div>
    </div>
  </footer>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear()

    // Public site theme (dark/light)
    const siteDefaultTheme = '{{ in_array(($cfgSiteTheme ?? 'dark'), ['dark','light']) ? ($cfgSiteTheme ?? 'dark') : 'dark' }}';
    const savedSiteTheme = localStorage.getItem('site_theme') || siteDefaultTheme || 'dark';
    document.body.setAttribute('data-theme', savedSiteTheme);
    const themeBtn = document.getElementById('theme-toggle');
    if (themeBtn){
      const setLabel = () => { themeBtn.textContent = (document.body.getAttribute('data-theme') === 'light') ? 'Light' : 'Dark'; };
      setLabel();
      themeBtn.addEventListener('click', () => {
        const cur = document.body.getAttribute('data-theme') || 'dark';
        const next = cur === 'dark' ? 'light' : 'dark';
        document.body.setAttribute('data-theme', next);
        localStorage.setItem('site_theme', next);
        setLabel();
      });
    }

    // Services tab interactivity (only if dynamic services exist)
    const tabs = document.querySelectorAll('#svc-tabs .tab');
    if (tabs && tabs.length) {
      const img = document.getElementById('svc-image');
      const list = document.getElementById('svc-check');
      tabs.forEach(t => t.addEventListener('click', () => {
        tabs.forEach(x => x.classList.remove('active'));
        t.classList.add('active');
        const idx = t.getAttribute('data-idx');
        const tpl = document.getElementById('svc-data-'+idx);
        if (tpl && list) {
          list.innerHTML = tpl.innerHTML.trim() || '<li>Fast Delivery</li><li>Safety</li><li>Good Package</li><li>Privacy</li>';
        }
        const src = tpl ? tpl.getAttribute('data-image') : '';
        if (img) img.src = src && src.length ? src : 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1600&auto=format&fit=crop';
      }));
    }
    // Mobile header toggle
    const hamb = document.querySelector('.hamb');
    const links = document.getElementById('primary-links');
    if (hamb && links){
      hamb.addEventListener('click', () => {
        const open = links.classList.toggle('open');
        hamb.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
      window.addEventListener('resize', () => {
        if (window.innerWidth > 720) { links.classList.remove('open'); hamb.setAttribute('aria-expanded','false'); }
      });
    }

    // Banner slider
    (function(){
      const el = document.getElementById('hero-banner');
      if (!el) return;
      const slides = el.querySelectorAll('.hero-banner__slide');
      const dots = el.querySelectorAll('.hero-banner__dot');
      const prevBtn = el.querySelector('.hero-banner__arrow.prev');
      const nextBtn = el.querySelector('.hero-banner__arrow.next');
      const total = slides.length;
      if (total < 2) return;

      let current = 0;
      let autoTimer = null;
      const autoRotate = el.getAttribute('data-banner-auto-rotate') === '1';
      const intervalSec = parseInt(el.getAttribute('data-banner-interval') || '5', 10) || 5;

      function goToSlide(idx) {
        current = (idx + total) % total;
        slides.forEach((s, i) => s.classList.toggle('active', i === current));
        dots.forEach((d, i) => d.classList.toggle('active', i === current));
      }

      function next() { goToSlide(current + 1); resetAuto(); }
      function prev() { goToSlide(current - 1); resetAuto(); }

      function resetAuto() {
        if (autoTimer) clearInterval(autoTimer);
        if (autoRotate) autoTimer = setInterval(next, intervalSec * 1000);
      }

      if (prevBtn) prevBtn.addEventListener('click', prev);
      if (nextBtn) nextBtn.addEventListener('click', next);
      dots.forEach((dot, i) => dot.addEventListener('click', () => { goToSlide(i); resetAuto(); }));

      if (autoRotate) autoTimer = setInterval(next, intervalSec * 1000);
    })();

    (function(){
      const input = document.getElementById('tracking_number');
      document.querySelectorAll('.track-provider').forEach(function(btn){
        btn.addEventListener('click', function(){
          var num = (input && input.value) ? input.value.trim() : '';
          if (!num){ alert('Please enter a tracking number.'); return; }
          var template = this.getAttribute('data-url-template') || '';
          var url = template.replace(/\{tracking_number\}/gi, encodeURIComponent(num)).replace(/\{tracking\}/gi, encodeURIComponent(num));
          if (url) window.open(url, '_blank', 'noopener');
        });
      });
    })();
  </script>
</body>
</html>
