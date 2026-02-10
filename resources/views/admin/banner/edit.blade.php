@extends('admin.layout')

@section('title', 'Edit Home Banner')

@section('content')
  <style>
    .banner-form .field-group { margin-bottom: 20px; padding: 14px; border: 1px solid var(--border); border-radius: var(--radius); background: rgba(15,23,42,.4); }
    .banner-form .field-group.disabled { opacity: 0.65; }
    .banner-form .field-group.disabled .field-group-inner { display: none; }
    .banner-form .use-toggle { display: flex; align-items: center; gap: 10px; margin-bottom: 0; cursor: pointer; }
    .banner-form .use-toggle input[type="checkbox"] { width: auto; margin: 0; }
    .banner-form .field-group-inner { margin-top: 12px; }
    .banner-form .field-group-inner label { margin-top: 8px; }
    .banner-form .color-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .banner-form .color-row input[type="color"] { width: 44px; height: 36px; padding: 2px; cursor: pointer; border-radius: 8px; border: 1px solid var(--border); }
    .banner-form .color-row input[type="text"] { width: 120px; max-width: 100%; }
    .banner-form input, .banner-form textarea, .banner-form select { width: 100%; max-width: 100%; box-sizing: border-box; }
    @media (max-width: 768px) {
      .banner-form .row { grid-template-columns: 1fr; }
      .banner-form .field-group { padding: 12px; }
    }
    @media (max-width: 640px) {
      .banner-form .row { grid-template-columns: 1fr; gap: 10px; }
      .banner-form .field-group { padding: 12px; margin-bottom: 14px; }
      .banner-form .page-actions { flex-direction: column; align-items: stretch; }
    }
    @media (max-width: 480px) {
      .banner-form .color-row input[type="text"] { width: 100%; }
      .banner-form .color-row { flex-direction: column; align-items: flex-start; }
      .content .wrap { padding: 10px; }
    }
  </style>
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif
  @if ($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:8px">
    <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap">
      <a class="btn" href="{{ route('admin.banner.index') }}">← Banners</a>
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Edit Banner</h2>
    </div>
  </div>

  <p style="color:var(--muted); font-size:13px; margin:0 0 16px">All text fields are optional. Enable only the ones you want to show on the site. First banner by order shows on the home page.</p>

  <form method="POST" action="{{ route('admin.banner.update', $banner) }}" enctype="multipart/form-data" class="banner-form">
    @csrf
    @method('PUT')

    <label for="name">Banner name (for admin list)</label>
    <input id="name" type="text" name="name" value="{{ old('name', $banner->name) }}" placeholder="e.g. Home Hero">

    <div class="field-group" id="fg-eyebrow" data-field="eyebrow">
      <label class="use-toggle">
        <input type="checkbox" name="use_eyebrow" value="1" {{ $hasEyebrow ? 'checked' : '' }} aria-controls="fg-eyebrow-inner" class="banner-use-cb">
        <span>Show Eyebrow on site</span>
      </label>
      <div class="field-group-inner" id="fg-eyebrow-inner">
        <label for="eyebrow">Eyebrow</label>
        <input id="eyebrow" type="text" name="eyebrow" value="{{ old('eyebrow', optional($banner)->eyebrow) }}" placeholder="e.g. A PLUS EXPRESS PVT LIMITED" data-empty-name="eyebrow">
        <label for="eyebrow_color" style="margin-top:10px">Eyebrow color</label>
        <div class="color-row">
          <input type="color" id="eyebrow_color_picker" value="{{ old('eyebrow_color', optional($banner)->eyebrow_color ?: '#ffffff') }}" title="Pick color">
          <input id="eyebrow_color" type="text" name="eyebrow_color" value="{{ old('eyebrow_color', optional($banner)->eyebrow_color) }}" placeholder="#ffffff" maxlength="20" data-empty-name="eyebrow_color">
        </div>
      </div>
    </div>

    <div class="field-group" id="fg-title_line1" data-field="title_line1">
      <label class="use-toggle">
        <input type="checkbox" name="use_title_line1" value="1" {{ $hasTitle1 ? 'checked' : '' }} aria-controls="fg-title_line1-inner" class="banner-use-cb">
        <span>Show Title Line 1 on site</span>
      </label>
      <div class="field-group-inner" id="fg-title_line1-inner">
        <label for="title_line1">Title Line 1</label>
        <input id="title_line1" type="text" name="title_line1" value="{{ old('title_line1', optional($banner)->title_line1) }}" placeholder="e.g. Seamless journeys, secure deliveries" data-empty-name="title_line1">
        <label for="title_color" style="margin-top:10px">Title color</label>
        <div class="color-row">
          <input type="color" id="title_color_picker" value="{{ old('title_color', optional($banner)->title_color ?: '#ffffff') }}" title="Pick color">
          <input id="title_color" type="text" name="title_color" value="{{ old('title_color', optional($banner)->title_color) }}" placeholder="#ffffff" maxlength="20" data-empty-name="title_color">
        </div>
      </div>
    </div>

    <div class="field-group" id="fg-title_line2" data-field="title_line2">
      <label class="use-toggle">
        <input type="checkbox" name="use_title_line2" value="1" {{ $hasTitle2 ? 'checked' : '' }} aria-controls="fg-title_line2-inner" class="banner-use-cb">
        <span>Show Title Line 2 on site</span>
      </label>
      <div class="field-group-inner" id="fg-title_line2-inner">
        <label for="title_line2">Title Line 2</label>
        <input id="title_line2" type="text" name="title_line2" value="{{ old('title_line2', optional($banner)->title_line2) }}" placeholder="e.g. Your parcel is not just a package" data-empty-name="title_line2">
        <label for="title_line2_color" style="margin-top:10px">Title Line 2 color</label>
        <div class="color-row">
          <input type="color" id="title_line2_color_picker" value="{{ old('title_line2_color', optional($banner)->title_line2_color ?: '#ffffff') }}" title="Pick color">
          <input id="title_line2_color" type="text" name="title_line2_color" value="{{ old('title_line2_color', optional($banner)->title_line2_color) }}" placeholder="#ffffff" maxlength="20" data-empty-name="title_line2_color">
        </div>
        <small class="help">Empty = same as Title color.</small>
      </div>
    </div>

    <div class="field-group" id="fg-subtitle" data-field="subtitle">
      <label class="use-toggle">
        <input type="checkbox" name="use_subtitle" value="1" {{ $hasSubtitle ? 'checked' : '' }} aria-controls="fg-subtitle-inner" class="banner-use-cb">
        <span>Show Subtitle on site</span>
      </label>
      <div class="field-group-inner" id="fg-subtitle-inner">
        <label for="subtitle">Subtitle</label>
        <textarea id="subtitle" name="subtitle" placeholder="e.g. Safe & Trust & Fast" data-empty-name="subtitle">{{ old('subtitle', optional($banner)->subtitle) }}</textarea>
        <label for="subtitle_color" style="margin-top:10px">Subtitle color</label>
        <div class="color-row">
          <input type="color" id="subtitle_color_picker" value="{{ old('subtitle_color', optional($banner)->subtitle_color ?: '#ffffff') }}" title="Pick color">
          <input id="subtitle_color" type="text" name="subtitle_color" value="{{ old('subtitle_color', optional($banner)->subtitle_color) }}" placeholder="#ffffff" maxlength="20" data-empty-name="subtitle_color">
        </div>
      </div>
    </div>

    <label for="bg_image_url">Background Image URL</label>
    <input id="bg_image_url" type="text" name="bg_image_url" value="{{ old('bg_image_url', optional($banner)->bg_image_url) }}" placeholder="https://...">
    <small class="help">Paste a full image URL or upload an image below.</small>

    <label for="bg_image_file">Background Image Upload</label>
    <input id="bg_image_file" type="file" name="bg_image_file" accept="image/jpeg,image/png,image/webp,image/jpg">
    <small class="help">JPG, PNG or WEBP. Max 6 MB. If upload fails, try a smaller image or check PHP upload limits.</small>

    <label for="bg_image_urls">Additional background images for auto-rotate (one URL per line)</label>
    <textarea id="bg_image_urls" name="bg_image_urls" rows="4" placeholder="https://example.com/image2.jpg&#10;https://example.com/image3.jpg">{{ old('bg_image_urls', ($banner && is_array($banner->bg_image_urls)) ? implode("\n", $banner->bg_image_urls) : '') }}</textarea>
    <small class="help">Add more image URLs to rotate with the main image. Enable "Auto-rotate banner" in Settings.</small>

    @if(!empty(optional($banner)->bg_image_url))
      <div style="margin-top:10px">
        <div style="color:#94a3b8; font-weight:700; font-size:12px; margin-bottom:6px">Current Image Preview</div>
        <img src="{{ asset(
          \Illuminate\Support\Str::startsWith(ltrim((string) optional($banner)->bg_image_url, '/'), 'uploads/')
            ? 'public/'.ltrim((string) optional($banner)->bg_image_url, '/')
            : ltrim((string) optional($banner)->bg_image_url, '/'))
        }}" alt="Banner" style="width:100%; max-width:720px; height:220px; object-fit:cover; border-radius:12px; border:1px solid rgba(148,163,184,.18)">
      </div>
    @endif

    <div class="row">
      <div>
        <label for="banner_height_px">Banner Height (px)</label>
        <input id="banner_height_px" type="number" name="banner_height_px" min="220" max="900" value="{{ old('banner_height_px', optional($banner)->banner_height_px) }}" placeholder="520">
        <small class="help">Recommended: 420 - 620</small>
      </div>
      <div>
        <label for="bg_position">Background Position</label>
        <select id="bg_position" name="bg_position">
          @php $pos = (string)old('bg_position', optional($banner)->bg_position ?: 'center'); @endphp
          @foreach(['center'=>'Center','top'=>'Top','bottom'=>'Bottom','left'=>'Left','right'=>'Right'] as $v=>$lbl)
            <option value="{{ $v }}" {{ $pos===(string)$v ? 'selected' : '' }}>{{ $lbl }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="row">
      <div>
        <label for="banner_content_max_width_px">Banner Content Max Width (px)</label>
        <input id="banner_content_max_width_px" type="number" name="banner_content_max_width_px" min="680" max="1600" value="{{ old('banner_content_max_width_px', optional($banner)->banner_content_max_width_px) }}" placeholder="950">
        <small class="help">Text area width inside banner (not the image). Recommended: 900 - 1100</small>
      </div>
      <div>
        <label for="bg_size">Background Size</label>
        <select id="bg_size" name="bg_size">
          @php $bs = (string)old('bg_size', optional($banner)->bg_size ?: 'cover'); @endphp
          @foreach(['cover'=>'Cover (Full size)','contain'=>'Contain (Fit image)'] as $v=>$lbl)
            <option value="{{ $v }}" {{ $bs===(string)$v ? 'selected' : '' }}>{{ $lbl }}</option>
          @endforeach
        </select>
      </div>
    </div>

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

    <div class="actions page-actions" style="display:flex; flex-wrap:wrap; gap:10px; align-items:center">
      <button class="btn" type="submit">Save Banner</button>
      <a class="btn" href="{{ route('admin.banner.index') }}">Back to list</a>
      <a class="btn" href="/" target="_blank">View Site</a>
    </div>
  </form>

  <script>
    (function(){
      function syncColor(pickerId, textId) {
        var picker = document.getElementById(pickerId);
        var text = document.getElementById(textId);
        if (!picker || !text) return;
        picker.addEventListener('input', function(){ text.value = picker.value; });
        text.addEventListener('input', function(){
          var v = text.value.trim();
          if (/^#[0-9A-Fa-f]{3}$/.test(v)) { v = '#' + v[1]+v[1]+v[2]+v[2]+v[3]+v[3]; }
          if (/^#[0-9A-Fa-f]{6}$/.test(v)) picker.value = v;
        });
      }
      syncColor('eyebrow_color_picker', 'eyebrow_color');
      syncColor('title_color_picker', 'title_color');
      syncColor('subtitle_color_picker', 'subtitle_color');
      syncColor('title_line2_color_picker', 'title_line2_color');

      function toggleFieldGroup(fg) {
        var cb = fg.querySelector('.banner-use-cb');
        var inner = fg.querySelector('.field-group-inner');
        if (!cb || !inner) return;
        var use = cb.checked;
        fg.classList.toggle('disabled', !use);
        var inputs = inner.querySelectorAll('input, textarea, select');
        inputs.forEach(function(inp) { inp.disabled = !use; });
      }
      document.querySelectorAll('.banner-form .field-group').forEach(function(fg) {
        toggleFieldGroup(fg);
        var cb = fg.querySelector('.banner-use-cb');
        if (cb) cb.addEventListener('change', function() { toggleFieldGroup(fg); });
      });
    })();
  </script>
@endsection
