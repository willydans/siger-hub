<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\StaffArticleController;
use App\Http\Controllers\StaffDraftController;
use App\Http\Controllers\StaffRevisionController;
use App\Http\Controllers\StaffNotificationController;
use App\Http\Controllers\StaffEditorController;
use App\Http\Controllers\StaffProfileController;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminBackupController;
use App\Http\Controllers\AdminStorageController;
use App\Http\Controllers\AdminActivityLogController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\AdminSearchLogController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AdminFeedbackController;
use App\Http\Controllers\AdminAnalyticsController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminUserController;

use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\PortalController;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Tidak perlu login)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home.public');

// Portal publik khusus untuk staff/admin (tanpa redirect ke dashboard)
Route::get('/portal', [PortalController::class, 'index'])->name('portal');

Route::get('/knowledge-base', [KnowledgeBaseController::class, 'index'])->name('knowledge-base');

// Contoh halaman statis
Route::get('/document/sop-siber', function () {
    return view('document-detail');
});

// Detail dokumen publik
Route::get('/document/{slug}', [DocumentController::class, 'show'])->name('document.detail');

// AI Chatbot
Route::post('/api/ai/chat', [AiAssistantController::class, 'chat'])->name('api.ai.chat');

// Track klik dari hasil pencarian (Search Log)
Route::post('/api/track-click', function (Request $request) {
    $validated = $request->validate([
        'query'      => 'required|string',
        'article_id' => 'required|integer|exists:articles,id'
    ]);

    $log = \App\Models\SearchLog::where('query', $validated['query'])
                ->where('user_id', auth()->id())
                ->latest()
                ->first();

    if ($log) {
        $log->increment('clicks');
        $log->update(['clicked_article_id' => $validated['article_id']]);
    }

    return response()->json(['status' => 'ok']);
})->middleware('web');

/*
|--------------------------------------------------------------------------
| GUEST ROUTES (Login, Register, Socialite)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);
});

/*
|--------------------------------------------------------------------------
| OTP VERIFICATION
|--------------------------------------------------------------------------
*/
Route::get('/otp/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify');
Route::post('/otp/verify', [OtpController::class, 'verify']);
Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');

