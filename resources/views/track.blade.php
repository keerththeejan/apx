<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php
    $seoSiteName = optional(\App\Models\Setting::where('key','site_name')->first())->value ?: 'Parcel Transport';
    $seoTitle = 'Track Your Parcel | ' . $seoSiteName;
    $seoDesc = 'Track your parcel with ' . $seoSiteName . '. Enter your tracking number and select a carrier to view delivery status.';
    $seoKw = optional(\App\Models\Setting::where('key','meta_keywords')->first())->value;
    $seoImg = optional(\App\Models\Setting::where('key','og_image')->first())->value;
  @endphp
  @include('partials.seo-meta', ['seoTitle' => $seoTitle, 'seoDescription' => $seoDesc, 'seoKeywords' => $seoKw, 'seoImage' => $seoImg, 'seoSiteName' => $seoSiteName])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --bg: #0b1220; --card: #0f172a; --muted: #94a3b8; --text: #e2e8f0; --blue: #3b82f6; --border: rgba(148,163,184,.12); }
    * { box-sizing: border-box }
    html { overflow-x: hidden }
    body { margin: 0; font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background: var(--bg); color: var(--text); overflow-x: hidden; min-width: 0 }
    .header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; padding: 14px 20px; background: var(--card); border-bottom: 1px solid var(--border); }
    .header h1 { margin: 0; font-size: clamp(18px, 3vw, 22px); font-weight: 800; }
    .btn { display: inline-block; padding: 10px 14px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.55); color: #fff; text-decoration: none; font-weight: 600; font-size: 14px; flex-shrink: 0 }
    .btn:hover { filter: brightness(1.1) }
    .wrap { max-width: 640px; margin: 0 auto; padding: 28px 24px; min-width: 0 }
    .track-section { padding: 0 }
    .track-section h2 { margin: 0 0 8px; font-size: clamp(22px, 4vw, 28px); font-weight: 800; }
    .track-section .lead { color: var(--muted); margin: 0 0 20px; font-size: 15px; line-height: 1.5 }
    .track-wrap { margin-top: 0 }
    .track-input { width: 100%; padding: 12px 14px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.6); color: var(--text); font-size: 16px }
    .track-select-wrap { margin-top: 14px }
    .track-select-wrap label { display: block; margin-bottom: 6px; color: var(--muted); font-size: 14px; font-weight: 600 }
    .track-select { width: 100%; padding: 12px 14px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: rgba(15,23,42,.6); color: var(--text); font-size: 16px }
    .track-buttons { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 14px }
    .track-submit-wrap { margin-top: 14px }
    .track-submit { padding: 12px 24px; border-radius: 10px; border: 1px solid rgba(148,163,184,.25); background: var(--blue); color: #fff; font-weight: 600; font-size: 16px; cursor: pointer }
    .track-submit:hover { filter: brightness(1.1) }
    .track-provider { margin: 0 }
    .track-empty { color: var(--muted); font-size: 14px; margin-top: 10px }
    .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; border: 0 }
    @media (max-width: 576px) { .wrap { padding: 20px 16px } .header { padding: 12px 16px } }
  </style>
</head>
<body>
  <header class="header">
    <h1>Track your parcel</h1>
    <a class="btn" href="{{ url('/') }}">Home</a>
  </header>

  <main class="wrap">
    <section class="track-section" aria-label="Track your parcel">
      <h2>Track your parcel</h2>
      <p class="lead">Enter your tracking number, select a parcel company, then click Track to open their tracking page.</p>
      <div class="track-wrap">
        @php $trackingLinksList = isset($trackingLinks) ? $trackingLinks : collect(); @endphp
        <label for="tracking_number" class="sr-only">Tracking number</label>
        <input type="text" id="tracking_number" class="track-input" name="track" placeholder="Tracking number" autocomplete="off" value="{{ e(request('track', '')) }}">
        <div class="track-select-wrap">
          <label for="track_carrier">Select parcel company</label>
          <select id="track_carrier" class="track-select" aria-label="Select parcel company">
            <option value="">— Select company —</option>
            @foreach($trackingLinksList as $link)
              <option value="{{ e($link->url_template) }}">{{ $link->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="track-submit-wrap">
          <button type="button" class="track-submit" id="track-submit-btn" aria-label="Track parcel">Track</button>
        </div>
        <div class="track-buttons">
          @if($trackingLinksList->count())
            @foreach($trackingLinksList as $link)
              <button type="button" class="btn track-provider" data-url-template="{{ e($link->url_template) }}" title="Opens in new tab">{{ $link->name }}</button>
            @endforeach
          @endif
        </div>
      </div>
    </section>
  </main>

  <script>
    (function(){
      var input = document.getElementById('tracking_number');
      var carrierSelect = document.getElementById('track_carrier');
      var providers = document.querySelectorAll('.track-provider');
      var trackBtn = document.getElementById('track-submit-btn');

      function openTracking(num, template){
        if (!template) return;
        var url = template.replace(/\{tracking_number\}/gi, encodeURIComponent(num)).replace(/\{tracking\}/gi, encodeURIComponent(num));
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
    })();
  </script>
</body>
</html>
