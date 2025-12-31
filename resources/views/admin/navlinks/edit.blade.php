<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Nav Link - Admin</title>
  <style>
    body{font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background:#0b1220; color:#e2e8f0; margin:0}
    header{display:flex; justify-content:space-between; align-items:center; padding:14px 20px; background:#0f172a; border-bottom:1px solid rgba(148,163,184,.12)}
    .wrap{max-width:900px; margin:0 auto; padding:18px 20px}
    label{display:block; margin:10px 0 6px; color:#cbd5e1}
    input, select{width:100%; padding:10px 12px; border-radius:10px; border:1px solid rgba(148,163,184,.25); background:#0b1a21; color:#e5e7eb}
    .row{display:grid; grid-template-columns: 1fr 1fr; gap:10px}
    .btn{display:inline-block; padding:10px 14px; border-radius:10px; border:1px solid rgba(148,163,184,.25); background:#1e293b; color:#fff; text-decoration:none; font-weight:700}
    .actions{display:flex; gap:10px; margin-top:12px}
    .error{background: rgba(239,68,68,.15); color:#fecaca; border:1px solid rgba(239,68,68,.35); padding:10px 12px; border-radius:8px; font-size:14px; margin-bottom:10px}
    .danger{background:#ef4444; border-color:#ef4444}
    form.inline{display:inline}
  </style>
</head>
<body>
  <header>
    <div>Edit Navigation Link</div>
    <div>
      <a class="btn" href="{{ route('admin.navlinks.index') }}">Back</a>
    </div>
  </header>

  <div class="wrap">
    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.navlinks.update', $link) }}">
      @csrf
      @method('PUT')
      <label for="label">Label</label>
      <input id="label" type="text" name="label" value="{{ old('label', $link->label) }}" required>

      <label for="icon">Icon (emoji or short text)</label>
      <input id="icon" type="text" name="icon" value="{{ old('icon', $link->icon) }}" placeholder="Pick or type…" list="naviconlist">
      <datalist id="naviconlist">
        <option value="🏠">Home</option>
        <option value="🔍">Track</option>
        <option value="📝">Book</option>
        <option value="☎️">Contact</option>
        <option value="ℹ️">About</option>
        <option value="🛒">Shop</option>
        <option value="✉️">Message</option>
        <option value="⭐">Featured</option>
      </datalist>

      <label for="url">URL</label>
      <input id="url" type="text" name="url" value="{{ old('url', $link->url) }}" required>

      <div class="row">
        <div>
          <label for="target">Target</label>
          <select id="target" name="target">
            <option value="_self" {{ old('target', $link->target ?? '_self') === '_self' ? 'selected':'' }}>Same tab</option>
            <option value="_blank" {{ old('target', $link->target) === '_blank' ? 'selected':'' }}>New tab</option>
          </select>
        </div>
        <div>
          <label for="sort_order">Sort Order</label>
          <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $link->sort_order) }}" min="0">
        </div>
      </div>

      <label>
        <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $link->is_visible) ? 'checked' : '' }}> Visible
      </label>

      <div class="actions">
        <button class="btn" type="submit">Save</button>
        <a class="btn" href="{{ route('admin.navlinks.index') }}">Cancel</a>
        <form class="inline" method="POST" action="{{ route('admin.navlinks.destroy', $link) }}" onsubmit="return confirm('Delete this link?')">
          @csrf
          @method('DELETE')
          <button class="btn danger" type="submit">Delete</button>
        </form>
      </div>
    </form>
  </div>
</body>
</html>
