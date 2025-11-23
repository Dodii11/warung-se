<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
</head>
<body>
    <h2>Login Admin</h2>
    <form method="POST" action="{{ url('/login/admin') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email_admin" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
