@extends('layout')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                      <li class="breadcrumb-item"><a href="#" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                      <li class="breadcrumb-item active" aria-current="page">Tambah User</li>
                    </ol>
                  </nav>
                <h1 class="mb-0 fw-bold">Tambah User</h1> 
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <form class="form-horizontal form-material mx-2" method="POST" action="#">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12">Email <span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <input type="email" name="email" class="form-control form-control-line" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12">Nama <span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <input type="text" name="name" class="form-control form-control-line" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12">Role <span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <select name="role" class="form-select shadow-none form-control-line" required>
                                <option value="admin">Admin</option>
                                <option value="employee">Employee</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12">Password <span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <input type="password" name="password" class="form-control form-control-line" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary w-25">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
