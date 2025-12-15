<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
</head>

<body>
    <h1>HALO!</h1>
    <p>Terima kasih telah mendaftar! Silakan gunakan kode verifikasi di bawah ini untuk mengaktifkan akun Anda:</p>
    <h2 syle="background: #f3f3f3; padding: 10px; display: inline-block; letter-spacing: 5px;">{{$code ?? 'XXXXXX'}}</h2>
    <p>Jika Anda tidak melakukan pendaftaran, abaikan email ini.</p>
    <p>Salam,<br>Tim Warung SE</p>
</body>
</html>