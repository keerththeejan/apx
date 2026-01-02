<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceUploadController;
use App\Http\Controllers\Admin\ServiceVisibilityController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\NavLinkController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\HelpItemController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\FooterLinkController;
use App\Http\Controllers\Admin\QuoteController as AdminQuoteController;
use App\Http\Controllers\Admin\DailyActivityController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ActivityController;
use App\Models\Feature;
use App\Models\HomeBanner;
use App\Models\Service;
use App\Models\NavLink;
use App\Models\GalleryItem;
use App\Models\HelpItem;
use App\Models\DailyActivity;

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
    $features = Feature::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->get();
    $banner = HomeBanner::first();
    $services = Service::orderBy('sort_order')->orderBy('id')->take(5)->get();
    $activities = DailyActivity::where('is_visible', true)
        ->orderByDesc('activity_date')
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->take(6)
        ->get();
    $navLinks = NavLink::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->get();
    $gallery = GalleryItem::orderBy('sort_order')->orderBy('id')->take(12)->get();
    $helpItems = HelpItem::orderBy('sort_order')->orderBy('id')->take(6)->get();
    $formServices = Service::orderBy('title')->orderBy('id')->get();
    return view('home', compact('features','banner','services','activities','navLinks','gallery','helpItems','formServices'));
});

// Public home preview that never redirects admins
Route::get('/site', function () {
    $features = Feature::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->get();
    $banner = HomeBanner::first();
    $services = Service::orderBy('sort_order')->orderBy('id')->take(5)->get();
    $activities = DailyActivity::where('is_visible', true)
        ->orderByDesc('activity_date')
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->take(6)
        ->get();
    $navLinks = NavLink::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->get();
    $gallery = GalleryItem::orderBy('sort_order')->orderBy('id')->take(12)->get();
    $helpItems = HelpItem::orderBy('sort_order')->orderBy('id')->take(6)->get();
    $formServices = Service::orderBy('title')->orderBy('id')->get();
    return view('home', compact('features','banner','services','activities','navLinks','gallery','helpItems','formServices'));
})->name('site.home');

// Public quote submissions
Route::post('/quotes', [QuoteController::class, 'store'])->name('quote.store');
// Newsletter subscribe
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

// Public activities list
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');

Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('features', FeatureController::class)->names('admin.features');
    Route::patch('features/{feature}/toggle-visibility', [FeatureController::class, 'toggleVisibility'])->name('admin.features.toggle');
    Route::resource('activities', DailyActivityController::class)->names('admin.activities');
    Route::patch('activities/{activity}/toggle-visibility', [DailyActivityController::class, 'toggleVisibility'])->name('admin.activities.toggle');
    Route::patch('activities/{activity}/sort-order', [DailyActivityController::class, 'updateSortOrder'])->name('admin.activities.sort');
    Route::get('banner', [HomeBannerController::class, 'edit'])->name('admin.banner.edit');
    Route::post('banner', [HomeBannerController::class, 'update'])->name('admin.banner.update');
    Route::resource('services', ServiceController::class)->names('admin.services');
    Route::post('services/upload', [ServiceUploadController::class, 'store'])->name('admin.services.upload');
    Route::patch('services/{service}/toggle-visibility', [ServiceVisibilityController::class, 'toggle'])->name('admin.services.toggle');
    Route::get('settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::get('footer', [SettingController::class, 'footer'])->name('admin.settings.footer');
    Route::post('settings', [SettingController::class, 'update'])->name('admin.settings.update');
    Route::resource('nav-links', NavLinkController::class)->names('admin.navlinks');
    Route::resource('gallery', GalleryItemController::class)->names('admin.gallery');
    Route::resource('help-items', HelpItemController::class)->names('admin.helpitems');
    Route::resource('social-links', SocialLinkController::class)->names('admin.sociallinks');
    Route::resource('footer-links', FooterLinkController::class)->names('admin.footerlinks');
    Route::resource('quotes', AdminQuoteController::class)->names('admin.quotes');
});
