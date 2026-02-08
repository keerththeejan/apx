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

  <form method="POST" action="{{ route('admin.banner.update') }}" enctype="multipart/form-data">
    @csrf

    <label for="eyebrow">Eyebrow</label>
    <input id="eyebrow" type="text" name="eyebrow" value="{{ old('eyebrow', optional($banner)->eyebrow) }}" placeholder="SAFE TRANSPORTATION & LOGISTICS">

    <label for="title_line1">Title Line 1</label>
    <input id="title_line1" type="text" name="title_line1" value="{{ old('title_line1', optional($banner)->title_line1) }}" placeholder="Adaptable coordinated factors">

    <label for="title_line2">Title Line 2</label>
    <input id="title_line2" type="text" name="title_line2" value="{{ old('title_line2', optional($banner)->title_line2) }}" placeholder="Quick Conveyance">

    <label for="subtitle">Subtitle</label>
    <textarea id="subtitle" name="subtitle" placeholder="Short description for the banner">{{ old('subtitle', optional($banner)->subtitle) }}</textarea>

    <div class="navsec" style="margin-top:20px; margin-bottom:10px">Text colors (banner hero)</div>
    <p style="color:var(--muted); font-size:13px; margin:0 0 12px">Set a specific color for each text line. Use hex (e.g. #ffffff). Leave empty for default white.</p>
    <div class="row">
      <div>
        <label for="eyebrow_color">Eyebrow color</label>
        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap">
          <input type="color" id="eyebrow_color_picker" value="{{ old('eyebrow_color', optional($banner)->eyebrow_color ?? '#ffffff') }}" title="Pick color" style="width:44px; height:36px; padding:2px; cursor:pointer; border-radius:8px; border:1px solid var(--border)">
          <input id="eyebrow_color" type="text" name="eyebrow_color" value="{{ old('eyebrow_color', optional($banner)->eyebrow_color) }}" placeholder="#ffffff" maxlength="20" style="width:120px">
        </div>
      </div>
      <div>
        <label for="title_color">Title color</label>
        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap">
          <input type="color" id="title_color_picker" value="{{ old('title_color', optional($banner)->title_color ?? '#ffffff') }}" title="Pick color" style="width:44px; height:36px; padding:2px; cursor:pointer; border-radius:8px; border:1px solid var(--border)">
          <input id="title_color" type="text" name="title_color" value="{{ old('title_color', optional($banner)->title_color) }}" placeholder="#ffffff" maxlength="20" style="width:120px">
        </div>
      </div>
      <div>
        <label for="subtitle_color">Subtitle color</label>
        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap">
          <input type="color" id="subtitle_color_picker" value="{{ old('subtitle_color', optional($banner)->subtitle_color ?? '#ffffff') }}" title="Pick color" style="width:44px; height:36px; padding:2px; cursor:pointer; border-radius:8px; border:1px solid var(--border)">
          <input id="subtitle_color" type="text" name="subtitle_color" value="{{ old('subtitle_color', optional($banner)->subtitle_color) }}" placeholder="#ffffff" maxlength="20" style="width:120px">
        </div>
      </div>
      <div>
        <label for="title_line2_color">Title Line 2 color</label>
        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap">
          <input type="color" id="title_line2_color_picker" value="{{ old('title_line2_color', optional($banner)->title_line2_color ?? '#ffffff') }}" title="Pick color" style="width:44px; height:36px; padding:2px; cursor:pointer; border-radius:8px; border:1px solid var(--border)">
          <input id="title_line2_color" type="text" name="title_line2_color" value="{{ old('title_line2_color', optional($banner)->title_line2_color) }}" placeholder="#ffffff" maxlength="20" style="width:120px">
        </div>
        <small class="help">Second line of the title. Empty = same as Title color.</small>
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
          @php $pos = (string)old('bg_position', optional($banner)->bg_position ?? 'center'); @endphp
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
          @php $bs = (string)old('bg_size', optional($banner)->bg_size ?? 'cover'); @endphp
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

    <div class="actions">
      <button class="btn" type="submit">Save Banner</button>
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
    })();
  </script>
@endsection
