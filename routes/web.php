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

// ✅ Tambahkan import UserProfileController
use App\Http\Controllers\UserProfileController;

// ✨ TAMBAHAN: Controller baru hasil sinkronisasi dengan web.php teman (Ghaisan)
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AiAssistantController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Public Routes (Tidak perlu login)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home.public');
Route::get('/knowledge-base', [KnowledgeBaseController::class, 'index'])->name('knowledge-base');
Route::get('/document/sop-siber', function () { return view('document-detail'); });

// ✨ TAMBAHAN: Detail dokumen dinamis berdasarkan slug (dari web.php teman)
Route::get('/document/{slug}', [DocumentController::class, 'show'])->name('document.detail');

// ✨ TAMBAHAN: Endpoint AI Chatbot publik, terbatas pada database AKSARA (dari web.php teman)
Route::post('/api/ai/chat', [AiAssistantController::class, 'chat'])->name('api.ai.chat');

Route::post('/api/track-click', function (Request $request) {
    $validated = $request->validate([
        'query' => 'required|string',
        'article_id' => 'required|integer|exists:articles,id'
    ]);

    // Cari log pencarian terakhir yang cocok dengan query dan user saat ini
    $log = \App\Models\SearchLog::where('query', $validated['query'])
                ->where('user_id', auth()->id())
                ->latest()
                ->first();

    if ($log) {
        $log->increment('clicks');
        $log->update(['clicked_article_id' => $validated['article_id']]);
    }

    return response()->json(['status' => 'ok']);
})->middleware('web'); // Middleware web memastikan CSRF token terverifikasi

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);
});

/*
|--------------------------------------------------------------------------
| Routes yang membutuhkan login (autentikasi dasar)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/otp/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify');
    Route::post('/otp/verify', [OtpController::class, 'verify']);
    Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect (Aman untuk semua role)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->to('/admin/dashboard');
    }
    if ($user->role === 'staff') {
        return redirect()->to('/staff/dashboard');
    }
    return redirect()->to('/user/profil');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Staff Routes (Peran staff)
|--------------------------------------------------------------------------
*/
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:staff', 'prevent.back'])->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');

    // Artikel & Manajemen
    Route::get('/articles', [StaffArticleController::class, 'index'])->name('articles');
    Route::get('/articles/preview/{id}', [StaffArticleController::class, 'preview'])->name('articles.preview');
    Route::get('/articles/history/{id}', [StaffArticleController::class, 'history'])->name('articles.history');
    Route::post('/articles/quick-update/{id}', [StaffArticleController::class, 'quickUpdate'])->name('articles.quickUpdate');
    Route::post('/articles/duplicate/{id}', [StaffArticleController::class, 'duplicate'])->name('articles.duplicate');
    Route::post('/articles/archive/{id}', [StaffArticleController::class, 'archive'])->name('articles.archive');
    Route::post('/articles/unarchive/{id}', [StaffArticleController::class, 'unarchive'])->name('articles.unarchive');
    Route::post('/articles/bulk-action', [StaffArticleController::class, 'bulkAction'])->name('articles.bulkAction');
    Route::get('/articles/download/{id}', [StaffArticleController::class, 'downloadPdf'])->name('articles.download');
    Route::get('/articles/{id}', [StaffArticleController::class, 'show'])->name('articles.show');
    Route::delete('/articles/{id}', [StaffArticleController::class, 'destroy'])->name('articles.destroy');

    // Draft
    Route::get('/draft', [StaffDraftController::class, 'index'])->name('draft');
    Route::get('/draft/{id}/edit', [StaffDraftController::class, 'edit'])->name('draft.edit');
    Route::get('/draft/{id}/preview', [StaffDraftController::class, 'preview'])->name('draft.preview');
    Route::post('/draft/{id}/submit', [StaffDraftController::class, 'submit'])->name('draft.submit');
    Route::delete('/draft/{id}', [StaffDraftController::class, 'destroy'])->name('draft.destroy');

    // Revision
    Route::get('/revision', [StaffRevisionController::class, 'index'])->name('revision');
    Route::get('/revision/{id}/details', [StaffRevisionController::class, 'getDetails'])->name('revision.details');
    Route::post('/revision/{id}/submit', [StaffRevisionController::class, 'submitAgain'])->name('revision.submit');

    // Notification
    Route::get('/notification', [StaffNotificationController::class, 'index'])->name('notification');
    Route::post('/notification/read-all', [StaffNotificationController::class, 'markAllAsRead'])->name('notification.readAll');
    Route::post('/notification/{id}/read', [StaffNotificationController::class, 'markAsRead'])->name('notification.read');
    Route::delete('/notification/{id}', [StaffNotificationController::class, 'destroy'])->name('notification.destroy');

    /*
    |--------------------------------------------------------------------------
    | EDITOR ROUTES — Urutan sangat penting!
    |--------------------------------------------------------------------------
    */
    Route::get('/editor', [StaffEditorController::class, 'index'])->name('editor');
    Route::post('/editor', [StaffEditorController::class, 'store'])->name('editor.store');
    Route::post('/editor/upload-image', [StaffEditorController::class, 'uploadImage'])->name('editor.upload.image');
    Route::post('/editor/upload-attachment', [StaffEditorController::class, 'uploadAttachment'])->name('editor.upload.attachment');
    Route::post('/editor/ai-assistant', [StaffEditorController::class, 'aiAssistant'])->name('editor.ai');

    // ✨ TAMBAHAN: Auto-fill metadata artikel pakai AI (dari web.php teman)
    Route::post('/editor/autofill', [StaffEditorController::class, 'autoFillMetadata'])->name('editor.autofill');

    Route::get('/editor/{id}', [StaffEditorController::class, 'edit'])->whereNumber('id')->name('editor.edit');
    Route::post('/editor/{id}', [StaffEditorController::class, 'update'])->whereNumber('id')->name('editor.update');
    Route::post('/editor/{id}/submit', [StaffEditorController::class, 'submitApproval'])->whereNumber('id')->name('editor.submit');

    // Profil
    Route::get('/profile', [StaffProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [StaffProfileController::class, 'update'])->name('profile.update');
});

