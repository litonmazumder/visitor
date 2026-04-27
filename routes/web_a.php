<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ZKTecoController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\BulkEmailController;
// use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Portal\MediaController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Portal\PortalController;
use App\Http\Controllers\Portal\VendorController;
use App\Http\Controllers\Remote\Remote_Desk_Controller;

use App\Http\Controllers\Portal\GalleryController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\Vehicle\VehicleController;

use App\Http\Controllers\Visitor\VisitorController;
use App\Http\Controllers\Inventory\DeviceController;
use App\Http\Controllers\Remote\AnyDeskController;
use App\Http\Controllers\Visitor\VisitorAdminController;

Route::get('/bulk-email', [BulkEmailController::class, 'showForm']);
Route::post('/send-bulk-email', [BulkEmailController::class, 'sendBulkEmails'])->name('send.bulk.email');

Route::get('/medialibrary', [MediaController::class, 'media'])->name('mediaLibrary');
Route::get('/staff', [StaffController::class, 'staff'])->name('staffList');
Route::get('/vendor', [VendorController::class, 'vendor'])->name('vendorList');
Route::get('/project', [PortalController::class, 'project'])->name('projectList');
Route::get('/templates/{category}', [PortalController::class, 'template'])->name('templates.category');
Route::get('projects/{id}', [PortalController::class, 'project_page']);
// Route::get('/projects', [PortalController::class, 'project_page'])->name('projectPage');
Route::post('/staff/fetch', [StaffController::class, 'fetchStaff'])->name('staff.fetch');
//Auth
Route::get('/', [PortalController::class, 'index'])->name('home');
Route::post('/portal/register', [RegisteredUserController::class, 'store']);

Route::middleware('guest')->group(function () {
    Route::get('/portal/login', [SessionController::class, 'create'])->name('login');
});

Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

Route::get('/portal/forgot-password', [PasswordResetController::class, 'forgot_pass'])->name('password.request');;
Route::post('/reset-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.reset');

// Route::post('/portal/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/portal/reset-password/{token}', [PasswordResetController::class, 'showResetForm']);
Route::post('/portal/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');


