@extends('admin.layout')

@section('title', 'Footer Settings - Admin')

@section('content')
  <style>
    .settings-page { width: 100%; max-width: none; margin: 0; padding: 0; box-sizing: border-box; }
    .settings-top { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 18px; }
    .settings-top h2 { margin: 0; font-size: 1.5rem; font-weight: 800; }
    .settings-card { background: linear-gradient(180deg, rgba(15,23,42,.6), rgba(2,6,23,.5)); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; margin-bottom: 20px; }
    .settings-card h3 { margin: 0 0 6px; font-size: 1.1rem; font-weight: 700; }
    .settings-section-desc { color: var(--muted); font-size: 13px; margin: 0 0 14px; line-height: 1.45; }
    .footer-settings-form .row { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; align-items: start; }
    .footer-settings-form .row > * { min-width: 0; }
    .footer-settings-form .color-row { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    .footer-settings-form .color-row input[type="text"] { flex: 1 1 120px; min-width: 0; }
    .footer-settings-form .color-row input[type="color"] { flex-shrink: 0; width: 54px; height: 44px; padding: 0; border-radius: 10px; }
    .footer-settings-form .help { color: var(--muted); font-size: 12px; margin-top: 4px; display: block; }
    @media (max-width: 768px) { .footer-settings-form .row { grid-template-columns: 1fr; } .settings-card { padding: 16px; } }
    @media (max-width: 480px) {
      .footer-settings-form input, .footer-settings-form textarea { padding: 10px 12px; font-size: 16px; min-height: 44px; }
      .footer-settings-form .color-row input[type="color"] { width: 48px; height: 40px; }
    }
  </style>
  <div class="settings-page">
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

    <div class="settings-top">
      <a href="{{ route('admin.dashboard') }}" class="btn">Back</a>
      <h2>Footer Settings</h2>
    </div>

    <form class="footer-settings-form" method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
      @csrf

      <div class="settings-card">
        <h3>Footer Logo & Text</h3>
        <p class="settings-section-desc">Logo and default copy shown in the site footer.</p>
        <label for="footer_logo_file">Footer Logo Image</label>
        <input id="footer_logo_file" type="file" name="footer_logo_file" accept="image/*">
        <span class="help">PNG, JPG, WEBP, or SVG up to 4MB.</span>
        <label for="footer_logo_url">Footer Logo URL (optional)</label>
        <input id="footer_logo_url" type="text" name="footer_logo_url" value="{{ old('footer_logo_url', $settings['footer_logo_url']) }}" placeholder="/uploads/logos/footer.png">
        <label for="footer_text">Footer Text</label>
        <input id="footer_text" type="text" name="footer_text" value="{{ old('footer_text', $settings['footer_text']) }}" placeholder="All rights reserved.">
        <label for="footer_newsletter">Footer Newsletter Text</label>
        <input id="footer_newsletter" type="text" name="footer_newsletter" value="{{ old('footer_newsletter', $settings['footer_newsletter'] ?? '') }}" placeholder="Subscribe to get updates…">
        <label for="footer_hours">Working Hours</label>
        <input id="footer_hours" type="text" name="footer_hours" value="{{ old('footer_hours', $settings['footer_hours'] ?? '') }}" placeholder="Mon–Fri 9–6">
      </div>

      <div class="settings-card">
        <h3>Footer About</h3>
        <p class="settings-section-desc">About block and optional link in the footer.</p>
        <label for="footer_about_title">About Title</label>
        <input id="footer_about_title" type="text" name="footer_about_title" value="{{ old('footer_about_title', $settings['footer_about_title'] ?? 'About') }}" placeholder="About">
        <label for="footer_about_text">About Text</label>
        <textarea id="footer_about_text" name="footer_about_text" rows="3">{{ old('footer_about_text', $settings['footer_about_text'] ?? '') }}</textarea>
        <div class="row" style="margin-top:12px">
          <div>
            <label for="footer_about_link_label">Link Label</label>
            <input id="footer_about_link_label" type="text" name="footer_about_link_label" value="{{ old('footer_about_link_label', $settings['footer_about_link_label'] ?? '') }}" placeholder="Read more">
          </div>
          <div>
            <label for="footer_about_link_url">Link URL</label>
            <input id="footer_about_link_url" type="text" name="footer_about_link_url" value="{{ old('footer_about_link_url', $settings['footer_about_link_url'] ?? '') }}" placeholder="https://…">
          </div>
        </div>
        <label style="display:flex; align-items:center; gap:8px; margin-top:12px">
          <input type="checkbox" name="footer_show_social" value="1" {{ old('footer_show_social', $settings['footer_show_social'] ?? true) ? 'checked' : '' }}> Show social icons under About
        </label>
      </div>

      <div class="settings-card">
        <h3>Contact</h3>
        <p class="settings-section-desc">Contact details shown in the footer.</p>
        <label for="contact_email">Contact Email</label>
        <input id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" placeholder="name@example.com">
        <label for="contact_phone">Contact Phone</label>
        <input id="contact_phone" type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" placeholder="(000) 000-0000">
        <label for="address">Address</label>
        <input id="address" type="text" name="address" value="{{ old('address', $settings['address'] ?? '') }}" placeholder="123 Main St, City">
      </div>

      <div class="settings-card">
        <h3>Footer color management</h3>
        <p class="settings-section-desc">Background, text, link, and top border colors for the site footer.</p>
        <div class="row">
          <div>
            <label for="footer_bg_color">Background</label>
            <div class="color-row">
              <input id="footer_bg_color" type="text" name="footer_bg_color" value="{{ old('footer_bg_color', $settings['footer_bg_color'] ?? '#0b1220') }}" placeholder="#0b1220 or #d83526">
              <input class="js-color" type="color" value="{{ old('footer_bg_color', $settings['footer_bg_color'] ?? '#0b1220') }}" data-target="#footer_bg_color" style="width:54px; height:44px; padding:0; border-radius:10px">
            </div>
          </div>
          <div>
            <label for="footer_text_color">Text color</label>
            <div class="color-row">
              <input id="footer_text_color" type="text" name="footer_text_color" value="{{ old('footer_text_color', $settings['footer_text_color'] ?? '#94a3b8') }}" placeholder="#94a3b8">
              <input class="js-color" type="color" value="{{ old('footer_text_color', $settings['footer_text_color'] ?? '#94a3b8') }}" data-target="#footer_text_color" style="width:54px; height:44px; padding:0; border-radius:10px">
            </div>
          </div>
          <div>
            <label for="footer_link_color">Link color</label>
            <div class="color-row">
              <input id="footer_link_color" type="text" name="footer_link_color" value="{{ old('footer_link_color', $settings['footer_link_color'] ?? '#cbd5e1') }}" placeholder="#cbd5e1">
              <input class="js-color" type="color" value="{{ old('footer_link_color', $settings['footer_link_color'] ?? '#cbd5e1') }}" data-target="#footer_link_color" style="width:54px; height:44px; padding:0; border-radius:10px">
            </div>
          </div>
        </div>
        @php $fborder = old('footer_border_color', $settings['footer_border_color'] ?? ''); $fborderHex = (is_string($fborder) && preg_match('/^#?([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', trim($fborder))) ? ('#'.ltrim(trim($fborder), '#')) : '#1e293b'; @endphp
        <div style="margin-top:12px">
          <label for="footer_border_color">Top border color</label>
          <div class="color-row">
            <input id="footer_border_color" type="text" name="footer_border_color" value="{{ old('footer_border_color', $settings['footer_border_color'] ?? '') }}" placeholder="#1e293b or rgba(0,0,0,.2)">
            <input class="js-color" type="color" value="{{ $fborderHex }}" data-target="#footer_border_color" style="width:54px; height:44px; padding:0; border-radius:10px">
          </div>
          <span class="help">Line above the footer. Hex or rgba. Empty = default.</span>
        </div>
      </div>

      <div class="settings-card" style="margin-bottom:0">
        <div class="actions">
          <button class="btn" type="submit">Save Footer</button>
          <a class="btn" href="{{ route('admin.settings.index') }}">All Settings</a>
        </div>
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

      ['#footer_bg_color', '#footer_text_color', '#footer_link_color', '#footer_border_color'].forEach((sel) => {
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
