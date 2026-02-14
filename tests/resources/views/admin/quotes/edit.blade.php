@extends('admin.layout')

@section('title', 'Edit Quote')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.quotes.index') }}">Back</a>
      <h2 style="margin:0">Edit Quote #{{ $quote->id }}</h2>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.quotes.update', $quote) }}">
    @csrf
    @method('PUT')

    <label for="service_id">Service</label>
    <select id="service_id" name="service_id" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">
      <option value="">—</option>
      @foreach($services as $svc)
        <option value="{{ $svc->id }}" {{ (string)old('service_id', $quote->service_id)===(string)$svc->id? 'selected':'' }}>{{ $svc->title }}</option>
      @endforeach
    </select>

    <label for="status">Status</label>
    <select id="status" name="status" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">
      @foreach(['new'=>'New','in_progress'=>'In Progress','closed'=>'Closed'] as $key=>$label)
        <option value="{{ $key }}" {{ old('status', $quote->status)===$key? 'selected':'' }}>{{ $label }}</option>
      @endforeach
    </select>

    <label for="notes">Notes</label>
    <textarea id="notes" name="notes" class="input" style="min-height:120px; padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">{{ old('notes', $quote->notes) }}</textarea>

    <div class="actions" style="margin-top:12px; display:flex; gap:8px">
      <button class="btn" type="submit">Save</button>
      <a class="btn" href="{{ route('admin.quotes.show', $quote) }}">Cancel</a>
    </div>
  </form>
@endsection
