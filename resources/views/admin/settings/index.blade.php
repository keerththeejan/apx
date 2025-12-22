<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Settings - Admin</title>
  <style>
    :root{--bg:#0b1220;--panel:#0f172a;--muted:#94a3b8;--text:#e2e8f0;--border:rgba(148,163,184,.12);--accent:#1e293b}
    body{font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background:var(--bg); color:var(--text); margin:0}
    header{display:flex; justify-content:space-between; align-items:center; padding:14px 20px; background:#0f172a; border-bottom:1px solid var(--border)}
    .wrap{max-width:900px; margin:0 auto; padding:18px 20px}
    label{display:block; margin:10px 0 6px; color:#cbd5e1}
    input, textarea, select{width:100%; padding:10px 12px; border-radius:10px; border:1px solid var(--border); background:#0b1a21; color:#e5e7eb}
    .row{display:grid; grid-template-columns: 1fr 1fr; gap:10px}
    .btn{display:inline-block; padding:10px 14px; border-radius:10px; border:1px solid var(--border); background:#1e293b; color:#fff; text-decoration:none; font-weight:700}
    .actions{display:flex; gap:10px; margin-top:12px}
    .status{background:#052; color:#c7f9cc; border:1px solid #0a4; padding:8px 10px; border-radius:8px; margin-bottom:12px; display:inline-block}
    .error{background: rgba(239,68,68,.15); color:#fecaca; border:1px solid rgba(239,68,68,.35); padding:10px 12px; border-radius:8px; font-size:14px; margin-bottom:10px}
  </style>
</head>
<body>
  <header>
    <div>Settings</div>
    <div>
      <a class="btn" href="{{ route('admin.dashboard') }}">Dashboard</a>
    </div>
  </header>

  <div class="wrap">
    @if(session('status'))
      <div class="status">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
      @csrf

      <label for="site_name">Site Name</label>
      <input id="site_name" type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required>

      <div class="row">
        <div>
          <label for="contact_email">Contact Email</label>
          <input id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}">
        </div>
        <div>
          <label for="contact_phone">Contact Phone</label>
          <input id="contact_phone" type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}">
        </div>
      </div>

      <label for="address">Address</label>
      <textarea id="address" name="address">{{ old('address', $settings['address']) }}</textarea>

      <label for="default_theme">Default Admin Theme</label>
      <select id="default_theme" name="default_theme">
        @php $themes = ['dark'=>'Dark','slate'=>'Slate','indigo'=>'Indigo','emerald'=>'Emerald','rose'=>'Rose','amber'=>'Amber','sky'=>'Sky','violet'=>'Violet']; @endphp
        @foreach($themes as $val=>$label)
          <option value="{{ $val }}" {{ old('default_theme', $settings['default_theme'])===$val? 'selected':'' }}>{{ $label }}</option>
        @endforeach
      </select>

      <div class="actions">
        <button class="btn" type="submit">Save Settings</button>
        <a class="btn" href="{{ route('admin.dashboard') }}">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>
