<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Home Banner</title>
  <style>
    body{font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background:#0b1220; color:#e2e8f0; margin:0}
    header{display:flex; justify-content:space-between; align-items:center; padding:14px 20px; background:#0f172a; border-bottom:1px solid rgba(148,163,184,.12)}
    .wrap{max-width:900px; margin:0 auto; padding:18px 20px}
    label{display:block; margin:10px 0 6px; color:#cbd5e1}
    input, textarea{width:100%; padding:10px 12px; border-radius:8px; border:1px solid rgba(148,163,184,.25); background:#0b1a21; color:#e5e7eb}
    .row{display:grid; grid-template-columns: 1fr 1fr; gap:10px}
    .btn{display:inline-block; padding:10px 14px; border-radius:10px; border:1px solid rgba(148,163,184,.25); background:#1e293b; color:#fff; text-decoration:none; font-weight:700}
    .actions{display:flex; gap:10px; margin-top:12px}
    .status{background:#052; color:#c7f9cc; border:1px solid #0a4; padding:8px 10px; border-radius:8px; margin-bottom:12px; display:inline-block}
    .error{background: rgba(239,68,68,.15); color:#fecaca; border:1px solid rgba(239,68,68,.35); padding:10px 12px; border-radius:8px; font-size:14px; margin-bottom:10px}
    small.help{color:#94a3b8}
  </style>
</head>
<body>
  <header>
    <div>Edit Home Banner</div>
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

    <form method="POST" action="{{ route('admin.banner.update') }}">
      @csrf

      <label for="eyebrow">Eyebrow</label>
      <input id="eyebrow" type="text" name="eyebrow" value="{{ old('eyebrow', optional($banner)->eyebrow) }}" placeholder="SAFE TRANSPORTATION & LOGISTICS">

      <label for="title_line1">Title Line 1</label>
      <input id="title_line1" type="text" name="title_line1" value="{{ old('title_line1', optional($banner)->title_line1) }}" placeholder="Adaptable coordinated factors">

      <label for="title_line2">Title Line 2</label>
      <input id="title_line2" type="text" name="title_line2" value="{{ old('title_line2', optional($banner)->title_line2) }}" placeholder="Quick Conveyance">

      <label for="subtitle">Subtitle</label>
      <textarea id="subtitle" name="subtitle" placeholder="Short description for the banner">{{ old('subtitle', optional($banner)->subtitle) }}</textarea>

      <label for="bg_image_url">Background Image URL</label>
      <input id="bg_image_url" type="text" name="bg_image_url" value="{{ old('bg_image_url', optional($banner)->bg_image_url) }}" placeholder="https://...">
      <small class="help">Paste a full image URL. We can switch to file uploads later if you prefer.</small>

      <div class="row">
        <div>
          <label for="primary_text">Primary Button Text</label>
          <input id="primary_text" type="text" name="primary_text" value="{{ old('primary_text', optional($banner)->primary_text) }}" placeholder="Get Started">
        </div>
        <div>
          <label for="primary_url">Primary Button URL</label>
          <input id="primary_url" type="text" name="primary_url" value="{{ old('primary_url', optional($banner)->primary_url) }}" placeholder="#get-started">
        </div>
      </div>

      <div class="row">
        <div>
          <label for="secondary_text">Secondary Button Text</label>
          <input id="secondary_text" type="text" name="secondary_text" value="{{ old('secondary_text', optional($banner)->secondary_text) }}" placeholder="Learn More">
        </div>
        <div>
          <label for="secondary_url">Secondary Button URL</label>
          <input id="secondary_url" type="text" name="secondary_url" value="{{ old('secondary_url', optional($banner)->secondary_url) }}" placeholder="#learn">
        </div>
      </div>

      <div class="actions">
        <button class="btn" type="submit">Save Banner</button>
        <a class="btn" href="/" target="_blank">View Site</a>
      </div>
    </form>
  </div>
</body>
</html>
