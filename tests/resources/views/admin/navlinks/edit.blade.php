@extends('admin.layout')

@section('title', 'Edit Nav Link - Admin')
@section('brand', 'Nav Links')

@section('content')
  @if ($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.navlinks.index') }}">Back</a>
      <h2 style="margin:0">Edit Nav Link</h2>
    </div>
  </div>

  <div class="wrap">
    <form method="POST" action="{{ route('admin.navlinks.update', $link) }}">
      @csrf
      @method('PUT')
      <label for="label">Label</label>
      <input id="label" type="text" name="label" value="{{ old('label', $link->label) }}" required>

      <label for="icon">Icon (emoji or short text)</label>
      <input id="icon" type="text" name="icon" value="{{ old('icon', $link->icon) }}" placeholder="Pick or type…" list="naviconlist">
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
      <input id="url" type="text" name="url" value="{{ old('url', $link->url) }}" required>

      <div class="row">
        <div>
          <label for="target">Target</label>
          <select id="target" name="target">
            <option value="_self" {{ old('target', $link->target ?? '_self') === '_self' ? 'selected':'' }}>Same tab</option>
            <option value="_blank" {{ old('target', $link->target) === '_blank' ? 'selected':'' }}>New tab</option>
          </select>
        </div>
        <div>
          <label for="sort_order">Sort Order</label>
          <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $link->sort_order) }}" min="0">
        </div>
      </div>

      <label>
        <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $link->is_visible) ? 'checked' : '' }}> Visible
      </label>

      <div class="actions">
        <button class="btn" type="submit">Save</button>
        <a class="btn" href="{{ route('admin.navlinks.index') }}">Cancel</a>
        <form method="POST" action="{{ route('admin.navlinks.destroy', $link) }}" onsubmit="return confirm('Delete this link?')" style="display:inline">
          @csrf
          @method('DELETE')
          <button class="logout" type="submit" style="padding:8px 12px; font-size:14px">Delete</button>
        </form>
      </div>
    </form>
  </div>
@endsection
