@extends('admin.layout')

@section('title', 'Edit user - Admin')

@section('content')
  @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
    <div style="display:flex; gap:8px; align-items:center">
      <a class="btn" href="{{ route('admin.users.index') }}">Back</a>
      <h2 style="margin:0">Edit user</h2>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf
    @method('PUT')

    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>

    <label for="email">Email (login)</label>
    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>

    <label for="password">New password (leave blank to keep current)</label>
    <input id="password" type="password" name="password" autocomplete="new-password">

    <label for="password_confirmation">Confirm new password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">

    <label style="display:flex; gap:8px; align-items:center; margin-top:12px">
      <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}> Admin (can access admin panel)
    </label>

    <div class="actions" style="margin-top:12px; display:flex; gap:8px">
      <button class="btn" type="submit">Update user</button>
      <a class="btn" href="{{ route('admin.users.index') }}">Cancel</a>
    </div>
  </form>
@endsection
