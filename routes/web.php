<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
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
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\HumanResourcesController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\ProjectManager\ProjectManagerDashboardController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\HR\HRDashboardController;

use App\Http\Middleware\RegisterAccess;
use App\Http\Middleware\CheckRecruitmentManager;
use App\Http\Middleware\ProjectOwnerOrSuperAdmin;
use App\Http\Middleware\CheckTicketAccess;


// Redirect to Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect to Dashboard
Route::get('/dashboard-redirect', [UserController::class, 'dashboardRedirect'])->name('dashboard.redirect');

// Profile page
Route::get('/profile', [UserController::class, 'profile'])->name('profile');

// Public Routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/support', [SupportController::class, 'show'])->name('support');
Route::post('/support', [SupportController::class, 'submit'])->name('support.submit');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::middleware(['auth', 'role:HR|Super Admin'])->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register.user.create');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.user.store');
});

// Notifications Routes
Route::get('/notifications', function () {
    $user = Auth::user();
    $notifications = $user->notifications;
    return view('pages.notifications', compact('notifications'));
})->name('notifications.index');

Route::patch('/notifications/{id}/read', function ($id) {
    $user = Auth::user();
    $notification = $user->notifications()->find($id);

    if ($notification) {
        $notification->markAsRead();
    }

    return redirect()->route('notifications.index');
})->name('notifications.read');



