<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php
    $seoSiteName = optional(\App\Models\Setting::where('key','site_name')->first())->value ?: 'apx.lk';
    $seoTitle = $seoSiteName;
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <style>
    :root { --bg: #0b1220; --card: #0f172a; --muted:#94a3b8; --text:#e2e8f0; --brand:#1e293b; --blue:#3b82f6; }
    body[data-theme="dark"] { --bg:#0b1220; --card:#0f172a; --muted:#94a3b8; --text:#e2e8f0; --brand:#1e293b; --blue:#3b82f6; --header-bg: #9f1239; }
    body[data-theme="light"] { --bg:#f8fafc; --card:#ffffff; --muted:#475569; --text:#0f172a; --brand:#e2e8f0; --blue:#2563eb; }
    * { box-sizing: border-box }
    html { overflow-x: hidden; height: 100%; background: var(--bg); }
    body { margin: 0; font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; background: var(--bg); color: var(--text); overflow-x: hidden; min-width: 0; --content-gutter: 20px; --header-height: 80px; -webkit-tap-highlight-color: transparent; transition: background-color .3s ease, color .3s ease; }
    img { max-width: 100%; height: auto; }
    /* Content and scroll start below fixed header - one border (header bottom), then spacer, then banner visible */
    .content-below-header { display: block; min-height: 100vh; width: 100%; max-width: 100vw; overflow-x: hidden; background: var(--bg); }
    main { background: var(--bg); }
    .header-spacer { display: block; width: 100%; height: 240px; min-height: 240px; flex-shrink: 0; background: transparent; }
    @media (max-width: 1920px) { .header-spacer { height: 200px; min-height: 200px; } }
    @media (max-width: 1680px) { .header-spacer { height: 180px; min-height: 180px; } }
    @media (max-width: 1024px) { .header-spacer { height: 180px; min-height: 180px; } }
    @media (max-width: 900px) { .header-spacer { height: 110px; min-height: 110px; } }
    @media (max-width: 720px) { .header-spacer { height: 72px; min-height: 72px; } }
    @media (max-width: 400px) { .header-spacer { height: 64px; min-height: 64px; } }
    /* Header: logo starts 3" from left, menu right; one clear border below, then banner */
    .topbar { background: var(--header-bg, #d83526); border-bottom: 2px solid var(--header-border, rgba(0,0,0,.15)); position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 0; box-sizing: border-box; }
    .topbar::before { content: ''; display: block; height: 4px; background: var(--header-strip, #fce4dc); }
    /* Dark mode: header uses dark color (override admin/inline --header-bg) */
    body[data-theme="dark"] .topbar { background: var(--card) !important; border-bottom-color: rgba(148,163,184,.25); }
    body[data-theme="dark"] .topbar::before { background: rgba(15,23,42,.6) !important; }
    body[data-theme="dark"] .topbar .brand span, body[data-theme="dark"] .topbar .brand small, body[data-theme="dark"] .topbar .header-tagline { color: var(--text) !important; }
    /* Header logo – light background for visibility on any header color */
    .topbar .brand img { background: rgba(255,255,255,.92); padding: 10px; border-radius: 10px; box-sizing: content-box; border: 1px solid rgba(255,255,255,.4); box-shadow: 0 2px 8px rgba(0,0,0,.2); }
    body[data-theme="dark"] .topbar .brand img { background: rgba(255,255,255,.95) !important; filter: none; border-color: rgba(255,255,255,.5) !important; }
    body[data-theme="dark"] .topbar .links a, body[data-theme="dark"] .topbar .header-contact-link, body[data-theme="dark"] .topbar .lang-switcher .lang-link { color: var(--text) !important; }
    body[data-theme="dark"] .topbar .lang-switcher .lang-sep, body[data-theme="dark"] .topbar .lang-switcher-mobile .lang-sep { color: var(--muted) !important; }
    body[data-theme="dark"] .lang-dropdown-trigger { background: rgba(255,255,255,.12); border-color: rgba(148,163,184,.25); color: var(--text) !important; }
    body[data-theme="dark"] .lang-dropdown-trigger:hover { background: rgba(255,255,255,.2); color: var(--text) !important; }
    body[data-theme="dark"] .lang-dropdown-menu { background: var(--card); border-color: rgba(148,163,184,.2); }
    body[data-theme="dark"] .lang-dropdown-menu a { color: var(--text) !important; }
    body[data-theme="dark"] .lang-dropdown-menu a:hover { background: rgba(148,163,184,.15); }
    body[data-theme="dark"] .lang-dropdown-menu a.active { background: rgba(148,163,184,.2); }
    body[data-theme="dark"] .links { background: var(--card) !important; }
    .nav { position: relative; width: 100%; max-width: none; margin: 0; padding: 12px 4in 12px 3in; display: flex; align-items: center; justify-content: space-between; gap: 14px; min-width: 0; }
    .header-left { display: flex; align-items: center; gap: 14px; flex-shrink: 0; min-width: 0; }
    .brand { display: flex; align-items: center; justify-content: flex-start; gap: 12px; font-weight: 800; text-align: left; min-width: 0; flex: 0 0 auto; margin: 0; }
    .header-tracking { flex: 0 0 auto; min-width: 0; max-width: 320px; display: flex; align-items: center; }
    .header-track-form { display: flex; align-items: center; gap: 10px; width: 100%; min-width: 0; }
    .header-track-input { flex: 1; min-width: 180px; padding: 10px 14px; border-radius: 8px; border: 1px solid rgba(255,255,255,.3); background: rgba(255,255,255,.15); color: var(--header-text, #fff); font-size: 20px; box-sizing: border-box; }
    .header-track-input::placeholder { color: rgba(255,255,255,.7); }
    .header-track-btn { flex-shrink: 0; padding: 10px 16px; border-radius: 8px; border: 1px solid rgba(255,255,255,.4); background: rgba(0,0,0,.25); color: var(--header-text, #fff); font-weight: 600; font-size: 20px; cursor: pointer; }
    .header-track-btn:hover { background: rgba(0,0,0,.4); }
    /* Keep header track inputs readable on red/dark-red header in both themes */
    body[data-theme="light"] .topbar .header-track-input, body[data-theme="dark"] .topbar .header-track-input { background: rgba(255,255,255,.15); color: #fff; border-color: rgba(255,255,255,.3); }
    body[data-theme="light"] .topbar .header-track-input::placeholder, body[data-theme="dark"] .topbar .header-track-input::placeholder { color: rgba(255,255,255,.7); }
    body[data-theme="light"] .topbar .header-track-btn, body[data-theme="dark"] .topbar .header-track-btn { background: rgba(0,0,0,.25); color: #fff; border-color: rgba(255,255,255,.4); }
    .header-right { display: flex; align-items: center; gap: 16px; margin-left: auto; flex-shrink: 0; min-width: 0; }
    .header-contact { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .header-contact-link { color: var(--header-link, #ffffff); text-decoration: none; font-size: 20px; font-weight: 500; white-space: nowrap; }
    .header-contact-link:hover { color: var(--header-text, #ffffff); opacity: 0.95; }
    .header-tagline { color: var(--header-tagline, rgba(255,255,255,.9)); font-weight: 600; font-size: var(--menu-size, var(--tagline-size, 14px)); letter-spacing: 0.03em; white-space: nowrap; }
    .header-menu { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }
    .brand img { width: 180px; max-width: 4in; height: auto; max-height: 1.5in; border-radius: 8px; object-fit: contain; border: none; display: block; flex-shrink: 0; margin: 0; }
    .brand span { line-height: 1.05; color: var(--header-text, #ffffff); font-size: var(--brand-size, 17px); font-weight: var(--brand-weight, 800); font-style: var(--brand-style, normal); word-break: break-word; letter-spacing: 0.02em; }
    .brand small { color: var(--header-tagline, rgba(255,255,255,.9)); font-weight: 600; display: block; line-height: 1.1; font-size: var(--tagline-size, 14px); letter-spacing: 0.03em; }
    .links { display: flex; align-items: center; gap: 20px; flex-shrink: 0; }
    .links a { color: var(--header-link, #ffffff); text-decoration: none; font-weight: 600; font-size: var(--menu-size, 14px); }
    .links a:hover { color: var(--header-text, #ffffff); opacity: 0.9; }
    .links a span { font-size: 0.95em; margin-right: 5px; }
    .hamb { display: none; background: rgba(17,24,39,.75); color: #fff; border: none; padding: 8px 14px; border-radius: 999px; font-weight: 700; flex-shrink: 0; }
    .themebtn { display: inline-flex; align-items: center; justify-content: center; background: rgba(30,30,30,.9); color: #ffffff; border: none; padding: 8px 16px; border-radius: 999px; font-weight: 600; font-size: var(--menu-size, 14px); cursor: pointer; }
    .themebtn:hover { background: rgba(0,0,0,.95); color: #fff; }
    .themebtn-icon { padding: 8px 10px; min-width: 40px; }
    .themebtn-icon .theme-icon { width: 20px; height: 20px; display: inline-block; line-height: 0; }
    .themebtn-icon .theme-icon svg { width: 100%; height: 100%; fill: none; stroke: currentColor; }
    .lang-switcher { display: flex; align-items: center; flex-shrink: 0; font-size: 14px; font-weight: 600; position: relative; }
    .lang-switcher .lang-link { color: var(--header-link, #ffffff); text-decoration: none; opacity: 0.85; }
    .lang-switcher .lang-link:hover { opacity: 1; color: var(--header-text, #fff); }
    .lang-switcher .lang-link.active { opacity: 1; text-decoration: underline; }
    .lang-switcher .lang-sep { color: rgba(255,255,255,.6); user-select: none; }
    /* Language dropdown: one symbol (globe) shows 3 languages */
    .lang-dropdown { position: relative; display: inline-block; }
    .lang-dropdown-trigger { display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; border-radius: 10px; background: rgba(255,255,255,.15); color: var(--header-link, #fff); font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; border: 1px solid rgba(255,255,255,.25); transition: background .2s ease, color .2s ease; }
    .lang-dropdown-trigger:hover { background: rgba(255,255,255,.25); color: #fff; }
    .lang-dropdown-trigger .lang-globe { font-size: 18px; line-height: 1; }
    .lang-dropdown-menu { position: absolute; top: 100%; right: 0; margin-top: 6px; min-width: 120px; background: var(--header-bg, #c2410c); border: 1px solid rgba(255,255,255,.3); border-radius: 12px; padding: 8px 0; box-shadow: 0 10px 28px rgba(0,0,0,.25); z-index: 100; display: none; }
    .lang-dropdown:focus-within .lang-dropdown-menu { display: block; }
    .lang-dropdown-menu a { display: block; padding: 10px 14px; color: #fff; text-decoration: none; font-size: 14px; font-weight: 600; transition: background .15s ease; }
    .lang-dropdown-menu a:hover { background: rgba(255,255,255,.2); }
    .lang-dropdown-menu a.active { background: rgba(255,255,255,.25); text-decoration: underline; }
    .lang-switcher-mobile { display: none; align-items: center; gap: 8px; padding: 10px 12px; margin-top: 8px; font-size: 13px; }
    .lang-switcher-mobile:not(.lang-in-header-mobile) { border-top: 1px solid rgba(255,255,255,.2); }
    .lang-switcher-mobile .lang-dropdown { width: 100%; }
    .lang-switcher-mobile .lang-dropdown-trigger { width: 100%; justify-content: center; }
    .lang-switcher-mobile .lang-dropdown-menu { left: 50%; right: auto; transform: translateX(-50%); }
    /* Mobile: lang in header bar, hidden on desktop */
    .lang-in-header-mobile { display: none; flex-shrink: 0; border: none; border-top: none; }
    .lang-switcher-mobile .lang-link { color: var(--header-link, #ffffff); text-decoration: none; opacity: 0.9; }
    .lang-switcher-mobile .lang-link.active { text-decoration: underline; opacity: 1; }
    .lang-switcher-mobile .lang-sep { color: rgba(255,255,255,.5); }
    body[data-theme="light"] .hamb { background: rgba(30,30,30,.9); color: #fff; }
    body[data-theme="light"] .themebtn { background: rgba(30,30,30,.9); color: #fff; }
    /* Auto-responsive: 24" / smaller desktop – scale header and spacing so layout stays intact */
    @media (max-width: 2000px) {
      .nav { padding: 12px 3in 12px 2in; gap: 12px; }
      .brand img { width: 160px; max-height: 1.35in; }
      .header-contact-link { font-size: 18px; }
      .header-tracking { max-width: 300px; }
      .links { gap: 16px; }
    }
    @media (max-width: 1680px) {
      .nav { padding: 12px 2in 12px 1.5in; gap: 10px; }
      .brand img { width: 150px; max-height: 1.25in; }
      .brand span { font-size: 16px; }
      .header-tagline { font-size: 13px; white-space: normal; max-width: 160px; }
      .header-contact-link { font-size: 17px; }
      .header-track-input { font-size: 18px; min-width: 160px; }
      .header-track-btn { font-size: 18px; padding: 8px 14px; }
      .header-tracking { max-width: 280px; }
      .links { gap: 14px; }
      .links a { font-size: 13px; }
    }
    @media (max-width: 1440px) {
      .nav { padding: 12px 1.5in 12px 1in; gap: 8px; }
      .brand img { width: 140px; max-height: 1.2in; }
      .brand span { font-size: 15px; }
      .header-tagline { font-size: 12px; white-space: normal; max-width: 140px; }
      .header-contact-link { font-size: 16px; }
      .header-track-input { font-size: 16px; min-width: 140px; }
      .header-track-btn { font-size: 16px; }
      .header-tracking { max-width: 260px; }
      .links { gap: 12px; }
      .links a { font-size: 13px; }
    }
    @media (max-width: 900px) {
      body { --content-gutter: 16px; --header-height: 68px; }
      .nav { padding: 10px 2in 10px 1.5in }
      .brand img { width: 140px; max-height: 1.2in }
      .brand span { font-size: clamp(14px, 2.5vw, 16px) }
      .header-tracking { max-width: 280px }
      .header-track-input { min-width: 160px }
      .header-contact-link { font-size: 18px }
    }
    @media (max-width: 720px) {
      body { --content-gutter: 14px; --header-height: 60px; }
      .nav { padding: 10px 16px 10px 16px; gap: 0; flex-wrap: nowrap; justify-content: space-between; align-items: center; }
      .header-left { flex: 1 1 auto; min-width: 0; width: 100%; max-width: 100%; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: nowrap; }
      .header-right { display: none; }
      .lang-switcher { font-size: 13px; }
      .lang-switcher-mobile { display: flex; }
      .lang-in-header-mobile { display: flex; align-items: center; padding: 0; margin: 0; border: none; border-top: none; }
      .lang-in-header-mobile .lang-dropdown { width: auto; }
      .lang-in-header-mobile .lang-dropdown-trigger { width: auto; padding: 8px 12px; min-height: 44px; font-size: 13px; }
      .header-tracking { display: none }
      .header-contact { display: none }
      .brand { flex: 0 1 auto; min-width: 0; max-width: calc(100% - 56px); }
      .brand img { width: auto; max-width: 100px; max-height: 44px; border-radius: 6px; object-fit: contain; }
      .brand span { font-size: 14px; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap }
      .header-menu { flex: 0 0 auto; position: relative; }
      .header-tagline { display: none }
      /* Mobile menu: responsive compact dropdown (right-aligned), not full-screen */
      .links { position: fixed; right: 12px; left: auto; top: var(--header-mobile-top, 60px); z-index: 99; background: var(--header-bg, #d83526); border: none; border-radius: 12px; padding: 10px 0; display: flex; flex-direction: column; gap: 2px; min-width: 160px; max-width: min(280px, calc(100vw - 24px)); width: auto; box-shadow: 0 10px 28px rgba(0,0,0,.25); visibility: hidden; opacity: 0; transform: translateY(-8px); transition: visibility .2s ease, opacity .2s ease, transform .2s ease; box-sizing: border-box; }
      .links.open { visibility: visible; opacity: 1; transform: translateY(0); }
      .links a { margin: 0 8px; padding: 10px 12px; font-size: 14px; border-radius: 8px; line-height: 1.3; min-height: 44px; display: flex; align-items: center; justify-content: flex-start; color: #fff; font-weight: 600; transition: background .2s ease; }
      .links a:hover { background: rgba(255,255,255,.15) }
      .links a span { margin-right: 8px; font-size: 1em; opacity: .95; }
      .theme-link-mobile { margin: 0 8px; padding: 10px 12px; font-size: 14px; border-radius: 8px; line-height: 1.3; min-height: 44px; display: flex; align-items: center; justify-content: flex-start; color: #fff; font-weight: 600; background: none; border: none; cursor: pointer; width: 100%; transition: background .2s ease; }
      .theme-link-mobile:hover { background: rgba(255,255,255,.15); color: #fff; }
      .lang-switcher-mobile:not(.lang-in-header-mobile) { flex-wrap: wrap; justify-content: center; gap: 4px; padding: 8px 12px 0; margin-top: 6px; margin-left: 8px; margin-right: 8px; border-top: 1px solid rgba(255,255,255,.2); font-size: 13px; }
      .lang-switcher-mobile .lang-link { color: #fff; padding: 4px 8px; font-weight: 600; }
      .lang-switcher-mobile .lang-sep { color: rgba(255,255,255,.5); font-size: 12px; }
      .hamb { display: inline-flex; align-items: center; justify-content: center; min-height: 44px; min-width: 44px; padding: 8px 12px; font-size: 13px; font-weight: 700; border-radius: 10px; transition: background .2s ease, transform .1s ease; }
      .hamb:active { transform: scale(0.98); }
      /* Theme button stays visible on mobile (single toggle with icon) */
    }
    @media (max-width: 400px) {
      body { --content-gutter: 12px; --header-height: 56px; }
      .nav { padding: 8px 12px 8px 12px; }
      .brand img { max-width: 80px; max-height: 36px; }
      .brand span { font-size: 13px; max-width: 90px; }
      .hamb { min-height: 42px; min-width: 42px; padding: 6px 10px; font-size: 12px; }
      .links { right: 8px; min-width: 140px; max-width: calc(100vw - 16px); padding: 8px 0; border-radius: 10px; }
      .links a { margin: 0 6px; padding: 8px 10px; font-size: 13px; min-height: 42px; }
      .lang-switcher-mobile { padding: 6px 10px 0; margin: 6px 6px 0; font-size: 12px; }
    }
    /* Mobile: prevent horizontal scroll, full-width sections */
    @media (max-width: 900px) {
      .section { width: 100%; padding-left: var(--content-gutter); padding-right: var(--content-gutter); box-sizing: border-box; }
    }
    @media (max-width: 600px) {
      .section { padding-top: 20px; padding-bottom: 20px; }
      .features { grid-template-columns: 1fr; gap: 12px; }
      main { overflow-x: hidden; max-width: 100%; }
    }
    @media (max-width: 480px) {
      .reviews-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
      .hero-content { text-align: left; }
      .hero-banner { min-height: var(--banner-h, 45vh); }
    }
    .icon { width:18px; height:18px; opacity:.9; vertical-align:-3px; margin-right:6px }
    /* Trending responsive banner: full width, stroke, trending style */
    .hero-banner { position: relative; width: 100%; min-height: var(--banner-h, 70vh); margin-top: 0; margin-bottom: 32px; display: grid; grid-template-columns: 1fr; align-items: start; justify-items: center; text-align: center; overflow: hidden; scroll-margin-top: 240px; border: 3px solid rgba(255,255,255,.35); border-radius: 20px; box-shadow: 0 0 0 1px rgba(0,0,0,.15), 0 12px 40px rgba(0,0,0,.25), inset 0 1px 0 rgba(255,255,255,.08); }
    .hero-banner::after { content: ''; position: absolute; left: 0; right: 0; bottom: 0; height: 4px; background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899); z-index: 5; pointer-events: none; border-radius: 0 0 17px 17px; }
    body[data-theme="dark"] .hero-banner { border-color: rgba(148,163,184,.25); box-shadow: 0 0 0 1px rgba(0,0,0,.3), 0 12px 40px rgba(0,0,0,.4), inset 0 1px 0 rgba(255,255,255,.05); }
    .hero-banner__slides { position: absolute; inset: 0; z-index: 0; background: var(--bg, #0b1220); border-radius: inherit; }
    .hero-banner__slide { position: absolute; inset: 0; background-position: var(--hero-pos, center); background-size: var(--hero-size, contain); background-repeat: no-repeat; background-color: var(--bg, #0b1220); opacity: 0; transition: opacity 0.6s ease; -webkit-background-size: var(--hero-size, contain); border-radius: inherit; }
    .hero-banner__slide.active { opacity: 1; z-index: 1; }
    .hero-banner__overlay { position: absolute; inset: 0; z-index: 2; pointer-events: none; }
    .hero-content { position: relative; z-index: 3; padding: 20px var(--content-gutter, 20px) 20px; padding-top: 20px; width: 90%; max-width: var(--hero-content-w, 820px); min-width: 0; }
    .hero-banner__controls { position: absolute; inset: 0; z-index: 4; pointer-events: none; }
    .hero-banner__controls .hero-banner__arrow { pointer-events: auto; }
    .hero-banner__controls .hero-banner__dots { pointer-events: auto; }
    .hero-banner__arrow { position: absolute; top: 50%; transform: translateY(-50%); z-index: 4; min-width: 42px; height: 42px; padding: 0 10px; border-radius: 999px; background: rgba(0,0,0,.4); color: #fff; border: 1px solid rgba(255,255,255,.3); cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 4px; font-size: 14px; font-weight: 600; line-height: 1; transition: background .2s, color .2s; user-select: none; }
    .hero-banner__arrow:hover { background: rgba(0,0,0,.6); color: #fff; }
    .hero-banner__arrow .hero-banner__arrow-icon { font-size: 20px; font-weight: 400; }
    .hero-banner__arrow.prev { left: 12px; }
    .hero-banner__arrow.next { right: 12px; }
    .hero-banner__dots { position: absolute; bottom: 14px; left: 50%; transform: translateX(-50%); z-index: 4; display: flex; gap: 8px; align-items: center; justify-content: center; }
    .hero-banner__dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,.5); border: 1px solid rgba(255,255,255,.6); cursor: pointer; transition: background .2s, transform .2s; }
    .hero-banner__dot:hover { background: rgba(255,255,255,.8); }
    .hero-banner__dot.active { background: #fff; transform: scale(1.2); }
    .hero-banner--single .hero-banner__controls { display: none; }
    /* Banner text colors: use CSS vars set from admin (default #ffffff) */
    .hero-content .eyebrow { color: var(--banner-eyebrow-color, #ffffff); text-shadow: 0 2px 4px rgba(0,0,0,.9), 0 4px 12px rgba(0,0,0,.7), 0 0 40px rgba(0,0,0,.5); }
    .hero-content .title { color: var(--banner-title-color, #ffffff); text-shadow: 0 2px 4px rgba(0,0,0,.9), 0 4px 12px rgba(0,0,0,.7), 0 0 40px rgba(0,0,0,.5); }
    .hero-content .title-line2 { color: var(--banner-title-line2-color, var(--banner-title-color, #ffffff)); text-shadow: 0 2px 4px rgba(0,0,0,.9), 0 4px 12px rgba(0,0,0,.7), 0 0 40px rgba(0,0,0,.5); }
    .hero-content .subtitle { color: var(--banner-subtitle-color, #ffffff); text-shadow: 0 2px 4px rgba(0,0,0,.9), 0 4px 12px rgba(0,0,0,.7), 0 0 40px rgba(0,0,0,.5); }
    .eyebrow { font-size: clamp(10px, 1.8vw, 14px); font-weight: 700; letter-spacing: .08em; text-transform: uppercase; margin: 0; line-height: 1.2; }
    .title { margin: 6px 0 0; font-size: clamp(18px, 4.2vw, 36px); line-height: 1.15; font-weight: 800; word-wrap: break-word; hyphens: auto; }
    .subtitle { margin-top: 8px; font-size: clamp(13px, 2vw, 16px); font-weight: 600; line-height: 1.35; }
    .hero-banner .actions { display: none; }
    @media (max-width: 1920px) {
      .hero-banner { min-height: var(--banner-h, 65vh); }
      .title { font-size: clamp(18px, 3.8vw, 34px); }
      .subtitle { font-size: clamp(13px, 1.9vw, 15px); }
    }
    @media (max-width: 1680px) {
      .hero-banner { min-height: var(--banner-h, 60vh); }
      .title { font-size: clamp(18px, 3.5vw, 30px); }
      .subtitle { font-size: clamp(13px, 1.8vw, 14px); }
      .hero-content { width: 92%; max-width: 720px; }
    }
    @media (max-width: 1024px) {
      .hero-banner { min-height: var(--banner-h, 60vh); }
    }
    /* Mobile view only: fixed banner (no responsive scaling) */
    @media (max-width: 720px) {
      .hero-banner { min-height: 280px; scroll-margin-top: 72px; margin-bottom: 24px; border-radius: 16px; border-width: 2px; }
      .hero-banner::after { height: 3px; border-radius: 0 0 14px 14px; }
      .hero-banner__slide { background-size: cover !important; background-position: center !important; }
      .hero-content { position: relative; padding: 16px var(--content-gutter); width: 100%; max-width: 100%; margin: 0; box-sizing: border-box; }
      .track-section { scroll-margin-top: 72px; }
      .eyebrow { font-size: 10px; }
      .title { font-size: 18px; line-height: 1.25; margin-top: 6px; }
      .subtitle { font-size: 13px; margin-top: 6px; }
      .hero-banner__arrow { width: 36px; height: 36px; min-width: 36px; padding: 0; font-size: 12px; }
      .hero-banner__arrow .hero-banner__arrow-text { display: none; }
      .hero-banner__arrow .hero-banner__arrow-icon { font-size: 18px; }
      .hero-banner__arrow.prev { left: 8px; }
      .hero-banner__arrow.next { right: 8px; }
      .hero-banner__dots { bottom: 12px; gap: 6px; }
      .hero-banner__dot { width: 6px; height: 6px; }
    }
    @media (max-width: 480px) {
      .hero-banner { min-height: 240px; margin-bottom: 20px; border-radius: 12px; border-width: 2px; }
      .hero-banner::after { height: 3px; border-radius: 0 0 10px 10px; }
      .hero-content { padding: 12px var(--content-gutter); }
      .eyebrow { font-size: 9px; letter-spacing: .06em; }
      .title { font-size: 16px; line-height: 1.2; margin-top: 4px; }
      .subtitle { font-size: 12px; margin-top: 4px; }
      .hero-banner__arrow { width: 32px; height: 32px; min-width: 32px; padding: 0; font-size: 0; }
      .hero-banner__arrow .hero-banner__arrow-text { display: none; }
      .hero-banner__arrow .hero-banner__arrow-icon { font-size: 16px; }
      .hero-banner__arrow.prev { left: 6px; }
      .hero-banner__arrow.next { right: 6px; }
      .hero-banner__dots { bottom: 10px; gap: 5px; }
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

    .section { width: 80%; max-width: none; margin: 0 auto; padding: 28px 0; min-width: 0; }
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
    .reviews-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 20px; margin-top: 22px }
    .review-card { background: rgba(15,23,42,.6); border: 1px solid rgba(148,163,184,.12); border-radius: 14px; padding: 18px; text-align: left; min-width: 0; box-shadow: 0 4px 14px rgba(0,0,0,.12) }
    .review-card .review-quote { font-size: 14px; line-height: 1.55; color: var(--text); margin: 0 0 12px }
    .review-card .review-author { font-weight: 700; font-size: 15px; color: var(--text); margin: 0 }
    .review-card .review-role { font-size: 13px; color: var(--muted); margin: 2px 0 0 }
    .review-card .review-stars { margin-bottom: 10px; color: #fbbf24; font-size: 14px; letter-spacing: 2px }
    body[data-theme="light"] .review-card { background: #fff; border-color: rgba(15,23,42,.08); box-shadow: 0 4px 14px rgba(0,0,0,.06) }
    body[data-theme="light"] .review-card .review-quote { color: var(--text) }
    body[data-theme="light"] .review-card .review-role { color: var(--muted) }
    .reviews-more-wrap { text-align: center; margin-top: 16px; display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 12px }
    .reviews-more-wrap.reviews-more-hidden { display: none }
    .reviews-more-btn { padding: 10px 20px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.55); color: #fff; font-weight: 600; cursor: pointer }
    .reviews-more-btn.reviews-more-btn-hidden { display: none }
    .reviews-more-btn:hover { background: rgba(30,41,59,.8); color: #fff }
    .reviews-add-btn { display: inline-block; padding: 10px 20px; border-radius: 10px; border: none; background: var(--blue); color: #fff; font-weight: 600; text-decoration: none; font-size: 14px }
    .reviews-add-btn:hover { filter: brightness(1.1); color: #fff }
    @media (max-width: 1100px) { .reviews-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px } }
    @media (max-width: 768px) {
      .reviews-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; margin-top: 14px }
      .reviews-grid .review-card:nth-child(n+7) { display: none }
      .reviews-grid.reviews-expanded .review-card:nth-child(n+7) { display: block }
      .review-card { padding: 14px }
      .review-card .review-quote { font-size: 13px }
      .review-card .review-author { font-size: 14px }
      .review-card .review-role { font-size: 12px }
    }
    @media (max-width: 576px) {
      .reviews-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; margin-top: 12px }
      .review-card { padding: 12px }
      .review-card .review-quote { font-size: 12px }
    }

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
    body[data-theme="light"] .review-add input, body[data-theme="light"] .review-add select, body[data-theme="light"] .review-add textarea { background: rgba(255,255,255,.95); border-color: rgba(15,23,42,.2); color: var(--text); }

    .track-section { padding: 28px 0; scroll-margin-top: 240px }
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
    body[data-theme="light"] .track-input, body[data-theme="light"] .track-select { background: rgba(255,255,255,.95); border-color: rgba(15,23,42,.2); color: var(--text); }
    body[data-theme="light"] .track-section .track-wrap label { color: var(--muted); }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0 }

    .activities { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 20px; margin-top: 22px }
    .activity-card { background: rgba(15,23,42,.6); border: 1px solid rgba(148,163,184,.12); border-radius: 14px; overflow: hidden; text-align: left; min-width: 0; box-shadow: 0 4px 14px rgba(0,0,0,.12) }
    .activity-card img { width: 100%; height: 160px; object-fit: cover; display: block; background: #0b1220 }
    .activity-card .pad { padding: 16px }
    .activity-card h3 { margin: 0 0 6px; font-size: 18px }
    .activity-card .meta { color: #94a3b8; font-size: 12px; margin-bottom: 10px }
    .activity-card p { margin: 0; color: #94a3b8; font-size: 14px; line-height: 1.5 }
    body[data-theme="light"] .activity-card { background: #fff; border-color: rgba(15,23,42,.08); box-shadow: 0 4px 14px rgba(0,0,0,.06) }
    body[data-theme="light"] .activity-card .meta,
    body[data-theme="light"] .activity-card p { color: var(--muted) }
    .clamp2 { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden }
    .clamp2.expanded { display:block; -webkit-line-clamp:unset; overflow:visible }
    .readmore { margin-top:8px; border:0; background:transparent; color:#93c5fd; font-weight:700; cursor:pointer; padding:0 }
    .readmore:hover { text-decoration: underline }

    .services { display:grid; grid-template-columns: 360px 1fr; gap: 22px; align-items:stretch; margin-top: 28px }
    .tabs { background: var(--card); border:1px solid rgba(148,163,184,.12); border-radius:14px; padding:10px; display:flex; flex-direction:column; gap:10px }
    .tab { display:flex; align-items:center; gap:10px; padding:12px 14px; border-radius:10px; color: var(--text); background: rgba(2,6,23,.35); border:1px solid rgba(148,163,184,.12) }
    body[data-theme="light"] .tab { background: rgba(15,23,42,.08); color: var(--text); border-color: rgba(15,23,42,.12); }
    .tab .ti { width: 28px; height: 28px; min-width: 28px; min-height: 28px; display: grid; place-items: center; border-radius: 8px; background: rgba(51,65,85,.55); overflow: hidden; flex-shrink: 0 }
    .tab .ti img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: inherit }
    /* Services section only: larger tab icons */
    .services .tab .ti { width: 2rem; height: 2rem; min-width: 2rem; min-height: 2rem; border-radius: 10px }
    .services .tab .ti img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: inherit }
    .tab.active { background:#ef4444; border-color:#ef4444; color:#fff }
    .preview { position:relative; border-radius:14px; overflow:hidden; border:1px solid rgba(148,163,184,.12) }
    /* Services preview image: fixed height so it doesn't overflow */
    .services .preview { height: 320px; min-height: 260px }
    .services .preview img { width: 100%; height: 100%; object-fit: cover; display: block; filter: saturate(1.05) }
    body[data-theme="light"] .tabs { background: rgba(255,255,255,.95); border-color: rgba(15,23,42,.12); }
    body[data-theme="light"] .preview { border-color: rgba(15,23,42,.12); }
    .preview img { width:100%; height:100%; object-fit:cover; display:block; filter:saturate(1.05) }
    .check-card { position: absolute; right: 10px; top: 10px; background: rgba(239,68,68,.95); color: #fff; padding: 8px 10px; border-radius: 10px; width: 160px; max-width: 45%; font-size: 13px; box-shadow: 0 8px 24px rgba(239,68,68,.35) }
    .check-card li { list-style:none; margin:4px 0 }
    .check-card li::before { content:"✓ "; margin-right:4px }
    /* Dark mode: footer uses theme surface so it matches page */
    body[data-theme="dark"] .footer .footer-bg { background: var(--card) !important; color: var(--text) !important; border-top-color: rgba(148,163,184,.2) !important; }
    body[data-theme="dark"] .footer .footer-bg a, body[data-theme="dark"] .footer .footer-bg h4, body[data-theme="dark"] .footer .footer-bg p, body[data-theme="dark"] .footer .footer-bg li { color: var(--text) !important; }
    body[data-theme="dark"] .footer .footer-bg a { color: var(--muted) !important; }
    body[data-theme="dark"] .footer .footer-bg a:hover { color: var(--text) !important; }
    /* Footer logo – light background for visibility */
    .footer .footer-bg .footer-logo img { background: rgba(255,255,255,.92); padding: 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,.35) !important; box-sizing: content-box; box-shadow: 0 2px 10px rgba(0,0,0,.2); }
    body[data-theme="dark"] .footer .footer-bg .footer-logo img { background: rgba(255,255,255,.95) !important; filter: none; }
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
    .footer-logo img { width: 140px; max-width: 100%; height: auto; border-radius: 10px; border: 1px solid rgba(255,255,255,.35); display: block; object-fit: contain; background: rgba(255,255,255,.92); padding: 12px; box-sizing: content-box; box-shadow: 0 2px 10px rgba(0,0,0,.2) }
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
      .footer { overflow-x: hidden }
      .footer-grid { grid-template-columns: 1fr; gap: 22px }
      .footer-inner { padding: 20px 16px; box-sizing: border-box }
      .footer-col { min-width: 0; overflow-wrap: break-word; word-wrap: break-word }
      .footer-col p, .footer-col li { word-break: break-word; overflow-wrap: break-word }
      .footer-col h4 { margin-bottom: 10px; font-size: 14px }
      .footer-col li { margin: 6px 0 }
      .footer-bottom { margin-top: 20px; padding-top: 16px; font-size: 12px; padding-left: 8px; padding-right: 8px }
    }
    @media (max-width: 480px) {
      .footer-inner { padding: 18px 12px }
      .footer-logo img { width: 120px; max-width: 100% }
      .footer-brand-name { font-size: 1.5rem }
      .footer-brand-tagline { font-size: 0.75rem }
      .footer-col p { font-size: 13px }
      .footer-col li { font-size: 13px; margin: 6px 0 }
      .footer-bottom { padding-top: 14px; font-size: 11px }
    }
    @media (max-width: 1100px) { .features { grid-template-columns: repeat(2, 1fr) } .services { grid-template-columns: 1fr } .services .preview { height: 280px; min-height: 220px } }
    @media (max-width: 1100px) { .activities { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px } }
    @media (max-width: 768px) { .features { grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 14px } .features .feature-card:nth-child(n+7) { display: none } .feature-card { padding: 12px } .feature-card .ic { width: 32px; height: 32px; border-radius: 8px; margin-bottom: 8px } .feature-card h3 { font-size: 14px } .feature-card p { font-size: 12px; line-height: 1.4 } .services .preview { height: 240px; min-height: 200px } }
    @media (max-width: 620px) { .features { gap: 8px; margin-top: 12px } .feature-card { padding: 10px } .feature-card .ic { width: 28px; height: 28px; margin-bottom: 6px } .feature-card h3 { font-size: 12px } .feature-card p { font-size: 11px } }
    @media (max-width: 768px) { .activities { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; margin-top: 14px } .activities .activity-card:nth-child(n+7) { display: none } .activity-card img { height: 100px } .activity-card .pad { padding: 10px } .activity-card h3 { font-size: 14px } .activity-card .meta { font-size: 10px; margin-bottom: 6px } .activity-card p { font-size: 12px; line-height: 1.4 } }
    @media (max-width: 576px) { .activities { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; margin-top: 12px } }
    @media (max-width: 480px) { .activities { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px } .activity-card img { height: 80px } .activity-card .pad { padding: 8px } .activity-card h3 { font-size: 12px } .activity-card .meta { font-size: 9px } .activity-card p { font-size: 11px } .services .preview { height: 200px; min-height: 160px } }

    /* Why section */
    .why { position:relative; padding: 42px 0; }
    .why .wrap { width: 80%; max-width: none; margin:0 auto; position:relative }
    .why::before{ content:""; position:absolute; inset:0; background: url('https://images.unsplash.com/photo-1567446537708-ac4aa75c9c28?q=80&w=1800&auto=format&fit=crop') center/cover no-repeat; filter: brightness(.45); }
    .why::after{ content:""; position:absolute; inset:0; background: linear-gradient(180deg, rgba(2,6,23,.3), rgba(2,6,23,.6)); }
    .why h2 { position:relative; text-align:center; font-size:22px; font-weight:800; margin: 6px 0 8px; color: var(--text); }
    .why p.lead { position:relative; text-align:center; color: var(--muted); margin:0 0 16px }
    .why-grid { position:relative; display:grid; grid-template-columns: 1fr 340px 1fr; gap: 22px; align-items:center }
    .glass { background: rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.25); backdrop-filter: blur(6px); border-radius:16px; overflow:hidden }
    body[data-theme="light"] .glass { background: rgba(255,255,255,.4); border-color: rgba(15,23,42,.15); }
    .glass img { display:block; width:100%; height:100%; object-fit:cover }
    .benefits { display:grid; gap:14px }
    .benefit { display:flex; align-items:flex-start; gap:10px; color: var(--text); }
    .benefit p { margin:2px 0 0; color: var(--muted); font-size:14px }
    .dot { width:14px; height:14px; border-radius:999px; background:#ef4444; margin-top:6px; box-shadow:0 0 0 3px rgba(239,68,68,.25) }
    .benefit h4 { margin:0; font-size:16px }
    @media (max-width: 1100px) { .why-grid { grid-template-columns: 1fr } }

    /* Quote section */
    .quote-wrap { width: 80%; max-width: none; margin: 0 auto 18px; padding: 0 }
    .quote { display:grid; grid-template-columns: 1fr 1fr; gap:0; border-radius:16px; overflow:hidden; border:1px solid rgba(148,163,184,.12) }
    body[data-theme="light"] .quote { border-color: rgba(15,23,42,.12); }
    .best { background: #0f2530; padding:24px }
    body[data-theme="light"] .best { background: var(--card); }
    .best small { color:#ef4444; font-weight:800 }
    .best h3 { margin:4px 0 10px; font-size:28px; color: var(--text); }
    .best ul { margin:12px 0 0; padding-left:0 }
    .best li { list-style:none; color: var(--muted); margin:8px 0 }
    .best li::before { content:"✓"; color:#10b981; margin-right:8px }
    .best .media { display:flex; gap:10px; margin-top:12px; align-items:center }
    .best .media img { width:68px; height:44px; border-radius:10px; object-fit:cover; border:1px solid rgba(148,163,184,.18) }
    .form { background:#ef4444; padding:22px }
    body[data-theme="dark"] .form { background: var(--card) !important; }
    .form h4 { margin:0 0 12px; color:#fff; font-size:18px }
    .card-form { background:#06202a; padding:16px; border-radius:12px; border:1px solid rgba(0,0,0,.2) }
    .row { display:grid; grid-template-columns: 1fr 1fr; gap:10px }
    .input, .select, .textarea { width:100%; padding:10px 12px; border-radius:8px; border:1px solid rgba(148,163,184,.25); background:#0b1a21; color: var(--text); }
    body[data-theme="light"] .card-form { background: rgba(255,255,255,.2); border-color: rgba(255,255,255,.3); }
    body[data-theme="light"] .quote .input, body[data-theme="light"] .quote .select, body[data-theme="light"] .quote .textarea { background: rgba(255,255,255,.9); color: var(--text); border-color: rgba(15,23,42,.2); }
    .textarea { min-height:90px; resize:vertical }
    .chips { display:flex; gap:14px; margin:8px 0 }
    .chip { display:flex; align-items:center; gap:6px; color: var(--text); }
    .chip input { accent-color:#ef4444 }
    .submit { margin-top:10px; width:100%; padding:10px 14px; border-radius:10px; background:#0b1220; color:#fff; border:1px solid rgba(255,255,255,.2); font-weight:700 }
    @media (max-width: 1000px) { .quote { grid-template-columns: 1fr } .row { grid-template-columns: 1fr } }
    /* Gallery */
    .gallery { width: 80%; max-width: none; margin: 12px auto 0; padding: 16px 0 8px; overflow-x: hidden }
    .gallery h2 { margin: 0 0 16px; font-size: 1.25rem }
    .gallery-track { display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px; margin-bottom: 0 }
    .gallery-track .gcard:nth-child(n+7) { display: none }
    .gallery-track.gallery-expanded .gcard:nth-child(n+7) { display: block }
    .gcard { position: relative; width: 100%; min-width: 0; height: 140px; border-radius: 14px; overflow: hidden; border: 1px solid rgba(148,163,184,.12); background: var(--card); }
    .gcard img { width: 100%; height: 100%; object-fit: cover; display: block }
    .gcard .meta { position: absolute; left: 8px; top: 8px; background: #111827; color: #fff; font-weight: 800; padding: 4px 8px; border-radius: 10px; display: flex; align-items: center; gap: 6px }
    .gcard .meta .d { background: #ef4444; color: #fff; width: 30px; height: 30px; border-radius: 10px; display: grid; place-items: center; font-size: 12px; line-height: 1 }
    .gcard .meta .t { font-size: 12px; color: #e5e7eb; display: flex; flex-direction: column; line-height: 1.1 }
    body[data-theme="light"] .gcard { border-color: rgba(15,23,42,.12); }
    body[data-theme="light"] .gallery h2 { color: var(--text); }
    .gallery-more-wrap { text-align: center; margin-top: 16px }
    .gallery-more-wrap.gallery-more-hidden { display: none }
    .gallery-more-btn { padding: 10px 20px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: var(--card); color: var(--text); font-weight: 600; cursor: pointer }
    .gallery-more-btn:hover { background: rgba(30,41,59,.8); color: #fff }
    body[data-theme="light"] .gallery-more-btn { background: rgba(255,255,255,.9); color: var(--text); border-color: rgba(15,23,42,.2); }
    body[data-theme="light"] .gallery-more-btn:hover { background: rgba(15,23,42,.1); color: var(--text); }
    @media (max-width: 1200px) { .gallery-track { grid-template-columns: repeat(3, 1fr) } }
    @media (max-width: 768px) { .gallery-track { grid-template-columns: repeat(2, 1fr); gap: 12px } .gcard { height: 120px } }
    @media (max-width: 480px) { .gallery { padding-left: 12px; padding-right: 12px } .gallery-track { grid-template-columns: repeat(2, 1fr); gap: 10px } .gcard { height: 100px } .gcard .meta { padding: 3px 6px; font-size: 11px } .gcard .meta .d { width: 26px; height: 26px; font-size: 11px } }

    /* Help + Quote section */
    .helpwrap { width: 80%; max-width: none; margin: 18px auto; padding: 0 }
    @media (max-width: 980px) { .section, .footer, .why .wrap, .quote-wrap, .gallery, .helpwrap { width: 100%; padding-left: 24px; padding-right: 24px } .why { padding-left: 24px; padding-right: 24px } }
    @media (max-width: 640px) { .section { padding-left: 16px; padding-right: 16px; padding-top: 20px; padding-bottom: 20px } }
    .helpgrid { display:grid; grid-template-columns: 1fr 1fr; gap:0; border:1px solid rgba(148,163,184,.12); border-radius:16px; overflow:hidden }
    body[data-theme="light"] .helpgrid { border-color: rgba(15,23,42,.12); }
    /* Need Help section – same red background and field style as quote sections */
    .help { background:#ef4444; padding:22px }
    .help h3 { margin:0 0 6px; font-size:22px; color:#fff; }
    .help p { margin:0 0 12px; color:#fde68a; font-size:14px; }
    .help .item { display:flex; align-items:center; gap:10px; padding:12px; border-radius:10px; border:1px solid rgba(255,255,255,.35); background:#061c24; color:#fff; margin-bottom:10px }
    .help .item strong { color:#fff; }
    .help .item div div { color: rgba(255,255,255,.9) !important; }
    .help .item .ic { width:34px; height:34px; border-radius:8px; display:grid; place-items:center; background:#0b1a21; color:#fff; flex-shrink:0 }
    body[data-theme="light"] .help .item { background: rgba(255,255,255,.2); border-color: rgba(0,0,0,.15); color: #0f172a; }
    body[data-theme="light"] .help .item strong { color: #0f172a; }
    body[data-theme="light"] .help .item div div { color: #334155 !important; }
    body[data-theme="light"] .help .item .ic { background: rgba(0,0,0,.15); color: #0f172a; }
    body[data-theme="dark"] .help { background: var(--card) !important; border: 1px solid rgba(148,163,184,.2); }
    body[data-theme="dark"] .help h3 { color: var(--text) !important; }
    body[data-theme="dark"] .help p { color: var(--muted) !important; }
    body[data-theme="dark"] .help .item { background: rgba(15,23,42,.7) !important; border-color: rgba(148,163,184,.25); color: var(--text); }
    body[data-theme="dark"] .help .item strong { color: var(--text); }
    body[data-theme="dark"] .help .item div div { color: var(--muted) !important; }
    body[data-theme="dark"] .help .item .ic { background: var(--bg); color: var(--text); }
    .getquote { background:#ef4444; padding:22px }
    .getquote h4 { margin:0 0 6px; color:#fff; font-size:22px }
    .getquote p { margin:0 0 12px; color:#fde68a }
    .getquote .form2 { background:#061c24; padding:16px; border-radius:12px }
    .getquote .row2 { display:grid; grid-template-columns: 1fr; gap:10px }
    .getquote .input, .getquote .select, .getquote .textarea { width:100%; padding:10px 12px; border-radius:8px; border:1px solid rgba(255,255,255,.35); background:#0b1a21 !important; color:#fff !important; -webkit-appearance:none; appearance:none; box-sizing:border-box }
    .getquote .input::placeholder, .getquote .textarea::placeholder { color: rgba(255,255,255,.7); }
    .getquote .select { color: #fff; }
    .getquote .select option { background: #0b1a21; color: #fff; }
    .getquote .textarea { min-height:90px }
    .getquote .submit { margin-top:10px; width:100%; padding:10px 14px; border-radius:10px; background:#0b1220; color:#fff; border:1px solid rgba(255,255,255,.25); font-weight:800 }
    /* Light mode: form fields on red sections – visible field color (off-white) and dark text */
    body[data-theme="light"] .getquote .form2 { background: rgba(255,255,255,.25); border-color: rgba(0,0,0,.1); }
    body[data-theme="light"] .getquote .input, body[data-theme="light"] .getquote .select, body[data-theme="light"] .getquote .textarea { background: #f8fafc !important; color: #0f172a !important; border: 1px solid #e2e8f0 !important; }
    body[data-theme="light"] .getquote .input::placeholder, body[data-theme="light"] .getquote .textarea::placeholder { color: #64748b; }
    body[data-theme="light"] .getquote .select option { background: #f8fafc; color: #0f172a; }
    body[data-theme="light"] .getquote .submit { background: #0f172a; color: #fff; border-color: rgba(0,0,0,.2); }
    /* Dark mode: Get A Free Quote section – force dark background (override bright red) */
    body[data-theme="dark"] .getquote { background: var(--card) !important; border: 1px solid rgba(148,163,184,.2); }
    body[data-theme="dark"] .getquote h4 { color: var(--text) !important; }
    body[data-theme="dark"] .getquote p { color: var(--muted) !important; }
    body[data-theme="dark"] .getquote .form2 { background: rgba(15,23,42,.7) !important; border-color: rgba(148,163,184,.2); }
    body[data-theme="dark"] .getquote .input, body[data-theme="dark"] .getquote .select, body[data-theme="dark"] .getquote .textarea { background: var(--card) !important; color: var(--text) !important; border-color: rgba(148,163,184,.25); }
    body[data-theme="dark"] .getquote .submit { background: var(--bg) !important; color: var(--text) !important; border-color: rgba(148,163,184,.3); }
    /* Get a price quote – trending + Bootstrap 5 */
    .quotation-section { background:#ef4444; padding:28px; border-radius:20px; margin-bottom:24px; border:1px solid rgba(148,163,184,.12); box-shadow: 0 8px 32px rgba(0,0,0,.15); position:relative; overflow:hidden }
    .quotation-section::before { content:''; position:absolute; left:0; right:0; bottom:0; height:4px; background:linear-gradient(90deg, #3b82f6, #8b5cf6); z-index:0; border-radius:0 0 19px 19px }
    .quotation-section h4 { margin:0 0 8px; color:#fff; font-size:1.5rem; font-weight:800 }
    .quotation-section p { margin:0 0 16px; color:#fde68a; font-size:14px }
    .quotation-section .form-quote { background:#061c24; padding:20px; border-radius:16px; border:1px solid rgba(255,255,255,.12); position:relative; z-index:1 }
    .quotation-section .form-quote .row2 { display:grid; grid-template-columns: 2fr 1fr; gap:14px; margin-bottom:14px }
    .quotation-section .form-quote .row2 > div:nth-child(3) { grid-column: 1 / -1; }
    .quotation-section .form-quote .row2:last-of-type { display:block; text-align:center; margin-bottom:0; margin-top:4px }
    .quotation-section .form-label { display:block; margin-bottom:6px; color:rgba(255,255,255,.95); font-size:13px; font-weight:600 }
    .quotation-section .form-control, .quotation-section .form-select { width:100%; padding:12px 14px; border-radius:12px; border:1px solid rgba(255,255,255,.35); background:#0b1a21 !important; color:#fff !important; font-size:15px; box-sizing:border-box; transition:border-color .2s, box-shadow .2s }
    .quotation-section .form-control:focus, .quotation-section .form-select:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.25); outline:none }
    .quotation-section .form-control::placeholder { color: rgba(255,255,255,.6); }
    .quotation-section .form-select option { background: #0b1a21; color: #fff; }
    .quotation-section .btn-quote-submit { padding:12px 24px; border-radius:12px; background:#0b1220; color:#fff; border:1px solid rgba(255,255,255,.25); font-weight:700; font-size:16px; cursor:pointer; transition:transform .2s, box-shadow .2s }
    .quotation-section .btn-quote-submit:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(0,0,0,.3); color:#fff }
    body[data-theme="light"] .quotation-section .form-quote { background: rgba(255,255,255,.25); border-color: rgba(0,0,0,.1); }
    body[data-theme="light"] .quotation-section .form-control, body[data-theme="light"] .quotation-section .form-select { background: #f8fafc !important; color: #0f172a !important; border: 1px solid #e2e8f0 !important; }
    body[data-theme="light"] .quotation-section .form-control:focus, body[data-theme="light"] .quotation-section .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.2); }
    body[data-theme="light"] .quotation-section .form-control::placeholder { color: #64748b; }
    body[data-theme="light"] .quotation-section .form-select option { background: #f8fafc; color: #0f172a; }
    body[data-theme="light"] .quotation-section .form-label { color: #0f172a !important; }
    body[data-theme="light"] .quotation-section .btn-quote-submit { background: #0f172a; color: #fff; border-color: rgba(0,0,0,.2); }
    body[data-theme="light"] .getquote label { color: #0f172a !important; }
    body[data-theme="dark"] .quotation-section { background: var(--card) !important; border-color: rgba(148,163,184,.2); box-shadow: 0 8px 32px rgba(0,0,0,.3); }
    body[data-theme="dark"] .quotation-section h4 { color: var(--text) !important; }
    body[data-theme="dark"] .quotation-section p { color: var(--muted) !important; }
    body[data-theme="dark"] .quotation-section .form-quote { background: rgba(15,23,42,.7) !important; border-color: rgba(148,163,184,.2); }
    body[data-theme="dark"] .quotation-section .form-control, body[data-theme="dark"] .quotation-section .form-select { background: var(--card) !important; color: var(--text) !important; border-color: rgba(148,163,184,.25); }
    body[data-theme="dark"] .quotation-section .form-control:focus, body[data-theme="dark"] .quotation-section .form-select:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,130,246,.2); }
    body[data-theme="dark"] .quotation-section .form-label { color: var(--text) !important; }
    body[data-theme="dark"] .quotation-section .btn-quote-submit { background: var(--bg) !important; color: var(--text) !important; border-color: rgba(148,163,184,.3); }
    body[data-theme="dark"] .quotation-result { background: rgba(15,23,42,.6); border-color: rgba(148,163,184,.2); color: var(--text); }
    .quotation-result { margin-top:16px; padding:18px; background:rgba(0,0,0,.25); border-radius:14px; color:#fff; border:1px solid rgba(255,255,255,.1); position:relative; z-index:1 }
    .quotation-result .quotation-line { margin-top:10px; font-size:15px }
    .quotation-result .quotation-line:first-child { margin-top:0 }
    .quotation-result .quotation-line.dealer-price { color:#fde68a }
    .quotation-result .quotation-line.quotation-total { margin-top:14px; padding-top:12px; border-top:1px solid rgba(255,255,255,.2); font-size:1.15rem; font-weight:700 }
    .quotation-whatsapp { margin-top:18px; padding-top:18px; border-top:1px solid rgba(255,255,255,.2); position:relative; z-index:1 }
    .quotation-whatsapp .wa-btn { display:inline-flex; align-items:center; gap:10px; padding:12px 20px; border-radius:12px; background:#25D366; color:#fff; text-decoration:none; font-weight:700; font-size:15px; border:none; cursor:pointer; transition:background .2s, transform .2s }
    .quotation-whatsapp .wa-btn:hover { background:#20bd5a; color:#fff; transform:translateY(-1px) }
    .quotation-downloads { margin-top:14px; display:flex; flex-wrap:wrap; gap:10px; align-items:center; position:relative; z-index:1 }
    .quotation-downloads .dl-btn { display:inline-flex; align-items:center; gap:8px; padding:10px 16px; border-radius:12px; background:rgba(0,0,0,.3); color:#fff; text-decoration:none; font-weight:600; font-size:14px; border:1px solid rgba(255,255,255,.25); transition:background .2s, transform .2s }
    .quotation-downloads .dl-btn:hover { background:rgba(0,0,0,.5); color:#fff; transform:translateY(-1px) }
    .quotation-section .error-msg { margin-top:10px; padding:12px; background:rgba(239,68,68,.35); color:#fef2f2; border-radius:10px; font-size:14px; border:1px solid rgba(239,68,68,.5) }
    @media (max-width: 1000px) { .helpgrid { grid-template-columns: 1fr } .getquote .row2 { grid-template-columns: 1fr } .quotation-section .row2 { grid-template-columns: 1fr } .quotation-section .form-quote .row2 > div:nth-child(3) { grid-column: auto; } .quotation-section .btn-quote-submit { max-width: 100%; } }
    /* #quote responsive: smaller breakpoints */
    @media (max-width: 768px) {
      .quotation-section .row2 { grid-template-columns: 1fr }
      .quotation-section .form-quote { padding: 14px }
      .getquote .form2 { padding: 14px }
      .getquote .input, .getquote .select, .getquote .textarea { padding: 8px 10px; font-size: 15px }
      .quotation-result { padding: 12px; font-size: 14px; word-wrap: break-word; overflow-wrap: break-word }
      .quotation-result .quotation-line { font-size: 14px }
      .quotation-downloads { gap: 8px }
      .quotation-downloads .dl-btn { padding: 8px 12px; font-size: 13px }
      .quotation-whatsapp .wa-btn { padding: 10px 14px; font-size: 14px; flex-wrap: wrap }
    }
    @media (max-width: 640px) {
      .quotation-section { padding: 16px; border-radius: 16px }
      .quotation-section h4 { font-size: 18px }
      .quotation-section .form-quote { padding: 12px }
      .quotation-section .form-control, .quotation-section .form-select { padding: 8px 10px; font-size: 15px; border-radius: 10px; min-height: 44px }
      .quotation-section .btn-quote-submit { width: 100%; padding: 10px 12px; font-size: 14px }
      .quotation-section .form-label { font-size: 12px; margin-bottom: 4px }
      .getquote { padding: 16px }
      .getquote h4 { font-size: 18px }
      .getquote p { font-size: 13px; margin-bottom: 10px }
      .getquote .form2 { padding: 12px; border-radius: 10px }
      .getquote .row2 { gap: 8px; margin-bottom: 8px }
      .getquote .input, .getquote .select, .getquote .textarea { padding: 8px 10px; font-size: 15px; border-radius: 6px; min-height: 40px }
      .getquote .textarea { min-height: 72px }
      .getquote .submit { padding: 10px 12px; font-size: 14px }
      .quotation-result { margin-top: 12px; padding: 10px }
      .quotation-downloads { flex-direction: column; align-items: stretch }
      .quotation-downloads .dl-btn { justify-content: center }
      .help { padding: 16px }
      .help h3 { font-size: 18px }
      .help .item { padding: 10px; margin-bottom: 8px }
      .help .item .ic { width: 30px; height: 30px; font-size: 14px }
    }
    /* Very small screens: prevent overflow, touch-friendly */
    @media (max-width: 360px) {
      body { --content-gutter: 10px; }
      .section { padding-left: 10px; padding-right: 10px; padding-top: 16px; padding-bottom: 16px; }
      .hero-content { padding-left: 10px; padding-right: 10px; }
    }
    @media (max-width: 480px) {
      .hero-banner { scroll-margin-top: 64px; }
      .track-section { scroll-margin-top: 64px; }
      .helpwrap { padding-left: 16px; padding-right: 16px }
      .quotation-section { padding: 16px; margin-bottom: 16px; border-radius: 16px }
      .quotation-section::before { border-radius: 0 0 14px 14px }
      .quotation-section h4 { font-size: 16px }
      .quotation-section .row2 { gap: 6px; margin-bottom: 6px }
      .quotation-section .form-quote { padding: 14px; border-radius: 12px }
      .quotation-section .form-control, .quotation-section .form-select { padding: 8px 10px; font-size: 14px; min-height: 40px; border-radius: 10px }
      .quotation-section .btn-quote-submit { padding: 10px 12px; font-size: 13px }
      .quotation-section .form-label { font-size: 11px }
      .getquote { padding: 12px }
      .getquote h4 { font-size: 16px }
      .getquote p { font-size: 12px }
      .getquote .form2 { padding: 10px; border-radius: 8px }
      .getquote .row2 { gap: 6px }
      .getquote .input, .getquote .select, .getquote .textarea { padding: 6px 10px; font-size: 14px; min-height: 36px }
      .getquote .textarea { min-height: 64px }
      .getquote .submit { padding: 8px 12px; font-size: 13px }
      .quotation-whatsapp .wa-btn { width: 100%; justify-content: center }
      .help { padding: 12px }
      .help h3 { font-size: 16px }
      .help .item { padding: 8px; margin-bottom: 6px; border-radius: 8px }
      .help .item .ic { width: 28px; height: 28px }
    }

    /* Trending / Bootstrap 5 enhancements – layout unchanged */
    .feature-card { transition: box-shadow .25s ease, transform .2s ease; }
    .feature-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.18); transform: translateY(-2px); }
    .review-card { transition: box-shadow .25s ease, transform .2s ease; }
    .review-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.18); transform: translateY(-2px); }
    .activity-card { transition: box-shadow .25s ease, transform .2s ease; }
    .activity-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.18); transform: translateY(-2px); }
    .gcard { transition: transform .2s ease, box-shadow .2s ease; }
    .gcard:hover { transform: scale(1.02); box-shadow: 0 6px 20px rgba(0,0,0,.2); }
    .tab { transition: background .2s ease, border-color .2s ease, color .2s ease; }
    .btn, .reviews-add-btn, .reviews-more-btn, .gallery-more-btn, .track-submit, .track-provider { transition: all .2s ease; }
    .btn:hover, .reviews-add-btn:hover { transform: translateY(-1px); }
    .quote, .helpgrid, .tabs, .preview { transition: box-shadow .2s ease; }
    .quote:hover, .tabs:hover { box-shadow: 0 4px 20px rgba(0,0,0,.12); }
    .glass { transition: transform .2s ease; }
    .glass:hover { transform: translateY(-1px); }
    body[data-theme="light"] .feature-card:hover, body[data-theme="light"] .review-card:hover, body[data-theme="light"] .activity-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,.1); }
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
    $cfgMenuFontSize = optional(\App\Models\Setting::where('key','header_menu_font_size')->first())->value;
    $headerContactEmail = optional(\App\Models\Setting::where('key','contact_email')->first())->value;
    $headerContactPhone = optional(\App\Models\Setting::where('key','contact_phone')->first())->value;
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

  <header class="topbar" style="{{ !empty($cfgHeaderBg) ? '--header-bg: '.$cfgHeaderBg.';' : '' }}{{ !empty($cfgHeaderBorder) ? '--header-border: '.$cfgHeaderBorder.';' : '' }}{{ !empty($cfgHeaderLink) ? '--header-link: '.$cfgHeaderLink.';' : '' }}{{ !empty($cfgHeaderText) ? '--header-text: '.$cfgHeaderText.';' : '' }}{{ !empty($cfgHeaderTagline) ? '--header-tagline: '.$cfgHeaderTagline.';' : '' }}{{ !empty($cfgBrandSize) ? '--brand-size: '.(int)$cfgBrandSize.'px;' : '' }}{{ !empty($cfgTaglineSize) ? '--tagline-size: '.(int)$cfgTaglineSize.'px;' : '' }}{{ isset($cfgMenuFontSize) && $cfgMenuFontSize !== '' ? '--menu-size: '.(int)$cfgMenuFontSize.'px;' : '' }}{{ !empty($cfgBrandWeight) ? '--brand-weight: '.$cfgBrandWeight.';' : '' }}{{ !empty($cfgBrandStyle) ? '--brand-style: '.$cfgBrandStyle.';' : '' }}">
    <div class="nav">
      <div class="header-left">
      <div class="brand">
        @if($logoSrc)
          <img src="{{ $logoSrc }}" alt="Logo">
        @else
          <span>📦</span>
        @endif
          <span>{{ $cfgName ?? 'apx.lk' }}</span>
      </div>
        @if(trim((string)($cfgTag ?? '')) !== '')
          <span class="header-tagline">{{ $cfgTag }}</span>
        @endif
        <div class="header-menu">
          @php $localeM = app()->getLocale(); $langLabelM = $localeM === 'en' ? 'EN' : ($localeM === 'ta' ? 'தமிழ்' : 'සිංහල'); @endphp
          <div class="lang-switcher-mobile lang-in-header-mobile" aria-label="{{ __('site.language') }}">
            <div class="lang-dropdown" tabindex="-1">
              <button type="button" class="lang-dropdown-trigger" aria-expanded="false" aria-haspopup="true" aria-label="{{ __('site.language') }}">
                <span class="lang-globe" aria-hidden="true">🌐</span>
                <span class="lang-current">{{ $langLabelM }}</span>
              </button>
              <div class="lang-dropdown-menu" role="menu">
                <a href="{{ route('locale.switch', ['locale' => 'en']) }}" role="menuitem" class="{{ $localeM === 'en' ? 'active' : '' }}">EN</a>
                <a href="{{ route('locale.switch', ['locale' => 'ta']) }}" role="menuitem" class="{{ $localeM === 'ta' ? 'active' : '' }}">தமிழ்</a>
                <a href="{{ route('locale.switch', ['locale' => 'si']) }}" role="menuitem" class="{{ $localeM === 'si' ? 'active' : '' }}">සිංහල</a>
      </div>
            </div>
          </div>
          <button id="theme-toggle" class="themebtn themebtn-icon" type="button" aria-label="Toggle theme"><span class="theme-icon" aria-hidden="true"></span></button>
          <button class="hamb" type="button" aria-expanded="false" aria-controls="primary-links">{{ __('site.menu') }}</button>
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
                  } else {
                    $parsed = parse_url($linkUrl);
                    $host = strtolower($parsed['host'] ?? '');
                    if (in_array($host, ['localhost', '127.0.0.1'], true)) {
                      $path = $parsed['path'] ?? '/';
                      $path = preg_replace('#^/apx(/|$)#', '$1', $path) ?: '/';
                      $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';
                      $linkUrl = url($path) . $query;
                    }
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
            <a href="{{ route('track') }}">{{ __('site.track') }}</a>
        @endif
          <a href="{{ route('login') }}">{{ __('site.login') }}</a>
          </div>
        </div>
      </div>
      <div class="header-right">
        <div class="header-tracking">
          <a href="{{ route('track') }}" class="header-track-btn" style="display:inline-block;text-decoration:none;line-height:1">{{ __('site.track') }}</a>
        </div>
        <div class="header-contact">
          @if(!empty($headerContactPhone))
            <a href="tel:{{ preg_replace('/\s+/', '', $headerContactPhone) }}" class="header-contact-link" title="Call us">📞 {{ $headerContactPhone }}</a>
          @endif
          @if(!empty($headerContactEmail))
            <a href="mailto:{{ $headerContactEmail }}" class="header-contact-link" title="Email us">✉️ {{ $headerContactEmail }}</a>
          @endif
        </div>
        @php
          $locale = app()->getLocale();
          $langLabel = $locale === 'en' ? 'EN' : ($locale === 'ta' ? 'தமிழ்' : 'සිංහල');
        @endphp
        <div class="lang-switcher" aria-label="{{ __('site.language') }}">
          <div class="lang-dropdown" tabindex="-1">
            <button type="button" class="lang-dropdown-trigger" aria-expanded="false" aria-haspopup="true" aria-label="{{ __('site.language') }}">
              <span class="lang-globe" aria-hidden="true">🌐</span>
              <span class="lang-current">{{ $langLabel }}</span>
            </button>
            <div class="lang-dropdown-menu" role="menu">
              <a href="{{ route('locale.switch', ['locale' => 'en']) }}" role="menuitem" class="{{ $locale === 'en' ? 'active' : '' }}">EN</a>
              <a href="{{ route('locale.switch', ['locale' => 'ta']) }}" role="menuitem" class="{{ $locale === 'ta' ? 'active' : '' }}">தமிழ்</a>
              <a href="{{ route('locale.switch', ['locale' => 'si']) }}" role="menuitem" class="{{ $locale === 'si' ? 'active' : '' }}">සිංහල</a>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </header>

  <div id="content-below-header" class="content-below-header">
  <div class="header-spacer" aria-hidden="true"></div>
  @php
    $heroPos = isset($banner) && $banner && !empty($banner->bg_position) ? $banner->bg_position : 'center';
    $heroSize = isset($banner) && $banner && !empty($banner->bg_size) ? $banner->bg_size : 'cover';
    $defaultSlideUrls = [
      'https://images.unsplash.com/photo-1483683804023-6ccdb62f86ef?q=80&w=1600&auto=format&fit=crop',
      'https://images.unsplash.com/photo-1567446537708-ac4aa75c9c28?q=80&w=1600&auto=format&fit=crop',
      'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1600&auto=format&fit=crop',
    ];
    // Ensure at least 2 slides so banner can change (auto and manual)
    if (count($bannerImages) >= 2) {
      $sliderImages = $bannerImages;
    } elseif (count($bannerImages) === 1) {
      $sliderImages = array_merge($bannerImages, array_slice($defaultSlideUrls, 0, 2));
    } else {
      $sliderImages = $defaultSlideUrls;
    }
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
      <div class="hero-banner__controls" role="group" aria-label="Banner slider – use arrows or dots to change slide manually">
        <button type="button" class="hero-banner__arrow prev" aria-label="Previous slide" title="Previous slide"><span class="hero-banner__arrow-icon" aria-hidden="true">‹</span><span class="hero-banner__arrow-text">Prev</span></button>
        <button type="button" class="hero-banner__arrow next" aria-label="Next slide" title="Next slide"><span class="hero-banner__arrow-icon" aria-hidden="true">›</span><span class="hero-banner__arrow-text">Next</span></button>
        <div class="hero-banner__dots" role="tablist" aria-label="Banner slides – click a dot to go to that slide">
          @foreach($sliderImages as $i => $imgUrl)
            <button type="button" class="hero-banner__dot {{ $i === 0 ? 'active' : '' }}" role="tab" aria-label="Slide {{ $i + 1 }} of {{ count($sliderImages) }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}" data-index="{{ $i }}"></button>
          @endforeach
    </div>
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
              @php
                $iconVal = $s->icon ?? '•';
                $iconIsImage = is_string($iconVal) && (str_starts_with($iconVal, 'http') || str_starts_with($iconVal, '/') || str_starts_with($iconVal, 'data:') || preg_match('/\.(png|jpe?g|gif|svg|webp)(\?|$)/i', $iconVal));
              @endphp
              <div class="tab {{ $i === 0 ? 'active' : '' }}" data-idx="{{ $i }}">
                <span class="ti">@if($iconIsImage)<img src="{{ $toUrl($iconVal) }}" alt="">@else{{ $iconVal }}@endif</span> {{ $s->title }}
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
          <div class="tabs tabs-empty">
            <p class="empty-msg" style="margin:0; padding:16px; color: var(--muted); font-size:14px;">No services added yet. Add services from the Admin panel.</p>
          </div>
          <div class="preview">
            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1600&auto=format&fit=crop" alt="Logistics">
          </div>
        @endif
      </div>
    </section>

    <section id="track" class="section track-section" aria-label="{{ __('site.track_your_parcel') }}">
      <h2 style="margin:0">{{ __('site.track_your_parcel') }}</h2>
      <p style="color:var(--muted); margin:8px 0 14px">{{ __('site.track_section_help') }}</p>
      <div class="track-wrap">
        @php $trackingLinksList = isset($trackingLinks) ? $trackingLinks : collect(); @endphp
        <label for="tracking_number" class="sr-only">{{ __('site.tracking_number') }}</label>
        <input type="text" id="tracking_number" class="track-input" placeholder="{{ __('site.tracking_number') }}" autocomplete="off">
        <div class="track-select-wrap">
          <label for="track_carrier">Select parcel company</label>
          <select id="track_carrier" class="track-select" aria-label="Select parcel company">
            <option value="">— Select company —</option>
            @foreach($trackingLinksList as $link)
              <option value="{{ e($link->url_template) }}">{{ $link->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="track-submit-wrap">
          <button type="button" class="track-submit" id="track-submit-btn" aria-label="{{ __('site.track_parcel') }}">{{ __('site.track') }}</button>
        </div>
        <div class="track-buttons">
          @if($trackingLinksList->count())
            @foreach($trackingLinksList as $link)
              <button type="button" class="btn track-provider" data-url-template="{{ e($link->url_template) }}" title="Opens in new tab">{{ $link->name }}</button>
            @endforeach
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
        <div class="alert alert-danger error-msg" role="alert">{{ session('error') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger error-msg" role="alert">{{ $errors->first() }}</div>
      @endif
      <form class="form-quote" action="{{ route('quotation.calculate') }}" method="post">
        @csrf
        <div class="row2">
          <div>
            <label for="rate_id" class="form-label">Country &amp; Service</label>
            <select class="form-select" id="rate_id" name="rate_id" required>
              <option value="">Select country – service</option>
              @forelse(($quotationRates ?? []) as $qr)
                <option value="{{ $qr->id }}" {{ old('rate_id') == $qr->id ? 'selected' : '' }}>{{ $qr->country }} – {{ $qr->service }}</option>
              @empty
                <option value="" disabled>No rates — add in Admin (Quotation Rates)</option>
              @endforelse
            </select>
          </div>
          <div>
            <label for="qty" class="form-label">Quantity (kg)</label>
            <input class="form-control" id="qty" type="number" step="0.01" min="0.01" name="qty" value="{{ old('qty', '1') }}" placeholder="kg" required>
          </div>
          <div>
            <label for="dealer_code" class="form-label">Dealer code (optional)</label>
            <input class="form-control" id="dealer_code" type="text" name="dealer_code" value="{{ old('dealer_code') }}" placeholder="Enter dealer code to get dealer price">
          </div>
        </div>
        <div class="row2">
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn-quote-submit">Get total</button>
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

  </div><!-- .content-below-header -->

  <script>
    (function(){ var y = document.getElementById('year'); if (y) y.textContent = new Date().getFullYear(); })();

    // On first load, ensure page is at top so banner is visible below header (before scrolling)
    (function(){
      if (window.history && window.history.scrollRestoration) window.history.scrollRestoration = 'manual';
      window.scrollTo(0, 0);
    })();

    // Sync header-spacer and --header-h to actual header height so banner and text align below header
    (function(){
      var topbar = document.querySelector('.topbar');
      var spacer = document.querySelector('.header-spacer');
      var heroBanner = document.getElementById('hero-banner');
      var trackSection = document.querySelector('.track-section');
      function syncSpacer() {
        if (!topbar || !spacer) return;
        var h = topbar.offsetHeight;
        spacer.style.height = h + 'px';
        spacer.style.minHeight = h + 'px';
        document.body.style.setProperty('--header-h', h + 'px');
        if (window.innerWidth <= 720) document.body.style.setProperty('--header-mobile-top', h + 'px');
        else document.body.style.removeProperty('--header-mobile-top');
        if (heroBanner) heroBanner.style.scrollMarginTop = h + 'px';
        if (trackSection) trackSection.style.scrollMarginTop = h + 'px';
      }
      function runSync() {
        syncSpacer();
        requestAnimationFrame(syncSpacer);
      }
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', runSync);
        window.addEventListener('load', syncSpacer);
      } else {
        runSync();
      }
      window.addEventListener('resize', syncSpacer);
    })();

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

    // Public site theme (dark/light) – all areas update; aria and mobile toggle
    const siteDefaultTheme = '{{ in_array(($cfgSiteTheme ?? 'dark'), ['dark','light']) ? ($cfgSiteTheme ?? 'dark') : 'dark' }}';
    const savedSiteTheme = localStorage.getItem('site_theme') || siteDefaultTheme || 'dark';
    document.body.setAttribute('data-theme', savedSiteTheme);
    function applyTheme(next) {
        document.body.setAttribute('data-theme', next);
        localStorage.setItem('site_theme', next);
    }
    var sunSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5" fill="none"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>';
    var moonSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';
    function updateThemeUi() {
      const cur = (document.body.getAttribute('data-theme') || 'dark').toLowerCase().trim();
      const isDark = (cur === 'dark');
      const ariaLabel = isDark ? 'Switch to light mode' : 'Switch to dark mode';
      const themeBtn = document.getElementById('theme-toggle');
      if (themeBtn) {
        const iconEl = themeBtn.querySelector('.theme-icon');
        if (iconEl) iconEl.innerHTML = isDark ? sunSvg : moonSvg;
        themeBtn.setAttribute('aria-label', ariaLabel);
        themeBtn.setAttribute('aria-pressed', isDark ? 'true' : 'false');
      }
    }
    const themeBtn = document.getElementById('theme-toggle');
    if (themeBtn) {
      themeBtn.addEventListener('click', () => {
        const cur = (document.body.getAttribute('data-theme') || 'dark').toLowerCase().trim();
        const isCurrentlyDark = (cur === 'dark');
        const next = isCurrentlyDark ? 'light' : 'dark';
        applyTheme(next);
        updateThemeUi();
      });
    }
    updateThemeUi();

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
    // Mobile menu toggle (trending overlay)
    const hamb = document.querySelector('.hamb');
    const links = document.getElementById('primary-links');
    if (hamb && links){
      hamb.addEventListener('click', function(e) {
        e.stopPropagation();
        const open = links.classList.toggle('open');
        hamb.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.style.overflow = open && window.innerWidth <= 720 ? 'hidden' : '';
      });
      window.addEventListener('resize', function() {
        if (window.innerWidth > 720) {
          links.classList.remove('open');
          hamb.setAttribute('aria-expanded','false');
          document.body.style.overflow = '';
        }
      });
      document.addEventListener('click', function(e) {
        if (window.innerWidth <= 720 && links.classList.contains('open') && !links.contains(e.target) && !hamb.contains(e.target)) {
          links.classList.remove('open');
          hamb.setAttribute('aria-expanded','false');
          document.body.style.overflow = '';
        }
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

    // Banner: auto-slide + manual controls (prev/next arrows, dots, keyboard)
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
      const autoRotate = (el.getAttribute('data-banner-auto-rotate') || '1') !== '0';
      const intervalSec = Math.max(3, Math.min(30, parseInt(el.getAttribute('data-banner-interval') || '5', 10) || 5));

      function goToSlide(idx) {
        current = ((idx % total) + total) % total;
        slides.forEach(function(s, i) { s.classList.toggle('active', i === current); });
        dots.forEach(function(d, i) {
          d.classList.toggle('active', i === current);
          d.setAttribute('aria-selected', i === current ? 'true' : 'false');
        });
      }

      function advanceSlide() { goToSlide(current + 1); resetAuto(); }
      function goPrev() { goToSlide(current - 1); resetAuto(); }

      function resetAuto() {
        if (autoTimer) clearInterval(autoTimer);
        autoTimer = null;
        if (autoRotate) autoTimer = setInterval(advanceSlide, intervalSec * 1000);
      }

      if (prevBtn) prevBtn.addEventListener('click', goPrev);
      if (nextBtn) nextBtn.addEventListener('click', advanceSlide);
      dots.forEach(function(dot, i) { dot.addEventListener('click', function() { goToSlide(i); resetAuto(); }); });

      // Keyboard: Left/Right change slide when banner is in view or a control is focused
      document.addEventListener('keydown', function(e) {
        if (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') return;
        var inView = el.getBoundingClientRect().top < window.innerHeight && el.getBoundingClientRect().bottom > 0;
        var controlFocused = el.contains(document.activeElement);
        if (!inView && !controlFocused) return;
        e.preventDefault();
        if (e.key === 'ArrowLeft') goPrev();
        else advanceSlide();
      });

      if (autoRotate) autoTimer = setInterval(advanceSlide, intervalSec * 1000);
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
