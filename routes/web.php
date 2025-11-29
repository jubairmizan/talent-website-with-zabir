<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TalentsController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Creator\DashboardController as CreatorDashboardController;
use App\Http\Controllers\Creator\PortfolioController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/talents', [TalentsController::class, 'index'])->name('talents');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/talent/{id}', [TalentsController::class, 'show'])->name('talent.show');

// Test route for avatar implementation
Route::get('/test-avatar', function () {
    return view('test-avatar');
})->name('test.avatar');

// Blog routes (public)
Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

// Admin authentication routes are now handled by Laravel Fortify
// All users (admin, creator, member) use the standard /login route

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Default dashboard redirect
    Route::get('/dashboard', function () {
        $user = auth()->user();
        return match ($user->role) {
            'admin' => redirect('/admin/dashboard'),
            'creator' => redirect('/creator/dashboard'),
            'member' => redirect('/member/dashboard'),
            default => abort(403, 'Invalid role'),
        };
    })->name('dashboard');

    // Admin routes (protected by admin middleware)
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // User management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users', [AdminController::class, 'createUser'])->name('users.create');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::patch('/users/{user}/status', [AdminController::class, 'updateUserStatus'])->name('users.status');
        Route::post('/users/{user}/reset-password', [AdminController::class, 'resetUserPassword'])->name('users.reset-password');
        Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');

        // Creator management
        // Route::get('/creators', [AdminController::class, 'creators'])->name('creators');

        // Blog management
        Route::resource('blog', \App\Http\Controllers\Admin\BlogController::class)->parameters(['blog' => 'blogPost']);
        Route::patch('/blog/{blogPost}/toggle-featured', [\App\Http\Controllers\Admin\BlogController::class, 'toggleFeatured'])->name('blog.toggle-featured');
        Route::post('/blog/bulk-action', [\App\Http\Controllers\Admin\BlogController::class, 'bulkAction'])->name('blog.bulk-action');
        Route::post('/blog/upload-image', [\App\Http\Controllers\Admin\BlogController::class, 'uploadImage'])->name('blog.upload-image');

        // Contact management
        Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts');
        Route::patch('/contacts/{contact}/status', [AdminController::class, 'updateContactStatus'])->name('contacts.update-status');

        // Website Management
        Route::prefix('website')->name('website.')->group(function () {
            // Home Page
            Route::get('/home', [\App\Http\Controllers\Admin\HomePageController::class, 'index'])->name('home.index');
            Route::put('/home', [\App\Http\Controllers\Admin\HomePageController::class, 'update'])->name('home.update');

            // Home Page Slides
            Route::get('/home/slides', [\App\Http\Controllers\Admin\HomePageController::class, 'slides'])->name('home.slides');
            Route::post('/home/slides', [\App\Http\Controllers\Admin\HomePageController::class, 'storeSlide'])->name('home.slides.store');
            Route::delete('/home/slides/{slide}', [\App\Http\Controllers\Admin\HomePageController::class, 'destroySlide'])->name('home.slides.destroy');
            Route::post('/home/slides/reorder', [\App\Http\Controllers\Admin\HomePageController::class, 'reorderSlides'])->name('home.slides.reorder');
            Route::patch('/home/slides/{slide}/toggle', [\App\Http\Controllers\Admin\HomePageController::class, 'toggleSlide'])->name('home.slides.toggle');

            // About Page
            Route::get('/about', [\App\Http\Controllers\Admin\AboutPageController::class, 'index'])->name('about.index');
            Route::put('/about', [\App\Http\Controllers\Admin\AboutPageController::class, 'update'])->name('about.update');

            // About Page Values
            Route::post('/about/values', [\App\Http\Controllers\Admin\AboutPageController::class, 'storeValue'])->name('about.values.store');
            Route::put('/about/values/{value}', [\App\Http\Controllers\Admin\AboutPageController::class, 'updateValue'])->name('about.values.update');
            Route::delete('/about/values/{value}', [\App\Http\Controllers\Admin\AboutPageController::class, 'deleteValue'])->name('about.values.delete');
            Route::post('/about/values/reorder', [\App\Http\Controllers\Admin\AboutPageController::class, 'reorderValues'])->name('about.values.reorder');

            // Contact Page
            Route::get('/contact', [\App\Http\Controllers\Admin\ContactPageController::class, 'index'])->name('contact.index');
            Route::put('/contact', [\App\Http\Controllers\Admin\ContactPageController::class, 'update'])->name('contact.update');

            // Contact Page FAQs
            Route::post('/contact/faqs', [\App\Http\Controllers\Admin\ContactPageController::class, 'storeFaq'])->name('contact.faqs.store');
            Route::put('/contact/faqs/{faq}', [\App\Http\Controllers\Admin\ContactPageController::class, 'updateFaq'])->name('contact.faqs.update');
            Route::delete('/contact/faqs/{faq}', [\App\Http\Controllers\Admin\ContactPageController::class, 'deleteFaq'])->name('contact.faqs.delete');
            Route::post('/contact/faqs/reorder', [\App\Http\Controllers\Admin\ContactPageController::class, 'reorderFaqs'])->name('contact.faqs.reorder');
        });
    });

    // Creator routes
    Route::middleware(['role:creator'])->prefix('creator')->name('creator.')->group(function () {
        Route::get('/dashboard', [CreatorDashboardController::class, 'index'])->name('dashboard');
        Route::put('/profile', [CreatorDashboardController::class, 'updateProfile'])->name('profile.update');

        // File download routes
        Route::get('/download/avatar', [CreatorDashboardController::class, 'downloadAvatar'])->name('download.avatar');
        Route::get('/download/banner', [CreatorDashboardController::class, 'downloadBanner'])->name('download.banner');
        Route::get('/download/resume', [CreatorDashboardController::class, 'downloadResume'])->name('download.resume');

        // Portfolio routes
        Route::resource('portfolio', PortfolioController::class)->parameters(['portfolio' => 'portfolioItem']);
        Route::patch('/portfolio/{portfolioItem}/toggle-status', [PortfolioController::class, 'toggleStatus'])->name('portfolio.toggle-status');
        Route::post('/portfolio/update-order', [PortfolioController::class, 'updateOrder'])->name('portfolio.update-order');
    });

    // Member routes
    Route::middleware(['role:member'])->prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [MemberDashboardController::class, 'getProfile'])->name('profile.get');
        Route::put('/profile', [MemberDashboardController::class, 'updateProfile'])->name('profile.update');
        Route::get('/favorites', [MemberDashboardController::class, 'getFavorites'])->name('favorites.get');
        Route::get('/favorites/count', [MemberDashboardController::class, 'getFavoritesCount'])->name('favorites.count');
        Route::delete('/favorites', [MemberDashboardController::class, 'removeFavorite'])->name('favorites.remove');
        Route::get('/conversations', [MemberDashboardController::class, 'getConversations'])->name('conversations.get');
    });

    // Favorite routes (for any authenticated user, mainly members)
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/favorites/toggle/{creatorProfileId}', [App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');
    });

    // Chat routes - accessible to both members and creators
    Route::middleware(['auth'])->group(function () {
        // Conversation routes
        Route::get('/conversations', [App\Http\Controllers\ConversationController::class, 'index'])->name('conversations.index');
        Route::post('/conversations/get-or-create', [App\Http\Controllers\ConversationController::class, 'getOrCreate'])->name('conversations.get-or-create');
        Route::patch('/conversations/{conversation}/toggle-block', [App\Http\Controllers\ConversationController::class, 'toggleBlock'])->name('conversations.toggle-block');
        Route::delete('/conversations/{conversation}', [App\Http\Controllers\ConversationController::class, 'destroy'])->name('conversations.destroy');

        // Message routes
        Route::get('/conversations/{conversation}/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
        Route::post('/conversations/{conversation}/messages', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
        Route::patch('/conversations/{conversation}/messages/mark-read', [App\Http\Controllers\MessageController::class, 'markAsRead'])->name('messages.mark-read');
        Route::get('/conversations/{conversation}/unread-count', [App\Http\Controllers\MessageController::class, 'getUnreadCount'])->name('messages.unread-count');
        Route::get('/messages/total-unread', [App\Http\Controllers\MessageController::class, 'getTotalUnreadCount'])->name('messages.total-unread');

        // Availability routes
        Route::get('/availability/creator/{creatorId}', [App\Http\Controllers\AvailabilityController::class, 'checkCreatorAvailability'])->name('availability.creator');
        Route::get('/availability/user', [App\Http\Controllers\AvailabilityController::class, 'getUserAvailability'])->name('availability.user');
    });
});


Route::get('/messages/unread-count', [MessageController::class, 'unreadCount'])->name('messages.unread-count');
