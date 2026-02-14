@extends('admin.layout')

@section('title', 'Add tracking link - Admin')

@section('content')
  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.trackinglinks.index') }}">Back</a>
      <h2 style="margin:0">Add tracking link (3rd party)</h2>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.trackinglinks.store') }}">
    @csrf

    <label for="name">Name (e.g. DHL, FedEx, UPS)</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="DHL">

    <label for="url_template">URL template</label>
    <input id="url_template" type="text" name="url_template" value="{{ old('url_template') }}" required placeholder="https://www.dhl.com/track?AWB={tracking_number}">
    <div style="color:var(--muted); font-size:12px; margin-top:4px">Use <code>{tracking_number}</code> where the tracking number should go. Opens in new tab.</div>

    <label for="sort_order">Sort order</label>
    <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}">

    <label style="display:flex; gap:8px; align-items:center; margin-top:12px">
      <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', true) ? 'checked' : '' }}> Visible on home page
    </label>

    <div class="actions" style="margin-top:12px; display:flex; gap:8px">
      <button class="btn" type="submit">Create</button>
      <a class="btn" href="{{ route('admin.trackinglinks.index') }}">Cancel</a>
    </div>
  </form>
@endsection
