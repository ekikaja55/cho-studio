<?php

use App\Http\Controllers\ArtistAdoptionController;
use App\Http\Controllers\ArtistCommisionController;
use App\Http\Controllers\GalleryPageController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\LoginPageController;
use App\Http\Controllers\ArtistGalleryController;
use App\Http\Controllers\CommissionMemberController;
use App\Http\Controllers\HistoryMemberController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('starting');
});
Route::get('/login', [LoginPageController::class, 'login'])->name('login');
Route::get('/register', [LoginPageController::class, 'register'])->name('register');
Route::get('/termsnconditions', [LoginPageController::class, 'termsnconditions'])->name('termsnconditions');
Route::get('/home', [HomePageController::class, 'index'])->name('home');
Route::get('/gallery', [GalleryPageController::class, 'index'])->name('gallery');
// Route for adoption (purchase) submissions from the public gallery page
Route::post('/gallery/adopt', [GalleryPageController::class, 'store'])->name('gallery.adopt');

Route::post('/login', [LoginPageController::class, 'processLogin'])->name('process_login');
Route::post('/register', [LoginPageController::class, 'processRegister'])->name('process_register');

// Artist Routes
// TODO: Kasih middleware nanti
Route::prefix('artist')->middleware(['auth', 'role:artist'])->group(function () {
    Route::get('/commisions', [ArtistCommisionController::class, 'index'])->name('artist.commisions');
    Route::get('/gallery', [ArtistGalleryController::class, 'index'])->name('artist.gallery');
    Route::put('/artist/gallery/{id}', [ArtistGalleryController::class, 'update'])->name('artist.gallery.update');
    Route::delete('/artist/gallery/{id}', [ArtistGalleryController::class, 'destroy'])->name('artist.gallery.destroy');
    Route::post('/gallery/store', [ArtistGalleryController::class, 'store'])->name('artist.gallery.store');
    Route::get('/commision-detail', [ArtistCommisionController::class, 'detail'])->name('artist.commision_detail');
    Route::get('/adoptions', [ArtistAdoptionController::class, 'index'])->name('artist.adoptions');
    Route::get('/adoption-detail', [ArtistAdoptionController::class, 'detail'])->name('artist.adoption_detail');
});

Route::prefix('member')->middleware('auth', "role:client")->group(function () {
    Route::get('/history', [HistoryMemberController::class, 'index'])->name('member.history');
    Route::get('/commission_type', [CommissionMemberController::class, 'index'])->name('member.commission_type');
    Route::get('/commission_form', [CommissionMemberController::class, 'form'])->name('member.commission_form');
    Route::post('/commission_store', [CommissionMemberController::class, 'store'])->name('member.commission_store');
    Route::get('/history/{id}', [HistoryMemberController::class, 'detail'])->name('member.history_detail');
});

// TODO: ganti ini nanti 
Route::post('/logout', function () {
    // Logic for logging out the user
    Auth::logout();
    return redirect('/');
})->name('logout');