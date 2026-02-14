@extends('admin.layout')

@section('title', 'Dealers - Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Dealers</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.dealers.create') }}">Add Dealer</a>
    </div>
  </div>

  <p style="color:var(--muted); margin:0 0 12px">Dealer codes give customers a discounted price. Customer enters the code in the quotation form to get dealer price.</p>

  <div class="tablewrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Code</th>
          <th>Name</th>
          <th>Discount %</th>
          <th>Active</th>
          <th>Order</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($dealers as $d)
          <tr>
            <td>{{ $d->id }}</td>
            <td><code>{{ $d->code }}</code></td>
            <td>{{ $d->name ?? '—' }}</td>
            <td>{{ number_format($d->discount_percent, 2) }}%</td>
            <td>{{ $d->is_active ? 'Yes' : 'No' }}</td>
            <td>{{ $d->sort_order }}</td>
            <td style="display:flex; gap:8px">
              <a class="btn" href="{{ route('admin.dealers.edit', $d) }}">Edit</a>
              <form method="POST" action="{{ route('admin.dealers.destroy', $d) }}" onsubmit="return confirm('Remove this dealer?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn" type="submit" style="background:var(--danger); border-color:var(--danger)">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="color:#94a3b8">No dealers yet. Add dealer codes so customers can get dealer price.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
