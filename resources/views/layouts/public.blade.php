<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @stack('head')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --bg: #0b1220; --card: #0f172a; --muted:#94a3b8; --text:#e2e8f0; --brand:#1e293b; --blue:#3b82f6; }
    body[data-theme="dark"] { --bg:#0b1220; --card:#0f172a; --muted:#94a3b8; --text:#e2e8f0; --brand:#1e293b; --blue:#3b82f6; --header-bg: #9f1239; }
    body[data-theme="light"] { --bg:#f8fafc; --card:#ffffff; --muted:#475569; --text:#0f172a; --brand:#e2e8f0; --blue:#2563eb; }
    * { box-sizing: border-box }
    html { overflow-x: hidden; height: 100%; background: var(--bg); }
    body { margin: 0; font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background: var(--bg); color: var(--text); overflow-x: hidden; min-width: 0; --content-gutter: 20px; --header-height: 80px; -webkit-tap-highlight-color: transparent; transition: background-color .3s ease, color .3s ease; }
    img { max-width: 100%; height: auto; }
    .content-below-header { display: flex; flex-direction: column; min-height: 100vh; width: 100%; max-width: 100vw; overflow-x: hidden; background: var(--bg); }
    main { flex: 1 0 auto; background: var(--bg); }
    .header-spacer { display: block; width: 100%; height: 100px; min-height: 100px; flex-shrink: 0; background: transparent; }
    @media (max-width: 1920px) { .header-spacer { height: 90px; min-height: 90px; } }
    @media (max-width: 1680px) { .header-spacer { height: 85px; min-height: 85px; } }
    @media (max-width: 900px) { .header-spacer { height: 90px; min-height: 90px; } }
    @media (max-width: 720px) { .header-spacer { height: 72px; min-height: 72px; } }
    @media (max-width: 400px) { .header-spacer { height: 64px; min-height: 64px; } }
    .topbar { background: var(--header-bg, #d83526); border-bottom: 2px solid var(--header-border, rgba(0,0,0,.15)); position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 0; box-sizing: border-box; }
    .topbar::before { content: ''; display: block; height: 4px; background: var(--header-strip, #fce4dc); }
    body[data-theme="dark"] .topbar { background: var(--card) !important; border-bottom-color: rgba(148,163,184,.25); }
    body[data-theme="dark"] .topbar .brand span, body[data-theme="dark"] .topbar .brand small, body[data-theme="dark"] .topbar .header-tagline { color: var(--text) !important; }
    .topbar .brand img { background: rgba(255,255,255,.92); padding: 10px; border-radius: 10px; box-sizing: content-box; border: 1px solid rgba(255,255,255,.4); box-shadow: 0 2px 8px rgba(0,0,0,.2); }
    body[data-theme="dark"] .topbar .brand img { background: rgba(255,255,255,.95) !important; filter: none; border-color: rgba(255,255,255,.5) !important; }
    body[data-theme="dark"] .topbar .links a, body[data-theme="dark"] .topbar .header-contact-link, body[data-theme="dark"] .topbar .lang-switcher .lang-link { color: var(--text) !important; }
    body[data-theme="dark"] .lang-dropdown-trigger { background: rgba(255,255,255,.12); border-color: rgba(148,163,184,.25); color: var(--text) !important; }
    body[data-theme="dark"] .lang-dropdown-menu { background: var(--card); border-color: rgba(148,163,184,.2); }
    body[data-theme="dark"] .links { background: var(--card) !important; }
    .nav { position: relative; width: 100%; max-width: none; margin: 0; padding: 12px 4in 12px 3in; display: flex; align-items: center; justify-content: space-between; gap: 14px; min-width: 0; }
    .header-left { display: flex; align-items: center; gap: 14px; flex-shrink: 0; min-width: 0; }
    .brand { display: flex; align-items: center; justify-content: flex-start; gap: 12px; font-weight: 800; text-align: left; min-width: 0; flex: 0 0 auto; margin: 0; }
    .header-tracking { flex: 0 0 auto; min-width: 0; max-width: 320px; display: flex; align-items: center; }
    .header-track-form { display: flex; align-items: center; gap: 10px; width: 100%; min-width: 0; }
    .header-track-input { flex: 1; min-width: 180px; padding: 10px 14px; border-radius: 8px; border: 1px solid rgba(255,255,255,.3); background: rgba(255,255,255,.15); color: var(--header-text, #fff); font-size: 20px; box-sizing: border-box; }
    .header-track-btn { flex-shrink: 0; padding: 10px 16px; border-radius: 8px; border: 1px solid rgba(255,255,255,.4); background: rgba(0,0,0,.25); color: var(--header-text, #fff); font-weight: 600; font-size: 20px; cursor: pointer; }
    .header-right { display: flex; align-items: center; gap: 16px; margin-left: auto; flex-shrink: 0; min-width: 0; }
    .header-contact { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .header-contact-link { color: var(--header-link, #ffffff); text-decoration: none; font-size: 20px; font-weight: 500; white-space: nowrap; }
    .header-tagline { color: var(--header-tagline, rgba(255,255,255,.9)); font-weight: 600; font-size: var(--menu-size, 14px); letter-spacing: 0.03em; white-space: nowrap; }
    .header-menu { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0; }
    .brand img { width: 180px; max-width: 4in; height: auto; max-height: 1.5in; border-radius: 8px; object-fit: contain; border: none; display: block; flex-shrink: 0; margin: 0; }
    .brand span { line-height: 1.05; color: var(--header-text, #ffffff); font-size: var(--brand-size, 17px); font-weight: var(--brand-weight, 800); word-break: break-word; letter-spacing: 0.02em; }
    .links { display: flex; align-items: center; gap: 20px; flex-shrink: 0; }
    .links a { color: var(--header-link, #ffffff); text-decoration: none; font-weight: 600; font-size: var(--menu-size, 14px); }
    .links a:hover { color: var(--header-text, #ffffff); opacity: 0.9; }
    .hamb { display: none; background: rgba(17,24,39,.75); color: #fff; border: none; padding: 8px 14px; border-radius: 999px; font-weight: 700; flex-shrink: 0; }
    .themebtn { display: inline-flex; align-items: center; justify-content: center; background: rgba(30,30,30,.9); color: #fff; border: none; padding: 8px 16px; border-radius: 999px; font-weight: 600; font-size: 14px; cursor: pointer; }
    .themebtn-icon { padding: 8px 10px; min-width: 40px; }
    .themebtn-icon .theme-icon { width: 20px; height: 20px; display: inline-block; line-height: 0; }
    .lang-dropdown { position: relative; display: inline-block; }
    .lang-dropdown-trigger { display: inline-flex; align-items: center; gap: 6px; padding: 8px 12px; border-radius: 10px; background: rgba(255,255,255,.15); color: var(--header-link, #fff); font-size: 14px; font-weight: 600; cursor: pointer; border: 1px solid rgba(255,255,255,.25); }
    .lang-dropdown-trigger:hover { background: rgba(255,255,255,.25); color: #fff; }
    .lang-dropdown-menu { position: absolute; top: 100%; right: 0; margin-top: 6px; min-width: 120px; background: var(--header-bg, #c2410c); border: 1px solid rgba(255,255,255,.3); border-radius: 12px; padding: 8px 0; box-shadow: 0 10px 28px rgba(0,0,0,.25); z-index: 100; display: none; }
    .lang-dropdown:focus-within .lang-dropdown-menu { display: block; }
    .lang-dropdown-menu a { display: block; padding: 10px 14px; color: #fff; text-decoration: none; font-size: 14px; font-weight: 600; }
    .lang-switcher { display: flex; align-items: center; flex-shrink: 0; font-size: 14px; font-weight: 600; position: relative; }
    .lang-switcher-mobile { display: none; }
    .lang-in-header-mobile { display: none; flex-shrink: 0; }
    /* Auto-responsive: 24" / smaller desktop */
    @media (max-width: 2000px) { .nav { padding: 12px 3in 12px 2in; gap: 12px; } .brand img { width: 160px; max-height: 1.35in; } .header-contact-link { font-size: 18px; } .header-tracking { max-width: 300px; } .links { gap: 16px; } }
    @media (max-width: 1680px) { .nav { padding: 12px 2in 12px 1.5in; gap: 10px; } .brand img { width: 150px; max-height: 1.25in; } .brand span { font-size: 16px; } .header-tagline { font-size: 13px; white-space: normal; max-width: 160px; } .header-contact-link { font-size: 17px; } .header-track-input { font-size: 18px; min-width: 160px; } .header-track-btn { font-size: 18px; padding: 8px 14px; } .header-tracking { max-width: 280px; } .links { gap: 14px; } .links a { font-size: 13px; } }
    @media (max-width: 1440px) { .nav { padding: 12px 1.5in 12px 1in; gap: 8px; } .brand img { width: 140px; max-height: 1.2in; } .brand span { font-size: 15px; } .header-tagline { font-size: 12px; white-space: normal; max-width: 140px; } .header-contact-link { font-size: 16px; } .header-track-input { font-size: 16px; min-width: 140px; } .header-track-btn { font-size: 16px; } .header-tracking { max-width: 260px; } .links { gap: 12px; } .links a { font-size: 13px; } }
    @media (max-width: 900px) { .nav { padding: 10px 2in 10px 1.5in } .brand img { width: 140px } .header-tracking { max-width: 280px } .header-contact-link { font-size: 18px } }
    @media (max-width: 720px) {
      .nav { padding: 10px 16px; flex-wrap: nowrap; justify-content: space-between; }
      .header-left { flex: 1 1 auto; width: 100%; max-width: 100%; justify-content: space-between; }
      .header-right { display: none; }
      .lang-switcher-mobile, .lang-in-header-mobile { display: flex; align-items: center; }
      .header-tracking, .header-contact { display: none !important; }
      .brand { flex: 0 1 auto; max-width: calc(100% - 56px); }
      .brand img { width: auto; max-width: 100px; max-height: 44px; }
      .brand span { font-size: 14px; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap }
      .header-tagline { display: none }
      .links { position: fixed; right: 12px; left: auto; top: var(--header-mobile-top, 60px); z-index: 99; background: var(--header-bg, #d83526); border-radius: 12px; padding: 10px 0; flex-direction: column; min-width: 160px; visibility: hidden; opacity: 0; transform: translateY(-8px); transition: visibility .2s, opacity .2s, transform .2s; }
      .links.open { visibility: visible; opacity: 1; transform: translateY(0); }
      .links a { margin: 0 8px; padding: 10px 12px; border-radius: 8px; min-height: 44px; display: flex; align-items: center; }
      .hamb { display: inline-flex; align-items: center; justify-content: center; min-height: 44px; min-width: 44px; }
    }
    @media (max-width: 400px) { .nav { padding: 8px 12px } .brand img { max-width: 80px; max-height: 36px } .brand span { font-size: 13px; max-width: 90px } .hamb { min-height: 42px; min-width: 42px } }
    body[data-theme="dark"] .footer .footer-bg { background: var(--card) !important; color: var(--text) !important; border-top-color: rgba(148,163,184,.2) !important; }
    body[data-theme="dark"] .footer .footer-bg a, body[data-theme="dark"] .footer .footer-bg h4, body[data-theme="dark"] .footer .footer-bg p, body[data-theme="dark"] .footer .footer-bg li { color: var(--text) !important; }
    .footer { flex-shrink: 0; width: 100%; margin: 32px 0 0; padding: 0; color: var(--muted); font-size: 14px }
    .footer-inner { max-width: 1200px; margin: 0 auto; padding: 28px 24px; min-width: 0 }
    .footer-grid { display: grid; grid-template-columns: 1.25fr 1fr 1fr 1.1fr; gap: 28px 24px; align-items: start }
    .footer-col { min-width: 0 }
    .footer-col h4 { margin: 0 0 12px; font-size: 15px; font-weight: 700; }
    .footer-col p, .footer-col ul { margin: 0; font-size: 14px; line-height: 1.5 }
    .footer-col ul { list-style: none; padding: 0 }
    .footer-col li { margin: 8px 0 }
    .footer-col a { color: inherit; text-decoration: none; transition: opacity .2s }
    .footer-logo img { width: 140px; max-width: 100%; height: auto; border-radius: 10px; object-fit: contain; display: block; background: rgba(255,255,255,.92); padding: 12px; box-sizing: content-box; border: 1px solid rgba(255,255,255,.35); box-shadow: 0 2px 10px rgba(0,0,0,.2); }
    .footer-brand-name { display: block; font-size: 1.75rem; font-weight: 800; }
    .footer-brand-tagline { display: block; font-size: 0.8rem; font-weight: 600; opacity: .9; margin-top: 4px; }
    .footer-social { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 12px }
    .footer-social a { display: inline-flex; align-items: center; justify-content: center; padding: 8px 10px; border-radius: 10px; border: 1px solid rgba(255,255,255,.2) }
    .footer-bottom { display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 10px; margin-top: 24px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,.1); font-size: 13px; text-align: center }
    @media (max-width: 992px) { .footer-grid { grid-template-columns: repeat(2, 1fr); gap: 24px 20px } .footer-inner { padding: 24px 20px } }
    @media (max-width: 640px) { .footer-grid { grid-template-columns: 1fr; gap: 22px } .footer-inner { padding: 20px 16px } .footer-bottom { margin-top: 20px; padding-top: 16px; font-size: 12px } }
  </style>
  @stack('styles')
</head>
<body>
  @php
    $cfgName = optional(\App\Models\Setting::where('key','site_name')->first())->value ?? 'apx.lk';
    $cfgLogo = optional(\App\Models\Setting::where('key','logo_url')->first())->value;
    $cfgTag = optional(\App\Models\Setting::where('key','tagline')->first())->value;
    $cfgFooter = optional(\App\Models\Setting::where('key','footer_text')->first())->value;
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
    $cfgSiteTheme = optional(\App\Models\Setting::where('key','site_default_theme')->first())->value;
    $toUrl = function ($p) {
      if (empty($p)) return null;
      $p = trim((string) $p);
      if (\Illuminate\Support\Str::startsWith($p, ['http://','https://','data:'])) return $p;
      $path = ltrim($p, '/');
      if (\Illuminate\Support\Str::startsWith($path, 'uploads/')) $path = 'public/'.$path;
      return asset($path);
    };
    $logoSrc = !empty($cfgLogo) ? $toUrl($cfgLogo) : null;
    $navLinks = $navLinks ?? \App\Models\NavLink::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->get();
    $services = $services ?? \App\Models\Service::when(\Illuminate\Support\Facades\Schema::hasColumn('services', 'is_visible'), fn($q) => $q->where('is_visible', true))->orderBy('sort_order')->orderBy('id')->take(5)->get();
  @endphp

  @include('partials.header')

  <div class="content-below-header">
    <div class="header-spacer" aria-hidden="true"></div>
    <main>
      @yield('content')
    </main>

    @include('partials.footer')
  </div>

  <script>
    (function(){
      var spacer = document.querySelector('.header-spacer');
      var topbar = document.querySelector('.topbar');
      function syncSpacer() {
        if (topbar && spacer) {
          var h = topbar.offsetHeight;
          spacer.style.height = h + 'px';
          spacer.style.minHeight = h + 'px';
          if (window.innerWidth <= 720) document.body.style.setProperty('--header-mobile-top', h + 'px');
        }
      }
      if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', syncSpacer);
      else syncSpacer();
      window.addEventListener('resize', syncSpacer);
    })();
    var siteDefaultTheme = '{{ in_array($cfgSiteTheme ?? 'dark', ['dark','light']) ? ($cfgSiteTheme ?? 'dark') : 'dark' }}';
    var savedSiteTheme = localStorage.getItem('site_theme') || siteDefaultTheme || 'dark';
    document.body.setAttribute('data-theme', savedSiteTheme);
    var sunSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2"/></svg>';
    var moonSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>';
    function updateThemeUi() {
      var cur = (document.body.getAttribute('data-theme') || 'dark').toLowerCase();
      var themeBtn = document.getElementById('theme-toggle');
      if (themeBtn) {
        var icon = themeBtn.querySelector('.theme-icon');
        if (icon) icon.innerHTML = (cur === 'dark') ? sunSvg : moonSvg;
      }
    }
    var themeBtn = document.getElementById('theme-toggle');
    if (themeBtn) {
      themeBtn.addEventListener('click', function() {
        var cur = (document.body.getAttribute('data-theme') || 'dark').toLowerCase();
        var next = (cur === 'dark') ? 'light' : 'dark';
        document.body.setAttribute('data-theme', next);
        localStorage.setItem('site_theme', next);
        updateThemeUi();
      });
    }
    updateThemeUi();
    var hamb = document.querySelector('.hamb');
    var links = document.getElementById('primary-links');
    if (hamb && links) {
      hamb.addEventListener('click', function() {
        var open = links.classList.toggle('open');
        hamb.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.style.overflow = (open && window.innerWidth <= 720) ? 'hidden' : '';
      });
      window.addEventListener('resize', function() {
        if (window.innerWidth > 720) { links.classList.remove('open'); hamb.setAttribute('aria-expanded','false'); document.body.style.overflow = ''; }
      });
      document.addEventListener('click', function(e) {
        if (window.innerWidth <= 720 && links.classList.contains('open') && !links.contains(e.target) && !hamb.contains(e.target)) {
          links.classList.remove('open'); hamb.setAttribute('aria-expanded','false'); document.body.style.overflow = '';
        }
      });
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  @stack('scripts')
</body>
</html>
