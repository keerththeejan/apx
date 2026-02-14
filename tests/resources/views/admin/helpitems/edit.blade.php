@extends('admin.layout')

@section('title', 'Edit Help Item')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif
  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.helpitems.index') }}">Back</a>
      <h2 style="margin:0">Edit Help Item</h2>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.helpitems.update', $item) }}">
    @csrf
    @method('PUT')

    <label for="icon">Icon</label>
    <input id="icon" type="text" name="icon" value="{{ old('icon', $item->icon) }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)" placeholder="e.g., 📞">

    <label for="title">Title</label>
    <input id="title" type="text" name="title" value="{{ old('title', $item->title) }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)" required>

    <label for="description">Description</label>
    <textarea id="description" name="description" class="input" style="min-height:120px; padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">{{ old('description', $item->description) }}</textarea>

    <label for="sort_order">Order</label>
    <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">

    <div class="actions" style="margin-top:12px; display:flex; gap:8px">
      <button class="btn" type="submit">Save</button>
      <a class="btn" href="{{ route('admin.helpitems.index') }}">Cancel</a>
    </div>
  </form>
@endsection
