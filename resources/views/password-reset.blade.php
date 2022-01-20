<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=chrome">
    <title>Document</title>
    @include("components.bootstrap")
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.1/examples/sign-in/signin.css">
    <title>Laravel</title>
    @include("components.forms-css")
</head>



<body class="text-center">
    <main class="form-signin">

        @include("components.forms-img")

        <h1 class="h3 mb-3 fw-normal">Please Enter Your Email</h1>
        <form method="POST" action="/forgot/password/reset">
            @csrf
            <div class="form-floating">
                <input name="email" type="email" class="form-control" id="floatingInput"
                    placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <button class="w-100 btn btn-lg btn-warning mt-3" type="submit">Reset Password</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p>

        </form>
    </main>




</body>


</html>
