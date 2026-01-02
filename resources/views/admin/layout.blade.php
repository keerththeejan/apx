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
    body{font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background:var(--bg); color:var(--text); margin:0}
    header{display:flex; justify-content:space-between; align-items:center; padding:14px 20px; background:var(--panel); border-bottom:1px solid var(--border); position:sticky; top:0; z-index:50}
    .brand{font-weight:800}
    .wrap{max-width:none; width:100%; margin:0; padding:14px}
    .grid{display:grid; grid-template-columns:280px minmax(0,1fr); gap:16px; align-items:start; width:100%}
    .card{background:linear-gradient(180deg, rgba(17,24,39,.85), rgba(2,6,23,.75)); border:1px solid var(--border); border-radius:var(--radius); box-shadow: var(--shadow)}
    @supports (backdrop-filter: blur(6px)){ .card{backdrop-filter: blur(8px)} }
    nav{padding:14px; position:sticky; top:82px}
    nav a{display:block; color:#cbd5e1; text-decoration:none; padding:11px 14px; border-radius:10px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; outline: none; transition: background .15s ease, color .15s ease, transform .08s ease}
    nav a:hover, nav a:focus{background:#111827; color:#fff; outline:2px solid rgba(59,130,246,.25)}
    nav a:active{transform: scale(.98)}
    nav a + a{margin-top:4px}
    .content{padding:16px}
    .content .wrap{max-width: 980px; margin:0 auto}
    .menu{display:none; background:#111827; color:var(--text); border:1px solid rgba(148,163,184,.2); padding:8px 12px; border-radius:10px; font-weight:700; cursor:pointer}
    .logout{background:var(--danger); border:0; color:#fff; padding:8px 12px; border-radius:10px; font-weight:700; cursor:pointer}
    .btn{display:inline-block; padding:10px 14px; border-radius:10px; border:1px solid var(--border); background:linear-gradient(135deg, var(--accent), rgba(255,255,255,.06)); color:#fff; text-decoration:none; font-weight:700}
    input, textarea, select{width:100%; padding:10px 12px; border-radius:10px; border:1px solid var(--border); background:#0b1a21; color:#e5e7eb}
    label{display:block; margin-top:12px; margin-bottom:6px; color:var(--muted); font-size:12px; font-weight:800; letter-spacing:.02em}
    .row{display:grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap:12px; align-items:start}
    .actions{display:flex; gap:10px; flex-wrap:wrap; margin-top:16px}
    table{width:100%; border-collapse:separate; border-spacing:0; background:linear-gradient(180deg, rgba(15,23,42,.9), rgba(2,6,23,.85)); border:1px solid var(--border); border-radius:12px; overflow:hidden}
    th,td{padding:12px 14px; border-bottom:1px solid var(--border); text-align:left}
    th{font-size:12px; color:var(--muted); font-weight:700; background:var(--panel)}
    .status{background:#052; color:#c7f9cc; border:1px solid #0a4; padding:8px 10px; border-radius:8px; margin-bottom:12px; display:inline-block}
    .error{background: rgba(239,68,68,.15); color:#fecaca; border:1px solid rgba(239,68,68,.35); padding:10px 12px; border-radius:8px; font-size:14px; margin-bottom:10px}
    .backdrop{display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:40}
    .sidebar{transition: transform .2s ease}
    .navsec{margin-top:12px; padding-top:10px; border-top:1px solid var(--border); color:var(--muted); font-size:12px; font-weight:800; letter-spacing:.08em; text-transform:uppercase}
    .navsub a{padding-left:28px; font-size:14px}
    @media (max-width: 980px){ .grid{grid-template-columns: 1fr} nav{position:static} .row{grid-template-columns: repeat(2, minmax(0, 1fr))} }
    @media (max-width: 520px){ .menu{display:inline-block} .wrap{padding:10px} .content{padding:12px} .row{grid-template-columns: 1fr} .sidebar{position:fixed; left:0; top:0; height:100%; width:82%; max-width:300px; z-index:45; transform: translateX(-102%)} .sidebar.open{transform: translateX(0)} .backdrop.show{display:block} }
  </style>
</head>
<body>
  <header>
    <div class="brand">@yield('brand', 'Admin')</div>
    <div style="display:flex; align-items:center; gap:10px">
      <select id="theme" aria-label="Theme" style="appearance:none; background:#111827; color:var(--text); border:1px solid var(--border); border-radius:10px; padding:8px 12px; font-weight:700">
        <option value="dark">Dark</option>
        <option value="slate">Slate</option>
        <option value="indigo">Indigo</option>
        <option value="emerald">Emerald</option>
        <option value="rose">Rose</option>
        <option value="amber">Amber</option>
        <option value="sky">Sky</option>
        <option value="violet">Violet</option>
      </select>
      <button class="menu" type="button" aria-expanded="false" aria-controls="sidebar">Menu</button>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button class="logout" type="submit">Logout</button>
    </form>
  </header>

  <div class="wrap">
    <div class="grid">
      <div id="sidebar" class="card sidebar" role="navigation" aria-label="Admin menu">
        <nav>
          <a href="{{ route('admin.dashboard') }}">Overview</a>
          <a href="#">Users</a>
          <a href="#">Orders</a>
          <a href="#">Shipments</a>
          <a href="{{ route('admin.settings.index') }}">Settings</a>
          <div class="navsec">Footer</div>
          <div class="navsub">
            <a href="{{ route('admin.settings.footer') }}">Footer Settings</a>
            <a href="{{ route('admin.footerlinks.index') }}">Footer Links</a>
            <a href="{{ route('admin.sociallinks.index') }}">Social Links</a>
          </div>
          <a href="{{ route('admin.features.index') }}">Features</a>
          <a href="{{ route('admin.activities.index') }}">Daily Activities</a>
          <a href="{{ route('admin.banner.edit') }}">Home Banner</a>
          <a href="{{ route('admin.services.index') }}">Services</a>
        </nav>
      </div>
      <div id="backdrop" class="backdrop" aria-hidden="true"></div>
      <div class="card content">
        @yield('content')
      </div>
    </div>
  </div>

  <script>
    const btn = document.querySelector('.menu');
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('backdrop');
    const themeSelect = document.getElementById('theme');
    function toggleDrawer(force){
      const willOpen = typeof force === 'boolean' ? force : !sidebar.classList.contains('open');
      sidebar.classList.toggle('open', willOpen);
      btn && btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
      backdrop && backdrop.classList.toggle('show', willOpen);
    }
    if (btn && sidebar){ btn.addEventListener('click', () => toggleDrawer()); }
    if (backdrop){ backdrop.addEventListener('click', () => toggleDrawer(false)); }
    window.addEventListener('resize', () => { if (window.innerWidth > 520) toggleDrawer(false); });

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