Route::get('/home', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT (Berdasarkan Role)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();
    $roleName = $user->role ? $user->role->name : 'user';

    if ($roleName === 'admin') {
        return redirect()->to('/admin/dashboard');
    }
    if ($roleName === 'staff') {
        return redirect()->to('/staff/dashboard');
    }

    return redirect()->route('home.public');
})->middleware(['auth', 'verified.otp'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| ✅ HELPER: Route Editor bersama untuk Staff & Admin
|--------------------------------------------------------------------------
| StaffEditorController sudah didesain generik untuk kedua role (lewat
| getViewPrefix() / getRedirectRoute() di dalam controllernya sendiri),
| jadi definisi route-nya cukup ditulis SEKALI di sini dan dipanggil
| ulang di dalam grup 'staff' maupun grup 'admin' — menghindari drift
| kalau salah satu lupa diupdate saat menambah/mengubah endpoint editor.
*/
$registerEditorRoutes = function () {
    Route::get('/editor', [StaffEditorController::class, 'index'])->name('editor');
    Route::post('/editor', [StaffEditorController::class, 'store'])->name('editor.store');
    Route::post('/editor/upload-image', [StaffEditorController::class, 'uploadImage'])->name('editor.upload.image');
    Route::post('/editor/upload-attachment', [StaffEditorController::class, 'uploadAttachment'])->name('editor.upload.attachment');
    Route::post('/editor/ai-assistant', [StaffEditorController::class, 'aiAssistant'])->name('editor.ai');
    Route::post('/editor/autofill', [StaffEditorController::class, 'autoFillMetadata'])->name('editor.autofill');

    Route::get('/editor/{id}', [StaffEditorController::class, 'edit'])->whereNumber('id')->name('editor.edit');
    Route::post('/editor/{id}', [StaffEditorController::class, 'update'])->whereNumber('id')->name('editor.update');
    Route::post('/editor/{id}/submit', [StaffEditorController::class, 'submitApproval'])->whereNumber('id')->name('editor.submit');
};

/*
|--------------------------------------------------------------------------
| STAFF ROUTES (Middleware role:staff)
|--------------------------------------------------------------------------
*/
Route::prefix('staff')->name('staff.')->middleware(['auth', 'verified.otp', 'role:staff'])->group(function () use ($registerEditorRoutes) {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

    // --- Manajemen Artikel ---
    Route::get('/articles', [StaffArticleController::class, 'index'])->name('articles');
    Route::get('/articles/preview/{id}', [StaffArticleController::class, 'preview'])->name('articles.preview');
    Route::get('/articles/history/{id}', [StaffArticleController::class, 'history'])->name('articles.history');
    Route::post('/articles/quick-update/{id}', [StaffArticleController::class, 'quickUpdate'])->name('articles.quickUpdate');
    Route::post('/articles/duplicate/{id}', [StaffArticleController::class, 'duplicate'])->name('articles.duplicate');
    Route::post('/articles/archive/{id}', [StaffArticleController::class, 'archive'])->name('articles.archive');
    Route::post('/articles/unarchive/{id}', [StaffArticleController::class, 'unarchive'])->name('articles.unarchive');
    Route::post('/articles/bulk-action', [StaffArticleController::class, 'bulkAction'])->name('articles.bulkAction');

    Route::get('/articles/download/{id}', [StaffArticleController::class, 'downloadPdf'])->name('articles.download-pdf');
    Route::get('/articles/{id}', [StaffArticleController::class, 'show'])->name('articles.show');
    Route::delete('/articles/{id}', [StaffArticleController::class, 'destroy'])->name('articles.destroy');

    // --- Draft ---
    Route::get('/draft', [StaffDraftController::class, 'index'])->name('draft');
    Route::get('/draft/{id}/edit', [StaffDraftController::class, 'edit'])->name('draft.edit');
    Route::get('/draft/{id}/preview', [StaffDraftController::class, 'preview'])->name('draft.preview');
    Route::post('/draft/{id}/submit', [StaffDraftController::class, 'submit'])->name('draft.submit');
    Route::delete('/draft/{id}', [StaffDraftController::class, 'destroy'])->name('draft.destroy');

    // --- Revisi ---
    Route::get('/revision', [StaffRevisionController::class, 'index'])->name('revision');
    Route::get('/revision/{id}/details', [StaffRevisionController::class, 'getDetails'])->name('revision.details');
    Route::post('/revision/{id}/submit', [StaffRevisionController::class, 'submitAgain'])->name('revision.submit');

    // --- Notifikasi ---
    Route::get('/notification', [StaffNotificationController::class, 'index'])->name('notification');
    Route::post('/notification/read-all', [StaffNotificationController::class, 'markAllAsRead'])->name('notification.readAll');
    Route::post('/notification/{id}/read', [StaffNotificationController::class, 'markAsRead'])->name('notification.read');
    Route::delete('/notification/{id}', [StaffNotificationController::class, 'destroy'])->name('notification.destroy');

    // --- Editor Artikel ---
    $registerEditorRoutes();

    // --- Profil Staff ---
    Route::get('/profile', [StaffProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [StaffProfileController::class, 'update'])->name('profile.update');
});

// Test connection (opsional)
Route::any('/test-connection', function() {
    return response()->json(['status' => 'OK', 'message' => 'Laravel is online!', 'method' => request()->method()]);
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Middleware role:admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified.otp', 'role:admin'])->group(function () use ($registerEditorRoutes) {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // --- Manajemen Artikel (dengan status filter) ---
    Route::get('/all-articles/{status?}', [AdminArticleController::class, 'index'])->name('all-articles');
    Route::get('/pending-approval', [AdminArticleController::class, 'index'])->defaults('status', 'pending')->name('pending-approval');
    Route::get('/draft', [AdminArticleController::class, 'index'])->defaults('status', 'draft')->name('draft');
    Route::get('/revision', [AdminArticleController::class, 'index'])->defaults('status', 'revision')->name('revision');
    Route::get('/published', [AdminArticleController::class, 'index'])->defaults('status', 'published')->name('published');
    Route::get('/archive', [AdminArticleController::class, 'index'])->defaults('status', 'archived')->name('archive');
    Route::get('/delete', [AdminArticleController::class, 'index'])->defaults('status', 'deleted')->name('delete');

    // --- CRUD Artikel ---
    Route::get('/all-articles/{id}/edit', [AdminArticleController::class, 'edit'])->name('all-articles.edit');
    Route::put('/all-articles/{id}', [AdminArticleController::class, 'update'])->name('all-articles.update');
    Route::delete('/all-articles/{id}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');
    Route::post('/articles/approve/{id}', [AdminArticleController::class, 'approve'])->name('articles.approve');
    Route::post('/articles/reject/{id}', [AdminArticleController::class, 'reject'])->name('articles.reject');
    Route::post('/articles/archive/{id}', [AdminArticleController::class, 'archive'])->name('articles.archive');

    // Restore (GET dan POST untuk kompatibilitas)
    Route::match(['get', 'post'], '/articles/restore/{id}', [AdminArticleController::class, 'restore'])->name('articles.restore');

    Route::post('/articles/duplicate/{id}', [AdminArticleController::class, 'duplicate'])->name('articles.duplicate');
    Route::get('/articles/view/{id}', [AdminArticleController::class, 'show'])->name('articles.show');
    Route::get('/articles/history/{id}', [AdminArticleController::class, 'history'])->name('articles.history');
    Route::get('/articles/json/{id}', [AdminArticleController::class, 'getArticleJson'])->name('articles.json');
    Route::post('/articles/revision/{id}', [AdminArticleController::class, 'revision'])->name('articles.revision');

    // Force Delete (permanen)
    Route::delete('/articles/force-delete/{id}', [AdminArticleController::class, 'forceDelete'])->name('articles.forceDelete');

    // --- Backup ---
    Route::get('/backup', [AdminBackupController::class, 'index'])->name('backup');
    Route::post('/backup/store', [AdminBackupController::class, 'store'])->name('backup.store');
    Route::post('/backup/schedule', [AdminBackupController::class, 'updateSchedule'])->name('backup.schedule');
    Route::get('/backup/download/{id}', [AdminBackupController::class, 'download'])->name('backup.download');
    Route::post('/backup/restore/{id}', [AdminBackupController::class, 'restore'])->name('backup.restore');
    Route::post('/backup/upload-restore', [AdminBackupController::class, 'uploadRestore'])->name('backup.uploadRestore');

    // --- Manajemen User ---
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.resetPassword');

    // --- Analytics & Reports ---
    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics');
    Route::view('/reports', 'admin-reports')->name('reports');

    // --- Feedback ---
    Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('feedback');
    Route::post('/feedback/{id}/update', [AdminFeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/feedback/{id}', [AdminFeedbackController::class, 'destroy'])->name('feedback.destroy');

    // --- Notifikasi Admin ---
    Route::get('/notification', [AdminNotificationController::class, 'index'])->name('notification');
    Route::post('/notification/read-all', [AdminNotificationController::class, 'markAllAsRead'])->name('notification.readAll');
    Route::post('/notification/{id}/read', [AdminNotificationController::class, 'markAsRead'])->name('notification.read');
    Route::delete('/notification/{id}', [AdminNotificationController::class, 'destroy'])->name('notification.destroy');

    // --- Aktivitas Log ---
    Route::get('/activity', [AdminActivityLogController::class, 'index'])->name('activity');
    Route::get('/activity/export-pdf', [AdminActivityLogController::class, 'exportPdf'])->name('activity.exportPdf');
    Route::get('/activity/export-excel', [AdminActivityLogController::class, 'exportExcel'])->name('activity.exportExcel');

    // --- Search Log ---
    Route::get('/searchlog', [AdminSearchLogController::class, 'index'])->name('searchlog');
    Route::post('/searchlog/assign', [AdminSearchLogController::class, 'assign'])->name('searchlog.assign');

    // --- Storage Management ---
    Route::get('/storage', [AdminStorageController::class, 'index'])->name('storage');
    Route::post('/storage/delete', [AdminStorageController::class, 'deleteFile'])->name('storage.delete');
    Route::post('/storage/cleanup', [AdminStorageController::class, 'cleanup'])->name('storage.cleanup');

    // --- Settings ---
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');

    // --- Kategori ---
    Route::get('/category', [AdminCategoryController::class, 'index'])->name('category');
    Route::post('/category', [AdminCategoryController::class, 'store'])->name('category.store');
    Route::put('/category/{category}', [AdminCategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{category}', [AdminCategoryController::class, 'destroy'])->name('category.destroy');
    Route::post('/category/{category}/subcategory', [AdminCategoryController::class, 'storeSubcategory'])->name('category.subcategory.store');
    Route::put('/subcategory/{subcategory}', [AdminCategoryController::class, 'updateSubcategory'])->name('subcategory.update');
    Route::delete('/subcategory/{subcategory}', [AdminCategoryController::class, 'destroySubcategory'])->name('subcategory.destroy');

    /*
    |--------------------------------------------------------------------------
    | ADMIN EDITOR ROUTES (Menggunakan StaffEditorController yang sama)
    |--------------------------------------------------------------------------
    | Digunakan oleh admin untuk menulis/mengedit artikel. Definisinya
    | dipakai ulang dari closure $registerEditorRoutes di atas supaya
    | selalu sinkron dengan versi staff — lihat blok "HELPER" di awal file.
    */
    $registerEditorRoutes();
});

/*
|--------------------------------------------------------------------------
| USER ROUTES (Middleware role:user)
|--------------------------------------------------------------------------
*/
Route::prefix('user')->name('user.')->middleware(['auth', 'verified.otp', 'role:user'])->group(function () {
    // Dashboard / Profil (single page)
    Route::get('/profil', [UserProfileController::class, 'index'])->name('profil');

    // Update Profil & Password
    Route::put('/profil/update', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profil/password', [UserProfileController::class, 'updatePassword'])->name('profile.password');

    // History
    Route::delete('/history/{id}', [UserProfileController::class, 'deleteHistory'])->name('history.delete');
    Route::delete('/history', [UserProfileController::class, 'clearHistory'])->name('history.clear');

    // Bookmark
    Route::post('/bookmarks/toggle', [UserProfileController::class, 'toggleBookmark'])->name('bookmarks.toggle');
    Route::delete('/bookmarks/{id}', [UserProfileController::class, 'deleteBookmark'])->name('bookmarks.delete');

    // Notifikasi
    Route::post('/notifications/{id}/read', [UserProfileController::class, 'markNotificationAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [UserProfileController::class, 'markAllNotificationsAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [UserProfileController::class, 'deleteNotification'])->name('notifications.delete');
    Route::delete('/notifications', [UserProfileController::class, 'clearNotifications'])->name('notifications.clear');

    /*
    |--------------------------------------------------------------------------
    | FITUR KEAMANAN (Login History, Active Devices, Logout All Devices)
    |--------------------------------------------------------------------------
    */
    Route::get('/login-history', [UserProfileController::class, 'loginHistory'])->name('login.history');
    Route::get('/active-devices', [UserProfileController::class, 'activeDevices'])->name('active.devices');
    Route::post('/logout-all-devices', [UserProfileController::class, 'logoutAllDevices'])->name('logout.all');
});

/*
|--------------------------------------------------------------------------
| DOKUMEN ACTION ROUTES (Like, Rate, Bookmark, Feedback, Download PDF)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/document/{id}/like', [DocumentController::class, 'toggleLike'])->name('document.like');
    Route::post('/document/{id}/rate', [DocumentController::class, 'rate'])->name('document.rate');
    Route::post('/document/{id}/bookmark', [DocumentController::class, 'toggleBookmark'])->name('document.bookmark');
    Route::post('/document/{id}/feedback', [DocumentController::class, 'submitFeedback'])->name('document.feedback');
});
Route::get('/document/{id}/download-pdf', [DocumentController::class, 'downloadPdf'])->name('document.download-pdf');
Route::get('/document/{id}/download', [DocumentController::class, 'downloadPdf'])->name('document.download'); // TAMBAHAN

/*
|--------------------------------------------------------------------------
| KOMENTAR ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{id}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

/*
|--------------------------------------------------------------------------
| LOGOUT ROUTE
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');