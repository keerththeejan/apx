@extends('admin.layout')

@section('title', 'Add Social Link - Admin')

@section('content')
  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.sociallinks.index') }}">Back</a>
      <h2 style="margin:0">Add Social Media Link</h2>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.sociallinks.store') }}">
    @csrf

    <label for="label">Label <span style="color:var(--muted)">(e.g. Instagram, Facebook)</span></label>
    <input id="label" type="text" name="label" value="{{ old('label') }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)" required maxlength="120">

    <label for="url">URL</label>
    <input id="url" type="url" name="url" value="{{ old('url') }}" placeholder="https://..." class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)" required>

    <label for="icon">Icon</label>
    <select id="icon" name="icon" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25); max-width:280px">
      @foreach($iconOptions ?? [] as $value => $label)
        <option value="{{ $value }}" {{ old('icon') === (string)$value ? 'selected' : '' }}>{{ $label }}</option>
      @endforeach
    </select>
    <div id="icon-custom-wrap" style="margin-top:8px; display:none">
      <label for="icon_custom">Custom icon <span style="color:var(--muted)">(emoji or text)</span></label>
      <input id="icon_custom" type="text" name="icon_custom" value="{{ old('icon_custom') }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25); max-width:120px" maxlength="20" placeholder="🔗">
    </div>
    <script>
      (function(){
        var sel = document.getElementById('icon');
        var wrap = document.getElementById('icon-custom-wrap');
        if (!sel || !wrap) return;
        function toggle(){ wrap.style.display = (sel.value === '' || sel.value === '_other') ? 'block' : 'none'; }
        sel.addEventListener('change', toggle);
        toggle();
      })();
    </script>

    <label for="sort_order">Order</label>
    <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25); max-width:100px">

    <label style="display:flex; gap:8px; align-items:center; margin-top:12px">
      <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', true) ? 'checked' : '' }}> Visible in footer
    </label>

    <div class="actions" style="margin-top:16px; display:flex; gap:8px">
      <button class="btn" type="submit">Add Link</button>
      <a class="btn" href="{{ route('admin.sociallinks.index') }}">Cancel</a>
    </div>
  </form>
@endsection
