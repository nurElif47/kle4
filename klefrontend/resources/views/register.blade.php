<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

    <form method="POST">
    @csrf

    <div class="container"
        style="margin-top:100px; background-color: lightblue; width: 100%; max-width: 500px; padding: 24px; border: 1px solid #dedede; border-radius: 0;">
        <h3 class="login-social-signin-title" style="text-align: center;">KLE</h3>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Hata mesajı -->
        @if ($errors->any())
          
        @endif

        <div class="form-group">
            <label for="name" style="font-size: 15px;">İsim Soyisim</label>
            <input type="name" class="form-control" id="name" name="name" placeholder="İsiminizi Ve Soyisminizi Giriniz" value="{{ old('name') }}">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>

        <div class="form-group">
            <label for="email" style="font-size: 15px;">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Mailinizi Giriniz" value="{{ old('email') }}">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" style="font-size: 15px;">Şifre</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Şifrenizi Giriniz">
            @error('password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation" style="font-size: 15px;">Şifre Tekrar</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Şifrenizi Tekrar Giriniz">
            @error('password_confirmation')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <li style="list-style-type: none;">
            <a href='/login'  class="forgot-guest-buy" rel="nofollow" style="display: flex; justify-content: flex-end;">
                Giriş Yap
            </a>
        </li>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px; font-size: 15px; background-color: #b098d9;">
            Kaydol
        </button>
    </div>
</form>

</body>
</html>
