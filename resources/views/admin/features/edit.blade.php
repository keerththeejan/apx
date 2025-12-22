<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Feature - Admin</title>
  <style>
    body{font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background:#0b1220; color:#e2e8f0; margin:0}
    header{display:flex; justify-content:space-between; align-items:center; padding:14px 20px; background:#0f172a; border-bottom:1px solid rgba(148,163,184,.12)}
    .wrap{max-width:800px; margin:0 auto; padding:18px 20px}
    label{display:block; margin:10px 0 6px; color:#cbd5e1}
    input, textarea{width:100%; padding:10px 12px; border-radius:8px; border:1px solid rgba(148,163,184,.25); background:#0b1a21; color:#e5e7eb}
    .row{display:grid; grid-template-columns: 1fr 1fr; gap:10px}
    .btn{display:inline-block; padding:10px 14px; border-radius:10px; border:1px solid rgba(148,163,184,.25); background:#1e293b; color:#fff; text-decoration:none; font-weight:700}
    .actions{display:flex; gap:10px; margin-top:12px}
    .error{background: rgba(239,68,68,.15); color:#fecaca; border:1px solid rgba(239,68,68,.35); padding:10px 12px; border-radius:8px; font-size:14px; margin-bottom:10px}
  </style>
</head>
<body>
  <header>
    <div>Edit Feature</div>
    <div>
      <a class="btn" href="{{ route('admin.features.index') }}">Back</a>
    </div>
  </header>

  <div class="wrap">
    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.features.update', $feature) }}">
      @csrf
      @method('PUT')

      <label for="title">Title</label>
      <input id="title" type="text" name="title" value="{{ old('title', $feature->title) }}" required>

      <label for="icon">Icon (emoji or short text)</label>
      <input id="icon" type="text" name="icon" value="{{ old('icon', $feature->icon) }}" placeholder="e.g. ✈️ or 🚚">

      <label for="description">Description</label>
      <textarea id="description" name="description">{{ old('description', $feature->description) }}</textarea>

      <div class="row">
        <div>
          <label for="sort_order">Sort Order</label>
          <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $feature->sort_order) }}" min="0">
        </div>
      </div>

      <div class="actions">
        <button class="btn" type="submit">Update</button>
      </div>
    </form>
  </div>
</body>
</html>
