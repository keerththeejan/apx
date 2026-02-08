@extends('admin.layout')

@section('title', 'Quotation Rates - Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Quotation Rates</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.quotationrates.create') }}">Add Rate</a>
    </div>
  </div>

  <p style="color:var(--muted); margin:0 0 12px">Country + Service (e.g. DHL, FedEx, UPS) with Customer price and Dealer price per unit. Total = unit price × qty.</p>

  <div class="tablewrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Country</th>
          <th>Service</th>
          <th>Customer price</th>
          <th>Dealer price</th>
          <th>Order</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rates as $r)
          <tr>
            <td>{{ $r->id }}</td>
            <td>{{ $r->country }}</td>
            <td>{{ $r->service }}</td>
            <td>{{ number_format($r->customer_price, 2) }}</td>
            <td>{{ number_format($r->dealer_price, 2) }}</td>
            <td>{{ $r->sort_order }}</td>
            <td style="display:flex; gap:8px">
              <a class="btn" href="{{ route('admin.quotationrates.edit', $r) }}">Edit</a>
              <form method="POST" action="{{ route('admin.quotationrates.destroy', $r) }}" onsubmit="return confirm('Remove this rate?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn" type="submit" style="background:var(--danger); border-color:var(--danger)">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="color:#94a3b8">No rates yet. Add Country, Service, Customer price and Dealer price.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
