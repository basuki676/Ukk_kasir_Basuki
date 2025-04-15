<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registrasi</title>
            <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
        </head>
        <body>

            <div class="text-center">
                <h2>Registrasi Aplikasi</h2>
                <p>silahkan isi folmulir berikut untuk registrasi aplikasi</p>

                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-start">
                                <form action="{{ route('register.create') }}" method="post">
                                    @csrf
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control mb-2">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control mb-2">
                                    <label>Password</label>
                                    <input type="text" name="password" class="form-control mb-2">
                                    <button class="btn btn-primary">Registrasi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </body>
        </html>
