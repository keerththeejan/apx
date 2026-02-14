@extends('admin.layout')

@section('title', 'Quotes - Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Quotes</h2>
    </div>
  </div>

  <form method="get" style="display:flex; gap:8px; margin-bottom:10px">
    <select name="status" class="input" style="padding:8px 10px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">
      <option value="">All Status</option>
      @foreach(['new'=>'New','in_progress'=>'In Progress','closed'=>'Closed'] as $key=>$label)
        <option value="{{ $key }}" {{ request('status')===$key? 'selected':'' }}>{{ $label }}</option>
      @endforeach
    </select>
    <select name="service_id" class="input" style="padding:8px 10px; border-radius:8px; background:#0b1a21; color:#e5e7eb; border:1px solid rgba(148,163,184,.25)">
      <option value="">All Services</option>
      @foreach($services as $svc)
        <option value="{{ $svc->id }}" {{ (string)request('service_id')===(string)$svc->id? 'selected':'' }}>{{ $svc->title }}</option>
      @endforeach
    </select>
    <button class="btn" type="submit">Filter</button>
  </form>

  <div class="tablewrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Service</th>
          <th>Subject</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($quotes as $q)
          <tr>
            <td>{{ $q->id }}</td>
            <td>{{ $q->name }}</td>
            <td>{{ $q->email }}</td>
            <td>{{ optional($q->service)->title ?? '—' }}</td>
            <td>{{ $q->subject }}</td>
            <td>
              <span style="padding:4px 8px; border-radius:8px; border:1px solid rgba(148,163,184,.25)">{{ ucfirst(str_replace('_',' ',$q->status)) }}</span>
            </td>
            <td class="actions" style="display:flex; gap:8px">
              <a class="btn" href="{{ route('admin.quotes.show', $q) }}">View</a>
              <a class="btn" href="{{ route('admin.quotes.edit', $q) }}">Edit</a>
              <form method="POST" action="{{ route('admin.quotes.destroy', $q) }}" onsubmit="return confirm('Delete this quote?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" style="color:#94a3b8">No quotes yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if(method_exists(($quotes ?? null),'links'))
    <div style="margin-top:10px">{!! $quotes->withQueryString()->links() !!}</div>
  @endif
@endsection
