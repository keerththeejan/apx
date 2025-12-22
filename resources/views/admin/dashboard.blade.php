<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <style>
    :root{--bg:#0b1220;--panel:#0f172a;--muted:#94a3b8;--text:#e2e8f0;--border:rgba(148,163,184,.12);--accent:#1e293b;--danger:#ef4444}
    /* Theme presets */
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
    .wrap{max-width:1200px; margin:0 auto; padding:18px 20px}
    .grid{display:grid; grid-template-columns:280px minmax(0,1fr); gap:18px; align-items:start}
    .card{background:var(--panel); border:1px solid var(--border); border-radius:12px; box-shadow: 0 6px 24px rgba(0,0,0,.18)}
    nav{padding:14px; position:sticky; top:82px}
    nav a{display:block; color:#cbd5e1; text-decoration:none; padding:10px 12px; border-radius:10px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; outline: none}
    nav a:hover, nav a:focus{background:#111827; color:#fff; outline:2px solid rgba(59,130,246,.35)}
    .content{padding:16px}
    .actionsbar{display:flex; flex-wrap:wrap; gap:10px; margin:10px 0 14px}
    .kpis{display:grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap:14px}
    .kpi{background:#0b1a21; border:1px solid var(--border); border-radius:12px; padding:14px; min-height:72px}
    .kpi h3{margin:0; font-size:13px; color:var(--muted)}
    .kpi .v{font-size:22px; font-weight:800; margin-top:6px}
    .logout{background:var(--danger); border:0; color:#fff; padding:8px 12px; border-radius:10px; font-weight:700; cursor:pointer}
    /* quick action links themed */
    .actionsbar .logout{background:var(--accent); border:1px solid var(--border)}
    .actionsbar .logout:hover{filter:brightness(1.1)}
    .menu{display:none; background:#111827; color:var(--text); border:1px solid rgba(148,163,184,.2); padding:8px 12px; border-radius:10px; font-weight:700; cursor:pointer}
    .table{width:100%; border-collapse:separate; border-spacing:0; background:#0b1a21; border:1px solid var(--border); border-radius:12px; overflow:hidden}
    .table th, .table td{padding:12px 14px; text-align:left; border-bottom:1px solid var(--border)}
    .table th{font-size:12px; color:var(--muted); font-weight:700; background:var(--panel)}
    .table tr:last-child td{border-bottom:none}
    .sidebar{transition: transform .2s ease}
    .backdrop{display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:40}
    @media (max-width: 1200px){ .kpis{grid-template-columns: repeat(3, minmax(0,1fr))} }
    @media (max-width: 980px){ .grid{grid-template-columns: 1fr} nav{position:static} }
    @media (max-width: 820px){ .kpis{grid-template-columns: repeat(2, minmax(0,1fr))} }
    @media (max-width: 620px){ .wrap{padding:14px} }
    @media (max-width: 520px){
      .kpis{grid-template-columns: 1fr}
      .menu{display:inline-block}
      .sidebar{position:fixed; left:0; top:0; height:100%; width:82%; max-width:300px; z-index:45; transform: translateX(-102%)}
      .sidebar.open{transform: translateX(0)}
      .backdrop.show{display:block}
    }
    @media (prefers-reduced-motion: reduce){ .sidebar{transition:none} }
  </style>
</head>
<body>
  <header>
    <div class="brand">Admin Dashboard</div>
    <div style="display:flex; align-items:center; gap:10px">
      <label for="theme" style="color:var(--muted); font-size:12px; display:none">Theme</label>
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
          <a href="#">Overview</a>
          <a href="#">Users</a>
          <a href="#">Orders</a>
          <a href="#">Shipments</a>
          <a href="{{ route('admin.settings.index') }}">Settings</a>
          <a href="{{ route('admin.features.index') }}">Features</a>
          <a href="{{ route('admin.banner.edit') }}">Home Banner</a>
          <a href="{{ route('admin.services.index') }}">Services</a>
        </nav>
      </div>
      <div id="backdrop" class="backdrop" aria-hidden="true"></div>
      <div class="card content">
        <h2 style="margin-top:0">Welcome, {{ auth()->user()->name }}</h2>
        <p>You are logged in as admin.</p>
        <div class="actionsbar" role="group" aria-label="Quick actions">
          <a class="logout" style="background:#1e293b; border:1px solid rgba(148,163,184,.25)" href="{{ route('admin.features.index') }}">Manage Features</a>
          <a class="logout" style="background:#1e293b; border:1px solid rgba(148,163,184,.25)" href="{{ route('admin.features.create') }}">Add Feature</a>
          <a class="logout" style="background:#1e293b; border:1px solid rgba(148,163,184,.25)" href="{{ route('admin.banner.edit') }}">Edit Home Banner</a>
          <a class="logout" style="background:#1e293b; border:1px solid rgba(148,163,184,.25)" href="{{ route('admin.services.index') }}">Manage Services</a>
          <a class="logout" style="background:#1e293b; border:1px solid rgba(148,163,184,.25)" href="{{ route('admin.services.create') }}">Add Service</a>
        </div>
        <div class="kpis">
          <div class="kpi"><h3>Total Users</h3><div class="v">—</div></div>
          <div class="kpi"><h3>Active Orders</h3><div class="v">—</div></div>
          <div class="kpi"><h3>Shipments Today</h3><div class="v">—</div></div>
          <div class="kpi"><h3>Revenue</h3><div class="v">—</div></div>
        </div>
        <h3 style="margin:18px 0 10px; font-size:16px">Recent Activity</h3>
        <div class="card" style="padding:0; overflow:auto">
          <table class="table" aria-label="Recent activity">
            <thead>
              <tr>
                <th>When</th>
                <th>Event</th>
                <th>User</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>—</td>
                <td>—</td>
                <td>—</td>
                <td>—</td>
              </tr>
            </tbody>
          </table>
        </div>
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

    // Theme persistence
    const serverDefault = '{{ isset($defaultTheme) ? $defaultTheme : 'dark' }}';
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
