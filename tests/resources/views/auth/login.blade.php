<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <style>
    body{font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; background:#0b1220; color:#e2e8f0; margin:0; display:grid; place-items:center; min-height:100vh}
    .card{width:100%; max-width:380px; background:#0f172a; border:1px solid rgba(148,163,184,.12); border-radius:12px; padding:20px}
    h1{margin:0 0 12px; font-size:20px}
    label{display:block; font-size:14px; color:#cbd5e1; margin:10px 0 6px}
    input{width:100%; padding:10px 12px; border-radius:8px; border:1px solid rgba(148,163,184,.25); background:#0b1a21; color:#e5e7eb}
    .row{display:flex; justify-content:space-between; align-items:center; margin-top:10px; font-size:14px}
    .btn{margin-top:14px; width:100%; padding:10px 14px; border-radius:10px; background:#3b82f6; color:#fff; border:0; font-weight:700; cursor:pointer}
    .error{background: rgba(239,68,68,.15); color:#fecaca; border:1px solid rgba(239,68,68,.35); padding:10px 12px; border-radius:8px; font-size:14px; margin-bottom:10px}
    a{color:#93c5fd}
  </style>
</head>
<body>
  <div class="card">
    <h1>Admin Login</h1>

    @if ($errors->any())
      <div class="error">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

      <label for="password">Password</label>
      <input id="password" type="password" name="password" required>

      <div class="row">
        <label style="display:flex; align-items:center; gap:8px">
          <input type="checkbox" name="remember"> Remember me
        </label>
        <a href="/">Back to site</a>
      </div>

      <button class="btn" type="submit">Sign in</button>
    </form>
  </div>
</body>
</html>
