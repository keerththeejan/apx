@extends('admin.layout')

@section('title', 'Change Password - Admin')
@section('brand', 'Change Password')

@section('content')
  <div class="wrap">
    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px">
      <div style="display:flex; gap:8px; align-items:center">
        <a class="btn" href="{{ route('admin.profile.edit') }}">Back</a>
        <h2 style="margin:0">Change password</h2>
      </div>
    </div>

    <form method="POST" action="{{ route('admin.profile.password.update') }}">
      @csrf
      <label for="current_password">Current password</label>
      <input id="current_password" type="password" name="current_password" required autocomplete="current-password">
      <label for="password">New password</label>
      <input id="password" type="password" name="password" required autocomplete="new-password">
      <label for="password_confirmation">Confirm new password</label>
      <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
      <div class="actions">
        <button class="btn" type="submit">Update password</button>
        <a class="btn" href="{{ route('admin.profile.edit') }}">Cancel</a>
      </div>
    </form>
  </div>
@endsection
