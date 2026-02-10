<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\CustomerReviewController;
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
use App\Http\Controllers\Admin\TrackingLinkController;
use App\Http\Controllers\Admin\QuoteController as AdminQuoteController;
use App\Http\Controllers\Admin\QuotationRateController;
use App\Http\Controllers\Admin\DealerController;
use App\Http\Controllers\Admin\DailyActivityController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CustomerReviewController as PublicReviewController;
use App\Models\Feature;
use App\Models\HomeBanner;
use App\Models\Service;
use App\Models\NavLink;
use App\Models\GalleryItem;
use App\Models\HelpItem;
use App\Models\DailyActivity;
use App\Models\TrackingLink;
use App\Models\QuotationRate;
use App\Models\CustomerReview;

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
    $banner = HomeBanner::orderBy('sort_order')->orderBy('id')->first();
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
    $trackingLinks = TrackingLink::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->get();
    $quotationRates = QuotationRate::orderBy('sort_order')->orderBy('country')->orderBy('service')->orderBy('id')->get();
    $customerReviews = CustomerReview::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->take(9)->get();
    return view('home', compact('features','banner','services','activities','navLinks','gallery','helpItems','formServices','trackingLinks','quotationRates','customerReviews'));
});

// Home route (same as root, so /home works)
Route::get('/home', function () {
    if (Auth::check() && Auth::user()->is_admin) {
        return redirect('/admin');
    }
    $features = Feature::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->get();
    $banner = HomeBanner::orderBy('sort_order')->orderBy('id')->first();
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
    $trackingLinks = TrackingLink::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->get();
    $quotationRates = QuotationRate::orderBy('sort_order')->orderBy('country')->orderBy('service')->orderBy('id')->get();
    $customerReviews = CustomerReview::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->take(9)->get();
    return view('home', compact('features','banner','services','activities','navLinks','gallery','helpItems','formServices','trackingLinks','quotationRates','customerReviews'));
})->name('home');

// Public home preview that never redirects admins
Route::get('/site', function () {
    $features = Feature::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->get();
    $banner = HomeBanner::orderBy('sort_order')->orderBy('id')->first();
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
    $trackingLinks = TrackingLink::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->get();
    $quotationRates = QuotationRate::orderBy('sort_order')->orderBy('country')->orderBy('service')->orderBy('id')->get();
    $customerReviews = CustomerReview::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->take(9)->get();
    return view('home', compact('features','banner','services','activities','navLinks','gallery','helpItems','formServices','trackingLinks','quotationRates','customerReviews'));
})->name('site.home');

// Public quote submissions
Route::post('/quotes', [QuoteController::class, 'store'])->name('quote.store');
// Quotation calculator: weight + country => total; optional dealer code => dealer price
Route::post('/quotation/calculate', [QuotationController::class, 'calculate'])->name('quotation.calculate');
Route::get('/quotation/download-pdf', [QuotationController::class, 'downloadPdf'])->name('quotation.download.pdf');
Route::get('/quotation/download-image', [QuotationController::class, 'downloadImage'])->name('quotation.download.image');
Route::get('/quotation/download-text', [QuotationController::class, 'downloadText'])->name('quotation.download.text');
// Newsletter subscribe
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

// Customer review (public add review — separate page + submit)
Route::get('/add-review', [PublicReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews', [PublicReviewController::class, 'store'])->name('reviews.store');

// Public activities list
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');

// Track your parcel (separate page)
Route::get('/track', function () {
    $trackingLinks = TrackingLink::where('is_visible', true)->orderBy('sort_order')->orderBy('id')->get();
    return view('track', compact('trackingLinks'));
})->name('track');

Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('profile/password', [ProfileController::class, 'editPassword'])->name('admin.profile.password');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password.update');
    Route::resource('users', UserController::class)->names('admin.users')->except(['show']);
    Route::get('company', function () {
        return redirect(route('admin.settings.index').'?section=company');
    })->name('admin.company');
    Route::resource('features', FeatureController::class)->names('admin.features');
    Route::patch('features/{feature}/toggle-visibility', [FeatureController::class, 'toggleVisibility'])->name('admin.features.toggle');
    Route::resource('customer-reviews', CustomerReviewController::class)->names('admin.customerreviews')->parameters(['customer-reviews' => 'customer_review']);
    Route::resource('activities', DailyActivityController::class)->names('admin.activities');
    Route::patch('activities/{activity}/toggle-visibility', [DailyActivityController::class, 'toggleVisibility'])->name('admin.activities.toggle');
    Route::patch('activities/{activity}/sort-order', [DailyActivityController::class, 'updateSortOrder'])->name('admin.activities.sort');
    Route::get('banner', [HomeBannerController::class, 'index'])->name('admin.banner.index');
    Route::get('banner/create', [HomeBannerController::class, 'create'])->name('admin.banner.create');
    Route::post('banner', [HomeBannerController::class, 'store'])->name('admin.banner.store');
    Route::get('banner/{banner}/edit', [HomeBannerController::class, 'edit'])->name('admin.banner.edit');
    Route::match(['put', 'patch'], 'banner/{banner}', [HomeBannerController::class, 'update'])->name('admin.banner.update');
    Route::delete('banner/{banner}', [HomeBannerController::class, 'destroy'])->name('admin.banner.destroy');
    Route::post('banner/order', [HomeBannerController::class, 'updateOrder'])->name('admin.banner.order');
    Route::resource('services', ServiceController::class)->names('admin.services');
    Route::post('services/upload', [ServiceUploadController::class, 'store'])->name('admin.services.upload');
    Route::patch('services/{service}/toggle-visibility', [ServiceVisibilityController::class, 'toggle'])->name('admin.services.toggle');
    Route::get('settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::get('footer', [SettingController::class, 'footer'])->name('admin.settings.footer');
    Route::post('settings', [SettingController::class, 'update'])->name('admin.settings.update');
    Route::resource('tracking-links', TrackingLinkController::class)->names('admin.trackinglinks');
    Route::resource('nav-links', NavLinkController::class)->names('admin.navlinks');
    Route::resource('gallery', GalleryItemController::class)->names('admin.gallery');
    Route::resource('help-items', HelpItemController::class)->names('admin.helpitems');
    Route::resource('social-links', SocialLinkController::class)->names('admin.sociallinks');
    Route::resource('footer-links', FooterLinkController::class)->names('admin.footerlinks');
    Route::resource('quotes', AdminQuoteController::class)->names('admin.quotes');
    Route::resource('quotation-rates', QuotationRateController::class)->names('admin.quotationrates');
    Route::resource('dealers', DealerController::class)->names('admin.dealers');
});
