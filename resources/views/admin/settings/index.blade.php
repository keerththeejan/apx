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

      <label for="site_default_theme">Default Site Theme</label>
      <select id="site_default_theme" name="site_default_theme">
        @php $siteThemes = ['dark'=>'Dark','light'=>'Light']; @endphp
        @foreach($siteThemes as $val=>$label)
          <option value="{{ $val }}" {{ (string)old('site_default_theme', $settings['site_default_theme'] ?? 'dark')===(string)$val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
      </select>

      <hr style="border:0; border-top:1px solid var(--border); margin:16px 0">
      <h3 style="margin:0 0 8px">Header</h3>
      <div class="row">
        <div>
          <label for="header_bg_color">Header Background Color</label>
          <div style="display:flex; gap:10px; align-items:center">
            <input id="header_bg_color" type="text" name="header_bg_color" value="{{ old('header_bg_color', $settings['header_bg_color'] ?? '#0b1220') }}" placeholder="#0b1220">
            <input class="js-color" type="color" value="{{ old('header_bg_color', $settings['header_bg_color'] ?? '#0b1220') }}" data-target="#header_bg_color" style="width:54px; height:44px; padding:0; border-radius:10px">
          </div>
        </div>
        <div>
          <label for="header_border_color">Header Border Color</label>
          <div style="display:flex; gap:10px; align-items:center">
            <input id="header_border_color" type="text" name="header_border_color" value="{{ old('header_border_color', $settings['header_border_color'] ?? 'rgba(148,163,184,.12)') }}" placeholder="rgba(148,163,184,.12)">
            @php
              $hdrBorder = (string) old('header_border_color', $settings['header_border_color'] ?? 'rgba(148,163,184,.12)');
              $hdrBorderHex = '#94a3b8';
              if (preg_match('/^\s*#?[0-9a-fA-F]{3,8}\s*$/', $hdrBorder)) {
                $hdrBorderHex = '#'.ltrim(trim($hdrBorder),'#');
              }
            @endphp
            <input class="js-color" type="color" value="{{ $hdrBorderHex }}" data-target="#header_border_color" style="width:54px; height:44px; padding:0; border-radius:10px">
          </div>
        </div>
        <div>
          <label for="header_link_color">Header Link Color</label>
          <div style="display:flex; gap:10px; align-items:center">
            <input id="header_link_color" type="text" name="header_link_color" value="{{ old('header_link_color', $settings['header_link_color'] ?? '#94a3b8') }}" placeholder="#94a3b8">
            <input class="js-color" type="color" value="{{ old('header_link_color', $settings['header_link_color'] ?? '#94a3b8') }}" data-target="#header_link_color" style="width:54px; height:44px; padding:0; border-radius:10px">
          </div>
        </div>
      </div>

      <div class="row" style="margin-top:12px">
        <div>
          <label for="header_text_color">Header Text Color</label>
          <div style="display:flex; gap:10px; align-items:center">
            <input id="header_text_color" type="text" name="header_text_color" value="{{ old('header_text_color', $settings['header_text_color'] ?? '#e2e8f0') }}" placeholder="#e2e8f0">
            <input class="js-color" type="color" value="{{ old('header_text_color', $settings['header_text_color'] ?? '#e2e8f0') }}" data-target="#header_text_color" style="width:54px; height:44px; padding:0; border-radius:10px">
          </div>
        </div>
        <div>
          <label for="header_tagline_color">Header Tagline Color</label>
          <div style="display:flex; gap:10px; align-items:center">
            <input id="header_tagline_color" type="text" name="header_tagline_color" value="{{ old('header_tagline_color', $settings['header_tagline_color'] ?? '#94a3b8') }}" placeholder="#94a3b8">
            <input class="js-color" type="color" value="{{ old('header_tagline_color', $settings['header_tagline_color'] ?? '#94a3b8') }}" data-target="#header_tagline_color" style="width:54px; height:44px; padding:0; border-radius:10px">
          </div>
        </div>
        <div>
          <label for="header_brand_font_size">Brand Font Size (px)</label>
          <input id="header_brand_font_size" type="number" min="12" max="48" step="1" name="header_brand_font_size" value="{{ old('header_brand_font_size', $settings['header_brand_font_size'] ?? 16) }}">
        </div>
      </div>

      <div class="row" style="margin-top:12px">
        <div>
          <label for="header_brand_font_weight">Brand Font Weight</label>
          <select id="header_brand_font_weight" name="header_brand_font_weight">
            @php $weights = ['400'=>'400','500'=>'500','600'=>'600','700'=>'700','800'=>'800']; @endphp
            @foreach($weights as $val=>$label)
              <option value="{{ $val }}" {{ (string)old('header_brand_font_weight', $settings['header_brand_font_weight'] ?? '800')===(string)$val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label for="header_brand_font_style">Brand Font Style</label>
          <select id="header_brand_font_style" name="header_brand_font_style">
            @php $styles = ['normal'=>'Normal','italic'=>'Italic']; @endphp
            @foreach($styles as $val=>$label)
              <option value="{{ $val }}" {{ (string)old('header_brand_font_style', $settings['header_brand_font_style'] ?? 'normal')===(string)$val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div></div>
      </div>

      <label for="logo_file">Logo Image</label>
      <input id="logo_file" type="file" name="logo_file" accept="image/*">
      <div style="color:#94a3b8; font-size:12px; margin-top:6px">PNG, JPG, WEBP, or SVG up to 4MB.</div>
      <label for="logo_url">Logo URL (optional)</label>
      <input id="logo_url" type="text" name="logo_url" value="{{ old('logo_url', $settings['logo_url']) }}" placeholder="https://..." />

      <hr style="border:0; border-top:1px solid var(--border); margin:16px 0">
      <h3 style="margin:0 0 8px">Footer</h3>
      <label for="footer_logo_file">Footer Logo Image</label>
      <input id="footer_logo_file" type="file" name="footer_logo_file" accept="image/*">
      <div style="color:#94a3b8; font-size:12px; margin-top:6px">PNG, JPG, WEBP, or SVG up to 4MB.</div>
      <label for="footer_logo_url">Footer Logo URL (optional)</label>
      <input id="footer_logo_url" type="text" name="footer_logo_url" value="{{ old('footer_logo_url', $settings['footer_logo_url'] ?? null) }}" placeholder="https://..." />

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

      ['#header_bg_color', '#header_border_color', '#header_link_color'].forEach((sel) => {
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

      ['#header_text_color', '#header_tagline_color'].forEach((sel) => {
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
