@extends('admin.layout')

@section('title', 'Help Items - Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Help Items</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.helpitems.create') }}">Add Item</a>
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
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $it)
          <tr>
            <td>{{ $it->id }}</td>
            <td>{{ $it->icon }}</td>
            <td>{{ $it->title }}</td>
            <td style="max-width:420px">{{ \Illuminate\Support\Str::limit($it->description, 120) }}</td>
            <td>{{ $it->sort_order }}</td>
            <td class="actions" style="display:flex; gap:8px">
              <a class="btn" href="{{ route('admin.helpitems.edit', $it) }}">Edit</a>
              <form method="POST" action="{{ route('admin.helpitems.destroy', $it) }}" onsubmit="return confirm('Delete this item?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" style="color:#94a3b8">No help items yet. Click "Add Item".</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
