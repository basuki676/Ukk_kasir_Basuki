@extends('layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.view') }}" class="link"><i
                                        class="mdi mdi-home-outline fs-4"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data User</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Data User</h1>
                </div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col text-end">
                <a href="{{ route('user.add') }}" class="btn btn-primary">
                    Tambah User
                </a>
                <a href="{{ route('users.export') }}" class="btn btn-success">
                    Export Excel
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row justify-content-end">
                <div class="col text-end">
                    <a href="{{ route('user.add') }}" class="btn btn-primary">
                        Tambah User
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Role</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $no => $data)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->role }}</td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <a href="{{ route('user.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('user.delete', $data->id) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE"><button type="submit"
                                                class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
