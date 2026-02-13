@extends('admin.layout')

@section('title', 'Settings - Admin')

@section('content')
  <style>
    .settings-page { width: 100%; max-width: none; margin: 0; padding: 0; box-sizing: border-box; }
    .settings-top { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; }
    .settings-top-inner { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    .settings-top h2 { margin: 0; font-size: 1.5rem; font-weight: 800; }
    .settings-jump { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; padding: 12px 14px; margin-bottom: 20px; background: linear-gradient(180deg, rgba(15,23,42,.95), rgba(2,6,23,.9)); border: 1px solid var(--border); border-radius: var(--radius); position: sticky; top: 70px; z-index: 10; }
    .settings-jump span { color: var(--muted); font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; margin-right: 4px; }
    .settings-jump a { color: var(--text); text-decoration: none; font-size: 13px; font-weight: 600; padding: 8px 14px; border-radius: 999px; white-space: nowrap; background: rgba(148,163,184,.1); border: 1px solid transparent; transition: background .15s, border-color .15s; }
    .settings-jump a:hover { background: rgba(148,163,184,.2); border-color: var(--border); }
    .settings-card { background: linear-gradient(180deg, rgba(15,23,42,.6), rgba(2,6,23,.5)); border: 1px solid var(--border); border-radius: var(--radius); padding: 18px 20px; margin-bottom: 14px; }
    .settings-card h3 { margin: 0 0 4px; font-size: 1.05rem; font-weight: 700; }
    .settings-section-desc { color: var(--muted); font-size: 12px; margin: 0 0 12px; line-height: 1.4; }
    .admin-settings-form .color-row { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    .admin-settings-form .color-row input[type="text"] { flex: 1 1 120px; min-width: 0; }
    .admin-settings-form .color-row input[type="color"] { flex-shrink: 0; width: 54px; height: 44px; padding: 0; border-radius: 10px; }
    .admin-settings-form .font-presets { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px; }
    .admin-settings-form .font-presets .btn { border-radius: 10px; padding: 6px 12px; font-size: 13px; }
    .admin-settings-form .row { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px 14px; align-items: start; }
    .admin-settings-form .row > * { min-width: 0; }
    .admin-settings-form input, .admin-settings-form textarea, .admin-settings-form select { box-sizing: border-box; }
    .admin-settings-form input[type="text"], .admin-settings-form input[type="email"], .admin-settings-form input[type="number"], .admin-settings-form input[type="url"], .admin-settings-form select { width: 100%; max-width: 320px; }
    .admin-settings-form input[type="file"] { max-width: 320px; }
    .admin-settings-form textarea { width: 100%; max-width: 400px; min-height: 56px; resize: vertical; }
    .admin-settings-form .row input, .admin-settings-form .row select, .admin-settings-form .row textarea { max-width: none; }
    .admin-settings-form .actions { margin-top: 4px; }
    .admin-settings-form .help { color: var(--muted); font-size: 11px; margin-top: 2px; display: block; }
    @media (max-width: 980px) {
      .admin-settings-form .row { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 768px) {
      .settings-jump { top: 60px; padding: 10px 12px; gap: 6px; }
      .settings-jump span { display: block; width: 100%; margin-bottom: 6px; }
      .settings-card { padding: 14px 16px; margin-bottom: 12px; }
      .admin-settings-form input[type="text"], .admin-settings-form input[type="email"], .admin-settings-form input[type="number"], .admin-settings-form input[type="url"], .admin-settings-form select, .admin-settings-form input[type="file"] { max-width: 280px; }
      .admin-settings-form textarea { max-width: 100%; }
    }
    @media (max-width: 640px) {
      .settings-top { margin-bottom: 12px; }
      .settings-top h2 { font-size: 1.25rem; }
      .admin-settings-form .row { grid-template-columns: 1fr; gap: 12px; }
      .admin-settings-form input[type="text"], .admin-settings-form input[type="email"], .admin-settings-form input[type="number"], .admin-settings-form input[type="url"], .admin-settings-form select, .admin-settings-form input[type="file"] { max-width: 100%; }
      .admin-settings-form textarea { max-width: 100%; }
      .admin-settings-form .color-row input[type="text"] { flex: 1 1 100%; }
      .admin-settings-form .font-presets { gap: 6px; }
      .admin-settings-form .font-presets .btn { padding: 8px 12px; font-size: 13px; min-height: 40px; }
      .admin-settings-form .actions { flex-direction: column; gap: 8px; }
      .admin-settings-form .actions .btn, .admin-settings-form .actions .logout { width: 100%; text-align: center; }
    }
    @media (max-width: 480px) {
      .settings-jump { padding: 8px 10px; }
      .settings-jump a { padding: 8px 12px; font-size: 12px; }
      .settings-card { padding: 12px 14px; }
      .admin-settings-form input, .admin-settings-form textarea, .admin-settings-form select { padding: 8px 10px; font-size: 15px; min-height: 42px; }
      .admin-settings-form textarea { min-height: 64px; }
      .admin-settings-form label { font-size: 12px; margin-top: 8px; }
      .admin-settings-form .color-row input[type="color"] { width: 44px; height: 38px; min-width: 44px; }
    }
  </style>
  <div class="settings-page">
    @if(session('status'))
      <div class="status">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <div class="settings-top">
      <div class="settings-top-inner">
        <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
        <h2>Settings</h2>
      </div>
    </div>

    <form class="admin-settings-form" method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
      @csrf

      <nav class="settings-jump" aria-label="Jump to section">
        <span>Jump to</span>
        <a href="{{ route('admin.settings.index') }}?section=company#company">Company</a>
        <a href="{{ route('admin.settings.index') }}?section=seo#seo">SEO</a>
        <a href="{{ route('admin.settings.index') }}?section=header#header">Header</a>
        <a href="{{ route('admin.settings.index') }}?section=banner#banner">Banner</a>
        <a href="{{ route('admin.settings.index') }}?section=logo#logo">Logo</a>
        <a href="{{ route('admin.settings.index') }}?section=footer#footer">Footer</a>
        <a href="{{ route('admin.settings.index') }}?section=footer-colors#footer-colors">Footer colors</a>
        <a href="{{ route('admin.settings.index') }}?section=footer-about#footer-about">About</a>
        <a href="#settings-actions">Save</a>
      </nav>

      <div class="settings-card">
          <h3 id="company">Company details</h3>
          <p class="settings-section-desc">Site name and tagline appear in the header. Default theme applies when the user has not chosen a theme.</p>
          <label for="site_name">Site Name</label>
          <input id="site_name" type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" placeholder="Optional">
          <label for="tagline">Tagline</label>
          <input id="tagline" type="text" name="tagline" value="{{ old('tagline', $settings['tagline']) }}" placeholder="Safe Transportation & Logistics">
          <label for="site_default_theme">Default Site Theme</label>
          <select id="site_default_theme" name="site_default_theme">
            @php $siteThemes = ['dark'=>'Dark','light'=>'Light']; @endphp
            @foreach($siteThemes as $val=>$label)
              <option value="{{ $val }}" {{ (string)old('site_default_theme', $settings['site_default_theme'] ?? 'dark')===(string)$val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="settings-card">
          <h3 id="seo">SEO</h3>
          <p class="settings-section-desc">Meta description and keywords for the home page. OG image for social sharing.</p>
          <label for="meta_description">Default meta description</label>
          <textarea id="meta_description" name="meta_description" rows="2" placeholder="Reliable parcel and logistics services…">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
          <label for="meta_keywords">Meta keywords (comma-separated)</label>
          <input id="meta_keywords" type="text" name="meta_keywords" value="{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}" placeholder="parcel, logistics, shipping">
          <label for="og_image">OG image URL</label>
          <input id="og_image" type="text" name="og_image" value="{{ old('og_image', $settings['og_image'] ?? '') }}" placeholder="https://… or /path/to/image.jpg">
      </div>

      <div class="settings-card">
        <h3 id="header">Header</h3>
        <p class="settings-section-desc">Colors and font sizes for the site header. Use presets or fine-tune below.</p>
        <div class="font-presets">
          <button type="button" class="btn font-preset" data-brand="14" data-tagline="12">Small</button>
          <button type="button" class="btn font-preset" data-brand="18" data-tagline="14">Medium</button>
          <button type="button" class="btn font-preset" data-brand="24" data-tagline="16">Large</button>
          <button type="button" class="btn font-preset" data-brand="32" data-tagline="18">Extra large</button>
        </div>
        <div class="row">
          <div>
            <label for="header_bg_color">Background Color</label>
            <div class="color-row">
              <input id="header_bg_color" type="text" name="header_bg_color" value="{{ old('header_bg_color', $settings['header_bg_color'] ?? '#0b1220') }}" placeholder="#0b1220">
              <input class="js-color" type="color" value="{{ old('header_bg_color', $settings['header_bg_color'] ?? '#0b1220') }}" data-target="#header_bg_color" style="width:54px; height:44px; padding:0; border-radius:10px">
            </div>
          </div>
          <div>
            <label for="header_border_color">Border Color</label>
            <div class="color-row">
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
            <label for="header_link_color">Link Color</label>
            <div class="color-row">
              <input id="header_link_color" type="text" name="header_link_color" value="{{ old('header_link_color', $settings['header_link_color'] ?? '#94a3b8') }}" placeholder="#94a3b8">
              <input class="js-color" type="color" value="{{ old('header_link_color', $settings['header_link_color'] ?? '#94a3b8') }}" data-target="#header_link_color" style="width:54px; height:44px; padding:0; border-radius:10px">
            </div>
          </div>
        </div>
        <div class="row" style="margin-top:12px">
          <div>
            <label for="header_text_color">Text Color</label>
            <div class="color-row">
              <input id="header_text_color" type="text" name="header_text_color" value="{{ old('header_text_color', $settings['header_text_color'] ?? '#e2e8f0') }}" placeholder="#e2e8f0">
              <input class="js-color" type="color" value="{{ old('header_text_color', $settings['header_text_color'] ?? '#e2e8f0') }}" data-target="#header_text_color" style="width:54px; height:44px; padding:0; border-radius:10px">
            </div>
          </div>
          <div>
            <label for="header_tagline_color">Tagline Color</label>
            <div class="color-row">
              <input id="header_tagline_color" type="text" name="header_tagline_color" value="{{ old('header_tagline_color', $settings['header_tagline_color'] ?? '#94a3b8') }}" placeholder="#94a3b8">
              <input class="js-color" type="color" value="{{ old('header_tagline_color', $settings['header_tagline_color'] ?? '#94a3b8') }}" data-target="#header_tagline_color" style="width:54px; height:44px; padding:0; border-radius:10px">
            </div>
          </div>
          <div>
            <label for="header_brand_font_size">Brand Font Size (px)</label>
            <input id="header_brand_font_size" type="number" min="12" max="96" step="1" name="header_brand_font_size" value="{{ old('header_brand_font_size', $settings['header_brand_font_size'] ?? 16) }}">
            <span class="help">12–96 px</span>
          </div>
          <div>
            <label for="header_tagline_font_size">Tagline Font Size (px)</label>
            <input id="header_tagline_font_size" type="number" min="10" max="48" step="1" name="header_tagline_font_size" value="{{ old('header_tagline_font_size', $settings['header_tagline_font_size'] ?? 14) }}">
            <span class="help">10–48 px</span>
          </div>
          <div>
            <label for="header_brand_font_weight">Brand Font Weight</label>
            <select id="header_brand_font_weight" name="header_brand_font_weight">
              @php $weights = ['100'=>'100 (Thin)','200'=>'200 (Extra light)','300'=>'300 (Light)','400'=>'400 (Normal)','500'=>'500 (Medium)','600'=>'600 (Semi bold)','700'=>'700 (Bold)','800'=>'800 (Extra bold)','900'=>'900 (Black)']; @endphp
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
          <div>
            <label for="header_menu_font_size">Menu Font Size (px)</label>
            <input id="header_menu_font_size" type="number" min="11" max="24" step="1" name="header_menu_font_size" value="{{ old('header_menu_font_size', $settings['header_menu_font_size'] ?? 14) }}">
            <span class="help">11–24 px. Applies to nav links (Track, Login, etc.) and tagline in header.</span>
          </div>
        </div>
      </div>

      <div class="settings-card">
          <h3 id="banner">Banner</h3>
          <p class="settings-section-desc">Auto-rotate home page banner images. Manage banners in Banner Management.</p>
          <label style="display:flex; gap:8px; align-items:center; margin-bottom:10px">
            <input type="checkbox" name="banner_auto_rotate" value="1" {{ old('banner_auto_rotate', data_get($settings, 'banner_auto_rotate', true)) ? 'checked' : '' }}> Auto-rotate banner images
          </label>
          <label for="banner_rotate_interval_sec">Rotate interval (seconds)</label>
          <input id="banner_rotate_interval_sec" type="number" name="banner_rotate_interval_sec" min="2" max="30" value="{{ old('banner_rotate_interval_sec', data_get($settings, 'banner_rotate_interval_sec', 5)) }}" style="max-width:120px">
          <span class="help">2–30 seconds. Add banners in Banners.</span>
      </div>

      <div class="settings-card">
          <h3 id="logo">Logo</h3>
          <p class="settings-section-desc">Header logo. Upload or paste URL.</p>
          <label for="logo_file">Logo Image</label>
          <input id="logo_file" type="file" name="logo_file" accept="image/*">
          <span class="help">PNG, JPG, WEBP, or SVG up to 4MB.</span>
          <label for="logo_url">Logo URL (optional)</label>
          <input id="logo_url" type="text" name="logo_url" value="{{ old('logo_url', $settings['logo_url']) }}" placeholder="https://…">
      </div>

      <div class="settings-card">
        <h3 id="footer">Footer & Contact</h3>
        <p class="settings-section-desc">Footer logo, contact info, and default text. Shown site-wide.</p>
        <label for="footer_logo_file">Footer Logo Image</label>
        <input id="footer_logo_file" type="file" name="footer_logo_file" accept="image/*">
        <span class="help">PNG, JPG, WEBP, or SVG up to 4MB.</span>
        <label for="footer_logo_url">Footer Logo URL (optional)</label>
        <input id="footer_logo_url" type="text" name="footer_logo_url" value="{{ old('footer_logo_url', $settings['footer_logo_url'] ?? null) }}" placeholder="https://…">
        <div class="row" style="margin-top:14px">
          <div>
            <label for="contact_email">Contact Email</label>
            <input id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}">
          </div>
          <div>
            <label for="contact_phone">Contact Phone</label>
            <input id="contact_phone" type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}">
          </div>
          <div>
            <label for="whatsapp_number">WhatsApp Number</label>
            <input id="whatsapp_number" type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}" placeholder="94771234567">
            <span class="help">Digits + country code. Used after quotation.</span>
          </div>
        </div>
        <label for="address">Address</label>
        <textarea id="address" name="address" rows="2">{{ old('address', $settings['address']) }}</textarea>
        <label for="footer_text">Footer Text</label>
        <input id="footer_text" type="text" name="footer_text" value="{{ old('footer_text', $settings['footer_text']) }}" placeholder="All rights reserved.">
        <label for="footer_newsletter">Footer Newsletter Text</label>
        <input id="footer_newsletter" type="text" name="footer_newsletter" value="{{ old('footer_newsletter', $settings['footer_newsletter'] ?? '') }}" placeholder="Subscribe to get updates…">
        <label for="footer_hours">Working Hours</label>
        <input id="footer_hours" type="text" name="footer_hours" value="{{ old('footer_hours', $settings['footer_hours'] ?? '') }}" placeholder="Mon–Fri 9–6">
      </div>

      <div class="settings-card">
          <h3 id="footer-about">Footer About</h3>
          <p class="settings-section-desc">About block and link in the footer.</p>
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

      <div class="settings-card" id="footer-colors">
          <h3>Footer color management</h3>
          <p class="settings-section-desc">Control the site footer background, text, links, and top border. Use hex (e.g. #d83526) or leave default.</p>
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
          @php
            $fborder = old('footer_border_color', $settings['footer_border_color'] ?? '');
            $fborderHex = (is_string($fborder) && preg_match('/^#?([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', trim($fborder))) ? ('#'.ltrim(trim($fborder), '#')) : '#1e293b';
          @endphp
          <div style="margin-top:12px">
            <label for="footer_border_color">Top border color</label>
            <div class="color-row">
              <input id="footer_border_color" type="text" name="footer_border_color" value="{{ old('footer_border_color', $settings['footer_border_color'] ?? '') }}" placeholder="e.g. #1e293b or rgba(0,0,0,.2)">
              <input class="js-color" type="color" value="{{ $fborderHex }}" data-target="#footer_border_color" style="width:54px; height:44px; padding:0; border-radius:10px">
            </div>
            <span class="help">Optional. Line above the footer. Hex or rgba. Empty = subtle default.</span>
          </div>
          <p style="margin-top:14px; margin-bottom:0"><a href="{{ route('admin.settings.footer') }}" class="btn">Full Footer Settings →</a></p>
      </div>

      <div class="settings-card">
          <h3>Admin Theme</h3>
          <p class="settings-section-desc">Default theme for this admin panel.</p>
          <label for="default_theme">Theme</label>
          <select id="default_theme" name="default_theme">
            @php $themes = ['dark'=>'Dark','slate'=>'Slate','indigo'=>'Indigo','emerald'=>'Emerald','rose'=>'Rose','amber'=>'Amber','sky'=>'Sky','violet'=>'Violet']; @endphp
            @foreach($themes as $val=>$label)
              <option value="{{ $val }}" {{ old('default_theme', $settings['default_theme'])===$val? 'selected':'' }}>{{ $label }}</option>
            @endforeach
          </select>
      </div>

      <div class="settings-card" style="margin-bottom:0">
        <div class="actions" id="settings-actions">
          <button class="btn" type="submit">Save Settings</button>
          <a class="btn" href="{{ route('admin.dashboard') }}">Cancel</a>
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

      ['#header_text_color', '#header_tagline_color', '#footer_bg_color', '#footer_text_color', '#footer_link_color', '#footer_border_color'].forEach((sel) => {
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

      document.querySelectorAll('.font-preset').forEach((btn) => {
        btn.addEventListener('click', () => {
          const brand = document.getElementById('header_brand_font_size');
          const tagline = document.getElementById('header_tagline_font_size');
          if (brand) brand.value = btn.getAttribute('data-brand') || brand.value;
          if (tagline) tagline.value = btn.getAttribute('data-tagline') || tagline.value;
        });
      });
    })();

    (function(){
      var hash = window.location.hash.replace('#', '');
      var search = window.location.search || '';
      var section = (search.match(/section=([^&]+)/) || [])[1] || hash;
      var ids = ['company', 'seo', 'header', 'banner', 'logo', 'footer', 'footer-colors', 'footer-about', 'settings-actions'];
      if (section && ids.indexOf(section) !== -1) {
        var el = document.getElementById(section);
        if (el) {
          setTimeout(function(){ el.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 100);
          if (search.indexOf('section=') !== -1) {
            try { history.replaceState(null, '', window.location.pathname + '#' + section); } catch (e) {}
          }
        }
      }
    })();
  </script>
@endsection
