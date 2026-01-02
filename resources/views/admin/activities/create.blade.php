@extends('admin.layout')

@section('title', 'Add Daily Activity - Admin')

@section('content')
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
      <h2 style="margin:0">Add Daily Activity</h2>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data">
    @csrf

    <label>Title</label>
    <input type="text" name="title" value="{{ old('title') }}" required>

    <label>Body</label>
    <textarea name="body" rows="5">{{ old('body') }}</textarea>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px">
      <div>
        <label>Date</label>
        <input type="date" name="activity_date" value="{{ old('activity_date') }}">
      </div>
      <div>
        <label>Order</label>
        <input type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}">
      </div>
    </div>

    <label>Image Upload</label>
    <input type="file" name="image_file" accept="image/*">

    <label>Image URL (optional)</label>
    <input type="text" name="image_url" value="{{ old('image_url') }}" placeholder="/public/uploads/activities/example.jpg">

    <label style="display:flex; align-items:center; gap:8px; margin-top:10px">
      <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', true) ? 'checked' : '' }}> Visible
    </label>

    <div style="margin-top:14px">
      <button class="btn" type="submit">Create</button>
    </div>
  </form>
@endsection
