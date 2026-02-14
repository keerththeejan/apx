@extends('admin.layout')

@section('title', 'Services - Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Services</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.services.create') }}">Add Service</a>
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
        @forelse($services as $s)
          <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->icon }}</td>
            <td>{{ $s->title }}</td>
            <td style="max-width:420px">{{ \Illuminate\Support\Str::limit($s->description, 120) }}</td>
            <td>{{ $s->sort_order }}</td>
            <td>
              @if(\Illuminate\Support\Facades\Schema::hasColumn('services','is_visible'))
                @if($s->is_visible)
                  <span style="background:#052; color:#c7f9cc; border:1px solid #0a4; padding:4px 8px; border-radius:8px">Visible</span>
                @else
                  <span style="background: rgba(239,68,68,.15); color:#fecaca; border:1px solid rgba(239,68,68,.35); padding:4px 8px; border-radius:8px">Hidden</span>
                @endif
              @endif
            </td>
            <td class="actions">
              @if(\Illuminate\Support\Facades\Schema::hasColumn('services','is_visible'))
                <form method="POST" action="{{ route('admin.services.toggle', $s) }}" style="display:inline">
                  @csrf
                  @method('PATCH')
                  <button class="btn" type="submit" style="margin-right:6px">{{ $s->is_visible ? 'Hide' : 'Show' }}</button>
                </form>
              @endif
              <a class="btn" href="{{ route('admin.services.edit', $s) }}">Edit</a>
              <form method="POST" action="{{ route('admin.services.destroy', $s) }}" onsubmit="return confirm('Delete this service?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="color:#94a3b8">No services yet. Click "Add Service".</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if(method_exists(($services ?? null),'links'))
    <div style="margin-top:10px">{!! $services->links() !!}</div>
  @endif
@endsection