// Test connection (opsional)
Route::any('/test-connection', function() {
    return response()->json(['status' => 'OK', 'message' => 'Laravel is online!', 'method' => request()->method()]);
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Peran admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin', 'prevent.back'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/all-articles/{status?}', [AdminArticleController::class, 'index'])->name('all-articles');
    Route::get('/pending-approval', [AdminArticleController::class, 'index'])->defaults('status', 'pending')->name('pending-approval');
    Route::post('/articles/approve/{id}', [AdminArticleController::class, 'approve'])->name('articles.approve');
    Route::post('/articles/reject/{id}', [AdminArticleController::class, 'reject'])->name('articles.reject');
    Route::delete('/articles/{id}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');
    
    Route::get('/backup', [AdminBackupController::class, 'index'])->name('backup');
    Route::post('/backup/store', [AdminBackupController::class, 'store'])->name('backup.store');
    Route::post('/backup/schedule', [AdminBackupController::class, 'updateSchedule'])->name('backup.schedule');
    Route::get('/backup/download/{id}', [AdminBackupController::class, 'download'])->name('backup.download');
    Route::post('/backup/restore/{id}', [AdminBackupController::class, 'restore'])->name('backup.restore');
    Route::post('/backup/upload-restore', [AdminBackupController::class, 'uploadRestore'])->name('backup.uploadRestore');

    Route::view('/users', 'admin-users')->name('users');
    Route::view('/reports', 'admin-reports')->name('reports');
    Route::view('/editor', 'admin-editor')->name('editor');
    Route::get('/draft', [AdminArticleController::class, 'draft'])->name('draft');
    Route::view('/revision', 'admin-revision')->name('revision');
    Route::post('/articles/{id}/submit', [ArticleController::class, 'submit'])->name('article.submit');
    Route::get('/published', [AdminArticleController::class, 'published'])->name('published');
    Route::get('/archive', [AdminArticleController::class, 'archived'])->name('archive');
    Route::get('/delete', [AdminArticleController::class, 'deleted'])->name('delete');
    
    // Tambahkan juga route ini agar tombol Restore & Force Delete di halaman Archive/Delete tidak error
    Route::post('/articles/restore/{id}', [AdminArticleController::class, 'restore'])->name('articles.restore');
    Route::delete('/articles/force-delete/{id}', [AdminArticleController::class, 'forceDelete'])->name('articles.forceDelete');

    Route::get('/notification', [AdminNotificationController::class, 'index'])->name('notification');
    Route::post('/notification/read-all', [AdminNotificationController::class, 'markAllAsRead'])->name('notification.readAll');
    Route::post('/notification/{id}/read', [AdminNotificationController::class, 'markAsRead'])->name('notification.read');
    Route::delete('/notification/{id}', [AdminNotificationController::class, 'destroy'])->name('notification.destroy');

    Route::get('/activity', [AdminActivityLogController::class, 'index'])->name('activity');
    Route::get('/activity/export-pdf', [AdminActivityLogController::class, 'exportPdf'])->name('activity.exportPdf');
    Route::get('/activity/export-excel', [AdminActivityLogController::class, 'exportExcel'])->name('activity.exportExcel');

    Route::get('/storage', [AdminStorageController::class, 'index'])->name('storage');
    Route::post('/storage/delete', [AdminStorageController::class, 'deleteFile'])->name('storage.delete');
    Route::post('/storage/cleanup', [AdminStorageController::class, 'cleanup'])->name('storage.cleanup');

    Route::get('/searchlog', [AdminSearchLogController::class, 'index'])->name('searchlog');
    Route::post('/searchlog/assign', [AdminSearchLogController::class, 'assign'])->name('searchlog.assign');

    // Settings
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');

    //Route::view('/category', 'admin-category')->name('category');
    Route::get('/category', [App\Http\Controllers\AdminCategoryController::class, 'index'])->name('category');
    Route::post('/category', [App\Http\Controllers\AdminCategoryController::class, 'store'])->name('category.store');
    Route::put('/category/{id}', [App\Http\Controllers\AdminCategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{id}', [App\Http\Controllers\AdminCategoryController::class, 'destroy'])->name('category.destroy');

    Route::post('/admin/subcategory', [App\Http\Controllers\AdminSubcategoryController::class, 'store'])->name('admin.subcategory.store');
    Route::delete('/admin/subcategory/{id}', [App\Http\Controllers\AdminSubcategoryController::class, 'destroy'])->name('admin.subcategory.destroy');

    Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('feedback');
    Route::put('/feedback/{id}/status', [AdminFeedbackController::class, 'updateStatus'])->name('feedback.updateStatus');

    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])
    ->name('analytics');

    // Route CRUD untuk User Management
    Route::resource('users', App\Http\Controllers\AdminUserController::class);

    // ================================================================
    // ✨ TAMBAHAN BARU (hasil sinkronisasi dengan web.php teman)
    // Semua route di bawah ini pakai path/nama baru sehingga TIDAK
    // bentrok dengan route lama di atas. Route lama tidak diubah.
    // ================================================================

    // --- Aksi tambahan Artikel (Admin) ---
    Route::get('/article/create', [AdminArticleController::class, 'create'])->name('article.create');
    Route::post('/article/store', [AdminArticleController::class, 'store'])->name('article.store');
    Route::get('/all-articles/{id}/edit', [AdminArticleController::class, 'edit'])->name('all-articles.edit');
    Route::put('/all-articles/{id}', [AdminArticleController::class, 'update'])->name('all-articles.update');
    Route::post('/articles/archive/{id}', [AdminArticleController::class, 'archive'])->name('articles.archive');
    Route::post('/articles/duplicate/{id}', [AdminArticleController::class, 'duplicate'])->name('articles.duplicate');
    Route::get('/articles/view/{id}', [AdminArticleController::class, 'show'])->name('articles.show');
    Route::get('/articles/history/{id}', [AdminArticleController::class, 'history'])->name('articles.history');
    Route::get('/articles/json/{id}', [AdminArticleController::class, 'getArticleJson'])->name('articles.json');
    Route::post('/articles/revision/{id}', [AdminArticleController::class, 'revision'])->name('articles.revision');

    // --- Aksi tambahan User & Role Management (Admin) ---
    Route::post('/users/{user}/toggle-status', [App\Http\Controllers\AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::post('/users/{user}/reset-password', [App\Http\Controllers\AdminUserController::class, 'resetPassword'])->name('users.resetPassword');
    Route::post('/roles', [App\Http\Controllers\AdminUserController::class, 'storeRole'])->name('roles.store');
    Route::get('/roles/{role}/edit', [App\Http\Controllers\AdminUserController::class, 'editRole'])->name('roles.edit');
    Route::put('/roles/{role}', [App\Http\Controllers\AdminUserController::class, 'updateRole'])->name('roles.update');
    Route::delete('/roles/{role}', [App\Http\Controllers\AdminUserController::class, 'destroyRole'])->name('roles.destroy');
    Route::post('/permissions/toggle', [App\Http\Controllers\AdminUserController::class, 'togglePermission'])->name('permissions.toggle');

    // --- Aksi tambahan Subkategori (Admin) — path baru, tidak sentuh route subcategory lama ---
    Route::post('/category/{category}/subcategory', [App\Http\Controllers\AdminSubcategoryController::class, 'store'])->name('category.subcategory.store');
    Route::put('/subcategory/{subcategory}', [App\Http\Controllers\AdminSubcategoryController::class, 'update'])->name('subcategory.update');
    Route::delete('/subcategory/{subcategory}', [App\Http\Controllers\AdminSubcategoryController::class, 'destroy'])->name('subcategory.destroy');

    // --- Aksi tambahan Feedback (Admin) ---
    Route::post('/feedback/{id}/update', [AdminFeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/feedback/{id}', [AdminFeedbackController::class, 'destroy'])->name('feedback.destroy');

    });

/*
|--------------------------------------------------------------------------
| User Routes (Peran user biasa) - Direvisi Lengkap dengan Controller
|--------------------------------------------------------------------------
*/
Route::prefix('user')->name('user.')->middleware(['auth', 'role:user', 'prevent.back'])->group(function () {
    // Halaman Dashboard/Profil
    Route::get('/profil', [UserProfileController::class, 'index'])->name('profil');
    Route::put('/profil/update', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profil/password', [UserProfileController::class, 'updatePassword'])->name('profile.password');

    // History
    Route::delete('/history/{id}', [UserProfileController::class, 'deleteHistory'])->name('history.delete');
    Route::delete('/history', [UserProfileController::class, 'clearHistory'])->name('history.clear');

    // Bookmarks
    Route::post('/bookmarks/toggle', [UserProfileController::class, 'toggleBookmark'])->name('bookmarks.toggle');
    Route::delete('/bookmarks/{id}', [UserProfileController::class, 'deleteBookmark'])->name('bookmarks.delete');

    // Notifications
    Route::post('/notifications/{id}/read', [UserProfileController::class, 'markNotificationAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [UserProfileController::class, 'markAllNotificationsAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [UserProfileController::class, 'deleteNotification'])->name('notifications.delete');
    Route::delete('/notifications', [UserProfileController::class, 'clearNotifications'])->name('notifications.clear');
});

/*
|--------------------------------------------------------------------------
| ✨ TAMBAHAN: Aksi Dokumen (Like, Rate, Bookmark, Download PDF)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/document/{id}/like', [DocumentController::class, 'toggleLike'])->name('document.like');
    Route::post('/document/{id}/rate', [DocumentController::class, 'rate'])->name('document.rate');
    Route::post('/document/{id}/bookmark', [DocumentController::class, 'toggleBookmark'])->name('document.bookmark');
    Route::post('/document/{id}/feedback', [DocumentController::class, 'submitFeedback'])->name('document.feedback');
});
Route::get('/document/{id}/download-pdf', [DocumentController::class, 'downloadPdf'])->name('document.download-pdf');

/*
|--------------------------------------------------------------------------
| ✨ TAMBAHAN: Rute Komentar (hanya untuk user yang login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{id}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');