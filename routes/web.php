<?php
use App\Http\Controllers\EquipmentBorrowController;
use App\Http\Controllers\EquipmentReturnController;
use App\Http\Controllers\EquipmentsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;

Route::get('/', function () {
    return view('template.backend');
})->middleware('auth');

Route::get('/backend', function () {
    return view('template.backend');
});

Route::get('/backend', function () {
    return view('template.frontends');
});

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('register', [AuthController::class, 'showSignUpForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('users', UserController::class);

Route::resource('equipments', EquipmentsController::class)->except(['show']);

Route::resource('equipment_types', EquipmentTypeController::class);

Route::resource('equipmentborrow', EquipmentBorrowController::class);

Route::patch('/equipmentborrow/{id}/update-status/{status}', [EquipmentBorrowController::class, 'updateStatus'])->name('equipmentborrow.updateStatus');

Route::patch('/equipmentreturn/{id}/update-status/{status}', [EquipmentReturnController::class, 'updateStatus'])->name('equipmentreturn.updateStatus');

Route::resource('equipmentreturn', EquipmentReturnController::class);

Route::resource('frontend', FrontendController::class);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/equipments/pdf', [EquipmentsController::class, 'exportPDF'])->name('equipments.pdf');

Route::get('/equipment-borrow/export-pdf', [EquipmentBorrowController::class, 'exportPdf'])->name('equipmentborrow.exportPdf');

Route::get('/equipment-return/export-pdf', [EquipmentReturnController::class, 'exportPdf'])->name('equipmentreturn.exportPdf');

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::resource('frontend', FrontendController::class)->middleware('auth');

Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history.index');






