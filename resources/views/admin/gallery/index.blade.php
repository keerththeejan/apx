@extends('admin.layout')

@section('title', 'Gallery - Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Gallery</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.gallery.create') }}">Add Item</a>
    </div>
  </div>

  <div class="tablewrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Image</th>
          <th>Label</th>
          <th>Date</th>
          <th>Order</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $it)
          <tr>
            <td>{{ $it->id }}</td>
            <td><img class="thumb" src="{{ $it->image_url }}" alt="{{ $it->label }}" style="width:120px; height:70px; object-fit:cover; border-radius:8px; border:1px solid rgba(148,163,184,.12)"></td>
            <td>{{ $it->label }}</td>
            <td>{{ $it->date_label }}</td>
            <td>{{ $it->sort_order }}</td>
            <td class="actions" style="display:flex; gap:8px">
              <a class="btn" href="{{ route('admin.gallery.edit', $it) }}">Edit</a>
              <form method="POST" action="{{ route('admin.gallery.destroy', $it) }}" onsubmit="return confirm('Delete this item?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" style="color:#94a3b8">No gallery items yet. Click "Add Item".</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
