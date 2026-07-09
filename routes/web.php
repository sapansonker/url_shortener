<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ShortUrlController;

Route::get('/', function () {
    return view('welcome');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Super Admin
Route::middleware('auth', 'role:super_admin')->group(function () {
    Route::get('/super-admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/super-admin/company/create', [SuperAdminController::class, 'createCompany'])->name('company.create');
    Route::post('/super-admin/company/store', [SuperAdminController::class, 'storeCompany'])->name('company.store');
    // Route::get('/super-admin/urls/download', [ShortUrlController::class, 'superAdminDownload'])->name('urls.download');
});


// Admin
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/member/create', [AdminController::class, 'createMember'])->name('member.create');
    Route::post('/admin/member/store', [AdminController::class, 'storeMember'])->name('member.store');
});


// Admin and Member
Route::middleware(['auth', 'role:super_admin,admin,member'])->group(function () {
    Route::post('/urls', [ShortUrlController::class, 'store'])->name('urls.store');
    Route::get('/urls/download', [ShortUrlController::class, 'download'])->name('urls.download');
});


// Member
Route::middleware('auth', 'role:member')->group(function () {
    Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');
});


// Short URL redirection
Route::get('/s/{code}', [ShortUrlController::class, 'redirect'])->name('urls.redirect');

require __DIR__.'/auth.php';
