<!DOCTYPE html>
<html>
<head>
    <title>Login SuperAdmin</title>
</head>
<body>
    <h2>Login SuperAdmin</h2>
    <form method="POST" action="{{ url('/login/superadmin') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email_super" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
