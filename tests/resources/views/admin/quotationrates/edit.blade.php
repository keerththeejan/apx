@extends('admin.layout')

@section('title', 'Edit Quotation Rate - Admin')

@section('content')
  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; gap:8px; align-items:center; margin-bottom:12px">
    <a class="btn" href="{{ route('admin.quotationrates.index') }}">Back</a>
    <h2 style="margin:0">Edit Quotation Rate</h2>
  </div>

  <form method="POST" action="{{ route('admin.quotationrates.update', $rate) }}">
    @csrf
    @method('PUT')
    <label for="country">Country</label>
    <input id="country" type="text" name="country" value="{{ old('country', $rate->country) }}" required>

    <label for="service">Service</label>
    <input id="service" type="text" name="service" value="{{ old('service', $rate->service) }}" required>

    <label for="customer_price">Customer price (unit)</label>
    <input id="customer_price" type="number" step="0.01" min="0" name="customer_price" value="{{ old('customer_price', $rate->customer_price) }}" required>

    <label for="dealer_price">Dealer price (unit)</label>
    <input id="dealer_price" type="number" step="0.01" min="0" name="dealer_price" value="{{ old('dealer_price', $rate->dealer_price) }}" required>

    <label style="display:block; margin-top:16px; margin-bottom:8px">Connected dealers</label>
    <p style="color:var(--muted); font-size:13px; margin:0 0 10px">Select which dealers get dealer price for this rate. Leave all unchecked to allow any dealer code.</p>
    <div style="display:flex; flex-wrap:wrap; gap:12px; padding:12px; background:var(--accent); border-radius:10px; border:1px solid var(--border)">
      @forelse(($dealers ?? []) as $d)
        <label style="display:flex; align-items:center; gap:6px; cursor:pointer; white-space:nowrap">
          <input type="checkbox" name="dealer_ids[]" value="{{ $d->id }}" {{ in_array($d->id, old('dealer_ids', $rate->dealers->pluck('id')->toArray())) ? 'checked' : '' }}>
          <span>{{ $d->code }}{{ $d->name ? ' (' . $d->name . ')' : '' }}</span>
        </label>
      @empty
        <span style="color:var(--muted)">No dealers yet. <a href="{{ route('admin.dealers.index') }}" style="color:#93c5fd">Add dealers</a> first.</span>
      @endforelse
    </div>

    <label for="sort_order">Sort order</label>
    <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $rate->sort_order) }}">

    <div class="actions" style="margin-top:12px; display:flex; gap:8px">
      <button class="btn" type="submit">Save</button>
      <a class="btn" href="{{ route('admin.quotationrates.index') }}">Cancel</a>
    </div>
  </form>
@endsection
