@extends('admin.layout')

@section('title', 'Daily Activities - Admin')

@section('brand', 'Admin')

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
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Daily Activities</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.activities.create') }}">Add Activity</a>
    </div>
  </div>

  <table>
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
          <td>{{ $it->id }}</td>
          <td>
            @if(!empty($it->image_url))
              <img src="{{ $toUrl($it->image_url) }}" alt="Image" style="width:44px; height:32px; border-radius:8px; object-fit:cover; border:1px solid rgba(148,163,184,.25)">
            @else
              —
            @endif
          </td>
          <td>{{ $it->title }}</td>
          <td>{{ $it->activity_date ? $it->activity_date->format('Y-m-d') : '—' }}</td>
          <td>
            <button
              type="button"
              class="btn js-toggle-vis"
              data-id="{{ $it->id }}"
              data-url="{{ route('admin.activities.toggle', $it) }}"
              style="padding:6px 10px"
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
          <td style="max-width:110px">
            <input
              class="js-sort-order"
              type="number"
              min="0"
              step="1"
              value="{{ (int)$it->sort_order }}"
              data-id="{{ $it->id }}"
              data-url="{{ route('admin.activities.sort', $it) }}"
              style="padding:8px 10px"
            >
          </td>
          <td>
            <a class="btn" href="{{ route('admin.activities.edit', $it) }}">Edit</a>
            <form method="POST" action="{{ route('admin.activities.destroy', $it) }}" onsubmit="return confirm('Delete this activity?')" style="display:inline">
              @csrf
              @method('DELETE')
              <button class="btn danger" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" style="color:#94a3b8">No activities yet. Click "Add Activity".</td></tr>
      @endforelse
    </tbody>
  </table>

  <div style="margin-top:10px">
    {!! $items->links() !!}
  </div>

  <script>
    (function(){
      const csrf = '{{ csrf_token() }}';

      function setBtnState(btn, isVisible){
        const label = btn.querySelector('.js-vis-label');
        if (label) label.textContent = isVisible ? 'Visible' : 'Hidden';
        btn.style.opacity = '1';
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
