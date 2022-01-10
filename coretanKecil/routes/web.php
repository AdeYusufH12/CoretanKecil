<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/dashboard', function () {
//     return view('admin/dashboard');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth', 'role:admin|penulis']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    /*---- Kategori ----*/
    Route::resource('/kategori', KategoriController::class);
    Route::post('/kategori/search', [KategoriController::class, 'index']);
    Route::get('/kategori/{id}/konfirmasi', [KategoriController::class, 'konfirmasi']);
    Route::get('/kategori/{id}/destroy', [KategoriController::class, 'destroy']);

    /*---- Tag ----*/
    Route::resource('/tag', TagController::class);
    Route::post('/tag/search', [TagController::class, 'index']);
    Route::get('/tag/{id}/konfirmasi', [TagController::class, 'konfirmasi']);
    Route::get('/tag/{id}/destroy', [TagController::class, 'destroy']);

    /*---- Middleware ----*/
    Route::middleware(['role:admin'])->group(function () {

        /*---- Penulis ----*/
        Route::resource('/penulis', PenulisController::class);
        Route::post('/penulis/search', [PenulisController::class, 'index']);
        Route::get('/penulis/{id}/konfirmasi', [PenulisController::class, 'konfirmasi']);
        Route::get('/penulis/{id}/hapus', [PenulisController::class, 'hapus']);

        /*---- Logo ----*/
        Route::resource('/logo', LogoController::class);
    });

    /*---- Post ----*/
    Route::resource('/post', PostController::class);
    Route::get('/post/{id}/konfirmasi', [PostController::class, 'konfirmasi']);
    Route::get('/post/{id}/rekomendasi', [PostController::class, 'rekomendasi']);
    Route::get('/post/{id}/hapus', [PostController::class, 'hapus']);
    Route::post('/post/search', [PostController::class, 'index']);

    /*---- Banner ----*/
    Route::resource('/banner', BannerController::class);
    Route::get('/banner/{id}/konfirmasi', [BannerController::class, 'konfirmasi']);
    Route::get('/banner/{id}/hapus', [BannerController::class, 'hapus']);
    Route::post('/banner/search', [BannerController::class, 'index']);

    /*---- User ----*/
    Route::get('/user/{id}/setting', [UserController::class, 'setting']);
    Route::patch('/user/{id}/setting', [UserController::class, 'ubah_password']);
});

/*---- Artikel ----*/
Route::get('/', [ArtikelController::class, 'index']);
Route::get('/{slug}', [ArtikelController::class, 'artikel']);
Route::get('/artikel-kategori/{slug}', [ArtikelController::class, 'kategori']);
Route::get('/artikel-tag/{slug}', [ArtikelController::class, 'tag']);
Route::get('/artikel-banner/{slug}', [ArtikelController::class, 'banner']);
Route::get('/artikel-author/{id}', [ArtikelController::class, 'author']);

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
