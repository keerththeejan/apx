@extends('admin.layout')

@section('title', 'Banner Management')

@section('content')
  <style>
    .banner-mgmt { width: 100%; max-width: none; margin: 0; padding: 0; box-sizing: border-box; }
    .banner-mgmt .page-head { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 24px; }
    .banner-mgmt .page-head h2 { margin: 0; font-size: 1.5rem; font-weight: 800; }
    .banner-mgmt .btn-add { background: #2563eb; border-color: #2563eb; color: #fff; }
    .banner-mgmt .btn-add:hover { background: #1d4ed8; border-color: #1d4ed8; color: #fff; }
    .banner-mgmt .section-title { font-size: 1.1rem; font-weight: 700; color: var(--muted); margin: 0 0 14px; }
    .banner-mgmt .banner-table { width: 100%; min-width: 600px; border-collapse: separate; border-spacing: 0; background: linear-gradient(180deg, rgba(15,23,42,.9), rgba(2,6,23,.85)); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .banner-mgmt .banner-table th { text-align: left; padding: 12px 14px; font-size: 12px; font-weight: 700; color: var(--muted); background: var(--panel); border-bottom: 1px solid var(--border); }
    .banner-mgmt .banner-table td { padding: 12px 14px; border-bottom: 1px solid var(--border); font-size: 14px; vertical-align: middle; }
    .banner-mgmt .banner-table tr:last-child td { border-bottom: none; }
    .banner-mgmt .banner-table tr:hover td { background: rgba(255,255,255,.02); }
    .banner-mgmt .banner-table .col-num { width: 48px; color: var(--muted); font-weight: 700; }
    .banner-mgmt .banner-table .col-image { width: 64px; }
    .banner-mgmt .banner-table .thumb-circle { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; background: #1e293b; display: block; }
    .banner-mgmt .banner-table .thumb-placeholder { width: 48px; height: 48px; border-radius: 50%; background: #1e293b; display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 11px; text-align: center; }
    .banner-mgmt .banner-table .col-title { font-weight: 600; color: var(--text); }
    .banner-mgmt .banner-table .col-desc { color: var(--muted); font-size: 13px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .banner-mgmt .banner-table .status-badge { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
    .banner-mgmt .banner-table .status-active { background: rgba(34,197,94,.2); color: #86efac; border: 1px solid rgba(34,197,94,.4); }
    .banner-mgmt .banner-table .status-inactive { background: rgba(148,163,184,.15); color: var(--muted); border: 1px solid var(--border); }
    .banner-mgmt .banner-table .col-actions { white-space: nowrap; }
    .banner-mgmt .banner-table .btn-icon { display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; padding: 0; border-radius: 8px; border: none; cursor: pointer; text-decoration: none; margin-right: 6px; }
    .banner-mgmt .banner-table .btn-edit { background: rgba(59,130,246,.25); color: #93c5fd; }
    .banner-mgmt .banner-table .btn-edit:hover { background: rgba(59,130,246,.4); color: #fff; }
    .banner-mgmt .banner-table .btn-delete { background: rgba(239,68,68,.2); color: #fca5a5; }
    .banner-mgmt .banner-table .btn-delete:hover { background: rgba(239,68,68,.35); color: #fff; }
    .banner-mgmt .table-wrap { overflow-x: auto; border-radius: var(--radius); -webkit-overflow-scrolling: touch; }
    .banner-mgmt .empty-state { text-align: center; padding: 48px 20px; background: rgba(15,23,42,.4); border: 1px dashed var(--border); border-radius: var(--radius); color: var(--muted); }
    .banner-mgmt .empty-state .btn { margin-top: 14px; }
    /* Mobile: card list (hidden on desktop) */
    .banner-mgmt .banner-cards { display: none; }
    .banner-mgmt .banner-card-row { display: flex; align-items: center; gap: 12px; padding: 12px 14px; background: linear-gradient(180deg, rgba(15,23,42,.9), rgba(2,6,23,.85)); border: 1px solid var(--border); border-radius: var(--radius); margin-bottom: 10px; min-width: 0; }
    .banner-mgmt .banner-card-row .thumb-wrap { flex-shrink: 0; }
    .banner-mgmt .banner-card-row .thumb-circle { width: 52px; height: 52px; border-radius: 50%; object-fit: cover; background: #1e293b; display: block; }
    .banner-mgmt .banner-card-row .thumb-placeholder { width: 52px; height: 52px; border-radius: 50%; background: #1e293b; display: flex; align-items: center; justify-content: center; color: var(--muted); font-size: 11px; }
    .banner-mgmt .banner-card-row .card-body { flex: 1; min-width: 0; }
    .banner-mgmt .banner-card-row .card-title { font-weight: 600; color: var(--text); font-size: 14px; margin: 0 0 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .banner-mgmt .banner-card-row .card-meta { font-size: 12px; color: var(--muted); margin: 0 0 6px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .banner-mgmt .banner-card-row .card-footer { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .banner-mgmt .banner-card-row .btn-icon { min-width: 44px; min-height: 44px; display: inline-flex; align-items: center; justify-content: center; padding: 0; border-radius: 8px; border: none; cursor: pointer; text-decoration: none; }
    .banner-mgmt .banner-card-row .btn-edit { background: rgba(59,130,246,.25); color: #93c5fd; }
    .banner-mgmt .banner-card-row .btn-edit:hover { background: rgba(59,130,246,.4); color: #fff; }
    .banner-mgmt .banner-card-row .btn-delete { background: rgba(239,68,68,.2); color: #fca5a5; }
    .banner-mgmt .banner-card-row .btn-delete:hover { background: rgba(239,68,68,.35); color: #fff; }
    .banner-mgmt .banner-card-row .status-badge { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
    .banner-mgmt .banner-card-row .status-active { background: rgba(34,197,94,.2); color: #86efac; border: 1px solid rgba(34,197,94,.4); }
    .banner-mgmt .banner-card-row .status-inactive { background: rgba(148,163,184,.15); color: var(--muted); border: 1px solid var(--border); }
    @media (max-width: 768px) {
      .banner-mgmt .page-head { flex-direction: column; align-items: flex-start; gap: 10px; margin-bottom: 18px; }
      .banner-mgmt .page-head h2 { font-size: 1.25rem; }
      .banner-mgmt .btn-add { width: 100%; text-align: center; }
      .banner-mgmt .banner-table th, .banner-mgmt .banner-table td { padding: 10px 12px; font-size: 13px; }
      .banner-mgmt .banner-table .col-desc { max-width: 140px; }
    }
    @media (max-width: 640px) {
      .banner-mgmt .page-head { margin-bottom: 16px; }
      .banner-mgmt .section-title { font-size: 1rem; margin-bottom: 12px; }
      .banner-mgmt .table-wrap { display: none; }
      .banner-mgmt .banner-cards { display: block; }
      .banner-mgmt .banner-table .btn-icon { min-width: 44px; min-height: 44px; }
    }
    @media (max-width: 480px) {
      .banner-mgmt .page-head h2 { font-size: 1.1rem; }
      .banner-mgmt .empty-state { padding: 32px 16px; }
      .banner-mgmt .banner-card-row { padding: 10px 12px; gap: 10px; }
      .banner-mgmt .banner-card-row .thumb-circle, .banner-mgmt .banner-card-row .thumb-placeholder { width: 44px; height: 44px; }
    }
  </style>

  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div class="banner-mgmt">
    <div class="page-head">
      <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap">
        <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
        <h2>Banner Management</h2>
      </div>
      <a class="btn btn-add" href="{{ route('admin.banner.create') }}">+ Add New Banner</a>
    </div>

    <h3 class="section-title">All Banners</h3>

    @if($banners->isEmpty())
      <div class="empty-state">
        <p style="margin:0">No banners yet. The first banner you add will show on the home page.</p>
        <a class="btn btn-add" href="{{ route('admin.banner.create') }}">+ Add New Banner</a>
      </div>
    @else
      <div class="table-wrap">
        <table class="banner-table">
          <thead>
            <tr>
              <th class="col-num">#</th>
              <th class="col-image">Image</th>
              <th>Title</th>
              <th>Description</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($banners as $index => $b)
              @php
                $thumbUrl = $b->bg_image_url
                  ? (\Illuminate\Support\Str::startsWith(ltrim($b->bg_image_url, '/'), 'uploads/') ? asset('public/'.ltrim($b->bg_image_url, '/')) : asset(ltrim($b->bg_image_url, '/')))
                  : null;
                $title = $b->name ?: \Illuminate\Support\Str::limit($b->title_line1 ?? 'Banner #'.$b->id, 50);
                $desc = trim((string)($b->subtitle ?? ''));
                $isFirst = $index === 0;
              @endphp
              <tr>
                <td class="col-num">{{ $index + 1 }}</td>
                <td class="col-image">
                  @if($thumbUrl)
                    <img class="thumb-circle" src="{{ $thumbUrl }}" alt="">
                  @else
                    <div class="thumb-placeholder">No img</div>
                  @endif
                </td>
                <td class="col-title">{{ $title }}</td>
                <td class="col-desc">{{ $desc !== '' ? \Illuminate\Support\Str::limit($desc, 60) : '—' }}</td>
                <td>
                  <span class="status-badge {{ $isFirst ? 'status-active' : 'status-inactive' }}">{{ $isFirst ? 'Active' : 'Inactive' }}</span>
                </td>
                <td class="col-actions">
                  <a href="{{ route('admin.banner.edit', $b) }}" class="btn-icon btn-edit" title="Edit" aria-label="Edit">✎</a>
                  <form method="POST" action="{{ route('admin.banner.destroy', $b) }}" style="display:inline" onsubmit="return confirm('Delete this banner?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-icon btn-delete" title="Delete" aria-label="Delete">🗑</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="banner-cards" aria-label="Banner list (mobile view)">
        @foreach($banners as $index => $b)
          @php
            $thumbUrl = $b->bg_image_url
              ? (\Illuminate\Support\Str::startsWith(ltrim($b->bg_image_url, '/'), 'uploads/') ? asset('public/'.ltrim($b->bg_image_url, '/')) : asset(ltrim($b->bg_image_url, '/')))
              : null;
            $title = $b->name ?: \Illuminate\Support\Str::limit($b->title_line1 ?? 'Banner #'.$b->id, 50);
            $desc = trim((string)($b->subtitle ?? ''));
            $isFirst = $index === 0;
          @endphp
          <div class="banner-card-row">
            <div class="thumb-wrap">
              @if($thumbUrl)
                <img class="thumb-circle" src="{{ $thumbUrl }}" alt="">
              @else
                <div class="thumb-placeholder">No img</div>
              @endif
            </div>
            <div class="card-body">
              <p class="card-title">{{ $title }}</p>
              <p class="card-meta">{{ $desc !== '' ? \Illuminate\Support\Str::limit($desc, 40) : '—' }}</p>
              <div class="card-footer">
                <span class="status-badge {{ $isFirst ? 'status-active' : 'status-inactive' }}">{{ $isFirst ? 'Active' : 'Inactive' }}</span>
                <a href="{{ route('admin.banner.edit', $b) }}" class="btn-icon btn-edit" title="Edit" aria-label="Edit">✎</a>
                <form method="POST" action="{{ route('admin.banner.destroy', $b) }}" style="display:inline" onsubmit="return confirm('Delete this banner?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-icon btn-delete" title="Delete" aria-label="Delete">🗑</button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endsection
