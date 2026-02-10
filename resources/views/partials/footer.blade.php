<footer class="footer">
  @php
    $aboutText = $cfgFooter ?? 'All rights reserved.'; // legacy footer text
    $contactEmail = optional(\App\Models\Setting::where('key','contact_email')->first())->value;
    $contactPhone = optional(\App\Models\Setting::where('key','contact_phone')->first())->value;
    $contactAddr  = optional(\App\Models\Setting::where('key','address')->first())->value;
    $footerLogo = optional(\App\Models\Setting::where('key','footer_logo_url')->first())->value;
    $footerNews = optional(\App\Models\Setting::where('key','footer_newsletter')->first())->value;
    $footerHours = optional(\App\Models\Setting::where('key','footer_hours')->first())->value;
    $aboutTitle = optional(\App\Models\Setting::where('key','footer_about_title')->first())->value ?? 'About';
    $aboutBody  = optional(\App\Models\Setting::where('key','footer_about_text')->first())->value;
    $aboutLinkLabel = optional(\App\Models\Setting::where('key','footer_about_link_label')->first())->value;
    $aboutLinkUrl   = optional(\App\Models\Setting::where('key','footer_about_link_url')->first())->value;
    $showSocial = (bool) (optional(\App\Models\Setting::where('key','footer_show_social')->first())->value ?? true);
    $ftBg = optional(\App\Models\Setting::where('key','footer_bg_color')->first())->value ?? '#0b1220';
    $ftText = optional(\App\Models\Setting::where('key','footer_text_color')->first())->value ?? '#94a3b8';
    $ftLink = optional(\App\Models\Setting::where('key','footer_link_color')->first())->value ?? '#cbd5e1';
    $footerLinks = collect();
    if (\Illuminate\Support\Facades\Schema::hasTable('footer_links')) {
      $footerLinks = \App\Models\FooterLink::where('is_visible',true)->orderBy('sort_order')->orderBy('id')->get();
    }
    $social = collect();
    if (\Illuminate\Support\Facades\Schema::hasTable('social_links')) {
      $social = \App\Models\SocialLink::where('is_visible',true)->orderBy('sort_order')->orderBy('id')->get();
    }

    $footerBgEffective = $ftBg ?: ($cfgHeaderBg ?: '#0b1220');
    $footerTextEffective = $ftText ?: '#94a3b8';
    $footerLinkEffective = $ftLink ?: '#cbd5e1';
    $footerBorderEffective = $cfgHeaderBorder ?: 'rgba(148,163,184,.12)';
  @endphp

  <div style="width:100%; margin:0; padding:0; background: {{ $footerBgEffective }}; color: {{ $footerTextEffective }}; border-top:1px solid {{ $footerBorderEffective }}">
    <div class="footer-inner">
      <div class="footer-grid">
        <div class="footer-col">
          @if(!empty($footerLogo))
            <div class="footer-logo"><a href="{{ url('/') }}" style="display:inline-block; color:inherit; text-decoration:none"><img src="{{ $toUrl($footerLogo) }}" alt="{{ $cfgName ?? 'Logo' }}" style="border-color: rgba(255,255,255,.2)"></a></div>
          @elseif(!empty($cfgLogo))
            <div class="footer-logo"><a href="{{ url('/') }}" style="display:inline-block; color:inherit; text-decoration:none"><img src="{{ $toUrl($cfgLogo) }}" alt="{{ $cfgName ?? 'Logo' }}" style="border-color: rgba(255,255,255,.2)"></a></div>
          @else
            <div class="footer-brand-text">
              <a href="{{ url('/') }}" style="color:inherit; text-decoration:none">
                <span class="footer-brand-name" style="color: {{ $footerTextEffective }}">{{ $cfgName ?? 'apx' }}</span>
                @if(!empty($cfgTag))<small class="footer-brand-tagline" style="color: {{ $footerTextEffective }}">{{ $cfgTag }}</small>@endif
              </a>
            </div>
          @endif
          <h4 style="color: {{ $footerTextEffective }}">{{ $aboutTitle }}</h4>
          @if(!empty($aboutBody))
            <p style="color: {{ $footerTextEffective }}">{{ $aboutBody }}</p>
          @else
            <p style="color: {{ $footerTextEffective }}">{{ $aboutText }}</p>
          @endif
          @if(!empty($aboutLinkLabel) && !empty($aboutLinkUrl))
            <p style="margin-top:10px"><a href="{{ $aboutLinkUrl }}" style="color: {{ $footerLinkEffective }}">{{ $aboutLinkLabel }} →</a></p>
          @endif
          @if($showSocial)
            <div class="footer-social">
              @forelse($social as $s)
                <a href="{{ $s->url }}" target="_blank" rel="noopener" title="{{ $s->label }}" style="color: {{ $footerLinkEffective }}">{{ $s->icon ?? '🔗' }}</a>
              @empty
              @endforelse
            </div>
          @endif
        </div>

        <div class="footer-col">
          <h4 style="color: {{ $footerTextEffective }}">Services</h4>
          <ul style="color: {{ $footerTextEffective }}">
            @if(isset($services) && $services->count())
              @foreach($services as $svc)
                <li><a href="#" style="color: {{ $footerLinkEffective }}">{{ $svc->title }}</a></li>
              @endforeach
            @else
              <li><a href="#" style="color: {{ $footerLinkEffective }}">Air Freight</a></li>
              <li><a href="#" style="color: {{ $footerLinkEffective }}">Ocean Freight</a></li>
            @endif
          </ul>
        </div>

        <div class="footer-col">
          <h4 style="color: {{ $footerTextEffective }}">Quick Links</h4>
          <ul style="color: {{ $footerTextEffective }}">
            @forelse($footerLinks as $fl)
              <li><a href="{{ $fl->url }}" style="color: {{ $footerLinkEffective }}">{{ $fl->label }}</a></li>
            @empty
              <li><a href="#" style="color: {{ $footerLinkEffective }}">Privacy Policy</a></li>
              <li><a href="#" style="color: {{ $footerLinkEffective }}">Terms of Service</a></li>
            @endforelse
          </ul>
        </div>

        <div class="footer-col">
          <h4 style="color: {{ $footerTextEffective }}">Contact Us</h4>
          <ul style="color: {{ $footerTextEffective }}">
            @if($contactAddr)<li>📍 {{ $contactAddr }}</li>@endif
            @if($contactPhone)<li>📞 {{ $contactPhone }}</li>@endif
            @if($contactEmail)<li>✉️ {{ $contactEmail }}</li>@endif
            @if($footerHours)<li>🕑 {{ $footerHours }}</li>@endif
          </ul>
        </div>
      </div>

      <div class="footer-bottom" style="color: {{ $footerTextEffective }}">
        <span>© <span id="year"></span> {{ $cfgName ?? 'Parcel Transport' }}. {{ $aboutText }}</span>
      </div>
    </div>
  </div>
</footer>

