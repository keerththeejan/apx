@extends('admin.layout')

@section('title', 'Edit Daily Activity - Admin')

@section('content')
  @php
    $toUrl = function ($p) {
      if (empty($p)) return null;
      $p = trim((string) $p);
      if (\Illuminate\Support\Str::startsWith($p, ['http://','https://','data:'])) return $p;
      $path = ltrim($p, '/');
      if (\Illuminate\Support\Str::startsWith($path, 'uploads/')) {
        $path = 'public/'.$path;
      }
      return asset($path);
    };
  @endphp
  @if ($errors->any())
    <div class="error">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.activities.index') }}">Back</a>
      <h2 style="margin:0">Edit Daily Activity</h2>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.activities.update', $item) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Title</label>
    <input type="text" name="title" value="{{ old('title', $item->title) }}" required>

    <label>Body</label>
    <textarea name="body" rows="5">{{ old('body', $item->body) }}</textarea>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px">
      <div>
        <label>Date</label>
        <input type="date" name="activity_date" value="{{ old('activity_date', $item->activity_date ? $item->activity_date->format('Y-m-d') : '') }}">
      </div>
      <div>
        <label>Order</label>
        <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}">
      </div>
    </div>

    <label>Image Upload</label>
    <input type="file" name="image_file" accept="image/*">

    <label>Image URL (optional)</label>
    <input type="text" name="image_url" value="{{ old('image_url', $item->image_url) }}" placeholder="/public/uploads/activities/example.jpg">

    @if(!empty($item->image_url))
      <div style="margin-top:10px">
        <img src="{{ $toUrl($item->image_url) }}" alt="Current image" style="width:160px; height:100px; border-radius:12px; object-fit:cover; border:1px solid rgba(148,163,184,.25)">
      </div>
    @endif

    <label style="display:flex; align-items:center; gap:8px; margin-top:10px">
      <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $item->is_visible) ? 'checked' : '' }}> Visible
    </label>

    <div style="margin-top:14px">
      <button class="btn" type="submit">Save</button>
    </div>
  </form>
@endsection
