<!DOCTYPE html>
<html>
<head>
    <title>Dashboard SuperAdmin</title>
</head>
<body>
    <h2>Ini Dashboard SuperAdmin</h2>
    <a href="{{ url('/kelola-menu') }}">Kelola Menu</a> |
    <a href="{{ url('/kelola-driver') }}">Kelola Driver</a> |
    <a href="{{ url('/kelola-pelanggan') }}">Kelola Pelanggan</a> |
    <a href="{{ url('/kelola-pesanan') }}">Kelola Pesanan</a> |
    <a href="{{ url('/superadmin/add-admin') }}">Add Admin</a> |
    <a href="{{ url('/logout/superadmin') }}">Logout</a>
</body>
</html>
