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

Route::get('/', [DashboardController::class, 'home'])->name('dashboard');

});

Route::middleware(['auth'])->group(function () {

    Route::resource('/portal/users', UserController::class)
        ->middleware('permission:user.view');

    Route::resource('/portal/permissions', PermissionController::class)
        ->middleware('permission:permission.view');

    Route::resource('/portal/roles', RoleController::class)
        ->middleware('permission:role.view');

    Route::get('/portal/roles/{role}/give-permissions',
        [RoleController::class, 'AddPermissionToRole'])
        ->middleware('permission:role.edit')
        ->name('roles.give-permissions');

    Route::post('/portal/roles/{role}/give-permissions',
        [RoleController::class, 'GivePermissionToRole'])
        ->middleware('permission:role.edit')
        ->name('roles.give-permissions.store');
});


Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Public Features
|--------------------------------------------------------------------------
*/

Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
Route::post('/employee/fetch', [EmployeeController::class, 'fetchEmployee'])->name('employee.fetch');


Route::prefix('hr')->group(function () {

    Route::get('/employee/list', [EmployeeController::class, 'index'])->name('employee.index');

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
    Route::get('register', [VisitorController::class, 'register']);
    Route::get('search', [VisitorController::class, 'search']);
    Route::get('search/result', [VisitorController::class, 'result']);
    Route::get('active', [VisitorController::class, 'showActiveVisitors']);

    Route::post('store', [VisitorController::class, 'store'])->name('visitor.store');
    Route::post('record', [VisitorController::class, 'recordVisit'])->name('record.visit');
});

/*
|--------------------------------------------------------------------------
| Visitor API
|--------------------------------------------------------------------------
*/

Route::prefix('api/visitor')->group(function () {
    Route::get('active', [VisitorController::class, 'fetchActiveVisitors'])->name('api.visitor.active');
    Route::post('exit', [VisitorController::class, 'exitVisitor'])->name('api.visitor.exit');
    Route::get('staff-suggestions', [VisitorController::class, 'fetchStaffSuggestions'])->name('api.visitor.staff-suggestions');
});

/*
|--------------------------------------------------------------------------
| Visitor Admin
|--------------------------------------------------------------------------
*/

Route::prefix('portal/visitor')
    ->middleware(['permission:visitor.view'])
    ->group(function () {

        Route::get('/', [VisitorAdminController::class, 'show_all_visitor'])->name('index.visitor');
        Route::get('search/list', [VisitorAdminController::class, 'visitor_search'])->name('visitor.search');
        Route::get('{id}', [VisitorAdminController::class, 'visitor_details'])->name('visitor.details');
});
