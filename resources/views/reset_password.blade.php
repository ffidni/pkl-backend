<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('main-logo.png') }}" type="image/png">
    <title>ePKL - Reset Password</title>
    <link rel="stylesheet" href="{{asset('styles/reset.css')}}">
    <link rel="stylesheet" href="{{asset('styles/styles.css')}}">
</head>
<body>
    <div class="form-container">
        @if($resetTokenData)
        <form id="form-id" onsubmit="aSendRequest(event); return false;">
            <p class="title" style="margin-bottom: 1em;">Ganti Password</p>
            <div class="form-container__row">
             <label for="password">Password Baru</label>
             <input id="password" type="password" class="form-container__input" required>
           </div>
             <div class="form-container__row">
                <label for="confirm_password">Konfirmasi Password Baru</label>
                <input id="confirm_password" type="password" class="form-container__input"  required>
             </div>
            <button type="submit" class="submit-btn">
             Kirim
             </button>
        </form>
        @else
        <p class="title">Token tidak ditemukan/expired</p>
        <p class="title" style="text-align: center">Silahkan kirim request 'lupa password' <br>lagi di aplikasi ePKL!</p>
        @endif
        <p class="title hidden" id="success">
            Berhasil merubah password, coba login kembali di aplikasi ePkl.
        </p>
    </div>
    <script src="{{ asset('js/api-consume.js') }}"></script>
    <script>
        var tokenData = {!! json_encode($resetTokenData) !!};

        function aSendRequest(event) {
            event.preventDefault();
            sendRequest(document, tokenData.token);
        }
    </script>

</body>
</html>