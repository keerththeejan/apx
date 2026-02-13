@extends('admin.layout')

@section('title', 'Daily Activities - Admin')

@section('brand', 'Admin')

@push('styles')
  <style>
    .act-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px }
    .act-header h2 { margin: 0; font-size: 1.5rem; font-weight: 800 }
    .act-table-wrap { border-radius: 16px; overflow: hidden; border: 1px solid var(--border); box-shadow: 0 4px 20px rgba(0,0,0,.15) }
    .act-table { margin: 0 }
    .act-table thead th { background: var(--panel); color: var(--muted); font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: .04em; padding: 14px 16px; border-bottom: 1px solid var(--border) }
    .act-table tbody td { padding: 12px 16px; vertical-align: middle; border-bottom: 1px solid var(--border) }
    .act-table tbody tr { transition: background .2s ease }
    .act-table tbody tr:hover { background: rgba(148,163,184,.06) }
    .act-table tbody tr:last-child td { border-bottom: none }
    .act-img { width: 44px; height: 32px; border-radius: 10px; object-fit: cover; border: 1px solid var(--border) }
    .act-btn-vis { min-width: 88px; padding: 6px 12px; font-size: 13px; border-radius: 10px }
    .act-input-sort { max-width: 90px; padding: 8px 12px; border-radius: 10px; font-weight: 600 }
    .act-actions { display: flex; flex-wrap: wrap; gap: 8px }
    .act-pager { margin-top: 20px }
    .act-empty { color: var(--muted); font-size: 14px; padding: 24px }
    .act-input-sort { background: #0b1a21 !important; border-color: var(--border) !important; color: var(--text) !important }
    .act-table-wrap .btn-outline-primary { border-color: rgba(59,130,246,.4); color: #93c5fd }
    .act-table-wrap .btn-outline-primary:hover { background: rgba(59,130,246,.2); border-color: #3b82f6; color: #93c5fd }
    .act-table-wrap .btn-outline-secondary { border-color: var(--border); color: var(--muted) }
    .act-table-wrap .btn-outline-secondary:hover { background: rgba(148,163,184,.15); color: var(--text) }
    .act-table-wrap .btn-success { background: #059669; border-color: #059669 }
    .act-table-wrap .btn-success:hover { background: #047857; border-color: #047857 }
    .act-table-wrap .btn-danger { background: var(--danger); border-color: var(--danger) }
    .act-table-wrap .alert-success { background: rgba(16,185,129,.15); border-color: rgba(16,185,129,.3); color: #a7f3d0 }
  </style>
@endpush

@section('content')
  @php
    $toUrl = function ($p) {
      if (empty($p)) return null;
      $p = trim((string) $p);
      if (\Illuminate\Support\Str::startsWith($p, ['http://','https://','data:'])) return $p;
      $path = ltrim($p, '/');
      if (\Illuminate\Support\Str::startsWith($path, 'uploads/')) {
        $path = 'public/'.$path;
      }
      return asset($path);
    };
  @endphp
  @if(session('status'))
    <div class="alert alert-success mb-4" role="alert">{{ session('status') }}</div>
  @endif

  <div class="act-header">
    <div class="d-flex align-items-center gap-2">
      <a class="btn btn-outline-secondary" href="{{ route('admin.dashboard') }}">Back</a>
      <h2>Daily Activities</h2>
    </div>
    <a class="btn btn-primary" href="{{ route('admin.activities.create') }}">Add Activity</a>
  </div>

  <div class="act-table-wrap">
    <table class="act-table table">
      <thead>
        <tr>
          <th>#</th>
          <th>Image</th>
          <th>Title</th>
          <th>Date</th>
          <th>Visible</th>
          <th>Order</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $it)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              @if(!empty($it->image_url))
                <img src="{{ $toUrl($it->image_url) }}" alt="" class="act-img">
              @else
                —
              @endif
            </td>
            <td>{{ $it->title }}</td>
            <td>{{ $it->activity_date ? $it->activity_date->format('Y-m-d') : '—' }}</td>
            <td>
              <button
                type="button"
                class="btn btn-sm act-btn-vis js-toggle-vis {{ $it->is_visible ? 'btn-success' : 'btn-outline-secondary' }}"
                data-id="{{ $it->id }}"
                data-url="{{ route('admin.activities.toggle', $it) }}"
              >
                <span class="js-vis-label">
                  @if($it->is_visible)
                    Visible
                  @else
                    Hidden
                  @endif
                </span>
              </button>
            </td>
            <td>
              <input
                class="form-control form-control-sm act-input-sort js-sort-order"
                type="number"
                min="0"
                step="1"
                value="{{ (int)$it->sort_order }}"
                data-id="{{ $it->id }}"
                data-url="{{ route('admin.activities.sort', $it) }}"
              >
            </td>
            <td>
              <div class="act-actions">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.activities.edit', $it) }}">Edit</a>
                <form method="POST" action="{{ route('admin.activities.destroy', $it) }}" onsubmit="return confirm('Delete this activity?')" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="act-empty">No activities yet. Click "Add Activity".</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($items->hasPages())
    <div class="act-pager">
      {!! $items->links() !!}
    </div>
  @endif

  <script>
    (function(){
      const csrf = '{{ csrf_token() }}';

      function setBtnState(btn, isVisible){
        const label = btn.querySelector('.js-vis-label');
        if (label) label.textContent = isVisible ? 'Visible' : 'Hidden';
        btn.style.opacity = '1';
        btn.classList.remove('btn-success', 'btn-outline-secondary');
        btn.classList.add(isVisible ? 'btn-success' : 'btn-outline-secondary');
      }

      async function patchJson(url, payload){
        const res = await fetch(url, {
          method: 'PATCH',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
          },
          body: JSON.stringify(payload || {}),
        });

        let data = null;
        try { data = await res.json(); } catch(e) {}
        if (!res.ok){
          const msg = (data && (data.message || (data.errors && JSON.stringify(data.errors)))) || ('Request failed (' + res.status + ')');
          throw new Error(msg);
        }
        return data;
      }

      document.querySelectorAll('.js-toggle-vis').forEach((btn) => {
        btn.addEventListener('click', async () => {
          const url = btn.getAttribute('data-url');
          if (!url) return;
          btn.style.opacity = '.65';
          try {
            const data = await patchJson(url);
            setBtnState(btn, !!(data && data.is_visible));
          } catch (e) {
            btn.style.opacity = '1';
            alert(e && e.message ? e.message : 'Failed');
          }
        });
      });

      let sortTimer = null;
      let lastSent = new Map();
      document.querySelectorAll('.js-sort-order').forEach((inp) => {
        inp.addEventListener('input', () => {
          const url = inp.getAttribute('data-url');
          if (!url) return;
          const val = parseInt(inp.value || '0', 10);
          inp.style.opacity = '.65';

          clearTimeout(sortTimer);
          sortTimer = setTimeout(async () => {
            const key = url;
            if (lastSent.get(key) === val) { inp.style.opacity = '1'; return; }
            lastSent.set(key, val);
            try {
              await patchJson(url, { sort_order: val });
              inp.style.opacity = '1';
            } catch (e) {
              inp.style.opacity = '1';
              alert(e && e.message ? e.message : 'Failed');
            }
          }, 450);
        });
      });
    })();
  </script>
@endsection