// Password Reset Routes
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Route
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'role:Super Admin']);

    // User Management Routes
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index')->middleware(['auth', 'role:Super Admin']);
        Route::get('/users/create', 'create')->name('users.create')->middleware(['auth', 'role:Super Admin']);
        Route::post('/users', 'store')->name('users.store')->middleware(['auth', 'role:Super Admin']);
        Route::get('/users/{id}/edit', 'edit')->name('users.edit')->middleware(['auth', 'role:Super Admin']);
        Route::put('/users/{id}', 'update')->name('users.update')->middleware(['auth', 'role:Super Admin']);
        Route::delete('/users/{id}', 'destroy')->name('users.destroy')->middleware(['auth', 'role:Super Admin']);
    });

    // Role Management Routes
    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles', 'index')->name('roles.index')->middleware(['auth', 'role:Super Admin']);
        Route::get('/roles/create', 'create')->name('roles.create')->middleware(['auth', 'role:Super Admin']);
        Route::post('/roles', 'store')->name('roles.store')->middleware(['auth', 'role:Super Admin|Project Manager']);
        Route::get('/roles/{id}/edit', 'edit')->name('roles.edit')->middleware(['auth', 'role:Super Admin']);
        Route::put('/roles/{id}', 'update')->name('roles.update')->middleware(['auth', 'role:Super Admin']);
        Route::delete('/roles/{id}', 'destroy')->name('roles.destroy')->middleware(['auth', 'role:Super Admin']);
    });

    // Settings Routes
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/settings', 'index')->name('settings.index')->middleware(['auth', 'role:Super Admin']);
        Route::post('/settings', 'store')->name('settings.store')->middleware(['auth', 'role:Super Admin']);
    });

    // Employees Management Routes
    Route::controller(EmployeesController::class)->group(function () {
        Route::get('/employees', 'index')->name('employees.index')->middleware('role:Super Admin|HR|Project Manager|Client');
        Route::get('/employees/{employee}', 'show')->name('employees.show')->middleware('role:Super Admin|HR|Project Manager|Client');
        Route::get('/admin/employees/create', 'create')->name('employees.create')->middleware('role:Super Admin|HR');
        Route::post('/employees', 'store')->name('employees.store')->middleware('role:Super Admin|HR');
        Route::get('/employees/{employee}/edit', 'edit')->name('employees.edit')->middleware('role:Super Admin|HR');
        Route::put('/employees/{employee}', 'update')->name('employees.update')->middleware('role:Super Admin|HR');
        Route::delete('/employees/{employee}', 'destroy')->name('employees.destroy')->middleware('role:Super Admin|HR');
    });

    // Attendance Management Routes
    Route::controller(AttendanceController::class)->group(function () {
        Route::get('/attendance', 'index')->name('attendance.index')->middleware('role:Super Admin|HR|Project Manager');
        Route::get('/attendance/{attendance}', 'show')->name('attendance.show')->middleware('role:Super Admin|HR|Project Manager');
        Route::get('/admin/attendance/create', 'create')->name('attendance.create')->middleware('role:Super Admin|HR');
        Route::post('/attendance', 'store')->name('attendance.store')->middleware('role:Super Admin|HR');
        Route::get('/attendance/{attendance}/edit', 'edit')->name('attendance.edit')->middleware('role:Super Admin|HR');
        Route::put('/attendance/{attendance}', 'update')->name('attendance.update')->middleware('role:Super Admin|HR');
        Route::delete('/admin/attendance/{attendance}', 'destroy')->name('attendance.destroy')->middleware('role:Super Admin|HR');
    });

    // Departments Management Routes
    Route::controller(DepartmentController::class)->group(function () {
        Route::get('/departments', 'index')->name('departments.index')->middleware('role:Super Admin|HR|Project Manager|Client');
        Route::get('/departments/{department}', 'show')->name('departments.show')->middleware('role:Super Admin|HR|Project Manager|Client');
        Route::get('/admin/departments/create', 'create')->name('departments.create')->middleware('role:Super Admin|HR');
        Route::post('/departments', 'store')->name('departments.store')->middleware('role:Super Admin|HR');
        Route::get('/departments/{department}/edit', 'edit')->name('departments.edit')->middleware('role:Super Admin|HR');
        Route::put('/departments/{department}', 'update')->name('departments.update')->middleware('role:Super Admin|HR');
        Route::delete('/admin/departments/{department}', 'destroy')->name('departments.destroy')->middleware('role:Super Admin|HR');
    });

    // Tickets Management Routes
    Route::controller(TicketsController::class)->group(function () {
        Route::get('/tickets', 'index')->name('tickets.index')->middleware('role:Super Admin|HR|Project Manager|Client');
        Route::get('/tickets/{ticket}', 'show')->name('tickets.show')->middleware('role:Super Admin|HR|Project Manager|Client');
        Route::get('/admin/tickets/create', 'create')->name('tickets.create')->middleware('role:Super Admin|Project Manager');
        Route::post('/tickets', 'store')->name('tickets.store')->middleware('role:Super Admin|Project Manager|Client|HR|employee');
        
        // custom middleware to check if the user has access to edit, update, or delete tickets
        Route::get('/tickets/{ticket}/edit', 'edit')->name('tickets.edit')->middleware(checkTicketAccess::class);
        Route::put('/tickets/{ticket}', 'update')->name('tickets.update')->middleware(checkTicketAccess::class);
        Route::delete('/tickets/{ticket}', 'destroy')->name('tickets.destroy')->middleware(checkTicketAccess::class);
    });


    // Clients Management Routes
    Route::controller(ClientsController::class)->group(function () {
        Route::get('/clients', 'index')->name('clients.index')->middleware('role:Super Admin|HR|Project Manager|Client');
        Route::get('/clients/{client}', 'show')->name('clients.show')->middleware('role:Super Admin|HR|Project Manager|Client');
        Route::get('/admin/clients/create', 'create')->name('clients.create')->middleware('role:Super Admin|Project Manager');
        Route::post('/clients', 'store')->name('clients.store')->middleware('role:Super Admin|Project Manager');
        Route::get('/clients/{client}/edit', 'edit')->name('clients.edit')->middleware('role:Super Admin|Project Manager');
        Route::put('/clients/{client}', 'update')->name('clients.update')->middleware('role:Super Admin|Project Manager');
        Route::delete('/clients/{client}', 'destroy')->name('clients.destroy')->middleware('role:Super Admin|Project Manager');
    });

    // Projects Management Routes
    Route::controller(ProjectController::class)->group(function () {
        Route::get('/projects', 'index')->name('projects.index')->middleware('role:Super Admin|HR|Project Manager|Client');
        Route::get('/projects/{project}', 'show')->name('projects.show')->middleware('role:Super Admin|HR|Project Manager|Client');
        
        // Only Super Admin and Project Manager can create new projects
        Route::get('/admin/projects/create', 'create')->name('projects.create')->middleware('role:Super Admin|Project Manager');
        Route::post('/projects', 'store')->name('projects.store')->middleware('role:Super Admin|Project Manager|Client');

        // custom middleware to check project owner or Super Admin
        Route::get('/projects/{project}/edit', 'edit')->name('projects.edit')->middleware(ProjectOwnerOrSuperAdmin::class);
        Route::put('/projects/{project}', 'update')->name('projects.update')->middleware(ProjectOwnerOrSuperAdmin::class);
        Route::delete('/projects/{project}', 'destroy')->name('projects.destroy')->middleware(ProjectOwnerOrSuperAdmin::class);
    });

    // Events Management Routes
    Route::controller(EventsController::class)->group(function () {
        Route::get('/events', 'index')->name('events.index')->middleware('role:Super Admin|HR|Project Manager|Employee');
        Route::get('/events/{event}', 'show')->name('events.show')->middleware('role:Super Admin|HR|Project Manager|Employee');
        Route::get('/admin/events/create', 'create')->name('events.create')->middleware('role:Super Admin|HR');
        Route::post('/events', 'store')->name('events.store')->middleware('role:Super Admin|HR');
        Route::get('/events/{event}/edit', 'edit')->name('events.edit')->middleware('role:Super Admin|HR');
        Route::put('/events/{event}', 'update')->name('events.update')->middleware('role:Super Admin|HR');
        Route::delete('/admin/events/{event}', 'destroy')->name('events.destroy')->middleware('role:Super Admin|HR');
    });

});

