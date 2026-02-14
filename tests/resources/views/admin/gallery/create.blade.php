@extends('admin.layout')

@section('title', 'Create Gallery Item - Admin')

@section('content')
  @if ($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <h2 style="margin:0">Create Gallery Item</h2>
    <div>
      <a class="btn" href="{{ route('admin.gallery.index') }}">Back</a>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
    @csrf
    <label for="image_url">Image URL</label>
    <input id="image_url" type="text" name="image_url" value="{{ old('image_url') }}" placeholder="https://..." required>
    <label for="image_file">Or upload an image (optional)</label>
    <input id="image_file" type="file" name="image_file" accept="image/*">
    <div id="preview" style="margin-top:8px; display:none">
      <img id="preview_img" src="" alt="Preview" style="width:260px; height:150px; object-fit:cover; border-radius:10px; border:1px solid rgba(148,163,184,.25)">
    </div>

    <div class="row">
      <div>
        <label for="label">Label</label>
        <input id="label" type="text" name="label" value="{{ old('label') }}" placeholder="Category or title">
      </div>
      <div>
        <label for="date_label">Date Label</label>
        <input id="date_label" type="text" name="date_label" value="{{ old('date_label') }}" placeholder="12 Dec">
      </div>
    </div>

    <label for="sort_order">Sort Order</label>
    <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">

    <div class="actions">
      <button class="btn" type="submit">Create</button>
      <a class="btn" href="{{ route('admin.gallery.index') }}">Cancel</a>
    </div>
  </form>

  <script>
    (function(){
      const f = document.getElementById('image_file');
      const url = document.getElementById('image_url');
      const p = document.getElementById('preview');
      const img = document.getElementById('preview_img');
      function show(u){ if (!u) return; img.src = u; p.style.display = 'block'; }
      if (url && url.value) show(url.value);
      if (url){ url.addEventListener('input', () => { if (url.value && url.value.length > 6) show(url.value); }); }
      if (f){
        f.addEventListener('change', async () => {
          if (!f.files || !f.files[0]) return;
          const fd = new FormData();
          fd.append('image_file', f.files[0]);
          const token = (document.querySelector('input[name="_token"]') || {}).value || '';
          try{
            const res = await fetch('{{ route('admin.services.upload') }}', { // reuse upload endpoint
              method: 'POST', headers: { 'X-CSRF-TOKEN': token }, body: fd
            });
            const data = await res.json();
            if (data && data.url){ url.value = data.url; show(data.url); }
          }catch(e){ console.error(e); }
        });
      }
    })();
  </script>
@endsection
