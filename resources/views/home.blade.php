<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php
    $seoSiteName = optional(\App\Models\Setting::where('key','site_name')->first())->value ?: 'Parcel Transport';
    $seoTitle = $seoSiteName . ' – Home';
    $seoDesc = optional(\App\Models\Setting::where('key','meta_description')->first())->value ?? optional(\App\Models\Setting::where('key','tagline')->first())->value ?? 'Reliable parcel and logistics solutions. Track shipments, get quotes, and manage delivery with ease.';
    $seoKw = optional(\App\Models\Setting::where('key','meta_keywords')->first())->value;
    $seoImg = optional(\App\Models\Setting::where('key','og_image')->first())->value;
    $jsonLd = [
      '@context' => 'https://schema.org',
      '@type' => 'WebSite',
      'name' => $seoSiteName,
      'url' => url('/'),
      'description' => \Illuminate\Support\Str::limit(strip_tags($seoDesc), 160),
    ];
  @endphp
  @include('partials.seo-meta', ['seoTitle' => $seoTitle, 'seoDescription' => $seoDesc, 'seoKeywords' => $seoKw, 'seoImage' => $seoImg, 'seoSiteName' => $seoSiteName, 'jsonLd' => $jsonLd])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --bg: #0b1220; --card: #0f172a; --muted:#94a3b8; --text:#e2e8f0; --brand:#1e293b; --blue:#3b82f6; }
    body[data-theme="light"] { --bg:#f8fafc; --card:#ffffff; --muted:#475569; --text:#0f172a; --brand:#e2e8f0; --blue:#2563eb }
    * { box-sizing: border-box }
    html { overflow-x: hidden; height: 100%; zoom: 0.9 }
    body { margin:0; font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; background: var(--bg); color: var(--text); overflow-x: hidden; min-width: 0; --content-gutter: 20px }
    /* Header: logo left, menu right */
    .topbar { background: var(--header-bg, #d83526); border-bottom: 1px solid var(--header-border, rgba(0,0,0,.08)); position: sticky; top: 0; z-index: 10; padding: 0 var(--content-gutter); }
    .topbar::before { content: ''; display: block; height: 4px; background: var(--header-strip, #fce4dc); }
    .nav { position: relative; max-width: 1200px; margin: 0 auto; padding: 12px var(--content-gutter); display: flex; align-items: center; justify-content: flex-start; gap: 14px; min-width: 0; }
    .brand { display: flex; align-items: center; justify-content: flex-start; gap: 12px; font-weight: 800; text-align: left; min-width: 0; flex: 0 0 auto; margin: 0; order: -1; }
    .header-menu { display: flex; align-items: center; gap: 12px; margin-left: auto; flex-shrink: 0; }
    .brand img { width: 180px; max-width: 4in; height: auto; max-height: 1.5in; border-radius: 8px; object-fit: contain; border: none; display: block; flex-shrink: 0; margin: 0; }
    .brand span { line-height: 1.05; color: var(--header-text, #ffffff); font-size: var(--brand-size, 17px); font-weight: var(--brand-weight, 800); font-style: var(--brand-style, normal); word-break: break-word; letter-spacing: 0.02em; }
    .brand small { color: var(--header-tagline, rgba(255,255,255,.9)); font-weight: 600; display: block; line-height: 1.1; font-size: var(--tagline-size, 14px); letter-spacing: 0.03em; }
    .header-menu { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
    .links { display: flex; align-items: center; gap: 20px; flex-shrink: 0; }
    .links a { color: var(--header-link, #ffffff); text-decoration: none; font-weight: 600; font-size: 14px; }
    .links a:hover { color: var(--header-text, #ffffff); opacity: 0.9; }
    .links a span { font-size: 0.95em; margin-right: 5px; }
    .hamb { display: none; background: rgba(17,24,39,.75); color: #fff; border: none; padding: 8px 14px; border-radius: 999px; font-weight: 700; flex-shrink: 0; }
    .themebtn { display: inline-block; background: rgba(30,30,30,.9); color: #ffffff; border: none; padding: 8px 16px; border-radius: 999px; font-weight: 600; font-size: 14px; cursor: pointer; }
    .themebtn:hover { background: rgba(0,0,0,.95); color: #fff; }
    body[data-theme="light"] .hamb { background: rgba(30,30,30,.9); color: #fff; }
    body[data-theme="light"] .themebtn { background: rgba(30,30,30,.9); color: #fff; }
    @media (max-width: 900px) {
      body { --content-gutter: 16px }
      .nav { padding: 10px var(--content-gutter) }
      .brand img { width: 140px; max-height: 1.2in }
      .brand span { font-size: clamp(14px, 2.5vw, 16px) }
    }
    @media (max-width: 720px) {
      body { --content-gutter: 14px }
      .nav { padding: 10px var(--content-gutter); gap: 10px }
      .links { position: absolute; right: 0; top: calc(100% + 6px); z-index: 50; background: var(--header-bg, #0b1220); border: 1px solid var(--header-border, rgba(148,163,184,.12)); border-radius: 10px; padding: 8px; display: none; flex-direction: column; gap: 2px; min-width: 160px; max-width: 220px; box-shadow: 0 12px 32px rgba(0,0,0,.35) }
      .links a { margin: 0; padding: 6px 10px; font-size: 13px; border-radius: 6px; line-height: 1.3 }
      .links a:hover { background: rgba(148,163,184,.1) }
      .links.open { display: flex }
      .hamb { display: inline-block }
      .themebtn { display: none }
      .brand img { width: 100px; max-width: 120px; max-height: 44px; border-radius: 6px }
      .brand span { font-size: 14px; max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap }
      .brand small { display: none }
    }
    @media (max-width: 400px) {
      body { --content-gutter: 12px }
      .nav { padding: 8px var(--content-gutter) }
      .brand img { width: 80px; max-height: 36px }
      .brand span { font-size: 13px; max-width: 100px }
      .hamb { padding: 6px 10px; font-size: 14px }
    }
    .icon { width:18px; height:18px; opacity:.9; vertical-align:-3px; margin-right:6px }
    /* Main banner: 2300×1300 desktop, responsive below */
    .hero-banner { position: relative; width: 100%; max-width: 2300px; margin: 0 auto; min-height: var(--banner-h, 1300px); display: grid; place-items: center; text-align: center; overflow: hidden; }
    .hero-banner__slides { position: absolute; inset: 0; z-index: 0; }
    .hero-banner__slide { position: absolute; inset: 0; background-position: var(--hero-pos, center); background-size: var(--hero-size, cover); background-repeat: no-repeat; opacity: 0; transition: opacity 0.6s ease; filter: brightness(.7); }
    .hero-banner__slide.active { opacity: 1; z-index: 1; }
    .hero-banner__overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(2,6,23,.55), rgba(2,6,23,.45)); z-index: 2; pointer-events: none; }
    .hero-content { position: relative; z-index: 3; padding: 0 var(--content-gutter, 20px); width: 90%; max-width: var(--hero-content-w, 820px); min-width: 0; }
    .hero-banner__arrow { position: absolute; top: 50%; transform: translateY(-50%); z-index: 4; width: 42px; height: 42px; border-radius: 50%; background: rgba(0,0,0,.4); color: #fff; border: 1px solid rgba(255,255,255,.3); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; line-height: 1; transition: background .2s, color .2s; user-select: none; }
    .hero-banner__arrow:hover { background: rgba(0,0,0,.6); color: #fff; }
    .hero-banner__arrow.prev { left: 12px; }
    .hero-banner__arrow.next { right: 12px; }
    .hero-banner__dots { position: absolute; bottom: 14px; left: 50%; transform: translateX(-50%); z-index: 4; display: flex; gap: 8px; align-items: center; justify-content: center; }
    .hero-banner__dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.5); border: 1px solid rgba(255,255,255,.6); cursor: pointer; transition: background .2s, transform .2s; }
    .hero-banner__dot:hover { background: rgba(255,255,255,.8); }
    .hero-banner__dot.active { background: #fff; transform: scale(1.2); }
    .hero-banner--single .hero-banner__arrow, .hero-banner--single .hero-banner__dots { display: none; }
    /* Banner text colors: use CSS vars set from admin (default #ffffff) */
    .hero-content .eyebrow { color: var(--banner-eyebrow-color, #ffffff); text-shadow: 0 2px 4px rgba(0,0,0,.9), 0 4px 12px rgba(0,0,0,.7), 0 0 40px rgba(0,0,0,.5); }
    .hero-content .title { color: var(--banner-title-color, #ffffff); text-shadow: 0 2px 4px rgba(0,0,0,.9), 0 4px 12px rgba(0,0,0,.7), 0 0 40px rgba(0,0,0,.5); }
    .hero-content .title-line2 { color: var(--banner-title-line2-color, var(--banner-title-color, #ffffff)); text-shadow: 0 2px 4px rgba(0,0,0,.9), 0 4px 12px rgba(0,0,0,.7), 0 0 40px rgba(0,0,0,.5); }
    .hero-content .subtitle { color: var(--banner-subtitle-color, #ffffff); text-shadow: 0 2px 4px rgba(0,0,0,.9), 0 4px 12px rgba(0,0,0,.7), 0 0 40px rgba(0,0,0,.5); }
    .eyebrow { font-size: clamp(10px, 1.8vw, 14px); font-weight: 700; letter-spacing: .08em; text-transform: uppercase; margin: 0; line-height: 1.2; }
    .title { margin: 6px 0 0; font-size: clamp(18px, 4.2vw, 36px); line-height: 1.15; font-weight: 800; word-wrap: break-word; hyphens: auto; }
    .subtitle { margin-top: 8px; font-size: clamp(13px, 2vw, 16px); font-weight: 600; line-height: 1.35; }
    .hero-banner .actions { display: none; }
    @media (max-width: 1024px) {
      .hero-banner { min-height: var(--banner-h, 560px); }
    }
    @media (max-width: 720px) {
      .hero-banner { min-height: var(--banner-h, clamp(180px, 36vh, 320px)); }
      .hero-content { padding: 0 var(--content-gutter); width: 92%; }
      .eyebrow { font-size: 10px; }
      .title { font-size: clamp(16px, 5vw, 24px); margin-top: 6px; }
      .subtitle { font-size: clamp(12px, 3vw, 14px); margin-top: 6px; }
      .hero-banner__arrow { width: 34px; height: 34px; font-size: 18px; }
      .hero-banner__arrow.prev { left: 8px; }
      .hero-banner__arrow.next { right: 8px; }
      .hero-banner__dots { bottom: 10px; gap: 6px; }
      .hero-banner__dot { width: 6px; height: 6px; }
    }
    @media (max-width: 480px) {
      .hero-banner { min-height: var(--banner-h, clamp(150px, 32vh, 260px)); }
      .hero-content { padding: 0 var(--content-gutter); width: 100%; }
      .eyebrow { font-size: 9px; letter-spacing: .06em; }
      .title { font-size: clamp(14px, 4.5vw, 20px); line-height: 1.2; margin-top: 4px; }
      .subtitle { font-size: 12px; margin-top: 4px; }
      .hero-banner__arrow { width: 30px; height: 30px; font-size: 16px; }
      .hero-banner__arrow.prev { left: 6px; }
      .hero-banner__arrow.next { right: 6px; }
      .hero-banner__dots { bottom: 8px; gap: 5px; }
      .hero-banner__dot { width: 5px; height: 5px; }
    }
    .actions { margin-top:22px; display:flex; gap:12px; justify-content:center; flex-wrap:wrap }
    .btn { padding:10px 16px; border-radius:10px; border:1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.55); backdrop-filter: blur(4px); color:#fff; text-decoration:none; font-weight:600 }
    .btn.primary { background: var(--blue); border-color: transparent }

    body[data-theme="light"] .eyebrow { color: var(--text); opacity: 1 }
    body[data-theme="light"] .subtitle { color: var(--text); opacity: .85 }
    /* Keep banner hero text readable in light mode: don't override with dark text on dark banner */
    body[data-theme="light"] .hero-content .eyebrow { color: var(--banner-eyebrow-color, #ffffff); opacity: 1 }
    body[data-theme="light"] .hero-content .title { color: var(--banner-title-color, #ffffff) }
    body[data-theme="light"] .hero-content .title-line2 { color: var(--banner-title-line2-color, var(--banner-title-color, #ffffff)) }
    body[data-theme="light"] .hero-content .subtitle { color: var(--banner-subtitle-color, #ffffff); opacity: 1 }
    body[data-theme="light"] .btn { background: rgba(226,232,240,.85); color: var(--text); border-color: rgba(15,23,42,.15) }
    body[data-theme="light"] .btn.primary { color: #fff; border-color: transparent }

    .section { width: 80%; max-width: none; margin: 0 auto; padding: 28px 0 }
    .features { display: grid; grid-template-columns: repeat(4, 1fr); gap: 22px; margin-top: 22px }
    .feature-card { background: rgba(15,23,42,.6); border: 1px solid rgba(148,163,184,.12); border-radius: 14px; padding: 18px; text-align: left; min-width: 0 }
    .feature-card .ic { width: 40px; height: 40px; border-radius: 10px; display: grid; place-items: center; background: rgba(30,64,175,.25); color: #93c5fd; margin-bottom: 10px }
    .feature-card .ic img { width: 100%; height: 100%; border-radius: 10px; object-fit: cover; display: block }
    .feature-card h3 { margin: 6px 0 6px; font-size: 18px }
    .feature-card p { margin: 0; color: #94a3b8; font-size: 14px; line-height: 1.5 }
    body[data-theme="light"] .feature-card { background: rgba(255,255,255,.9); border-color: rgba(15,23,42,.12) }
    body[data-theme="light"] .feature-card p { color: var(--muted) }

    /* Customer reviews */
    .reviews-section { }
    .reviews-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; margin-top: 22px }
    .review-card { background: rgba(15,23,42,.6); border: 1px solid rgba(148,163,184,.12); border-radius: 14px; padding: 18px; text-align: left; min-width: 0 }
    .review-card .review-quote { font-size: 14px; line-height: 1.55; color: var(--text); margin: 0 0 12px }
    .review-card .review-author { font-weight: 700; font-size: 15px; color: var(--text); margin: 0 }
    .review-card .review-role { font-size: 13px; color: var(--muted); margin: 2px 0 0 }
    .review-card .review-stars { margin-bottom: 10px; color: #fbbf24; font-size: 14px; letter-spacing: 2px }
    body[data-theme="light"] .review-card { background: rgba(255,255,255,.9); border-color: rgba(15,23,42,.12) }
    body[data-theme="light"] .review-card .review-quote { color: var(--text) }
    body[data-theme="light"] .review-card .review-role { color: var(--muted) }
    .reviews-more-wrap { text-align: center; margin-top: 16px; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 12px }
    .reviews-more-wrap.reviews-more-hidden { display: none }
    .reviews-more-btn { padding: 10px 20px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.55); color: #fff; font-weight: 600; cursor: pointer }
    .reviews-more-btn.reviews-more-btn-hidden { display: none }
    .reviews-more-btn:hover { background: rgba(30,41,59,.8); color: #fff }
    .reviews-add-btn { display: inline-block; padding: 10px 20px; border-radius: 10px; border: none; background: var(--blue); color: #fff; font-weight: 600; text-decoration: none; font-size: 14px }
    .reviews-add-btn:hover { filter: brightness(1.1); color: #fff }
    @media (max-width: 992px) { .reviews-grid { grid-template-columns: repeat(2, 1fr) } }
    @media (max-width: 768px) {
      .reviews-grid { grid-template-columns: repeat(3, 1fr); gap: 12px; margin-top: 14px }
      .reviews-grid .review-card:nth-child(n+7) { display: none }
      .reviews-grid.reviews-expanded .review-card:nth-child(n+7) { display: block }
      .review-card { padding: 14px }
      .review-card .review-quote { font-size: 13px }
      .review-card .review-author { font-size: 14px }
      .review-card .review-role { font-size: 12px }
    }
    @media (max-width: 576px) { .reviews-grid { gap: 10px; margin-top: 12px } .review-card { padding: 12px } .review-card .review-quote { font-size: 12px } }

    .review-add { margin-top: 28px; padding: 20px; background: rgba(15,23,42,.6); border: 1px solid rgba(148,163,184,.12); border-radius: 14px; max-width: 520px }
    .review-add h3 { margin: 0 0 14px; font-size: 18px; font-weight: 700 }
    .review-add label { display: block; margin-bottom: 4px; color: var(--muted); font-size: 13px; font-weight: 600 }
    .review-add input, .review-add select, .review-add textarea { width: 100%; padding: 10px 12px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.6); color: var(--text); font-size: 15px; margin-bottom: 12px; box-sizing: border-box }
    .review-add textarea { min-height: 100px; resize: vertical }
    .review-add .review-submit { padding: 10px 18px; border-radius: 10px; border: 0; background: var(--blue); color: #fff; font-weight: 600; font-size: 15px; cursor: pointer }
    .review-add .review-submit:hover { filter: brightness(1.1) }
    .review-add .review-success { background: rgba(16,185,129,.15); color: #a7f3d0; border: 1px solid rgba(16,185,129,.35); padding: 10px 12px; border-radius: 10px; margin-bottom: 12px; font-size: 14px }
    .review-add .review-errors { background: rgba(239,68,68,.15); color: #fecaca; border: 1px solid rgba(239,68,68,.35); padding: 10px 12px; border-radius: 10px; margin-bottom: 12px; font-size: 14px }
    body[data-theme="light"] .review-add { background: rgba(255,255,255,.9); border-color: rgba(15,23,42,.12) }

    .track-section { padding: 28px 0; scroll-margin-top: 80px }
    .track-section-row { display: flex; gap: 32px; align-items: flex-start; flex-wrap: wrap }
    .track-section-left { flex: 1 1 320px; min-width: 0 }
    .track-section-right { flex: 1 1 320px; min-width: 0 }
    .track-section-right.review-add { margin-top: 0 }
    @media (max-width: 720px) {
      .track-section-row { flex-direction: column; gap: 24px }
    }
    .track-wrap { margin-top: 16px; max-width: 560px }
    .track-input { width: 100%; padding: 12px 14px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.6); color: var(--text); font-size: 16px }
    .track-select-wrap { margin-top: 12px }
    .track-select-wrap label { display: block; margin-bottom: 6px; color: var(--muted); font-size: 14px; font-weight: 600 }
    .track-select { width: 100%; padding: 12px 14px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.6); color: var(--text); font-size: 16px }
    .track-buttons { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px }
    .track-submit-wrap { margin-top: 12px }
    .track-submit { padding: 12px 20px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: var(--blue); color: #fff; font-weight: 600; font-size: 16px; cursor: pointer }
    .track-submit:hover { filter: brightness(1.1) }
    .track-provider { margin: 0 }
    .track-empty { color: var(--muted); font-size: 14px }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0 }

    .activities { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; margin-top: 22px }
    .activity-card { background: rgba(15,23,42,.6); border: 1px solid rgba(148,163,184,.12); border-radius: 14px; overflow: hidden; text-align: left; min-width: 0 }
    .activity-card img { width: 100%; height: 160px; object-fit: cover; display: block; background: #0b1220 }
    .activity-card .pad { padding: 16px }
    .activity-card h3 { margin: 0 0 6px; font-size: 18px }
    .activity-card .meta { color: #94a3b8; font-size: 12px; margin-bottom: 10px }
    .activity-card p { margin: 0; color: #94a3b8; font-size: 14px; line-height: 1.5 }
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
    .check-card { position: absolute; right: 10px; top: 10px; background: rgba(239,68,68,.95); color: #fff; padding: 8px 10px; border-radius: 10px; width: 160px; max-width: 45%; font-size: 13px; box-shadow: 0 8px 24px rgba(239,68,68,.35) }
    .check-card li { list-style:none; margin:4px 0 }
    .check-card li::before { content:"✓ "; margin-right:4px }
    .footer { width: 100%; margin: 32px 0 0; padding: 0; color: var(--muted); font-size: 14px }
    .footer-inner { max-width: 1200px; margin: 0 auto; padding: 28px 24px; min-width: 0 }
    .footer form, .footer input { display: none }
    .footer-grid { display: grid; grid-template-columns: 1.25fr 1fr 1fr 1.1fr; gap: 28px 24px; align-items: start }
    .footer-col { min-width: 0 }
    .footer-col h4 { margin: 0 0 12px; font-size: 15px; font-weight: 700; letter-spacing: .02em }
    .footer-col p, .footer-col ul { margin: 0; font-size: 14px; line-height: 1.5 }
    .footer-col ul { list-style: none; padding: 0 }
    .footer-col li { margin: 8px 0 }
    .footer-col a { color: inherit; text-decoration: none; transition: opacity .2s }
    .footer-col a:hover { opacity: .9 }
    .footer-logo { margin: 0 0 14px }
    .footer-logo img { width: 140px; max-width: 100%; height: auto; border-radius: 8px; border: 1px solid rgba(255,255,255,.2); display: block; object-fit: contain }
    .footer-brand-text { margin: 0 0 14px }
    .footer-brand-name { display: block; font-size: 1.75rem; font-weight: 800; letter-spacing: -.02em; line-height: 1.1; color: inherit }
    .footer-brand-tagline { display: block; font-size: 0.8rem; font-weight: 600; opacity: .9; margin-top: 4px; letter-spacing: .02em }
    .footer-social { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 12px }
    .footer-social a { display: inline-flex; align-items: center; justify-content: center; padding: 8px 10px; border-radius: 10px; border: 1px solid rgba(255,255,255,.2) }
    .footer-bottom { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 10px; margin-top: 24px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,.1); font-size: 13px; text-align: center }
    @media (max-width: 992px) {
      .footer-grid { grid-template-columns: repeat(2, 1fr); gap: 24px 20px }
      .footer-inner { padding: 24px 20px }
    }
    @media (max-width: 640px) {
      .footer-grid { grid-template-columns: 1fr; gap: 22px }
      .footer-inner { padding: 20px 16px }
      .footer-col h4 { margin-bottom: 10px; font-size: 14px }
      .footer-col li { margin: 6px 0 }
      .footer-bottom { margin-top: 20px; padding-top: 16px; font-size: 12px }
    }
    @media (max-width: 480px) {
      .footer-inner { padding: 18px 12px }
      .footer-logo img { width: 120px }
      .footer-brand-name { font-size: 1.5rem }
      .footer-brand-tagline { font-size: 0.75rem }
      .footer-bottom { padding-top: 14px }
    }
    @media (max-width: 1100px) { .features { grid-template-columns: repeat(2, 1fr) } .services { grid-template-columns: 1fr } }
    @media (max-width: 1100px) { .activities { grid-template-columns: repeat(2, 1fr) } }
    @media (max-width: 768px) { .features { grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 14px } .features .feature-card:nth-child(n+7) { display: none } .feature-card { padding: 12px } .feature-card .ic { width: 32px; height: 32px; border-radius: 8px; margin-bottom: 8px } .feature-card h3 { font-size: 14px } .feature-card p { font-size: 12px; line-height: 1.4 } }
    @media (max-width: 620px) { .features { gap: 8px; margin-top: 12px } .feature-card { padding: 10px } .feature-card .ic { width: 28px; height: 28px; margin-bottom: 6px } .feature-card h3 { font-size: 12px } .feature-card p { font-size: 11px } }
    @media (max-width: 768px) { .activities { grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 14px } .activities .activity-card:nth-child(n+7) { display: none } .activity-card img { height: 100px } .activity-card .pad { padding: 10px } .activity-card h3 { font-size: 14px } .activity-card .meta { font-size: 10px; margin-bottom: 6px } .activity-card p { font-size: 12px; line-height: 1.4 } }
    @media (max-width: 480px) { .activities { gap: 8px; margin-top: 12px } .activity-card img { height: 80px } .activity-card .pad { padding: 8px } .activity-card h3 { font-size: 12px } .activity-card .meta { font-size: 9px } .activity-card p { font-size: 11px } }

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
    .gallery { width: 80%; max-width: none; margin: 12px auto 0; padding: 16px 0 8px; overflow-x: hidden }
    .gallery h2 { margin: 0 0 16px; font-size: 1.25rem }
    .gallery-track { display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px; margin-bottom: 0 }
    .gallery-track .gcard:nth-child(n+7) { display: none }
    .gallery-track.gallery-expanded .gcard:nth-child(n+7) { display: block }
    .gcard { position: relative; width: 100%; min-width: 0; height: 140px; border-radius: 14px; overflow: hidden; border: 1px solid rgba(148,163,184,.12); background: #0b1220 }
    .gcard img { width: 100%; height: 100%; object-fit: cover; display: block }
    .gcard .meta { position: absolute; left: 8px; top: 8px; background: #111827; color: #fff; font-weight: 800; padding: 4px 8px; border-radius: 10px; display: flex; align-items: center; gap: 6px }
    .gcard .meta .d { background: #ef4444; color: #fff; width: 30px; height: 30px; border-radius: 10px; display: grid; place-items: center; font-size: 12px; line-height: 1 }
    .gcard .meta .t { font-size: 12px; color: #e5e7eb; display: flex; flex-direction: column; line-height: 1.1 }
    .gallery-more-wrap { text-align: center; margin-top: 16px }
    .gallery-more-wrap.gallery-more-hidden { display: none }
    .gallery-more-btn { padding: 10px 20px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.55); color: #fff; font-weight: 600; cursor: pointer }
    .gallery-more-btn:hover { background: rgba(30,41,59,.8); color: #fff }
    @media (max-width: 1200px) { .gallery-track { grid-template-columns: repeat(3, 1fr) } }
    @media (max-width: 768px) { .gallery-track { grid-template-columns: repeat(2, 1fr); gap: 12px } .gcard { height: 120px } }
    @media (max-width: 480px) { .gallery { padding-left: 12px; padding-right: 12px } .gallery-track { grid-template-columns: repeat(2, 1fr); gap: 10px } .gcard { height: 100px } .gcard .meta { padding: 3px 6px; font-size: 11px } .gcard .meta .d { width: 26px; height: 26px; font-size: 11px } }

    /* Help + Quote section */
    .helpwrap { width: 80%; max-width: none; margin: 18px auto; padding: 0 }
    @media (max-width: 980px) { .section, .footer, .why .wrap, .quote-wrap, .gallery, .helpwrap { width: 100%; padding-left: 24px; padding-right: 24px } .why { padding-left: 24px; padding-right: 24px } }
    @media (max-width: 640px) { .section { padding-left: 16px; padding-right: 16px; padding-top: 20px; padding-bottom: 20px } }
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
    .quotation-section { background:#ef4444; padding:22px; border-radius:16px; margin-bottom:22px; border:1px solid rgba(148,163,184,.12) }
    .quotation-section h4 { margin:0 0 6px; color:#fff; font-size:22px }
    .quotation-section p { margin:0 0 12px; color:#fde68a; font-size:14px }
    .quotation-section .form-quote { background:#061c24; padding:16px; border-radius:12px }
    .quotation-section .row2 { display:grid; grid-template-columns: 1fr 1fr; gap:10px; margin-bottom:10px }
    .quotation-section .input, .quotation-section .select { width:100%; padding:10px 12px; border-radius:8px; border:1px solid rgba(255,255,255,.25); background:#0b1a21; color:#fff }
    .quotation-section .submit { margin-top:10px; padding:10px 14px; border-radius:10px; background:#0b1220; color:#fff; border:1px solid rgba(255,255,255,.25); font-weight:800; cursor:pointer }
    .quotation-result { margin-top:14px; padding:14px; background:rgba(0,0,0,.25); border-radius:10px; color:#fff }
    .quotation-result .quotation-line { margin-top:8px; font-size:15px }
    .quotation-result .quotation-line:first-child { margin-top:0 }
    .quotation-result .quotation-line.dealer-price { color:#fde68a }
    .quotation-result .quotation-line.quotation-total { margin-top:12px; padding-top:10px; border-top:1px solid rgba(255,255,255,.2); font-size:17px }
    .quotation-whatsapp { margin-top:16px; padding-top:16px; border-top:1px solid rgba(255,255,255,.25) }
    .quotation-whatsapp .wa-btn { display:inline-flex; align-items:center; gap:8px; padding:10px 16px; border-radius:10px; background:#25D366; color:#fff; text-decoration:none; font-weight:700; border:none; cursor:pointer; transition:background .2s }
    .quotation-whatsapp .wa-btn:hover { background:#20bd5a; color:#fff }
    .quotation-downloads { margin-top:14px; display:flex; flex-wrap:wrap; gap:10px; align-items:center }
    .quotation-downloads .dl-btn { display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:10px; background:rgba(0,0,0,.3); color:#fff; text-decoration:none; font-weight:600; font-size:14px; border:1px solid rgba(255,255,255,.25); transition:background .2s }
    .quotation-downloads .dl-btn:hover { background:rgba(0,0,0,.5); color:#fff }
    .quotation-section .error-msg { margin-top:10px; padding:10px; background:rgba(239,68,68,.3); color:#fef2f2; border-radius:8px; font-size:14px }
    @media (max-width: 1000px) { .helpgrid { grid-template-columns: 1fr } .getquote .row2 { grid-template-columns: 1fr } .quotation-section .row2 { grid-template-columns: 1fr } }
    /* #quote responsive: smaller breakpoints */
    @media (max-width: 768px) {
      .quotation-section .row2 { grid-template-columns: 1fr }
      .quotation-section .form-quote { padding: 14px }
      .quotation-result { padding: 12px; font-size: 14px; word-wrap: break-word; overflow-wrap: break-word }
      .quotation-result .quotation-line { font-size: 14px }
      .quotation-downloads { gap: 8px }
      .quotation-downloads .dl-btn { padding: 8px 12px; font-size: 13px }
      .quotation-whatsapp .wa-btn { padding: 10px 14px; font-size: 14px; flex-wrap: wrap }
    }
    @media (max-width: 640px) {
      .quotation-section { padding: 16px; border-radius: 12px }
      .quotation-section h4 { font-size: 18px }
      .quotation-section .form-quote { padding: 12px }
      .quotation-section .input, .quotation-section .select { padding: 10px 12px; font-size: 16px }
      .quotation-section .submit { width: 100%; padding: 12px 14px }
      .quotation-result { margin-top: 12px; padding: 10px }
      .quotation-downloads { flex-direction: column; align-items: stretch }
      .quotation-downloads .dl-btn { justify-content: center }
    }
    @media (max-width: 480px) {
      .helpwrap { padding-left: 16px; padding-right: 16px }
      .quotation-section { padding: 14px; margin-bottom: 16px }
      .quotation-section h4 { font-size: 17px }
      .quotation-section .row2 { gap: 8px; margin-bottom: 8px }
      .quotation-section .form-quote { padding: 10px }
      .quotation-whatsapp .wa-btn { width: 100%; justify-content: center }
    }
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
        @if(trim((string)($cfgTag ?? '')) !== '')<small>{{ $cfgTag }}</small>@endif
      </div>
      <div class="header-menu">
        <button id="theme-toggle" class="themebtn" type="button" aria-label="Toggle theme"><span class="themebtn-label">Dark</span></button>
        <button class="hamb" type="button" aria-expanded="false" aria-controls="primary-links">Menu</button>
        <div id="primary-links" class="links">
        @php $homePath = trim((string) parse_url(url('/'), PHP_URL_PATH), '/'); @endphp
        @if(isset($navLinks) && $navLinks->count())
          @foreach($navLinks as $nl)
            @if(strtolower(trim((string)($nl->label ?? ''))) === 'book') @continue @endif
            @php
              $linkUrl = $nl->url;
              if (!empty($linkUrl)) {
                $linkUrl = trim((string) $linkUrl);
                if (!\Illuminate\Support\Str::startsWith($linkUrl, ['http://', 'https://', 'mailto:', 'tel:', '#'])) {
                  $linkUrl = url($linkUrl);
                }
              }
            @endphp
            @php
              $path = $linkUrl ? trim((string) parse_url($linkUrl, PHP_URL_PATH), '/') : '';
              $isHomeUrl = ($path === $homePath || $path === 'home');
            @endphp
            @if($isHomeUrl) @continue @endif
            <a href="{{ $linkUrl }}" @if($nl->target) target="{{ $nl->target }}" rel="noopener" @endif>
              @if(!empty($nl->icon))<span style="margin-right:6px">{{ $nl->icon }}</span>@endif{{ $nl->label }}
            </a>
          @endforeach
        @else
          <a href="{{ route('track') }}">Track</a>
        @endif
        <a href="{{ route('login') }}">Login</a>
        </div>
      </div>
    </div>
  </header>

  @php
    $heroPos = isset($banner) && $banner && !empty($banner->bg_position) ? $banner->bg_position : 'center';
    $heroSize = isset($banner) && $banner && !empty($banner->bg_size) ? $banner->bg_size : 'cover';
    $defaultSlideUrl = 'https://images.unsplash.com/photo-1483683804023-6ccdb62f86ef?q=80&w=1600&auto=format&fit=crop';
    $sliderImages = count($bannerImages) > 0 ? $bannerImages : [$defaultSlideUrl];
    $isSingleSlide = count($sliderImages) < 2;
    $safeHex = function($v) { $v = trim((string)$v); return preg_match('/^#([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/', $v) ? $v : ''; };
    $eyebrowColor = isset($banner) && $banner ? $safeHex($banner->eyebrow_color ?? '') : '';
    $titleColor = isset($banner) && $banner ? $safeHex($banner->title_color ?? '') : '';
    $titleLine2Color = isset($banner) && $banner ? $safeHex($banner->title_line2_color ?? '') : '';
    $subtitleColor = isset($banner) && $banner ? $safeHex($banner->subtitle_color ?? '') : '';
    $bannerColorStyle = '';
    if ($eyebrowColor) $bannerColorStyle .= '--banner-eyebrow-color: '.e($eyebrowColor).'; ';
    if ($titleColor) $bannerColorStyle .= '--banner-title-color: '.e($titleColor).'; ';
    if ($titleLine2Color) $bannerColorStyle .= '--banner-title-line2-color: '.e($titleLine2Color).'; ';
    if ($subtitleColor) $bannerColorStyle .= '--banner-subtitle-color: '.e($subtitleColor).'; ';
  @endphp
  <section id="hero-banner" class="hero-banner {{ $isSingleSlide ? 'hero-banner--single' : '' }}" data-banner-images="{{ json_encode($sliderImages) }}" data-banner-auto-rotate="{{ $bannerAutoRotate ? '1' : '0' }}" data-banner-interval="{{ $bannerRotateIntervalSec }}" style="{{ isset($banner) && $banner && !empty($banner->banner_height_px) ? "--banner-h: ".(int)$banner->banner_height_px."px;" : '' }}{{ isset($banner) && $banner && !empty($banner->banner_content_max_width_px) ? "--hero-content-w: ".(int)$banner->banner_content_max_width_px."px;" : '' }}{{ $bannerColorStyle }} --hero-pos: {{ $heroPos }}; --hero-size: {{ $heroSize }};">
    <div class="hero-banner__slides">
      @foreach($sliderImages as $i => $imgUrl)
        <div class="hero-banner__slide {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}" style="background-image: url('{{ e($imgUrl) }}');"></div>
      @endforeach
    </div>
    <div class="hero-banner__overlay"></div>
    <div class="hero-content">
      @if(trim((string)(optional($banner)->eyebrow ?? '')) !== '')
        <div class="eyebrow">{{ $banner->eyebrow }}</div>
      @endif
      @php
        $t1 = trim((string)(optional($banner)->title_line1 ?? ''));
        $t2 = trim((string)(optional($banner)->title_line2 ?? ''));
      @endphp
      @if($t1 !== '' || $t2 !== '')
        <h1 class="title">@if($t1 !== ''){{ $banner->title_line1 }}@endif @if($t2 !== '')<br><span class="title-line2">{{ $banner->title_line2 }}</span>@endif</h1>
      @endif
      @if(trim((string)(optional($banner)->subtitle ?? '')) !== '')
        <p class="subtitle">{{ $banner->subtitle }}</p>
      @endif
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

    <section class="section reviews-section" aria-label="Customer reviews">
      <h2 class="mb-3">Customer Reviews</h2>
      <div class="reviews-grid" id="reviews-grid">
        @if(isset($customerReviews) && $customerReviews->count())
          @foreach($customerReviews as $r)
            <article class="review-card" itemscope itemtype="https://schema.org/Review">
              @if($r->rating)
                <div class="review-stars" aria-hidden="true">{{ str_repeat('★', (int) $r->rating) }}{{ str_repeat('☆', 5 - (int) $r->rating) }}</div>
              @endif
              <blockquote class="review-quote" itemprop="reviewBody">{{ $r->review_text }}</blockquote>
              <footer>
                <cite class="review-author" itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name">{{ $r->customer_name }}</span></cite>
                @if($r->role_or_company)
                  <div class="review-role" itemprop="worksFor">{{ $r->role_or_company }}</div>
                @endif
              </footer>
            </article>
          @endforeach
        @else
          <article class="review-card">
            <div class="review-stars" aria-hidden="true">★★★★★</div>
            <p class="review-quote">Fast and reliable delivery. Our packages arrived on time and in perfect condition. Highly recommend!</p>
            <footer>
              <cite class="review-author">Sarah M.</cite>
              <div class="review-role">Small Business Owner</div>
            </footer>
          </article>
          <article class="review-card">
            <div class="review-stars" aria-hidden="true">★★★★★</div>
            <p class="review-quote">Professional service from start to finish. Tracking was clear and customer support was very helpful.</p>
            <footer>
              <cite class="review-author">James K.</cite>
              <div class="review-role">Logistics Manager</div>
            </footer>
          </article>
          <article class="review-card">
            <div class="review-stars" aria-hidden="true">★★★★☆</div>
            <p class="review-quote">Great experience overall. Would use again for international shipments.</p>
            <footer>
              <cite class="review-author">Emma L.</cite>
              <div class="review-role">E-commerce</div>
            </footer>
          </article>
        @endif
      </div>
      <div class="reviews-more-wrap" id="reviews-more-wrap">
        <button type="button" class="reviews-more-btn" id="reviews-more-btn" aria-label="See all customer reviews">More</button>
        <a href="{{ route('reviews.create') }}" class="reviews-add-btn" aria-label="Add your review">Add your review</a>
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

    <section id="track" class="section track-section" aria-label="Track your parcel">
      <h2 style="margin:0">Track your parcel</h2>
      <p style="color:var(--muted); margin:8px 0 14px">Enter your tracking number, select a parcel company, then click Track to open their tracking page.</p>
      <div class="track-wrap">
        @php $trackingLinksList = isset($trackingLinks) ? $trackingLinks : collect(); @endphp
        <label for="tracking_number" class="sr-only">Tracking number</label>
        <input type="text" id="tracking_number" class="track-input" placeholder="Tracking number" autocomplete="off">
        <div class="track-select-wrap">
          <label for="track_carrier">Select parcel company</label>
          <select id="track_carrier" class="track-select" aria-label="Select parcel company">
            <option value="">— Select carrier —</option>
            @foreach($trackingLinksList as $link)
              <option value="{{ e($link->url_template) }}">{{ $link->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="track-submit-wrap">
          <button type="button" class="track-submit" id="track-submit-btn" aria-label="Track parcel">Track</button>
        </div>
        <div class="track-buttons">
          @if($trackingLinksList->count())
            @foreach($trackingLinksList as $link)
              <button type="button" class="btn track-provider" data-url-template="{{ e($link->url_template) }}" title="Opens in new tab">{{ $link->name }}</button>
            @endforeach
          @else
            <span class="track-empty">Add tracking links in Admin (Parcel Tracking Links) to enable 3rd party tracking.</span>
          @endif
        </div>
      </div>
    </section>
  </main>



  <section class="gallery" aria-label="Latest logistics posts">
    <h2 class="mb-0">Gallery</h2>
    <div class="gallery-track" id="gallery-track" data-total="{{ isset($gallery) ? $gallery->count() : 3 }}">
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
    <div class="gallery-more-wrap" id="gallery-more-wrap">
      <button type="button" class="gallery-more-btn" id="gallery-more-btn" aria-label="See all gallery items">More</button>
    </div>
  </section>

  <div class="helpwrap" id="quote">
    <section class="quotation-section" aria-label="Get a price quote">
      <h4>Get a price quote</h4>
      @if(session('error'))
        <div class="error-msg">{{ session('error') }}</div>
      @endif
      @if($errors->any())
        <div class="error-msg">{{ $errors->first() }}</div>
      @endif
      <form class="form-quote" action="{{ route('quotation.calculate') }}" method="post">
        @csrf
        <div class="row2">
          <div>
            <label for="rate_id" style="display:block; margin-bottom:6px; color:rgba(255,255,255,.9); font-size:13px">Country &amp; Service</label>
            <select class="select" id="rate_id" name="rate_id" required>
              <option value="">Select country – service</option>
              @forelse(($quotationRates ?? []) as $qr)
                <option value="{{ $qr->id }}" {{ old('rate_id') == $qr->id ? 'selected' : '' }}>{{ $qr->country }} – {{ $qr->service }}</option>
              @empty
                <option value="" disabled>No rates — add in Admin (Quotation Rates)</option>
              @endforelse
            </select>
          </div>
          <div>
            <label for="qty" style="display:block; margin-bottom:6px; color:rgba(255,255,255,.9); font-size:13px">Quantity (kg)</label>
            <input class="input" id="qty" type="number" step="0.01" min="0.01" name="qty" value="{{ old('qty', '1') }}" placeholder="kg" required>
          </div>
          <div>
            <label for="dealer_code" style="display:block; margin-bottom:6px; color:rgba(255,255,255,.9); font-size:13px">Dealer code (optional)</label>
            <input class="input" id="dealer_code" type="text" name="dealer_code" value="{{ old('dealer_code') }}" placeholder="Enter dealer code to get dealer price">
          </div>
        </div>
        <div class="row2">
          <div style="display:flex; align-items:flex-end">
            <button type="submit" class="submit">Get total</button>
          </div>
        </div>
      </form>
      <div id="quotation-result-area">
      @if(session('quotation_result'))
        @php
          $res = session('quotation_result');
          $unitPrice = !empty($res['dealer_applied']) ? $res['dealer_unit_price'] : $res['customer_unit_price'];
          $totalPrice = !empty($res['dealer_applied']) ? $res['total_dealer'] : $res['total_customer'];
        @endphp
        <div class="quotation-result">
          <div class="quotation-line"><strong>Country:</strong> {{ $res['country'] }}</div>
          <div class="quotation-line"><strong>Service:</strong> {{ $res['service'] }}</div>
          <div class="quotation-line"><strong>Total Weight:</strong> {{ $res['qty'] }} kg</div>
          <div class="quotation-line"><strong>Price per kg:</strong> {{ number_format($unitPrice, 0) }}</div>
          <div class="quotation-line quotation-total"><strong>Total Price:</strong> {{ number_format($totalPrice, 0) }}</div>
          @if(!empty($res['dealer_code_entered']) && empty($res['dealer_applied']))
            <div class="quotation-line" style="color:#fca5a5; font-size:13px;">Dealer code not found or inactive.</div>
          @endif
        </div>
        <div class="quotation-downloads">
          <a class="dl-btn" href="{{ route('quotation.download.pdf') }}" aria-label="Download quotation as PDF">📄 Download PDF</a>
          <a class="dl-btn" href="{{ route('quotation.download.image') }}" download aria-label="Download quotation as PNG">🖼️ Download PNG</a>
          <a class="dl-btn" href="{{ route('quotation.download.text') }}" download aria-label="Download quotation as text">📝 Download text</a>
        </div>
      @endif
      @php
        $whatsappNumber = trim((string) optional(\App\Models\Setting::where('key', 'whatsapp_number')->first())->value);
        if ($whatsappNumber === '') {
          $whatsappNumber = preg_replace('/\D/', '', (string) optional(\App\Models\Setting::where('key', 'contact_phone')->first())->value);
        }
        $whatsappMessage = 'Your QUOTATION';
        if (session('quotation_result')) {
          $qr = session('quotation_result');
          $unitPrice = !empty($qr['dealer_applied']) ? ($qr['dealer_unit_price'] ?? 0) : ($qr['customer_unit_price'] ?? 0);
          $totalPrice = !empty($qr['dealer_applied']) ? ($qr['total_dealer'] ?? 0) : ($qr['total_customer'] ?? 0);
          $lines = [
            'QUOTATION',
            '================',
            'Country: ' . ($qr['country'] ?? ''),
            'Service: ' . ($qr['service'] ?? ''),
            'Total Weight: ' . ($qr['qty'] ?? '') . ' kg',
            'Price per kg: ' . number_format($unitPrice, 0),
            'Total Price: ' . number_format($totalPrice, 0),
            '',
            'Generated ' . now()->format('Y-m-d H:i'),
          ];
          $whatsappMessage = implode("\n", $lines);
        }
      @endphp
      @if($whatsappNumber !== '')
        <div class="quotation-whatsapp">
          <a class="wa-btn" href="https://wa.me/{{ e($whatsappNumber) }}?text={{ rawurlencode($whatsappMessage) }}" target="_blank" rel="noopener" aria-label="Send via WhatsApp">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Send via WhatsApp
          </a>
        </div>
      @endif
      </div>
    </section>
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

  @include('partials.footer')

  <script>
    (function(){ var y = document.getElementById('year'); if (y) y.textContent = new Date().getFullYear(); })();

    // Hide quotation result when viewing #track (e.g. after refresh on #track)
    (function() {
      var quoteArea = document.getElementById('quotation-result-area');
      function toggleQuoteResult() {
        if (!quoteArea) return;
        quoteArea.style.display = (window.location.hash === '#track') ? 'none' : '';
      }
      toggleQuoteResult();
      window.addEventListener('hashchange', toggleQuoteResult);
    })();

    // Automatically clear quotation result when user changes rate, qty, or dealer code
    (function() {
      var quoteArea = document.getElementById('quotation-result-area');
      var rateSelect = document.getElementById('rate_id');
      var qtyInput = document.getElementById('qty');
      var dealerInput = document.getElementById('dealer_code');
      function clearResult() {
        if (quoteArea) quoteArea.style.display = 'none';
      }
      if (rateSelect) rateSelect.addEventListener('change', clearResult);
      if (qtyInput) { qtyInput.addEventListener('input', clearResult); qtyInput.addEventListener('change', clearResult); }
      if (dealerInput) { dealerInput.addEventListener('input', clearResult); dealerInput.addEventListener('change', clearResult); }
    })();

    // Public site theme (dark/light)
    const siteDefaultTheme = '{{ in_array(($cfgSiteTheme ?? 'dark'), ['dark','light']) ? ($cfgSiteTheme ?? 'dark') : 'dark' }}';
    const savedSiteTheme = localStorage.getItem('site_theme') || siteDefaultTheme || 'dark';
    document.body.setAttribute('data-theme', savedSiteTheme);
    const themeBtn = document.getElementById('theme-toggle');
    if (themeBtn){
      const setLabel = () => { const t = (document.body.getAttribute('data-theme') === 'light') ? 'Light' : 'Dark'; const el = themeBtn.querySelector('.themebtn-label') || themeBtn; el.textContent = t; };
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

    // Home link: stay on same page (scroll to top) when already on home
    (function(){
      var primaryLinks = document.getElementById('primary-links');
      document.querySelectorAll('.js-home-link').forEach(function(a){
        a.addEventListener('click', function(e){
          var path = (window.location.pathname || '/').replace(/\/$/, '') || '';
          var isHome = (path === '' || path === 'home' || path === 'site' || path.endsWith('/home') || path.endsWith('/site') || path === 'apx');
          if (isHome) {
            e.preventDefault();
            window.scrollTo(0, 0);
            if (primaryLinks && primaryLinks.classList.contains('open')) primaryLinks.classList.remove('open');
          }
        });
      });
    })();

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
      const carrierSelect = document.getElementById('track_carrier');
      const providers = document.querySelectorAll('.track-provider');
      const trackBtn = document.getElementById('track-submit-btn');

      function openTracking(num, template){
        if (!template) return;
        var url = template.replace(/\{tracking_number\}/gi, encodeURIComponent(num)).replace(/\{tracking\}/gi, encodeURIComponent(num));
        if (url) window.open(url, '_blank', 'noopener');
      }

      providers.forEach(function(btn){
        btn.addEventListener('click', function(){
          var num = (input && input.value) ? input.value.trim() : '';
          if (!num){ alert('Please enter a tracking number.'); return; }
          var template = this.getAttribute('data-url-template') || '';
          if (carrierSelect && template) carrierSelect.value = template;
          openTracking(num, template);
        });
      });

      if (trackBtn && input){
        trackBtn.addEventListener('click', function(){
          var num = (input.value || '').trim();
          if (!num){ alert('Please enter a tracking number.'); return; }
          var template = (carrierSelect && carrierSelect.value) ? carrierSelect.value : '';
          if (template){ openTracking(num, template); }
          else {
            var first = providers[0];
            if (first){ openTracking(num, first.getAttribute('data-url-template') || ''); }
            else { alert('Please select a parcel company, or add tracking links in Admin (Parcel Tracking Links).'); }
          }
        });
      }
    })();

    (function(){
      var track = document.getElementById('gallery-track');
      var wrap = document.getElementById('gallery-more-wrap');
      var btn = document.getElementById('gallery-more-btn');
      if (!track || !wrap || !btn) return;
      var total = parseInt(track.getAttribute('data-total') || '0', 10);
      if (total <= 6) { wrap.classList.add('gallery-more-hidden'); return; }
      btn.addEventListener('click', function(){
        track.classList.add('gallery-expanded');
        wrap.classList.add('gallery-more-hidden');
      });
    })();

    (function(){
      var grid = document.getElementById('reviews-grid');
      var wrap = document.getElementById('reviews-more-wrap');
      var btn = document.getElementById('reviews-more-btn');
      if (!grid || !wrap || !btn) return;
      var total = grid.querySelectorAll('.review-card').length;
      if (total <= 6) { btn.classList.add('reviews-more-btn-hidden'); return; }
      btn.addEventListener('click', function(){
        grid.classList.add('reviews-expanded');
        btn.classList.add('reviews-more-btn-hidden');
      });
    })();
  </script>
</body>
</html>
