<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <form id="admin_login" method="POST" action="{{ route('admin.login.submit') }}">

        @csrf

        <div class="input-group"> <span class="input-group-addon"> <i class="zmdi zmdi-account"></i> </span>

            <div class="form-line">

                <input type="email" class="form-control" name="email" placeholder="E-Posta Adresi"
                    value="{{ old('email') }}" required autofocus>

            </div>

            @if ($errors->has('email'))

                <span class="text-danger"><strong>{{ $errors->first('email') }}</strong></span>

            @endif

        </div>



        <div class="input-group"> <span class="input-group-addon"> <i class="zmdi zmdi-lock"></i> </span>

            <div class="form-line">

                <input type="password" class="form-control" name="password" placeholder="Şifre" required>

            </div>

        </div>

        <div>

            <div class="">

                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="rememberme"
                    class="filled-in chk-col-pink">

                <label for="rememberme">Beni Hatırla</label>

            </div>

            <div class="text-center">

                <button type="submit" class="btn btn-raised waves-effect g-bg-cyan">Giriş Yap</button>

            </div>

        </div>

    </form>

</body>

</html>
