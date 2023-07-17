<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('main-logo.png') }}" type="image/png">
    <title>ePKL - Konfirmasi</title>
    <link rel="stylesheet" href="{{asset('styles/reset.css')}}">
    <link rel="stylesheet" href="{{asset('styles/styles.css')}}">
</head>
<body>
    <div class="form-container">
        @if(isset($error))
        <p class="title">
            {{ $error }}
        </p>
        @else
        <p class="title">
            Verifikasi email anda berhasil!<br>silahkan kembali ke aplikasi ePkl!.
        </p>
        @endif
    </div>
</body>
</html>