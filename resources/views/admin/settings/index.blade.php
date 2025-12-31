@extends('admin.layout')

@section('title', 'Settings - Admin')

@section('content')
  <div class="wrap">
    @if(session('status'))
      <div class="status">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
      <div style="display:flex; gap:8px; align-items:center">
        <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
        <h2 style="margin:0">Settings</h2>
      </div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
      @csrf

      <label for="site_name">Site Name</label>
      <input id="site_name" type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required>

      <label for="tagline">Tagline</label>
      <input id="tagline" type="text" name="tagline" value="{{ old('tagline', $settings['tagline']) }}" placeholder="Safe Transportation & Logistics">

      <label for="logo_file">Logo Image</label>
      <input id="logo_file" type="file" name="logo_file" accept="image/*">
      <div style="color:#94a3b8; font-size:12px; margin-top:6px">PNG, JPG, WEBP, or SVG up to 4MB.</div>
      <label for="logo_url">Logo URL (optional)</label>
      <input id="logo_url" type="text" name="logo_url" value="{{ old('logo_url', $settings['logo_url']) }}" placeholder="https://..." />

      <div class="row">
        <div>
          <label for="contact_email">Contact Email</label>
          <input id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}">
        </div>
        <div>
          <label for="contact_phone">Contact Phone</label>
          <input id="contact_phone" type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}">
        </div>
      </div>

      <label for="address">Address</label>
      <textarea id="address" name="address">{{ old('address', $settings['address']) }}</textarea>

      <label for="default_theme">Default Admin Theme</label>
      <select id="default_theme" name="default_theme">
        @php $themes = ['dark'=>'Dark','slate'=>'Slate','indigo'=>'Indigo','emerald'=>'Emerald','rose'=>'Rose','amber'=>'Amber','sky'=>'Sky','violet'=>'Violet']; @endphp
        @foreach($themes as $val=>$label)
          <option value="{{ $val }}" {{ old('default_theme', $settings['default_theme'])===$val? 'selected':'' }}>{{ $label }}</option>
        @endforeach
      </select>

      <div class="actions">
        <button class="btn" type="submit">Save Settings</button>
        <a class="btn" href="{{ route('admin.dashboard') }}">Cancel</a>
      </div>
    </form>
  </div>
@endsection
