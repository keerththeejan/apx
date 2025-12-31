@extends('admin.layout')

@section('title', 'Create Service - Admin')

@section('content')
  @if ($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <h2 style="margin:0">Create Service</h2>
    <div>
      <a class="btn" href="{{ route('admin.services.index') }}">Back</a>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
    @csrf
    <label for="icon">Icon (emoji or short text)</label>
    <input id="icon" type="text" name="icon" value="{{ old('icon') }}" placeholder="✈️" list="iconlist">
    <datalist id="iconlist">
      <option value="✈️">✈️ Air</option>
      <option value="🚆">🚆 Train</option>
      <option value="🚢">🚢 Cargo Ship</option>
      <option value="⚓">⚓ Maritime</option>
      <option value="🛩️">🛩️ Flight</option>
      <option value="🚚">🚚 Land Transport</option>
      <option value="🏬">🏬 Warehousing</option>
      <option value="📦">📦 Parcel</option>
      <option value="🚛">🚛 Truck</option>
      <option value="🧭">🧭 Navigation</option>
      <option value="⛴️">⛴️ Ferry</option>
    </datalist>

    <label for="title">Title</label>
    <input id="title" type="text" name="title" value="{{ old('title') }}" placeholder="Air Transportation" required>

    <label for="description">Description</label>
    <textarea id="description" name="description" placeholder="Short description">{{ old('description') }}</textarea>

    <label for="image_url">Preview Image URL</label>
    <input id="image_url" type="text" name="image_url" value="{{ old('image_url') }}" placeholder="https://...">
    <label for="image_file">Or upload an image (optional)</label>
    <input id="image_file" type="file" name="image_file" accept="image/*">
    <small class="help">Image shown in the preview on the right of the services section.</small>
    <div id="image_preview_wrap" style="margin-top:8px;display:none">
      <img id="image_preview" src="" alt="Preview" style="width:260px; height:150px; object-fit:cover; border-radius:10px; border:1px solid rgba(148,163,184,.25)">
    </div>

    <label for="checklist_text">Checklist items (one per line)</label>
    <textarea id="checklist_text" name="checklist_text" placeholder="Fast Delivery
Safety
Good Package
Privacy">{{ old('checklist_text') }}</textarea>

    <div class="row">
      <div>
        <label for="sort_order">Sort Order</label>
        <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
      </div>
      @if(\Illuminate\Support\Facades\Schema::hasColumn('services','is_visible'))
      <div>
        <label for="is_visible">Visible</label>
        <input id="is_visible" type="checkbox" name="is_visible" value="1" {{ old('is_visible', 1) ? 'checked' : '' }}>
      </div>
      @endif
    </div>

    <div class="actions">
      <button class="btn" type="submit">Create</button>
      <a class="btn" href="{{ route('admin.services.index') }}">Cancel</a>
    </div>
  </form>
  <script>
    (function(){
      const file = document.getElementById('image_file');
      const urlInput = document.getElementById('image_url');
      const prevWrap = document.getElementById('image_preview_wrap');
      const prevImg = document.getElementById('image_preview');
      function showPreview(u){ if (!u) return; prevImg.src = u; prevWrap.style.display = 'block'; }
      if (urlInput && urlInput.value) { showPreview(urlInput.value); }
      if (file){
        file.addEventListener('change', async () => {
          if (!file.files || !file.files[0]) return;
          const fd = new FormData();
          fd.append('image_file', file.files[0]);
          // get csrf from any form token on page
          const tokenInput = document.querySelector('input[name="_token"]');
          const token = tokenInput ? tokenInput.value : '';
          try{
            const res = await fetch('{{ route('admin.services.upload') }}', {
              method: 'POST',
              headers: { 'X-CSRF-TOKEN': token },
              body: fd
            });
            const data = await res.json();
            if (data && data.url){ urlInput.value = data.url; showPreview(data.url); }
          }catch(e){ console.error(e); }
        });
      }
      if (urlInput){
        urlInput.addEventListener('input', () => {
          if (urlInput.value && urlInput.value.length > 6) { showPreview(urlInput.value); }
        });
      }
    })();
  </script>
@endsection
