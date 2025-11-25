<?php

use App\Http\Controllers\AdoptionDownloadController;
use App\Http\Controllers\ArtistAdoptionController;
use App\Http\Controllers\ArtistAdoptionDetailController;
use App\Http\Controllers\ArtistCommissionController;
use App\Http\Controllers\ArtistCommissionDetailController;
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


// Route for adoption (purchase) submissions from the public gallery page
Route::get('/gallery', [GalleryPageController::class, 'index'])->name('gallery');
// JSON endpoint for gallery item details (safe, minimal payload)
Route::get('/gallery/json/{id}', [GalleryPageController::class, 'json'])->name('gallery.json');
Route::post('/gallery/adopt', [GalleryPageController::class, 'store'])->name('gallery.adopt');

Route::post('/login', [LoginPageController::class, 'processLogin'])->name('process_login');
Route::post('/register', [LoginPageController::class, 'processRegister'])->name('process_register');

// Artist Routes
Route::prefix('artist')->middleware(['auth', 'role:artist'])->group(function () {
    // gallery
    Route::get('/gallery', [ArtistGalleryController::class, 'index'])->name('artist.gallery');

    // commissions
    Route::get('/commissions', [ArtistCommissionController::class, 'index'])->name('artist.commissions');
    Route::get('/getCommissions', [ArtistCommissionController::class, 'getCommissions'])->name('artist.getCommissions');

    Route::get('/commission_detail/{commission_id}', [ArtistCommissionDetailController::class, 'detail'])->name('artist.commission_detail');
    Route::post('/commissions/status/{commissionId}', [ArtistCommissionDetailController::class, 'update_progress_status'])->name('artist.commission_status_update');
    Route::post('/commissions/price/{commissionId}', [ArtistCommissionDetailController::class, 'update_price'])->name('artist.commission_price_update');
    Route::post('/commissions/deadline/{commissionId}', [ArtistCommissionDetailController::class, 'update_deadline'])->name('artist.commission_deadline_update');
    Route::post('/commissions/cancel/{commissionId}', [ArtistCommissionDetailController::class, 'cancel'])->name('artist.commission_cancel');
    Route::post('/commissions/payment/{commissionId}', [ArtistCommissionDetailController::class, 'update_payment_status'])->name('artist.commission_payment_update');
    Route::post('/commissions/upload/{commissionId}', [ArtistCommissionDetailController::class, 'upload_image'])->name('artist.commission_upload');

    // adoptions
    Route::put('/gallery/{id}', [ArtistGalleryController::class, 'update'])->name('artist.gallery.update');
    Route::delete('/gallery/{id}', [ArtistGalleryController::class, 'destroy'])->name('artist.gallery.destroy');
    Route::post('/gallery/store', [ArtistGalleryController::class, 'store'])->name('artist.gallery.store');
    Route::get('/adoptions', [ArtistAdoptionController::class, 'index'])->name('artist.adoptions');
    Route::get('/getAdoptions', [ArtistAdoptionController::class, 'getAdoptions'])->name('artist.getAdoptions');

    Route::get('/adoption_detail/{adoptionId}', [ArtistAdoptionDetailController::class, 'detail'])->name('artist.adoption_detail');
    Route::post('/adoptions/status/{adoptionId}', [ArtistAdoptionDetailController::class, 'update_order_status'])->name('artist.adoption_status_update');
    Route::post('/adoptions/confirm_payment/{adoptionId}', [ArtistAdoptionDetailController::class, 'confirm_payment'])->name('artist.adoption_confirm_payment');
    Route::post('/adoptions/invalidate_payment/{adoptionId}', [ArtistAdoptionDetailController::class, 'invalidate_payment'])->name('artist.adoption_invalidate_payment');
    Route::post('/adoptions/save_notes/{adoptionId}', [ArtistAdoptionDetailController::class, 'save_notes'])->name('artist.adoption_save_notes');
    Route::post('/adoptions/deliver_file/{adoptionId}', [ArtistAdoptionDetailController::class, 'deliver_file'])->name('artist.adoption_deliver_file');
    Route::post('/adoptions/mark_complete/{adoptionId}', [ArtistAdoptionDetailController::class, 'mark_complete'])->name('artist.adoption_mark_complete');
});

// Public download routes goes here (no auth required)
Route::get('/adoption_download/{adoptionId}', [AdoptionDownloadController::class, 'download'])->name('adoption.download');

// Member Routes
Route::prefix('member')->middleware(['auth', 'role:client'])->group(function () {
    Route::get('/history', [HistoryMemberController::class, 'index'])->name('member.history');
    Route::get('/getHistory', [HistoryMemberController::class, 'getHistory'])->name('member.getHistory');

    Route::get('/history/adoption/{id}', [HistoryMemberController::class, 'adoption_detail'])->name('member.history_adoption_detail');
    Route::get('/history/commission/{id}', [HistoryMemberController::class, 'commission_detail'])->name('member.history_commission_detail');
    Route::post('/history/commission/review/{commissionId}', [HistoryMemberController::class, 'submit_review'])->name('member.history_commission_submit_review');

    Route::get('/commission_type', [CommissionMemberController::class, 'index'])->name('member.commission_type');
    Route::get('/commission_form', [CommissionMemberController::class, 'form'])->name('member.commission_form');
    Route::post('/commission_store', [CommissionMemberController::class, 'store'])->name('member.commission_store');
});

Route::post('/logout', function () {
    // Logic for logging out the user
    Auth::logout();
    return redirect('/');
})->name('logout');
