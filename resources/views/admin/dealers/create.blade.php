@extends('admin.layout')

@section('title', 'Add Dealer - Admin')

@section('content')
  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; gap:8px; align-items:center; margin-bottom:12px">
    <a class="btn" href="{{ route('admin.dealers.index') }}">Back</a>
    <h2 style="margin:0">Add Dealer</h2>
  </div>

  <form method="POST" action="{{ route('admin.dealers.store') }}">
    @csrf
    <label for="code">Dealer code (unique)</label>
    <input id="code" type="text" name="code" value="{{ old('code') }}" required placeholder="DEALER01">

    <label for="name">Name (optional)</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Partner Name">

    <label for="discount_percent">Discount % (0–100)</label>
    <input id="discount_percent" type="number" step="0.01" min="0" max="100" name="discount_percent" value="{{ old('discount_percent', '0') }}" required>

    <label style="display:flex; gap:8px; align-items:center; margin-top:12px">
      <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}> Active
    </label>

    <label for="sort_order">Sort order</label>
    <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}">

    <div class="actions" style="margin-top:12px; display:flex; gap:8px">
      <button class="btn" type="submit">Create</button>
      <a class="btn" href="{{ route('admin.dealers.index') }}">Cancel</a>
    </div>
  </form>
@endsection
