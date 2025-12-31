<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nav Links - Admin</title>
  <style>
    body{font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background:#0b1220; color:#e2e8f0; margin:0}
    header{display:flex; justify-content:space-between; align-items:center; padding:14px 20px; background:#0f172a; border-bottom:1px solid rgba(148,163,184,.12)}
    .wrap{max-width:1100px; margin:0 auto; padding:18px 20px}
    .btn{display:inline-block; padding:8px 12px; border-radius:10px; border:1px solid rgba(148,163,184,.25); background:#1e293b; color:#fff; text-decoration:none; font-weight:700}
    table{width:100%; border-collapse:collapse; background:#0f172a; border:1px solid rgba(148,163,184,.12); border-radius:12px; overflow:hidden}
    th,td{padding:12px 14px; border-bottom:1px solid rgba(148,163,184,.12)}
    th{color:#94a3b8; text-align:left}
    .actions{display:flex; gap:8px}
    .danger{background:#ef4444; border-color:#ef4444}
    form{display:inline}
    .status{background:#052; color:#c7f9cc; border:1px solid #0a4; padding:8px 10px; border-radius:8px; margin-bottom:12px; display:inline-block}
  </style>
</head>
<body>
  <header>
    <div>Nav Links</div>
    <div>
      <a class="btn" href="{{ route('admin.dashboard') }}">Dashboard</a>
      <a class="btn" href="{{ route('admin.navlinks.create') }}">Add Link</a>
    </div>
  </header>
  <div class="wrap">
    @if(session('status'))
      <div class="status">{{ session('status') }}</div>
    @endif

    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Label</th>
          <th>URL</th>
          <th>Target</th>
          <th>Visible</th>
          <th>Order</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($links as $l)
          <tr>
            <td>{{ $l->id }}</td>
            <td>{{ $l->label }}</td>
            <td style="max-width:420px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap">{{ $l->url }}</td>
            <td>{{ $l->target ?? '_self' }}</td>
            <td>{{ $l->is_visible ? 'Yes' : 'No' }}</td>
            <td>{{ $l->sort_order }}</td>
            <td class="actions">
              <a class="btn" href="{{ route('admin.navlinks.edit', $l) }}">Edit</a>
              <form method="POST" action="{{ route('admin.navlinks.destroy', $l) }}" onsubmit="return confirm('Delete this link?')">
                @csrf
                @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="color:#94a3b8">No links yet. Click "Add Link".</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</body>
</html>
