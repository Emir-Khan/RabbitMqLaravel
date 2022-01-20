<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include("components.bootstrap")
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.1/examples/sign-in/signin.css">
    <title>Laravel</title>
    @include("components.forms-css")
</head>

<body class="text-center">
    <main class="form-signin">

        @include("components.forms-img")

        <h1 class="h3 mb-3 fw-normal">Please Log In</h1>
        <form method="POST" action="/login/post">
            @csrf
            <div class="form-floating">
                <input name="email" value="{{ old('email') }}" type="email" class="form-control" id="floatingInput"
                    placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input name="password" type="password" class="form-control" id="floatingPassword"
                    placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="checkbox mb-3">
                <label>
                    <a href="forgot/password">Forgot Password?</a>
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Log In</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p>
        </form>



        </form>
    </main>
    <ul style="position: absolute;bottom:0;right:0;" class="h-100 w-25">
        @foreach ($errors->all() as $error)
            <div style="height: 50px; display: block">

            </div>
            <style>
                .alert {
                    position: absolute;
                    bottom: 0;
                    right: 0;
                }

            </style>
            <div style="display: block; margin-bottom: 50px; position: absolute;
    bottom: 0;
    right: {{ 10 }}px;list-style-type: none;" class="alert alert-danger alert-dismissible fade show"
                role="alert">
                <strong>Hatalı Giriş!</strong> {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    </ul>



</body>

</html>
