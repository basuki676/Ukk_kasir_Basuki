<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
</head>

<body>

    <div class="text-center">
        <h2>Login Aplikasi</h2>
        <p>silahkan masuk dengan akun yang sudah anda daftarkan</p>

        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-start">
                        <form action="{{ route('login.auth') }}" method="post">
                            @csrf
                            <label>Email</label>
                            <input type="text" name="email" id="email" class="form-control mb-2">
                            <label>Password</label>
                            <input type="password" id="password" name="password" class="form-control mb-2">
                            <button class="btn btn-primary">Login</button>
                        </form>

                        @if (session('error'))
                            <p class="text-danger">{{ session('error') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
