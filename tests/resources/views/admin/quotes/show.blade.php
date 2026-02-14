@extends('admin.layout')

@section('title', 'View Quote')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.quotes.index') }}">Back</a>
      <h2 style="margin:0">Quote #{{ $quote->id }}</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.quotes.edit', $quote) }}">Edit</a>
    </div>
  </div>

  <div class="panel" style="background:#0f172a; border:1px solid rgba(148,163,184,.12); border-radius:12px; padding:16px">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px">
      <div><strong>Name</strong><div>{{ $quote->name }}</div></div>
      <div><strong>Email</strong><div>{{ $quote->email }}</div></div>
      <div><strong>Service</strong><div>{{ optional($quote->service)->title ?? '—' }}</div></div>
      <div><strong>Subject</strong><div>{{ $quote->subject ?? '—' }}</div></div>
      <div style="grid-column: 1 / -1"><strong>Message</strong><div style="white-space:pre-wrap">{{ $quote->message }}</div></div>
      <div><strong>Status</strong><div>{{ ucfirst(str_replace('_',' ',$quote->status)) }}</div></div>
      <div style="grid-column: 1 / -1"><strong>Notes</strong><div style="white-space:pre-wrap">{{ $quote->notes ?? '—' }}</div></div>
      <div><strong>Created</strong><div>{{ $quote->created_at }}</div></div>
      <div><strong>Updated</strong><div>{{ $quote->updated_at }}</div></div>
    </div>
  </div>
@endsection
