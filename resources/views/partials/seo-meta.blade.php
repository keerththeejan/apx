@php
  $seoTitle = $seoTitle ?? config('app.name', 'Parcel Transport');
  $seoDescription = $seoDescription ?? null;
  $seoKeywords = $seoKeywords ?? null;
  $seoCanonical = $seoCanonical ?? url()->current();
  $seoImage = $seoImage ?? null;
  $seoSiteName = $seoSiteName ?? $seoTitle;
  $noindex = $noindex ?? false;
  $seoImageAbsolute = $seoImage ? (str_starts_with($seoImage, 'http') ? $seoImage : url($seoImage)) : null;
@endphp
<title>{{ $seoTitle }}</title>
@if($seoDescription)
<meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($seoDescription), 160) }}">
@endif
@if($seoKeywords)
<meta name="keywords" content="{{ is_array($seoKeywords) ? implode(', ', $seoKeywords) : $seoKeywords }}">
@endif
@if($noindex)
<meta name="robots" content="noindex, nofollow">
@else
<link rel="canonical" href="{{ $seoCanonical }}">
@endif
{{-- Open Graph --}}
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $seoTitle }}">
@if($seoDescription)
<meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($seoDescription), 200) }}">
@endif
<meta property="og:url" content="{{ $seoCanonical }}">
<meta property="og:site_name" content="{{ $seoSiteName }}">
@if($seoImageAbsolute)
<meta property="og:image" content="{{ $seoImageAbsolute }}">
@endif
<meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">
{{-- Twitter Card --}}
<meta name="twitter:card" content="{{ $seoImageAbsolute ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $seoTitle }}">
@if($seoDescription)
<meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($seoDescription), 200) }}">
@endif
@if($seoImageAbsolute)
<meta name="twitter:image" content="{{ $seoImageAbsolute }}">
@endif
@if(!empty($jsonLd))
<script type="application/ld+json">@json($jsonLd)</script>
@endif
