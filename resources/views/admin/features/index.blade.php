@extends('admin.layout')

@section('title', 'Features - Admin')

@section('brand', 'Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Features</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.features.create') }}">Add Feature</a>
    </div>
  </div>

  <div class="tablewrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Icon</th>
          <th>Title</th>
          <th>Description</th>
          <th>Order</th>
          <th>Visible</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($features as $f)
          <tr>
            <td>{{ $f->id }}</td>
            <td>
              @if(!empty($f->icon_image_url))
                <img src="{{ $f->icon_image_url }}" alt="Icon" style="width:28px; height:28px; border-radius:6px; object-fit:cover; border:1px solid rgba(148,163,184,.25)">
              @else
                {{ $f->icon ?? '•' }}
              @endif
            </td>
            <td>{{ $f->title }}</td>
            <td style="max-width:520px">{{ \Illuminate\Support\Str::limit($f->description, 160) }}</td>
            <td>{{ $f->sort_order }}</td>
            <td>
              @if($f->is_visible)
                <span style="background:#052; color:#c7f9cc; border:1px solid #0a4; padding:4px 8px; border-radius:8px">Visible</span>
              @else
                <span style="background: rgba(239,68,68,.15); color:#fecaca; border:1px solid rgba(239,68,68,.35); padding:4px 8px; border-radius:8px">Hidden</span>
              @endif
            </td>
            <td class="actions">
              <form method="POST" action="{{ route('admin.features.toggle', $f) }}" style="display:inline">
                @csrf
                @method('PATCH')
                <button class="btn" type="submit" style="margin-right:6px">{{ $f->is_visible ? 'Hide' : 'Show' }}</button>
              </form>
              <a class="btn" href="{{ route('admin.features.edit', $f) }}">Edit</a>
              <form method="POST" action="{{ route('admin.features.destroy', $f) }}" onsubmit="return confirm('Delete this feature?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="color:#94a3b8">No features yet. Click "Add Feature".</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:10px">
    {!! $features->links() !!}
  </div>
@endsection
