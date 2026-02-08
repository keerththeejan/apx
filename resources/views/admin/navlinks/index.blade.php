@extends('admin.layout')

@section('title', 'Nav Links - Admin')
@section('brand', 'Nav Links')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Nav Links</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.navlinks.create') }}">Add Link</a>
    </div>
  </div>

  <div class="tablewrap">
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
            <td class="actions" style="display:flex; gap:8px">
              <a class="btn" href="{{ route('admin.navlinks.edit', $l) }}">Edit</a>
              <form method="POST" action="{{ route('admin.navlinks.destroy', $l) }}" onsubmit="return confirm('Delete this link?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn logout" type="submit" style="padding:8px 12px; font-size:14px">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="color:var(--muted)">No links yet. Click "Add Link".</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
