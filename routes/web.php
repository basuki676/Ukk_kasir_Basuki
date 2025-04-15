<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CekRole;

Route::middleware('guest')
    ->prefix('auth')
    ->group(function () {
        Route::get('/register', [AuthController::class, 'ViewRegister'])->name('register.view');
        Route::post('/register/add', [AuthController::class, 'CreateRegister'])->name('register.create');
        Route::get('/login', [AuthController::class, 'ViewLogin'])->name('login.view');
        Route::post('/login/auth', [AuthController::class, 'AuthLogin'])->name('login.auth');
    });

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard.view');
    }
    return redirect()->route('login.view');
});

Route::middleware(['auth', CekRole::class . ':admin,employe'])
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'ViewDashboard'])->name('dashboard.view');
        Route::get('/product', [ProductController::class, 'ViewData'])->name('product.view');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::prefix('sale')->group(
            callback: function () {
                Route::get('/sale', [SaleController::class, 'ViewSale'])->name('sale.view');
                Route::get('/sale/add', [SaleController::class, 'AddSale'])->name('sale.add');
                Route::post('/sale/create/post', [SaleController::class, 'CreateSalePost'])->name('sale.create.post');
                Route::get('/sale/view/post', [SaleController::class, 'ShowSalePost'])->name('sale.post');
                Route::post('/sale/add/post', [SaleController::class, 'Createsale'])->name('sale.create');
                Route::get('/sale/view/invoice/{id}', [SaleController::class, 'viewInvoice'])->name('sale.invoice');
                Route::get('/sale/post/member/{id}', [SaleController::class, 'CreateSaleMember'])->name('sale.member');
                route::post('sale/add/post/member/{id}', [SaleController::class, 'CreateSaleMemberPost'])->name('sale.member.post');
                Route::get('/sales/export', [ExportController::class, 'exportExcel'])->name('sale.export');
                Route::get('/export/pdf/{id}', [ExportController::class, 'ExportPDF'])->name('sale.export.pdf');
                Route::get('/users/export', [ExportController::class, 'exportUsersExcel'])->name('users.export');
            },
        );
    });

Route::middleware(['auth', CekRole::class . ':admin'])
    ->prefix('admin')
    ->group(function () {
        Route::prefix('product')->group(function () {
            Route::get('/add', [ProductController::class, 'AddData'])->name('product.add');
            Route::post('/create', [ProductController::class, 'CreateData'])->name('product.create');
            Route::get('/edit/{id}', [ProductController::class, 'EditData'])->name('product.edit');
            Route::post('/update/{id}', [ProductController::class, 'UpdateData'])->name('product.update');
            Route::delete('/delete/{id}', [ProductController::class, 'DeleteData'])->name('product.delete');
            Route::patch('/product/update-stock/{id}', [ProductController::class, 'updateStock'])->name('product.updateStock');
        });
        Route::get('/users', [UsersController::class, 'ViewUsers'])->name('users.view');
        Route::prefix('user')->group(function () {
            Route::get('/add', [UsersController::class, 'AddData'])->name('user.add');
            Route::post('/create', [UsersController::class, 'CreateData'])->name('user.create');
            Route::get('/edit/{id}', [UsersController::class, 'EditData'])->name('user.edit');
            Route::post('/update/{id}', [UsersController::class, 'UpdateData'])->name('user.update');
            Route::delete('/delete/{id}', [UsersController::class, 'DeleteData'])->name('user.delete');
        });
    });
