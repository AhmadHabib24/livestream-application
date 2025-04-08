<?php

use App\Http\Controllers\Admin\LivestreamController as AdminLivestreamController;
use App\Http\Controllers\LivestreamController;
use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Livestream routes for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/my-livestreams', [LivestreamController::class, 'myLivestreams'])->name('livestreams.my');
    Route::get('/livestreams/create', [LivestreamController::class, 'create'])->name('livestreams.create');
    Route::post('/livestreams', [LivestreamController::class, 'store'])->name('livestreams.store');
    Route::get('/livestreams/{livestream}/edit', [LivestreamController::class, 'edit'])->name('livestreams.edit');
    Route::put('/livestreams/{livestream}', [LivestreamController::class, 'update'])->name('livestreams.update');
    Route::delete('/livestreams/{livestream}', [LivestreamController::class, 'destroy'])->name('livestreams.destroy');
    
    // Go Live and End Live
    Route::post('/livestreams/{livestream}/go-live', [LivestreamController::class, 'goLive'])->name('livestreams.go-live');
    Route::post('/livestreams/{livestream}/end-live', [LivestreamController::class, 'endLive'])->name('livestreams.end-live');
});
// Livestream routes for all users
Route::get('/livestreams', [LivestreamController::class, 'index'])->name('livestreams.index');
Route::get('/livestreams/live-now', [LivestreamController::class, 'liveNow'])->name('livestreams.live-now');
Route::get('/livestreams/{livestream}', [LivestreamController::class, 'show'])->name('livestreams.show');



// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/livestreams', [AdminLivestreamController::class, 'index'])->name('livestreams.index');
    Route::get('/livestreams/live', [AdminLivestreamController::class, 'liveStreams'])->name('livestreams.live');
    Route::get('/livestreams/{livestream}', [AdminLivestreamController::class, 'show'])->name('livestreams.show');
    Route::post('/livestreams/{livestream}/toggle-active', [AdminLivestreamController::class, 'toggleActive'])->name('livestreams.toggle-active');
    Route::post('/livestreams/{livestream}/end-live', [AdminLivestreamController::class, 'endLive'])->name('livestreams.end-live');
});

require __DIR__.'/auth.php';
