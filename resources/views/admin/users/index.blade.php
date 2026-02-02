@extends('admin.layout')

@section('title', 'Users - Admin')

@section('content')
  @if(session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif
  @if(session('error'))
    <div class="error">{{ session('error') }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
      <h2 style="margin:0">Users</h2>
    </div>
    <div>
      <a class="btn" href="{{ route('admin.users.create') }}">Add user</a>
    </div>
  </div>

  <div class="tablewrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Admin</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
          <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->is_admin ? 'Yes' : 'No' }}</td>
            <td>{{ $u->created_at->format('Y-m-d') }}</td>
            <td class="actions" style="display:flex; gap:8px; flex-wrap:wrap">
              <a class="btn" href="{{ route('admin.users.edit', $u) }}">Edit</a>
              @if($u->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Delete this user?')" style="display:inline">
                  @csrf
                  @method('DELETE')
                  <button class="btn" type="submit" style="background:var(--danger); border-color:var(--danger)">Delete</button>
                </form>
              @endif
            </td>
          </tr>
        @empty
          <tr><td colspan="6" style="color:#94a3b8">No users yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if(method_exists($users, 'links'))
    <div style="margin-top:12px">{!! $users->links() !!}</div>
  @endif
@endsection
