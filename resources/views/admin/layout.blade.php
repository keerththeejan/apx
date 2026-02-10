<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin')</title>
  <style>
    :root{--bg:#0b1220;--panel:#0f172a;--muted:#94a3b8;--text:#e2e8f0;--border:rgba(148,163,184,.12);--accent:#1e293b;--danger:#ef4444;--radius:14px;--shadow:0 8px 28px rgba(0,0,0,.25)}
    body[data-theme="dark"]{--bg:#0b1220;--panel:#0f172a;--muted:#94a3b8;--text:#e2e8f0;--border:rgba(148,163,184,.12);--accent:#1e293b;--danger:#ef4444}
    body[data-theme="slate"]{--bg:#0b1020;--panel:#0c1426;--muted:#9aa5b1;--text:#e6edf3;--border:rgba(100,116,139,.25);--accent:#1f2a44;--danger:#f43f5e}
    body[data-theme="indigo"]{--bg:#0b1020;--panel:#0f1230;--muted:#a5b4fc;--text:#eef2ff;--border:rgba(129,140,248,.28);--accent:#3730a3;--danger:#f43f5e}
    body[data-theme="emerald"]{--bg:#041a17;--panel:#08251f;--muted:#a7f3d0;--text:#ecfdf5;--border:rgba(16,185,129,.28);--accent:#065f46;--danger:#ef4444}
    body[data-theme="rose"]{--bg:#160b12;--panel:#1f0f17;--muted:#fecdd3;--text:#ffe4e6;--border:rgba(244,114,182,.28);--accent:#be123c;--danger:#f43f5e}
    body[data-theme="amber"]{--bg:#140d02;--panel:#1f1505;--muted:#fcd34d;--text:#fffbeb;--border:rgba(251,191,36,.28);--accent:#b45309;--danger:#f43f5e}
    body[data-theme="sky"]{--bg:#07121a;--panel:#0a1722;--muted:#bae6fd;--text:#e0f2fe;--border:rgba(56,189,248,.28);--accent:#075985;--danger:#f43f5e}
    body[data-theme="violet"]{--bg:#0d0b16;--panel:#15122a;--muted:#c4b5fd;--text:#ede9fe;--border:rgba(167,139,250,.28);--accent:#5b21b6;--danger:#f43f5e}
    body{font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background:var(--bg); color:var(--text); margin:0; overflow-x: hidden}
    header{display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; padding:12px 16px; background:var(--panel); border-bottom:1px solid var(--border); position:sticky; top:0; z-index:50}
    .brand{font-weight:800; font-size:1.05rem}
    .header-nav{display:flex; align-items:center; gap:8px; flex-wrap:wrap}
    .header-nav a{color:var(--text); text-decoration:none; font-weight:600; font-size:14px; padding:6px 10px; border-radius:8px; white-space:nowrap}
    .header-nav a:hover{background:rgba(148,163,184,.15); color:#fff}
    .wrap{max-width:none; width:100%; margin:0; padding:12px; min-width:0}
    .grid{display:grid; grid-template-columns:260px minmax(0,1fr); gap:14px; align-items:start; width:100%; min-width:0}
    .card{background:linear-gradient(180deg, rgba(17,24,39,.85), rgba(2,6,23,.75)); border:1px solid var(--border); border-radius:var(--radius); box-shadow: var(--shadow)}
    @supports (backdrop-filter: blur(6px)){ .card{backdrop-filter: blur(8px)} }
    .sidebar nav{padding:12px; position:sticky; top:82px}
    .sidebar nav a{display:block; color:#cbd5e1; text-decoration:none; padding:9px 12px; border-radius:8px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; outline: none; transition: background .15s ease, color .15s ease; font-size:14px}
    .sidebar nav a:hover, .sidebar nav a:focus{background:#111827; color:#fff; outline:2px solid rgba(59,130,246,.25)}
    .sidebar nav a:active{transform: scale(.98)}
    .sidebar nav a + a{margin-top:2px}
    .content{padding:14px; min-width:0; overflow-x: auto}
    .content .wrap{max-width: 980px; margin:0 auto}
    .logout{background:var(--danger); border:0; color:#fff; padding:8px 12px; border-radius:10px; font-weight:700; cursor:pointer}
    .btn{display:inline-block; padding:10px 14px; border-radius:10px; border:1px solid var(--border); background:linear-gradient(135deg, var(--accent), rgba(255,255,255,.06)); color:#fff; text-decoration:none; font-weight:700}
    input, textarea, select{width:100%; max-width:100%; padding:10px 12px; border-radius:10px; border:1px solid var(--border); background:#0b1a21; color:#e5e7eb; box-sizing:border-box}
    label{display:block; margin-top:12px; margin-bottom:6px; color:var(--muted); font-size:12px; font-weight:800; letter-spacing:.02em}
    .row{display:grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap:12px; align-items:start}
    .actions{display:flex; gap:10px; flex-wrap:wrap; margin-top:16px}
    table{width:100%; min-width:320px; border-collapse:separate; border-spacing:0; background:linear-gradient(180deg, rgba(15,23,42,.9), rgba(2,6,23,.85)); border:1px solid var(--border); border-radius:12px; overflow:hidden}
    th,td{padding:10px 12px; border-bottom:1px solid var(--border); text-align:left; font-size:14px}
    th{font-size:12px; color:var(--muted); font-weight:700; background:var(--panel)}
    .status{background:#052; color:#c7f9cc; border:1px solid #0a4; padding:8px 10px; border-radius:8px; margin-bottom:12px; display:inline-block}
    .error{background: rgba(239,68,68,.15); color:#fecaca; border:1px solid rgba(239,68,68,.35); padding:10px 12px; border-radius:8px; font-size:14px; margin-bottom:10px}
    .sidebar{min-width:0}
    .navsec{margin-top:10px; padding-top:8px; border-top:1px solid var(--border); color:var(--muted); font-size:11px; font-weight:800; letter-spacing:.08em; text-transform:uppercase}
    .navsub a{padding-left:24px; font-size:13px}
    /* Responsive: show all menu without click – horizontal scroll nav below header */
    @media (max-width: 980px){
      .grid{grid-template-columns: 1fr}
      .sidebar{order:1; width:100%; position:static}
      .sidebar nav{position:static; display:flex; flex-wrap:nowrap; overflow-x:auto; overflow-y:hidden; gap:4px; padding:10px; -webkit-overflow-scrolling:touch; border-radius:var(--radius); background:var(--panel); border:1px solid var(--border)}
      .sidebar nav a{flex:0 0 auto; margin-top:0; padding:8px 12px; font-size:13px}
      .sidebar .navsec{flex:0 0 auto; border:none; padding:0; margin:0}
      .sidebar .navsub{display:inline-flex; flex:0 0 auto; gap:4px; border:none; padding:0; margin:0}
      .sidebar .navsub a{padding-left:0}
      .content{order:2}
      .row{grid-template-columns: repeat(2, minmax(0, 1fr))}
    }
    @media (max-width: 640px){
      header{padding:10px 12px}
      .wrap{padding:10px}
      .content{padding:12px}
      .row{grid-template-columns: 1fr}
      table{font-size:13px} th,td{padding:8px 10px}
    }
    @media (max-width: 480px){
      .header-nav a{font-size:13px; padding:5px 8px}
      .sidebar nav a{font-size:12px; padding:6px 10px}
    }
  </style>
</head>
<body>
  <header>
    <div class="brand">@yield('brand', 'Admin')</div>
    <nav class="header-nav" aria-label="Admin quick links">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <select id="theme" aria-label="Theme" style="appearance:none; background:#111827; color:var(--text); border:1px solid var(--border); border-radius:10px; padding:6px 10px; font-weight:700; font-size:14px; cursor:pointer">
        <option value="dark">Dark</option>
        <option value="slate">Slate</option>
        <option value="indigo">Indigo</option>
        <option value="emerald">Emerald</option>
        <option value="rose">Rose</option>
        <option value="amber">Amber</option>
        <option value="sky">Sky</option>
        <option value="violet">Violet</option>
      </select>
    </nav>
    <form method="POST" action="{{ route('logout') }}" style="margin:0">
      @csrf
      <button class="logout" type="submit">Logout</button>
    </form>
  </header>

  <div class="wrap">
    <div class="grid">
      <div id="sidebar" class="card sidebar" role="navigation" aria-label="Admin menu">
        <nav>
          <a href="{{ route('admin.dashboard') }}">Overview</a>
          <a href="{{ route('admin.profile.edit') }}">My account</a>
          <a href="{{ route('admin.users.index') }}">Users</a>
          <a href="{{ route('admin.company') }}">Company details</a>
          <a href="{{ route('admin.settings.index') }}">Settings</a>
          <a href="{{ route('admin.settings.index') }}?section=seo">SEO</a>
          <div class="navsec">Footer</div>
          <div class="navsub">
            <a href="{{ route('admin.settings.footer') }}">Footer Settings</a>
            <a href="{{ route('admin.footerlinks.index') }}">Footer Links</a>
            <a href="{{ route('admin.sociallinks.index') }}">Social Links</a>
          </div>
          <a href="{{ route('admin.features.index') }}">Features</a>
          <a href="{{ route('admin.trackinglinks.index') }}">Parcel Tracking Links</a>
          <a href="{{ route('admin.activities.index') }}">Daily Activities</a>
          <a href="{{ route('admin.banner.index') }}">Banners</a>
          <a href="{{ route('admin.services.index') }}">Services</a>
          <a href="{{ route('admin.quotationrates.index') }}">Quotation Rates</a>
          <a href="{{ route('admin.dealers.index') }}">Dealers (codes for dealer price)</a>
        </nav>
      </div>
      <div class="card content">
        @yield('content')
      </div>
    </div>
  </div>

  <script>
    const themeSelect = document.getElementById('theme');
    const serverDefault = (typeof window !== 'undefined' && window.serverDefaultTheme) || '{{ isset($defaultTheme) ? $defaultTheme : '' }}' || (function(){
      try { return ({{ json_encode((string)optional(\App\Models\Setting::query()->where('key','default_theme')->first())->value ?? 'dark') }}); } catch(e){ return 'dark'; }
    })();
    const savedTheme = localStorage.getItem('admin_theme') || serverDefault || 'dark';
    document.body.setAttribute('data-theme', savedTheme);
    if (themeSelect){
      themeSelect.value = savedTheme;
      themeSelect.addEventListener('change', () => {
        const val = themeSelect.value || 'dark';
        document.body.setAttribute('data-theme', val);
        localStorage.setItem('admin_theme', val);
      });
    }
  </script>
</body>
</html>
