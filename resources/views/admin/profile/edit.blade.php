@extends('admin.layout')

@section('title', 'My Account - Admin')
@section('brand', 'My Account')

@section('content')
  <div class="wrap">
    @if(session('status'))
      <div class="status">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
      <div style="display:flex; gap:8px; align-items:center">
        <a class="btn" href="{{ route('admin.dashboard') }}">Back</a>
        <h2 style="margin:0">My Account</h2>
      </div>
    </div>

    <h3 style="margin:16px 0 8px">Change name & email</h3>
    <form method="POST" action="{{ route('admin.profile.update') }}">
      @csrf
      <label for="name">Name</label>
      <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
      <label for="email">Email (login)</label>
      <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
      <div class="actions">
        <button class="btn" type="submit">Save profile</button>
      </div>
    </form>

    <hr style="border:0; border-top:1px solid var(--border); margin:20px 0">

    <h3 style="margin:16px 0 8px">Change password</h3>
    <p style="color:var(--muted); margin:0 0 10px">Update your login password.</p>
    <a class="btn" href="{{ route('admin.profile.password') }}">Change password</a>
  </div>
@endsection
