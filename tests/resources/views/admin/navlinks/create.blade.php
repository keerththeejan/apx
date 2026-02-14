@extends('admin.layout')

@section('title', 'Create Nav Link - Admin')
@section('brand', 'Nav Links')

@section('content')
  @if ($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.navlinks.index') }}">Back</a>
      <h2 style="margin:0">Create Nav Link</h2>
    </div>
  </div>

  <div class="wrap">
    <form method="POST" action="{{ route('admin.navlinks.store') }}">
      @csrf
      <label for="label">Label</label>
      <input id="label" type="text" name="label" value="{{ old('label') }}" required>

      <label for="icon">Icon (emoji or short text)</label>
      <input id="icon" type="text" name="icon" value="{{ old('icon') }}" placeholder="Pick or type…" list="naviconlist">
      <datalist id="naviconlist">
        <option value="🏠">Home</option>
        <option value="🔍">Track</option>
        <option value="📝">Book</option>
        <option value="☎️">Contact</option>
        <option value="ℹ️">About</option>
        <option value="🛒">Shop</option>
        <option value="✉️">Message</option>
        <option value="⭐">Featured</option>
      </datalist>

      <label for="url">URL</label>
      <input id="url" type="text" name="url" value="{{ old('url') }}" placeholder="/path or https://..." required>

      <div class="row">
        <div>
          <label for="target">Target</label>
          <select id="target" name="target">
            <option value="_self">Same tab</option>
            <option value="_blank" {{ old('target')==='_blank'?'selected':'' }}>New tab</option>
          </select>
        </div>
        <div>
          <label for="sort_order">Sort Order</label>
          <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
        </div>
      </div>

      <label>
        <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', true) ? 'checked' : '' }}> Visible
      </label>

      <div class="actions">
        <button class="btn" type="submit">Create</button>
        <a class="btn" href="{{ route('admin.navlinks.index') }}">Cancel</a>
      </div>
    </form>
  </div>
@endsection
