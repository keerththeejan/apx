@extends('admin.layout')

@section('title', 'Edit Home Banner')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif
  @if ($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Edit Home Banner</h2>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.banner.update') }}">
    @csrf

    <label for="eyebrow">Eyebrow</label>
    <input id="eyebrow" type="text" name="eyebrow" value="{{ old('eyebrow', optional($banner)->eyebrow) }}" placeholder="SAFE TRANSPORTATION & LOGISTICS">

    <label for="title_line1">Title Line 1</label>
    <input id="title_line1" type="text" name="title_line1" value="{{ old('title_line1', optional($banner)->title_line1) }}" placeholder="Adaptable coordinated factors">

    <label for="title_line2">Title Line 2</label>
    <input id="title_line2" type="text" name="title_line2" value="{{ old('title_line2', optional($banner)->title_line2) }}" placeholder="Quick Conveyance">

    <label for="subtitle">Subtitle</label>
    <textarea id="subtitle" name="subtitle" placeholder="Short description for the banner">{{ old('subtitle', optional($banner)->subtitle) }}</textarea>

    <label for="bg_image_url">Background Image URL</label>
    <input id="bg_image_url" type="text" name="bg_image_url" value="{{ old('bg_image_url', optional($banner)->bg_image_url) }}" placeholder="https://...">
    <small class="help">Paste a full image URL. We can switch to file uploads later if you prefer.</small>

    <div class="row">
      <div>
        <label for="primary_text">Primary Button Text</label>
        <input id="primary_text" type="text" name="primary_text" value="{{ old('primary_text', optional($banner)->primary_text) }}" placeholder="Get Started">
      </div>
      <div>
        <label for="primary_url">Primary Button URL</label>
        <input id="primary_url" type="text" name="primary_url" value="{{ old('primary_url', optional($banner)->primary_url) }}" placeholder="#get-started">
      </div>
    </div>

    <div class="row">
      <div>
        <label for="secondary_text">Secondary Button Text</label>
        <input id="secondary_text" type="text" name="secondary_text" value="{{ old('secondary_text', optional($banner)->secondary_text) }}" placeholder="Learn More">
      </div>
      <div>
        <label for="secondary_url">Secondary Button URL</label>
        <input id="secondary_url" type="text" name="secondary_url" value="{{ old('secondary_url', optional($banner)->secondary_url) }}" placeholder="#learn">
      </div>
    </div>

    <div class="actions">
      <button class="btn" type="submit">Save Banner</button>
      <a class="btn" href="/" target="_blank">View Site</a>
    </div>
  </form>
@endsection
