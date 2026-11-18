<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ToolController;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lang/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['ar', 'en'], true), 404);
    session(['locale' => $locale]);

    return redirect()->back();
})->name('lang');
Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
Route::get('/pricing', [ToolController::class, 'pricing'])->name('pricing');
Route::get('/tools', [ToolController::class, 'index'])->name('tools.index');
Route::get('/tools/dieline', [ToolController::class, 'dieline'])->name('tools.dieline');
Route::get('/printers', [PrinterController::class, 'index'])->name('printers.index');
Route::get('/preview/{uuid}', [DesignController::class, 'preview'])->name('designs.preview');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/designs', [DesignController::class, 'index'])->name('designs.index');
    Route::get('/designs/new/{template}', [DesignController::class, 'create'])->name('designs.create');
    Route::post('/designs', [DesignController::class, 'store'])->name('designs.store');
    Route::get('/designs/{design}/edit', [DesignController::class, 'edit'])->name('designs.edit');
    Route::put('/designs/{design}', [DesignController::class, 'update'])->name('designs.update');
    Route::delete('/designs/{design}', [DesignController::class, 'destroy'])->name('designs.destroy');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/designs/{design}/order', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/designs/{design}/order', [OrderController::class, 'store'])->name('orders.store');

    Route::middleware(AdminOnly::class)->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::patch('/orders/{order}', [AdminController::class, 'updateOrder'])->name('admin.orders.update');
    });
});
