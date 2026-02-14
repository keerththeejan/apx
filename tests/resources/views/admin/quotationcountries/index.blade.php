@extends('admin.layout')

@section('title', 'Quotation Countries - Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Quotation Countries</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.quotationcountries.create') }}">Add Country</a>
    </div>
  </div>

  <p style="color:var(--muted); margin:0 0 12px">Countries used for price quotation. Total = base fee + (weight kg × rate per kg).</p>

  <div class="tablewrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Code</th>
          <th>Rate/kg</th>
          <th>Base fee</th>
          <th>Order</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($countries as $c)
          <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->name }}</td>
            <td>{{ $c->code ?? '—' }}</td>
            <td>{{ number_format($c->rate_per_kg, 2) }}</td>
            <td>{{ number_format($c->base_fee ?? 0, 2) }}</td>
            <td>{{ $c->sort_order }}</td>
            <td style="display:flex; gap:8px">
              <a class="btn" href="{{ route('admin.quotationcountries.edit', $c) }}">Edit</a>
              <form method="POST" action="{{ route('admin.quotationcountries.destroy', $c) }}" onsubmit="return confirm('Remove this country?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn" type="submit" style="background:var(--danger); border-color:var(--danger)">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="color:#94a3b8">No countries yet. Add countries so customers can get a price quote by weight.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
