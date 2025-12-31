@extends('admin.layout')

@section('title', 'Footer Links - Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Footer Links</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.footerlinks.create') }}">Add Link</a>
    </div>
  </div>

  <div class="tablewrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
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
            <td>{{ $l->label }}</td>
            <td><a href="{{ $l->url }}" target="_blank" rel="noopener" style="color:#93c5fd">{{ $l->url }}</a></td>
            <td>{{ $l->sort_order }}</td>
            <td>{{ $l->is_visible ? 'Yes' : 'No' }}</td>
            <td class="actions" style="display:flex; gap:8px">
              <a class="btn" href="{{ route('admin.footerlinks.edit', $l) }}">Edit</a>
              <form method="POST" action="{{ route('admin.footerlinks.destroy', $l) }}" onsubmit="return confirm('Delete this link?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" style="color:#94a3b8">No footer links yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
