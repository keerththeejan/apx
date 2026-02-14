<header class="topbar" style="{{ !empty($cfgHeaderBg) ? '--header-bg: '.$cfgHeaderBg.';' : '' }}{{ !empty($cfgHeaderBorder) ? '--header-border: '.$cfgHeaderBorder.';' : '' }}{{ !empty($cfgHeaderLink) ? '--header-link: '.$cfgHeaderLink.';' : '' }}{{ !empty($cfgHeaderText) ? '--header-text: '.$cfgHeaderText.';' : '' }}{{ !empty($cfgHeaderTagline) ? '--header-tagline: '.$cfgHeaderTagline.';' : '' }}{{ !empty($cfgBrandSize) ? '--brand-size: '.(int)$cfgBrandSize.'px;' : '' }}{{ !empty($cfgTaglineSize) ? '--tagline-size: '.(int)$cfgTaglineSize.'px;' : '' }}{{ isset($cfgMenuFontSize) && $cfgMenuFontSize !== '' ? '--menu-size: '.(int)$cfgMenuFontSize.'px;' : '' }}{{ !empty($cfgBrandWeight) ? '--brand-weight: '.$cfgBrandWeight.';' : '' }}{{ !empty($cfgBrandStyle) ? '--brand-style: '.$cfgBrandStyle.';' : '' }}">
  <div class="nav">
    <div class="header-left">
      <div class="brand">
        @if(!empty($logoSrc))
          <img src="{{ $logoSrc }}" alt="Logo">
        @else
          <span>📦</span>
        @endif
        <span>{{ $cfgName ?? 'apx.lk' }}</span>
      </div>
      @if(trim((string)($cfgTag ?? '')) !== '')
        <span class="header-tagline">{{ $cfgTag }}</span>
      @endif
      <div class="header-menu">
        @php $localeM = app()->getLocale(); $langLabelM = $localeM === 'en' ? 'EN' : ($localeM === 'ta' ? 'தமிழ்' : 'සිංහල'); @endphp
        <div class="lang-switcher-mobile lang-in-header-mobile" aria-label="{{ __('site.language') }}">
          <div class="lang-dropdown" tabindex="-1">
            <button type="button" class="lang-dropdown-trigger" aria-expanded="false" aria-haspopup="true" aria-label="{{ __('site.language') }}">
              <span class="lang-globe" aria-hidden="true">🌐</span>
              <span class="lang-current">{{ $langLabelM }}</span>
            </button>
            <div class="lang-dropdown-menu" role="menu">
              <a href="{{ route('locale.switch', ['locale' => 'en']) }}" role="menuitem" class="{{ $localeM === 'en' ? 'active' : '' }}">EN</a>
              <a href="{{ route('locale.switch', ['locale' => 'ta']) }}" role="menuitem" class="{{ $localeM === 'ta' ? 'active' : '' }}">தமிழ்</a>
              <a href="{{ route('locale.switch', ['locale' => 'si']) }}" role="menuitem" class="{{ $localeM === 'si' ? 'active' : '' }}">සිංහල</a>
            </div>
          </div>
        </div>
        <button id="theme-toggle" class="themebtn themebtn-icon" type="button" aria-label="Toggle theme"><span class="theme-icon" aria-hidden="true"></span></button>
        <button class="hamb" type="button" aria-expanded="false" aria-controls="primary-links">{{ __('site.menu') }}</button>
        <div id="primary-links" class="links">
          @php $homePath = trim((string) parse_url(url('/'), PHP_URL_PATH), '/'); @endphp
          @if(isset($navLinks) && $navLinks->count())
            @foreach($navLinks as $nl)
              @php
                $linkUrl = $nl->url ?? '';
                if (!empty($linkUrl)) {
                  $linkUrl = trim((string) $linkUrl);
                  if (!\Illuminate\Support\Str::startsWith($linkUrl, ['http://', 'https://', 'mailto:', 'tel:', '#'])) {
                    $linkUrl = url($linkUrl);
                  } else {
                    $parsed = parse_url($linkUrl);
                    $host = strtolower($parsed['host'] ?? '');
                    if (in_array($host, ['localhost', '127.0.0.1'], true)) {
                      $path = $parsed['path'] ?? '/';
                      $path = preg_replace('#^/apx(/|$)#', '$1', $path) ?: '/';
                      $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';
                      $linkUrl = url($path) . $query;
                    }
                  }
                }
                $path = $linkUrl ? trim((string) parse_url($linkUrl, PHP_URL_PATH), '/') : '';
                $isHomeUrl = ($path === $homePath || $path === 'home');
              @endphp
              @if($isHomeUrl) @continue @endif
              <a href="{{ $linkUrl }}" @if($nl->target ?? null) target="{{ $nl->target }}" rel="noopener" @endif>
                @if(!empty($nl->icon))<span style="margin-right:6px">{{ $nl->icon }}</span>@endif{{ $nl->label }}
              </a>
            @endforeach
          @else
            <a href="{{ route('track') }}">{{ __('site.track') }}</a>
          @endif
          <a href="{{ route('login') }}">{{ __('site.login') }}</a>
        </div>
      </div>
    </div>
    <div class="header-right">
      <div class="header-tracking">
        <a href="{{ route('track') }}" class="header-track-btn" style="display:inline-block;text-decoration:none;line-height:1">{{ __('site.track') }}</a>
      </div>
      <div class="header-contact">
        @if(!empty($headerContactPhone))
          <a href="tel:{{ preg_replace('/\s+/', '', $headerContactPhone) }}" class="header-contact-link" title="Call us">📞 {{ $headerContactPhone }}</a>
        @endif
        @if(!empty($headerContactEmail))
          <a href="mailto:{{ $headerContactEmail }}" class="header-contact-link" title="Email us">✉️ {{ $headerContactEmail }}</a>
        @endif
      </div>
      @php $locale = app()->getLocale(); $langLabel = $locale === 'en' ? 'EN' : ($locale === 'ta' ? 'தமிழ்' : 'සිංහල'); @endphp
      <div class="lang-switcher" aria-label="{{ __('site.language') }}">
        <div class="lang-dropdown" tabindex="-1">
          <button type="button" class="lang-dropdown-trigger" aria-expanded="false" aria-haspopup="true" aria-label="{{ __('site.language') }}">
            <span class="lang-globe" aria-hidden="true">🌐</span>
            <span class="lang-current">{{ $langLabel }}</span>
          </button>
          <div class="lang-dropdown-menu" role="menu">
            <a href="{{ route('locale.switch', ['locale' => 'en']) }}" role="menuitem" class="{{ $locale === 'en' ? 'active' : '' }}">EN</a>
            <a href="{{ route('locale.switch', ['locale' => 'ta']) }}" role="menuitem" class="{{ $locale === 'ta' ? 'active' : '' }}">தமிழ்</a>
            <a href="{{ route('locale.switch', ['locale' => 'si']) }}" role="menuitem" class="{{ $locale === 'si' ? 'active' : '' }}">සිංහල</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
