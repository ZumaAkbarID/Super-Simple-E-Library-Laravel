<?php

use App\Http\Controllers\Account;
use App\Http\Controllers\Anggota;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Buku;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DataPinjam;
use App\Http\Controllers\Pengurus;
use App\Http\Controllers\Pinjam;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    Route::get('/', [Dashboard::class, 'index'])->name('Dashboard');

    Route::get('/akun', [Account::class, 'index'])->name('Account');

    Route::group(['prefix' => '/anggota'], function () {
        Route::post('/tambah', [Anggota::class, 'addHandler'])->name('Anggota.Tambah');
        Route::get('/{id}/data', [Anggota::class, 'getUser'])->name('Anggota.Get');
        Route::post('/edit', [Anggota::class, 'editHandler'])->name('Anggota.Edit');
        Route::post('/hapus', [Anggota::class, 'deleteHandler'])->name('Anggota.Delete');
    });

    Route::group(['prefix' => '/pengurus'], function () {
        Route::post('/tambah', [Pengurus::class, 'addHandler'])->name('Pengurus.Tambah');
        Route::get('/{id}/data', [Pengurus::class, 'getUser'])->name('Pengurus.Get');
        Route::post('/edit', [Pengurus::class, 'editHandler'])->name('Pengurus.Edit');
        Route::post('/hapus', [Pengurus::class, 'deleteHandler'])->name('Pengurus.Delete');
    });

    Route::group(['prefix' => '/buku'], function () {
        Route::get('/', [Buku::class, 'index'])->name('Buku');
        Route::post('/tambah', [Buku::class, 'addHandler'])->name('Buku.Tambah');
        Route::get('/{id}/data', [Buku::class, 'getUser'])->name('Buku.Get');
        Route::post('/edit', [Buku::class, 'editHandler'])->name('Buku.Edit');
        Route::post('/hapus', [Buku::class, 'deleteHandler'])->name('Buku.Delete');
    });

    Route::group(['prefix' => '/pinjam'], function () {
        Route::get('/', [Pinjam::class, 'index'])->name('Pinjam');
        Route::post('/tambah', [Pinjam::class, 'addHandler'])->name('Pinjam.Tambah');
    });

    Route::group(['prefix' => '/data-pinjam'], function () {
        Route::get('/', [DataPinjam::class, 'index'])->name('Data');
        Route::get('/kembali/{id}', [DataPinjam::class, 'signBookBackHandler'])->name('Data.Kembali');
        Route::post('/hapus', [DataPinjam::class, 'deleteHandler'])->name('Data.Delete');
    });

    Route::get('/auth/logout', [Logout::class, 'handler'])->name('Auth.Logout');
});

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
    Route::get('/', function () {
        return redirect()->to(route('Auth.Login'));
    });

    Route::get('login', [Login::class, 'form'])->name('Auth.Login');
    Route::post('login', [Login::class, 'handler']);
});
