@extends('admin.layout')

@section('title', 'Parcel Tracking Links - Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Parcel Tracking Links (3rd party)</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.trackinglinks.create') }}">Add tracking link</a>
    </div>
  </div>

  <p style="color:var(--muted); margin:0 0 12px">These links appear after Features on the home page. Use <code style="background:var(--accent); padding:2px 6px; border-radius:4px">{tracking_number}</code> in the URL so the tracking number is inserted when the user tracks.</p>

  <div class="tablewrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>URL template</th>
          <th>Order</th>
          <th>Visible</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($links as $l)
          <tr>
            <td>{{ $l->id }}</td>
            <td>{{ $l->name }}</td>
            <td><span style="color:#93c5fd; font-size:13px; word-break:break-all">{{ \Illuminate\Support\Str::limit($l->url_template, 60) }}</span></td>
            <td>{{ $l->sort_order }}</td>
            <td>{{ $l->is_visible ? 'Yes' : 'No' }}</td>
            <td class="actions" style="display:flex; gap:8px">
              <a class="btn" href="{{ route('admin.trackinglinks.edit', $l) }}">Edit</a>
              <form method="POST" action="{{ route('admin.trackinglinks.destroy', $l) }}" onsubmit="return confirm('Delete this tracking link?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn" type="submit" style="background:var(--danger); border-color:var(--danger)">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" style="color:#94a3b8">No tracking links yet. Add one to show parcel tracking options after Features.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
