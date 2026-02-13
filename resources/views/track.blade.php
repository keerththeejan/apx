@extends('layouts.public')

@push('head')
  @php
    $seoSiteName = optional(\App\Models\Setting::where('key','site_name')->first())->value ?: 'Parcel Transport';
    $seoTitle = 'Track Your Parcel | ' . $seoSiteName;
    $seoDesc = 'Track your parcel with ' . $seoSiteName . '. Enter your tracking number and select a carrier to view delivery status.';
    $seoKw = optional(\App\Models\Setting::where('key','meta_keywords')->first())->value;
    $seoImg = optional(\App\Models\Setting::where('key','og_image')->first())->value;
  @endphp
  @include('partials.seo-meta', ['seoTitle' => $seoTitle, 'seoDescription' => $seoDesc, 'seoKeywords' => $seoKw, 'seoImage' => $seoImg, 'seoSiteName' => $seoSiteName])
@endpush

@push('styles')
  <style>
    .track-wrap { width: 100%; max-width: 600px; margin: 0 auto; padding: 24px var(--content-gutter, 24px); min-width: 0; box-sizing: border-box }
    .track-card { background: var(--card); border: 1px solid rgba(148,163,184,.12); border-radius: 16px; padding: 28px; box-shadow: 0 4px 20px rgba(0,0,0,.15) }
    body[data-theme="light"] .track-card { background: #fff; border-color: rgba(15,23,42,.08); box-shadow: 0 4px 20px rgba(0,0,0,.06) }
    .track-section h2 { margin: 0 0 8px; font-size: clamp(22px, 4vw, 28px); font-weight: 800; }
    .track-section .lead { color: var(--muted); margin: 0 0 24px; font-size: 15px; line-height: 1.5 }
    .track-section .form-control, .track-section .form-select { background: rgba(15,23,42,.6); border-color: rgba(148,163,184,.25); color: var(--text) }
    .track-section .form-control:focus, .track-section .form-select:focus { background: rgba(15,23,42,.7); border-color: var(--blue); color: var(--text); box-shadow: 0 0 0 3px rgba(59,130,246,.25) }
    .track-section .form-control::placeholder { color: var(--muted); opacity: .8 }
    body[data-theme="light"] .track-section .form-control, body[data-theme="light"] .track-section .form-select { background: rgba(15,23,42,.06); border-color: rgba(15,23,42,.15); color: var(--text) }
    body[data-theme="light"] .track-section .form-control:focus, body[data-theme="light"] .track-section .form-select:focus { background: rgba(15,23,42,.08); border-color: var(--blue) }
    .track-section .form-label { color: var(--muted); font-weight: 600; font-size: 14px }
    .track-section .track-submit { padding: 12px 24px; font-size: 16px; font-weight: 600; border-radius: 12px }
    .track-section .track-provider { border-color: rgba(148,163,184,.3); color: var(--muted); border-radius: 10px; font-weight: 600 }
    .track-section .track-provider:hover { background: rgba(148,163,184,.15) !important; border-color: rgba(148,163,184,.4) !important; color: var(--text) !important }
    .track-quick-label { color: var(--muted); font-size: 13px; font-weight: 600; margin-bottom: 10px; display: block }
    .track-section .track-divider { border-top: 1px solid rgba(148,163,184,.2) }
    @media (max-width: 576px) { .track-wrap { padding: 20px var(--content-gutter, 16px) } .track-card { padding: 20px } }
  </style>
@endpush

@section('content')
  <div class="track-wrap">
    <section class="track-section" aria-label="Track your parcel">
      <div class="track-card">
        <h2>Track your parcel</h2>
        <p class="lead">Enter your tracking number, select a parcel company, then click Track. The carrier's tracking page opens in a new tab—this page stays open so you can track another parcel.</p>
        <div class="track-form-area">
          @php $trackingLinksList = isset($trackingLinks) ? $trackingLinks : collect(); @endphp
          <form class="mb-0">
            <div class="mb-3">
              <label for="tracking_number" class="form-label">Tracking number</label>
              <input type="text" id="tracking_number" class="form-control form-control-lg" name="track" placeholder="e.g. 12345678901234" autocomplete="off" value="{{ e(request('track', '')) }}" aria-label="Tracking number">
            </div>
            <div class="mb-3">
              <label for="track_carrier" class="form-label">Select parcel company</label>
              <select id="track_carrier" class="form-select" aria-label="Select parcel company">
                <option value="">— Select company —</option>
                @foreach($trackingLinksList as $link)
                  <option value="{{ e($link->url_template) }}">{{ $link->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-4">
              <button type="button" class="btn btn-primary track-submit" id="track-submit-btn" aria-label="Track parcel">Track parcel</button>
            </div>
          </form>
          @if($trackingLinksList->count())
            <div class="pt-3 border-top track-divider">
              <span class="track-quick-label">Quick select</span>
              <div class="d-flex flex-wrap gap-2">
                @foreach($trackingLinksList as $link)
                  <button type="button" class="btn btn-outline-secondary track-provider" data-url-template="{{ e($link->url_template) }}" title="Open in new tab">{{ $link->name }}</button>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </div>
    </section>
  </div>
@endsection

@push('scripts')
  <script>
    (function(){
      var input = document.getElementById('tracking_number');
      var headerInput = document.getElementById('header-track-input');
      var carrierSelect = document.getElementById('track_carrier');
      var providers = document.querySelectorAll('.track-provider');
      var trackBtn = document.getElementById('track-submit-btn');

      function getTrackFromUrl() {
        var params = new URLSearchParams(window.location.search);
        return (params.get('track') || '').trim();
      }
      function syncInputs() {
        var fromUrl = getTrackFromUrl();
        if (fromUrl && input) input.value = fromUrl;
        if (headerInput && input) headerInput.value = input.value;
      }
      syncInputs();
      if (input && headerInput) {
        input.addEventListener('input', function(){ headerInput.value = input.value; });
        headerInput.addEventListener('input', function(){ input.value = headerInput.value; });
      }

      var search = window.location.search;
      if ((search === '?track=' || search === '?track') && window.history && window.history.replaceState) {
        window.history.replaceState({}, document.title, window.location.pathname);
      }

      function buildTrackingUrl(num, template){
        if (!template) return '';
        return template.replace(/\{tracking_number\}/gi, encodeURIComponent(num)).replace(/\{tracking\}/gi, encodeURIComponent(num));
      }

      function openTracking(num, template){
        var url = buildTrackingUrl(num, template);
        if (url) window.open(url, '_blank', 'noopener');
      }

      if (providers.length) {
        for (var i = 0; i < providers.length; i++) {
          (function(btn){
            btn.addEventListener('click', function(){
              var num = (input && input.value) ? input.value.trim() : '';
              if (!num){ alert('Please enter a tracking number.'); return; }
              var template = btn.getAttribute('data-url-template') || '';
              if (carrierSelect && template) carrierSelect.value = template;
              openTracking(num, template);
            });
          })(providers[i]);
        }
      }

      if (trackBtn && input){
        trackBtn.addEventListener('click', function(){
          var num = (input.value || '').trim();
          if (!num){ alert('Please enter a tracking number.'); return; }
          var template = (carrierSelect && carrierSelect.value) ? carrierSelect.value : '';
          if (template){ openTracking(num, template); }
          else {
            var first = providers[0];
            if (first){ openTracking(num, first.getAttribute('data-url-template') || ''); }
            else { alert('Please select a parcel company, or add tracking links in Admin (Parcel Tracking Links).'); }
          }
        });
      }

      var headerForm = document.querySelector('.header-track-form');
      if (headerForm) {
        headerForm.addEventListener('submit', function(e){
          e.preventDefault();
          var num = (headerInput && headerInput.value) ? headerInput.value.trim() : ((input && input.value) ? input.value.trim() : '');
          if (!num){ alert('Please enter a tracking number.'); return; }
          var template = (carrierSelect && carrierSelect.value) ? carrierSelect.value : '';
          if (template){ openTracking(num, template); }
          else {
            var first = providers[0];
            if (first){ openTracking(num, first.getAttribute('data-url-template') || ''); }
            else { alert('Please select a parcel company.'); }
          }
        });
      }
    })();
  </script>
@endpush
