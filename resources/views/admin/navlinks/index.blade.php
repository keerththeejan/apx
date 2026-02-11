@extends('admin.layout')

@section('title', 'Nav Links (Menu) - Admin')
@section('brand', 'Nav Links')

@section('content')
  <style>
    .navlinks-page { width: 100%; max-width: none; }
    .navlinks-page .quick-add { background: linear-gradient(180deg, rgba(15,23,42,.6), rgba(2,6,23,.5)); border: 1px solid var(--border); border-radius: var(--radius); padding: 16px; margin-bottom: 18px; }
    .navlinks-page .quick-add h3 { margin: 0 0 12px; font-size: 1rem; }
    .navlinks-page .quick-add .row { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px; align-items: end; }
    .navlinks-page .quick-add label { margin-bottom: 4px; }
    .navlinks-page .order-btns { display: flex; flex-direction: column; gap: 4px; }
    .navlinks-page .order-btns form { display: inline; }
    .navlinks-page .order-btns button { padding: 4px 8px; font-size: 12px; cursor: pointer; border-radius: 6px; border: 1px solid var(--border); background: var(--panel); color: var(--text); }
    .navlinks-page .order-btns button:hover { background: rgba(148,163,184,.15); }
    @media (max-width: 640px) { .navlinks-page .quick-add .row { grid-template-columns: 1fr; } }
  </style>
  <div class="navlinks-page">
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:14px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Nav Links (Menu)</h2>
    </div>
    <a class="btn" href="{{ route('admin.navlinks.create') }}">+ Add Link (full form)</a>
  </div>

  <div class="quick-add">
    <h3>Add new menu item</h3>
    <form method="POST" action="{{ route('admin.navlinks.store') }}">
      @csrf
      <div class="row">
        <div>
          <label for="quick_label">Label</label>
          <input id="quick_label" type="text" name="label" value="{{ old('label') }}" placeholder="Track" required maxlength="80">
        </div>
        <div>
          <label for="quick_icon">Icon</label>
          <input id="quick_icon" type="text" name="icon" value="{{ old('icon') }}" placeholder="🔍" list="quickicons" maxlength="20">
          <datalist id="quickicons">
            <option value="🏠"><option value="🔍"><option value="📝"><option value="☎️"><option value="ℹ️"><option value="✉️">
          </datalist>
        </div>
        <div style="min-width:0">
          <label for="quick_url">URL</label>
          <input id="quick_url" type="text" name="url" value="{{ old('url') }}" placeholder="/track or https://..." required maxlength="255">
        </div>
        <div>
          <label for="quick_target">Target</label>
          <select id="quick_target" name="target">
            <option value="_self">Same tab</option>
            <option value="_blank" {{ old('target')==='_blank'?'selected':'' }}>New tab</option>
          </select>
        </div>
        <div>
          <label for="quick_sort">Order</label>
          <input id="quick_sort" type="number" name="sort_order" value="{{ old('sort_order', $links->isEmpty() ? 0 : $links->max('sort_order') + 1) }}" min="0" style="width:80px">
        </div>
        <div style="display:flex; align-items:center; gap:8px">
          <label style="margin:0; display:flex; align-items:center; gap:6px">
            <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', true) ? 'checked' : '' }}> Visible
          </label>
          <button class="btn" type="submit">Add</button>
        </div>
      </div>
    </form>
  </div>

  <div class="tablewrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Label</th>
          <th>URL</th>
          <th>Target</th>
          <th>Visible</th>
          <th>Order</th>
          <th>Adjust order</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($links as $index => $l)
          <tr>
            <td>{{ $l->id }}</td>
            <td>{{ $l->label }}</td>
            <td style="max-width:320px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap">{{ $l->url }}</td>
            <td>{{ $l->target ?? '_self' }}</td>
            <td>{{ $l->is_visible ? 'Yes' : 'No' }}</td>
            <td>{{ $l->sort_order }}</td>
            <td>
              <div class="order-btns">
                <form method="POST" action="{{ route('admin.navlinks.moveUp', $l) }}" style="display:inline">
                  @csrf
                  <button type="submit" title="Move up">↑ Up</button>
                </form>
                <form method="POST" action="{{ route('admin.navlinks.moveDown', $l) }}" style="display:inline">
                  @csrf
                  <button type="submit" title="Move down">↓ Down</button>
                </form>
              </div>
            </td>
            <td style="display:flex; gap:8px; flex-wrap:wrap">
              <a class="btn" href="{{ route('admin.navlinks.edit', $l) }}">Edit</a>
              <form method="POST" action="{{ route('admin.navlinks.destroy', $l) }}" onsubmit="return confirm('Delete this link?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn logout" type="submit" style="padding:8px 12px; font-size:14px">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="8" style="color:var(--muted)">No links yet. Add one above or use "Add Link (full form)".</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  </div>
@endsection