Route::middleware('auth')->group(function () {

    // Routes for Portal Home
    Route::get('/portal', [DashboardController::class, 'index'])->name('admin.index');

        // Routes for Device
        Route::prefix('portal/device')->middleware('can:device.view')->group(function () {
            Route::get('inventory', [DeviceController::class, 'inventory'])->name('device.inventory');
            Route::get('create', [DeviceController::class, 'create'])->name('device.create');
            Route::get('handover', [DeviceController::class, 'handover'])->name('device.handover');
            Route::get('takeover', [DeviceController::class, 'takeover'])->name('device.takeover');
            Route::get('gatepass', [DeviceController::class, 'gatepass'])->name('device.gatepass');
        });
        
        // Routes for Portal
        Route::prefix('portal')->middleware('can:portal.view')->group(function () {
            Route::get('templates', [PortalController::class, 'index'])->name('portal.templates');
            Route::get('links', [PortalController::class, 'index'])->name('portal.links');
            Route::get('images', [ImageController::class, 'index'])->name('portal.images');
        });
        
        // Routes for Visitor
        Route::middleware(['can:visitor.view'])->group(function () {
            Route::get('portal/visitor-details', [VisitorAdminController::class, 'show_all_visitor'])
                ->name('visitor.show');
                
            Route::get('portal/visitor-details/{id}', [VisitorAdminController::class, 'visitor_details'])
                ->name('visitor.details');
                
            Route::get('visitors', [VisitorAdminController::class, 'visitor_search'])
                ->name('visitor.list');
        });
        
    // Routes for Remote ID's
    Route::middleware(['can:remote.view'])->group(function () {    
        Route::get('/portal/remote-desk', [Remote_Desk_Controller::class, 'index'])->name('remote.index');
        Route::get('/portal/remote/create', [Remote_Desk_Controller::class, 'create'])->name('remote.create');
        Route::get('/anydesk/search', [AnyDeskController::class, 'searchAnydeskID'])->name('anydesk.search');
        Route::post('/remote', [Remote_Desk_Controller::class, 'store'])->name('remote.store'); // Form Page
        Route::get('remote/edit/{id}', [Remote_Desk_Controller::class, 'edit'])->name('remote.edit');
        Route::put('/user/{id}', [Remote_Desk_Controller::class, 'update'])->name('remote.update');
        Route::delete('remote/delete/{id}', [Remote_Desk_Controller::class, 'destroy'])->name('remote.destroy');       
    });
    Route::middleware(['can:attendance.view'])->group(function () {
        Route::get('/portal/attendance/checkinout', [AttendanceController::class, 'checkInOut'])->name('attendance.checkinout');
        Route::get('/portal/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
        Route::get('/portal/attendance/export/pdf', [AttendanceController::class, 'exportPDF'])->name('attendance.export.pdf');
     });   
    Route::get('/portal/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::get('/portal/staff/view', [StaffController::class, 'view'])->name('staff.view');
    Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');

    // Routes for Vehicle Module
    Route::middleware(['can:vehicle.view'])->group(function () {
        Route::prefix('portal/vehicle')->group(function () {
            Route::get('fuel-requisitions', [VehicleController::class, 'fuel_requisition'])
                ->name('fuel.requisition');
            
            Route::get('editmaintenance-requisitions', [VehicleController::class, 'maintenance_requisition'])
                ->name('maintenance.requisition');
            
            Route::get('fuel-report', [VehicleController::class, 'fuel_report'])
                ->name('fuel.report');
            
            Route::get('maintenance-report', [VehicleController::class, 'maintenance_report'])
                ->name('maintenance.report');
            
            Route::get('fuel-requisition/{id}/edit', [VehicleController::class, 'fuel_edit'])
                ->name('vehicle.edit');

            Route::get('/search/fuel', [SearchController::class, 'search']);    
        });
    });
    Route::resource('/portal/users', UserController::class);

    // Route::get('/portal/users', [UserController::class, 'show'])->name('user.index');
    // Route::get('/portal/users/create', [UserController::class, 'create'])->name('user.create');
    
    // Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    // Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    // Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Permission Routes
    Route::resource('/portal/permissions', PermissionController::class);
    // Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])
    //     ->name('permissions.destroy')
    //     ->middleware('can:permission.delete');
    
    // Role Routes
    Route::resource('portal/roles', RoleController::class);
    Route::get('portal/roles/{roleId}/give-permissions', [RoleController::class, 'AddPermissionToRole']);
    Route::put('portal/roles/{roleId}/give-permissions', [RoleController::class, 'GivePermissionToRole'])
        ->name('roles.give-permissions.store');
});

Route::get('/visitor/active', [VisitorController::class, 'showActiveVisitors']);
Route::get('/api/active-visitors', [VisitorController::class, 'fetchActiveVisitors'])->name('api.activeVisitors');
Route::post('/api/exit-visitor', [VisitorController::class, 'exitVisitor'])->name('api.exitVisitor');

Route::get('/visitor/register', [VisitorController::class, 'register']);
Route::get('/visitor/search', [VisitorController::class, 'search']);


Route::get('/visitor/search/result', [VisitorController::class, 'result']);

Route::post('/recordVisit', [VisitorController::class, 'recordVisit']);
Route::post('visitor/store', [VisitorController::class, 'store'])->name('visitor.store');

// routes/web.php
// Define this route in your web.php or api.php
Route::get('/fetch-staff-suggestions', [VisitorController::class, 'fetchStaffSuggestions'])->name('fetch.staff.suggestions');

Route::get('/check-sqlsrv-connection', function () {
    try {
        DB::connection('sqlsrv')->getPdo();
        return response()->json(['status' => 'Connection successful!']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
