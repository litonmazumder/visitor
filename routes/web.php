<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\{
    DashboardController,
    PermissionController,
    RoleController,
    SessionController,
    UserController,
};

use App\Http\Controllers\HR\EmployeeController;

use App\Http\Controllers\Visitor\{
    VisitorController,
    VisitorAdminController
};


/*
|--------------------------------------------------------------------------
| Auth Routes (NO guest middleware)
|--------------------------------------------------------------------------
*/

// Login (Admin - password)
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->name('login.submit');

// OTP Flow (Staff)
Route::post('/check-email', [SessionController::class, 'checkEmail'])->name('check.email');
Route::get('/verify-otp', fn () => view('auth.verify_otp'))->name('verify.otp.form');
Route::post('/verify-otp', [SessionController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/resend-otp', [SessionController::class, 'resendOtp'])->name('resend.otp');

// Refresh CSRF token for long-open auth pages
Route::get('/csrf-token', function () {
    request()->session()->regenerateToken();

    return response()->json([
        'token' => csrf_token(),
    ]);
})->name('csrf.token');

Route::middleware(['auth'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard');

});

Route::middleware(['auth','role:admin'])->group(function () {

    Route::resource('/dashboard/users', UserController::class)->names('user');

    Route::resource('/dashboard/permissions', PermissionController::class)->names('permission');

    Route::resource('/dashboard/roles', RoleController::class)->names('role');

    Route::get('/dashboard/roles/{role}/give-permissions',
        [RoleController::class, 'AddPermissionToRole'])
        ->name('role.give-permissions');

    Route::post('/dashboard/roles/{role}/give-permissions',
        [RoleController::class, 'GivePermissionToRole'])
        ->name('role.give-permissions.store');
});

Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Public Features
|--------------------------------------------------------------------------
*/

Route::post('/employee/fetch', [EmployeeController::class, 'fetchEmployee'])->name('employee.fetch');


Route::prefix('dashboard')->middleware(['auth'])->group(function () {

    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');

    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/employee/store', [EmployeeController::class, 'store'])->name('employee.store');

    Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::put('/employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');

    Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
});
/*
|--------------------------------------------------------------------------
| Visitor Public
|--------------------------------------------------------------------------
*/

Route::prefix('visitor')->group(function () {
    Route::get('register', [VisitorController::class, 'register'])->name('visitor.register');
    Route::get('search', [VisitorController::class, 'search'])->name('visitor.search');
    Route::get('search/result', [VisitorController::class, 'result'])->name('visitor.result');

    Route::post('store', [VisitorController::class, 'store'])->name('visitor.store');
    Route::post('record', [VisitorController::class, 'recordVisit'])->name('record.visit');
});

/*
|--------------------------------------------------------------------------
| Visitor API
|--------------------------------------------------------------------------
*/

Route::prefix('api/visitor')->group(function () {
    Route::get('staff-suggestions', [VisitorController::class, 'fetchStaffSuggestions'])->name('api.visitor.staff-suggestions');
});

/*
|--------------------------------------------------------------------------
| Visitor Admin
|--------------------------------------------------------------------------
*/

Route::prefix('dashboard/visitor')->middleware(['auth'])->group(function () {

        Route::get('/', [VisitorAdminController::class, 'show_all_visitor'])->name('visitor.index');
        Route::get('active', [VisitorAdminController::class, 'showActiveVisitors'])->name('visitor.active');
        Route::get('fetch', [VisitorAdminController::class, 'fetchActiveVisitors'])->name('api.visitor.active');
        Route::post('exit', [VisitorAdminController::class, 'exitVisitor'])->name('api.visitor.exit');
        Route::get('search', [VisitorAdminController::class, 'visitor_search'])->name('visitor_list.search');
        Route::get('{id}', [VisitorAdminController::class, 'visitor_details'])->name('visitor.details');
});
