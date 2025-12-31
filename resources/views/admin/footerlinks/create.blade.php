@extends('admin.layout')

@section('title', 'Create Footer Link')

@section('content')
  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.footerlinks.index') }}">Back</a>
      <h2 style="margin:0">Create Footer Link</h2>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.footerlinks.store') }}">
    @csrf

    <label for="label">Label</label>
    <input id="label" type="text" name="label" value="{{ old('label') }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)" required>

    <label for="url">URL</label>
    <input id="url" type="text" name="url" value="{{ old('url') }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)" required>

    <label for="sort_order">Order</label>
    <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">

    <label style="display:flex; gap:8px; align-items:center">
      <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', true) ? 'checked' : '' }}> Visible
    </label>

    <div class="actions" style="margin-top:12px; display:flex; gap:8px">
      <button class="btn" type="submit">Create Link</button>
      <a class="btn" href="{{ route('admin.footerlinks.index') }}">Cancel</a>
    </div>
  </form>
@endsection
