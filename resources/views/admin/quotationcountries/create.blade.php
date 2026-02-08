@extends('admin.layout')

@section('title', 'Add Quotation Country - Admin')

@section('content')
  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; gap:8px; align-items:center; margin-bottom:12px">
    <a class="btn" href="{{ route('admin.quotationcountries.index') }}">Back</a>
    <h2 style="margin:0">Add Quotation Country</h2>
  </div>

  <form method="POST" action="{{ route('admin.quotationcountries.store') }}">
    @csrf
    <label for="name">Country name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="United States">

    <label for="code">Code (optional)</label>
    <input id="code" type="text" name="code" value="{{ old('code') }}" placeholder="US">

    <label for="rate_per_kg">Rate per kg</label>
    <input id="rate_per_kg" type="number" step="0.01" min="0" name="rate_per_kg" value="{{ old('rate_per_kg', '0') }}" required>

    <label for="base_fee">Base fee (optional)</label>
    <input id="base_fee" type="number" step="0.01" min="0" name="base_fee" value="{{ old('base_fee', '0') }}">

    <label for="sort_order">Sort order</label>
    <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}">

    <div class="actions" style="margin-top:12px; display:flex; gap:8px">
      <button class="btn" type="submit">Create</button>
      <a class="btn" href="{{ route('admin.quotationcountries.index') }}">Cancel</a>
    </div>
  </form>
@endsection
