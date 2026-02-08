@extends('admin.layout')

@section('title', 'Customer Reviews - Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Customer Reviews</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.customerreviews.create') }}">Add Review</a>
    </div>
  </div>

  <div class="tablewrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Customer</th>
          <th>Role / Company</th>
          <th>Review</th>
          <th>Rating</th>
          <th>Visible</th>
          <th>Order</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($reviews as $r)
          <tr>
            <td>{{ $r->id }}</td>
            <td>{{ $r->customer_name }}</td>
            <td>{{ $r->role_or_company ?? '—' }}</td>
            <td style="max-width:320px">{{ \Illuminate\Support\Str::limit($r->review_text, 80) }}</td>
            <td>{{ $r->rating ? str_repeat('★', (int)$r->rating) . str_repeat('☆', 5 - (int)$r->rating) : '—' }}</td>
            <td>
              @if($r->is_visible)
                <span style="background:#052; color:#c7f9cc; border:1px solid #0a4; padding:4px 8px; border-radius:8px">Visible</span>
              @else
                <span style="background: rgba(239,68,68,.15); color:#fecaca; border:1px solid rgba(239,68,68,.35); padding:4px 8px; border-radius:8px">Hidden</span>
              @endif
            </td>
            <td>{{ $r->sort_order }}</td>
            <td class="actions" style="display:flex; gap:8px; flex-wrap:wrap">
              <a class="btn" href="{{ route('admin.customerreviews.edit', $r) }}">Edit</a>
              <form method="POST" action="{{ route('admin.customerreviews.destroy', $r) }}" onsubmit="return confirm('Delete this review?')" style="display:inline">
                @csrf
                @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="8" style="color:#94a3b8">No customer reviews yet. Click "Add Review".</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if(method_exists($reviews ?? null, 'links'))
    <div style="margin-top:10px">{!! $reviews->withQueryString()->links() !!}</div>
  @endif
@endsection
