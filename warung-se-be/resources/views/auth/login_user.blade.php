<!DOCTYPE html>
<html>
<head>
    <title>Login User</title>
</head>
<body>
    <h2>Login User</h2>
    <form method="POST" action="{{ url('/login/user') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email_user" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
