<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>
    @include("components.bootstrap")
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.1/examples/sign-in/signin.css">
    <title>Laravel</title>
    @include("components.forms-css")
</head>



<body class="text-center">
    <main class="form-signin">

        @include("components.forms-img")

        <h1 class="h3 mb-1 fw-normal">Please Enter Your New Password</h1>
        <small style="text-align: left !important" class="text-muted mb-1 d-block">{{ $user->email }}</small>
        <form method="POST" action="/reset/password/link/change">
            @csrf
            <input style="display: none !important" name="text" type="text" class="form-control" id="floatingInput"
                placeholder="link" value="{{ $link }}" aria-disabled="true" readonly>
            <input style="display: none !important" name="email" type="email" class="form-control" id="floatingInput"
                placeholder="name@example.com" value="{{ $user->email }}" readonly>
            <div class="form-floating">
                <input name="password" type="password" class="form-control" id="floatingInput"
                    placeholder="New Password">
                <label for="floatingInput">New Password</label>
            </div>

            <button class="w-100 btn btn-lg btn-warning mt-3" type="submit">Reset Password</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p>
        </form>
    </main>
</body>


</html>
