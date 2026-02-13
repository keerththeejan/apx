@extends('admin.layout')

@section('title', 'Edit Service - Admin')

@section('content')
  @if ($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <h2 style="margin:0">Edit Service</h2>
    <div>
      <a class="btn" href="{{ route('admin.services.index') }}">Back</a>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="icon">Icon (emoji or short text)</label>
    <input id="icon" type="text" name="icon" value="{{ old('icon', $service->icon) }}" placeholder="✈️" list="iconlist">
    <datalist id="iconlist">
      <option value="✈️">✈️ Air</option>
      <option value="🚆">🚆 Train</option>
      <option value="🚢">🚢 Cargo Ship</option>
      <option value="⚓">⚓ Maritime</option>
      <option value="🛩️">🛩️ Flight</option>
      <option value="🚚">🚚 Land Transport</option>
      <option value="🏬">🏬 Warehousing</option>
      <option value="📦">📦 Parcel</option>
      <option value="🚛">🚛 Truck</option>
      <option value="🧭">🧭 Navigation</option>
      <option value="⛴️">⛴️ Ferry</option>
    </datalist>

    <label for="title">Title</label>
    <input id="title" type="text" name="title" value="{{ old('title', $service->title) }}" required>

    <label for="description">Description</label>
    <textarea id="description" name="description">{{ old('description', $service->description) }}</textarea>

    <label for="image_url">Preview Image URL</label>
    <input id="image_url" type="text" name="image_url" value="{{ old('image_url', $service->image_url) }}" placeholder="https://...">
    <label for="image_file">Or upload an image (optional)</label>
    <input id="image_file" type="file" name="image_file" accept="image/*">
    @if(!empty($service->image_url))
      <div style="margin-top:6px"><img src="{{ $service->image_url }}" alt="Preview" style="width:220px; height:120px; object-fit:cover; border-radius:10px; border:1px solid rgba(148,163,184,.25)"></div>
    @endif
    <small class="help">Image shown in the preview on the right of the services section. For best fit use a <strong>landscape</strong> image (e.g. 1200×600 or 800×400 px); it will be cropped to fit a fixed height (object-fit: cover).</small>

    <label for="checklist_text">Checklist items (one per line)</label>
    <textarea id="checklist_text" name="checklist_text">{{ old('checklist_text', $checklist_text) }}</textarea>

    <div class="row">
      <div>
        <label for="sort_order">Sort Order</label>
        <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0">
      </div>
      @if(\Illuminate\Support\Facades\Schema::hasColumn('services','is_visible'))
      <div>
        <label for="is_visible">Visible</label>
        <input id="is_visible" type="checkbox" name="is_visible" value="1" {{ old('is_visible', $service->is_visible) ? 'checked' : '' }}>
      </div>
      @endif
    </div>

    <div class="actions">
      <button class="btn" type="submit">Save</button>
      <a class="btn" href="{{ route('admin.services.index') }}">Cancel</a>
      <form class="inline" method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Delete this service?')">
        @csrf
        @method('DELETE')
        <button class="btn danger" type="submit">Delete</button>
      </form>
    </div>
  </form>
@endsection
