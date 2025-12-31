@extends('admin.layout')

@section('title', 'Create Quote')

@section('content')
  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.quotes.index') }}">Back</a>
      <h2 style="margin:0">Create Quote</h2>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.quotes.store') }}">
    @csrf

    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)" required>

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)" required>

    <label for="phone">Phone</label>
    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">

    <label for="subject">Subject</label>
    <input id="subject" type="text" name="subject" value="{{ old('subject') }}" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">

    <label for="service_id">Service</label>
    <select id="service_id" name="service_id" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">
      <option value="">—</option>
      @foreach($services as $svc)
        <option value="{{ $svc->id }}" {{ (string)old('service_id')===(string)$svc->id? 'selected':'' }}>{{ $svc->title }}</option>
      @endforeach
    </select>

    <label for="message">Message</label>
    <textarea id="message" name="message" class="input" style="min-height:120px; padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)" required>{{ old('message') }}</textarea>

    <label for="status">Status</label>
    <select id="status" name="status" class="input" style="padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">
      @foreach(['new'=>'New','in_progress'=>'In Progress','closed'=>'Closed'] as $key=>$label)
        <option value="{{ $key }}" {{ old('status','new')===$key? 'selected':'' }}>{{ $label }}</option>
      @endforeach
    </select>

    <label for="notes">Notes</label>
    <textarea id="notes" name="notes" class="input" style="min-height:120px; padding:10px 12px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">{{ old('notes') }}</textarea>

    <div class="actions" style="margin-top:12px; display:flex; gap:8px">
      <button class="btn" type="submit">Create Quote</button>
      <a class="btn" href="{{ route('admin.quotes.index') }}">Cancel</a>
    </div>
  </form>
@endsection
