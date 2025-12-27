<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admin Portal</title></head>
<body>
    <h1>Admin Portal</h1>
    <p>Welcome, {{ auth()->user()->name }}</p>

    <ul>
        <li><a href="https://hrmis.local/login/sso">Open HRMIS</a></li>
        <li><a href="https://fleet.local/login/sso">Open Fleet</a></li>
        <li><a href="https://stores.local/login/sso">Open Stores</a></li>
    </ul>

    <form method="POST" action="{{ url('/logout') }}">
        @csrf
        <button>Logout</button>
    </form>
</body>
</html>
