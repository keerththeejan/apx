<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Gallery Item - Admin</title>
  <style>
    body{font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background:#0b1220; color:#e2e8f0; margin:0}
    header{display:flex; justify-content:space-between; align-items:center; padding:14px 20px; background:#0f172a; border-bottom:1px solid rgba(148,163,184,.12)}
    .wrap{max-width:900px; margin:0 auto; padding:18px 20px}
    label{display:block; margin:10px 0 6px; color:#cbd5e1}
    input{width:100%; padding:10px 12px; border-radius:10px; border:1px solid rgba(148,163,184,.25); background:#0b1a21; color:#e5e7eb}
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
    <div>Edit Gallery Item</div>
    <div>
      <a class="btn" href="{{ route('admin.gallery.index') }}">Back</a>
    </div>
  </header>

  <div class="wrap">
    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.gallery.update', $item) }}">
      @csrf
      @method('PUT')
      <label for="image_url">Image URL</label>
      <input id="image_url" type="text" name="image_url" value="{{ old('image_url', $item->image_url) }}" required>

      <div class="row">
        <div>
          <label for="label">Label</label>
          <input id="label" type="text" name="label" value="{{ old('label', $item->label) }}">
        </div>
        <div>
          <label for="date_label">Date Label</label>
          <input id="date_label" type="text" name="date_label" value="{{ old('date_label', $item->date_label) }}">
        </div>
      </div>

      <label for="sort_order">Sort Order</label>
      <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" min="0">

      <div class="actions">
        <button class="btn" type="submit">Save</button>
        <a class="btn" href="{{ route('admin.gallery.index') }}">Cancel</a>
        <form class="inline" method="POST" action="{{ route('admin.gallery.destroy', $item) }}" onsubmit="return confirm('Delete this item?')">
          @csrf
          @method('DELETE')
          <button class="btn danger" type="submit">Delete</button>
        </form>
      </div>
    </form>
  </div>
</body>
</html>
