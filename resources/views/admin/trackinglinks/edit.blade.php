@extends('admin.layout')

@section('title', 'Edit tracking link - Admin')

@section('content')
  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.trackinglinks.index') }}">Back</a>
      <h2 style="margin:0">Edit tracking link</h2>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.trackinglinks.update', $link) }}">
    @csrf
    @method('PUT')

    <label for="name">Name (e.g. DHL, FedEx, UPS)</label>
    <input id="name" type="text" name="name" value="{{ old('name', $link->name) }}" required>

    <label for="url_template">URL template</label>
    <input id="url_template" type="text" name="url_template" value="{{ old('url_template', $link->url_template) }}" required>
    <div style="color:var(--muted); font-size:12px; margin-top:4px">Use <code>{tracking_number}</code> where the tracking number should go.</div>

    <label for="sort_order">Sort order</label>
    <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $link->sort_order) }}">

    <label style="display:flex; gap:8px; align-items:center; margin-top:12px">
      <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $link->is_visible) ? 'checked' : '' }}> Visible on home page
    </label>

    <div class="actions" style="margin-top:12px; display:flex; gap:8px">
      <button class="btn" type="submit">Save</button>
      <a class="btn" href="{{ route('admin.trackinglinks.index') }}">Cancel</a>
    </div>
  </form>
@endsection