// Project Manager Management Routes with 'admin/project-managers' prefix
Route::prefix('admin/project-managers')->name('admin.')->controller(ProjectManagerController::class)->group(function () {
    Route::get('/', 'index')->name('project-managers.index')->middleware('role:Super Admin|HR|Project Manager|Client');
    Route::get('/{projectManager}', 'show')->name('project-managers.show')->middleware('role:Super Admin|HR|Project Manager|Client');
    Route::get('/create', 'create')->name('project-managers.create')->middleware('role:Super Admin|HR');
    Route::post('/', 'store')->name('project-managers.store')->middleware('role:Super Admin|HR');
    Route::get('/{projectManager}/edit', 'edit')->name('project-managers.edit')->middleware('role:Super Admin|HR');
    Route::put('/{projectManager}', 'update')->name('project-managers.update')->middleware('role:Super Admin|HR');
    Route::delete('/{projectManager}', 'destroy')->name('project-managers.destroy')->middleware('role:Super Admin|HR');
});


// Human Resources Management Routes with 'admin/human-resources' prefix
Route::prefix('admin/human-resources')->name('admin.')->controller(HumanResourcesController::class)->group(function () {
    Route::get('/', 'index')->name('human-resources.index')->middleware('role:Super Admin|HR|Project Manager|Client');
    Route::get('/{id}', 'show')->name('human-resources.show')->middleware('role:Super Admin|HR|Project Manager|Client');

    // custom middleware for creating, editing, updating, and deleting
    Route::get('/admin/human-resources/create', 'create')->name('human-resources.create')->middleware(CheckRecruitmentManager::class);
    Route::post('/', 'store')->name('human-resources.store')->middleware(CheckRecruitmentManager::class);
    Route::get('/{id}/edit', 'edit')->name('human-resources.edit')->middleware(CheckRecruitmentManager::class);
    Route::put('/{id}', 'update')->name('human-resources.update')->middleware(CheckRecruitmentManager::class);
    Route::delete('/{id}', 'destroy')->name('human-resources.destroy')->middleware(CheckRecruitmentManager::class);
});

// Task Management Route
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::put('/admin/tasks/update/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::get('/admin/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
Route::delete('/admin/tasks/delete/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');



// Route to take the ticket
Route::post('/admin/tickets/{id}/take', [TicketsController::class, 'takeTicket'])->name('admin.tickets.take');
// Route to send the ticket back
Route::post('/admin/tickets/{id}/send-back', [TicketsController::class, 'sendBack'])->name('admin.tickets.sendBack');

// Project Request for the client dashboard
Route::post('/admin/projects/request', [ProjectController::class, 'storeRequest'])->name('admin.projects.storeRequest');


// Project Manager Dashboard Route
Route::middleware(['auth', 'role:Project Manager|Super Admin'])->prefix('project-manager')->name('project-manager.')->group(function () {
    Route::get('/dashboard', [ProjectManagerDashboardController::class, 'index'])->name('dashboard');
});

// Employee Clock In/Out Routes
Route::middleware(['auth', 'role:Employee|Super Admin'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
    Route::post('/clockin', [EmployeeDashboardController::class, 'clockIn'])->name('clockin');
    Route::post('/clockout', [EmployeeDashboardController::class, 'clockOut'])->name('clockout');
});

// HR Dashboard Route
Route::middleware(['auth', 'role:HR|Super Admin'])->prefix('hr')->name('hr.')->group(function () {
    Route::get('/dashboard', [HRDashboardController::class, 'index'])->name('dashboard');
});

// Client Dashboard Route
Route::middleware(['auth', 'role:Client|Super Admin'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
});

// Permission Management (Accessible by Super Admin)
Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    Route::resource('permissions', PermissionsController::class);
});
