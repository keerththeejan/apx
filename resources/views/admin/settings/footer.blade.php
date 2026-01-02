@extends('admin.layout')

@section('title', 'Footer Settings - Admin')

@section('content')
  <div class="wrap">
    @if(session('status'))
      <div class="status">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
      <div class="error">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <a href="{{ route('admin.dashboard') }}" class="btn" style="margin-bottom:10px">← Back</a>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
      @csrf

      <h2 style="margin-top:0">Footer</h2>

      <label for="footer_logo_file">Footer Logo Image</label>
      <input id="footer_logo_file" type="file" name="footer_logo_file" accept="image/*">
      <div style="font-size:12px; color:var(--muted)">PNG, JPG, WEBP, or SVG up to 4MB.</div>

      <label for="footer_logo_url">Footer Logo URL (optional)</label>
      <input id="footer_logo_url" type="text" name="footer_logo_url" value="{{ old('footer_logo_url', $settings['footer_logo_url']) }}" placeholder="/uploads/logos/footer.png">

      <label for="footer_text">Footer Text</label>
      <input id="footer_text" type="text" name="footer_text" value="{{ old('footer_text', $settings['footer_text']) }}" placeholder="All rights reserved.">

      <label for="footer_newsletter">Footer Newsletter Text</label>
      <input id="footer_newsletter" type="text" name="footer_newsletter" value="{{ old('footer_newsletter', $settings['footer_newsletter'] ?? '') }}" placeholder="Subscribe to get updates about new services and offers.">

      <label for="footer_hours">Working Hours (Footer)</label>
      <input id="footer_hours" type="text" name="footer_hours" value="{{ old('footer_hours', $settings['footer_hours'] ?? '') }}" placeholder="Mon–Fri 9–6">

      <hr style="border:0; border-top:1px solid var(--border); margin:16px 0">
      <h3 style="margin:0 0 8px">Footer About</h3>
      <label for="footer_about_title">About Title</label>
      <input id="footer_about_title" type="text" name="footer_about_title" value="{{ old('footer_about_title', $settings['footer_about_title'] ?? 'About') }}" placeholder="About">

      <label for="footer_about_text">About Text</label>
      <textarea id="footer_about_text" name="footer_about_text" rows="3">{{ old('footer_about_text', $settings['footer_about_text'] ?? '') }}</textarea>

      <div class="row">
        <div>
          <label for="footer_about_link_label">About Link Label</label>
          <input id="footer_about_link_label" type="text" name="footer_about_link_label" value="{{ old('footer_about_link_label', $settings['footer_about_link_label'] ?? '') }}" placeholder="Read more">
        </div>
        <div>
          <label for="footer_about_link_url">About Link URL</label>
          <input id="footer_about_link_url" type="text" name="footer_about_link_url" value="{{ old('footer_about_link_url', $settings['footer_about_link_url'] ?? '') }}" placeholder="https://...">
        </div>
      </div>

      <label style="display:flex; align-items:center; gap:8px">
        <input type="checkbox" name="footer_show_social" value="1" {{ old('footer_show_social', $settings['footer_show_social'] ?? true) ? 'checked' : '' }}> Show social icons under About
      </label>

      <hr style="border:0; border-top:1px solid var(--border); margin:16px 0">
      <h3 style="margin:0 0 8px">Contact</h3>
      <label for="contact_email">Contact Email</label>
      <input id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" placeholder="name@example.com">

      <label for="contact_phone">Contact Phone</label>
      <input id="contact_phone" type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" placeholder="(000) 000-0000">

      <label for="address">Address</label>
      <input id="address" type="text" name="address" value="{{ old('address', $settings['address'] ?? '') }}" placeholder="123 Main St, City">

      <hr style="border:0; border-top:1px solid var(--border); margin:16px 0">
      <h3 style="margin:0 0 8px">Footer Theme</h3>
      <div class="row">
        <div>
          <label for="footer_bg_color">Background Color</label>
          <div style="display:flex; gap:10px; align-items:center">
            <input id="footer_bg_color" type="text" name="footer_bg_color" value="{{ old('footer_bg_color', $settings['footer_bg_color'] ?? '#0b1220') }}" placeholder="#0b1220">
            <input class="js-color" type="color" value="{{ old('footer_bg_color', $settings['footer_bg_color'] ?? '#0b1220') }}" data-target="#footer_bg_color" style="width:54px; height:44px; padding:0; border-radius:10px">
          </div>
        </div>
        <div>
          <label for="footer_text_color">Text Color</label>
          <div style="display:flex; gap:10px; align-items:center">
            <input id="footer_text_color" type="text" name="footer_text_color" value="{{ old('footer_text_color', $settings['footer_text_color'] ?? '#94a3b8') }}" placeholder="#94a3b8">
            <input class="js-color" type="color" value="{{ old('footer_text_color', $settings['footer_text_color'] ?? '#94a3b8') }}" data-target="#footer_text_color" style="width:54px; height:44px; padding:0; border-radius:10px">
          </div>
        </div>
        <div>
          <label for="footer_link_color">Link Color</label>
          <div style="display:flex; gap:10px; align-items:center">
            <input id="footer_link_color" type="text" name="footer_link_color" value="{{ old('footer_link_color', $settings['footer_link_color'] ?? '#cbd5e1') }}" placeholder="#cbd5e1">
            <input class="js-color" type="color" value="{{ old('footer_link_color', $settings['footer_link_color'] ?? '#cbd5e1') }}" data-target="#footer_link_color" style="width:54px; height:44px; padding:0; border-radius:10px">
          </div>
        </div>
      </div>

      <div class="actions" style="margin-top:16px">
        <button class="btn" type="submit">Save Footer</button>
      </div>
    </form>
  </div>

  <script>
    (function(){
      function isHexColor(v){
        return /^#?[0-9a-fA-F]{3}([0-9a-fA-F]{3})?([0-9a-fA-F]{2})?$/.test((v||'').trim());
      }

      document.querySelectorAll('.js-color').forEach((picker) => {
        picker.addEventListener('input', () => {
          const sel = picker.getAttribute('data-target');
          const target = sel ? document.querySelector(sel) : null;
          if (!target) return;
          target.value = picker.value;
        });
      });

      ['#footer_bg_color', '#footer_text_color', '#footer_link_color'].forEach((sel) => {
        const input = document.querySelector(sel);
        if (!input) return;
        input.addEventListener('input', () => {
          const picker = document.querySelector('.js-color[data-target="'+sel+'"]');
          if (!picker) return;
          if (isHexColor(input.value)) {
            picker.value = '#'+input.value.trim().replace('#','');
          }
        });
      });
    })();
  </script>
@endsection
