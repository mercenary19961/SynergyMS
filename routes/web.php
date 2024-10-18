<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\RegisterAccess;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TicketsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ProjectManagerController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\HumanResourcesController;
use App\Http\Controllers\Employee\EmployeeDashboardController;

// Redirect to Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Public Routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
// Route::middleware([RegisterAccess::class])->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register.user.create'); 
    Route::post('/register', [RegisterController::class, 'store'])->name('register.user.store');
// });

// Password Reset Routes
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Route
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management Routes
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::get('/users/create', 'create')->name('users.create');
        Route::post('/users', 'store')->name('users.store');
        Route::get('/users/{id}/edit', 'edit')->name('users.edit');
        Route::put('/users/{id}', 'update')->name('users.update');
        Route::delete('/users/{id}', 'destroy')->name('users.destroy');
    });

    // Role Management Routes
    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles', 'index')->name('roles.index');
        Route::get('/roles/create', 'create')->name('roles.create');
        Route::post('/roles', 'store')->name('roles.store');
        Route::get('/roles/{id}/edit', 'edit')->name('roles.edit');
        Route::put('/roles/{id}', 'update')->name('roles.update');
        Route::delete('/roles/{id}', 'destroy')->name('roles.destroy');
    });

    // Settings Routes
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/settings', 'index')->name('settings.index');
        Route::post('/settings', 'store')->name('settings.store');
    });

    // Ticket Management Routes
    Route::controller(TicketsController::class)->group(function () {
        Route::get('/tickets', 'index')->name('tickets.index');
        Route::get('/tickets/create', 'create')->name('tickets.create');
        Route::post('/tickets', 'store')->name('tickets.store');
        Route::get('/tickets/{id}', 'show')->name('tickets.show');
        Route::put('/tickets/{id}', 'update')->name('tickets.update');
        Route::delete('/tickets/{id}', 'destroy')->name('tickets.destroy');
    });

    // Employees Management Routes (Accessible by Super Admin, HR, and Project Manager)
    Route::resource('employees', EmployeesController::class)->middleware('role:Super Admin|HR|Project Manager');

    // Attendance Management Routes (Accessible by Super Admin and HR)
    Route::resource('attendance', AttendanceController::class)->middleware('role:Super Admin|HR');

    // Departments Management Routes (Accessible by Super Admin and HR)
    Route::resource('departments', DepartmentController::class)->middleware('role:Super Admin|HR');

    // Ticket Management Routes (Accessible by Super Admin and Project Manager)
    Route::resource('tickets', TicketsController::class)->middleware('role:Super Admin|Project Manager');

    // Project Manager Management Routes (Accessible by Super Admin and HR)
    Route::resource('project-managers', ProjectManagerController::class)->middleware('role:Super Admin|HR');

    // Clients Management Routes
    Route::resource('clients', ClientsController::class)->middleware('role:Super Admin|Project Manager');

    // Projects Management Routes
    Route::resource('projects', ProjectController::class)->middleware('role:Super Admin|Project Manager');

    // Human Resources Management Routes
    Route::resource('human-resources', HumanResourcesController::class)->middleware('role:Super Admin|HR');


});


// Employee Clock In/Out Routes
Route::middleware(['auth', 'role:Employee|Super Admin'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
    Route::post('/clockin', [EmployeeDashboardController::class, 'clockIn'])->name('clockin');
    Route::post('/clockout', [EmployeeDashboardController::class, 'clockOut'])->name('clockout');
});


// Permission Management (Accessible by Super Admin)
Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::resource('permissions', PermissionsController::class);
});
