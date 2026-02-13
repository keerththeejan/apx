@extends('admin.layout')

@section('title', 'Social Links - Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:10px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Social Media Links</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.sociallinks.create') }}">Add Social Link</a>
    </div>
  </div>

  <p style="color:var(--muted); font-size:14px; margin-bottom:16px">Links appear in the site footer. Use an emoji or icon code for the icon (e.g. 📷 Instagram, 🔗 Link).</p>

  <div class="tablewrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Icon</th>
          <th>Label</th>
          <th>URL</th>
          <th>Order</th>
          <th>Visible</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($links as $l)
          <tr>
            <td>{{ $l->id }}</td>
            <td>{{ $l->icon ?: '—' }}</td>
            <td>{{ $l->label }}</td>
            <td><a href="{{ $l->url }}" target="_blank" rel="noopener" style="color:#93c5fd">{{ Str::limit($l->url, 40) }}</a></td>
            <td>{{ $l->sort_order }}</td>
            <td>{{ $l->is_visible ? 'Yes' : 'No' }}</td>
            <td class="actions" style="display:flex; gap:8px; flex-wrap:wrap">
              <a class="btn" href="{{ route('admin.sociallinks.edit', $l) }}">Edit</a>
              <form method="POST" action="{{ route('admin.sociallinks.destroy', $l) }}" onsubmit="return confirm('Delete this social link?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn" type="submit" style="background:var(--danger); border-color:var(--danger)">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="color:#94a3b8">No social links yet. Add one to show icons in the footer.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
