<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Models\Feature;
use App\Models\HomeBanner;
use App\Models\Service;

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

Route::get('/', function () {
    if (Auth::check() && Auth::user()->is_admin) {
        return redirect('/admin');
    }
    $features = Feature::orderBy('sort_order')->orderBy('id')->take(4)->get();
    $banner = HomeBanner::first();
    $services = Service::orderBy('sort_order')->orderBy('id')->take(5)->get();
    return view('home', compact('features','banner','services'));
});

Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('features', FeatureController::class)->names('admin.features');
    Route::get('banner', [HomeBannerController::class, 'edit'])->name('admin.banner.edit');
    Route::post('banner', [HomeBannerController::class, 'update'])->name('admin.banner.update');
    Route::resource('services', ServiceController::class)->names('admin.services');
    Route::get('settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('admin.settings.update');
});
