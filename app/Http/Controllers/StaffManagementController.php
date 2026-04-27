<?php

namespace App\Http\Controllers;

use App\Models\Staff\Staff;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class StaffManagementController extends Controller
{
    public function index()
    {
        $staffData = Staff::where('emp_status', 'Active')->orderBy('staff_id', 'desc')->get();
        return view('staff-management.index', ['staffData' => $staffData]);
    }

    public function show($staffId)
    {
        $staff = Staff::findOrFail($staffId);
        $staffRoles = $staff->roles->pluck('id')->toArray();
        $staffPermissions = $staff->permissions->pluck('id')->toArray();
        $allRoles = Role::all();
        $allPermissions = Permission::all();

        return view('staff-management.show', [
            'staff' => $staff,
            'staffRoles' => $staffRoles,
            'staffPermissions' => $staffPermissions,
            'allRoles' => $allRoles,
            'allPermissions' => $allPermissions
        ]);
    }

    public function assignRoles(Request $request, $staffId)
    {
        $staff = Staff::findOrFail($staffId);
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        $roles = Role::whereIn('id', $request->roles ?? [])->get();
        $staff->syncRoles($roles);

        // Clear cached permissions to ensure immediate effect
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->back()->with('success', 'Roles assigned to staff successfully!');
    }

    public function assignPermissions(Request $request, $staffId)
    {
        $staff = Staff::findOrFail($staffId);
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();
        $staff->syncPermissions($permissions);

        // Clear cached permissions to ensure immediate effect
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->back()->with('success', 'Permissions assigned to staff successfully!');
    }

    public function removeRole($staffId, $roleId)
    {
        $staff = Staff::findOrFail($staffId);
        $role = Role::findOrFail($roleId);
        $staff->removeRole($role);

        // Clear cached permissions to ensure immediate effect
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->back()->with('success', 'Role removed from staff successfully!');
    }

    public function revokePermission($staffId, $permissionId)
    {
        $staff = Staff::findOrFail($staffId);
        $permission = Permission::findOrFail($permissionId);
        $staff->revokePermissionTo($permission);

        // Clear cached permissions to ensure immediate effect
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // If the staff member is currently logged in, log them out to force re-authentication
        if (auth()->guard('staff')->check() && auth()->guard('staff')->user()->staff_id == $staffId) {
            auth()->guard('staff')->logout();
        }
        if (auth()->guard('web')->check() && auth()->guard('web')->user()->id == $staffId) {
            auth()->guard('web')->logout();
        }

        return redirect()->back()->with('success', 'Permission revoked from staff successfully! Staff has been logged out.');
    }

    public function bulkPermissions()
    {
        $staffData = Staff::where('emp_status', 'Active')->orderBy('staff_id', 'desc')->get();
        $allPermissions = Permission::all();
        $permissionsByModule = $this->groupPermissionsByModule($allPermissions);

        return view('staff-management.bulk-permissions', [
            'staffData' => $staffData,
            'allPermissions' => $allPermissions,
            'permissionsByModule' => $permissionsByModule
        ]);
    }

    public function assignBulkPermissions(Request $request)
    {
        $request->validate([
            'staff_ids' => 'required|array|min:1',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id'
        ]);

        // Validate staff_ids exist in the secondary database
        $staffIds = $request->staff_ids;
        $existingStaffIds = Staff::whereIn('staff_id', $staffIds)->pluck('staff_id')->toArray();
        $missingStaffIds = array_diff($staffIds, $existingStaffIds);

        if (!empty($missingStaffIds)) {
            return redirect()->back()
                ->withErrors(['staff_ids' => 'The following staff IDs do not exist: ' . implode(', ', $missingStaffIds)])
                ->withInput();
        }

        $permissions = Permission::whereIn('id', $request->permissions)->get();

        $count = 0;
        $errors = [];

        foreach ($staffIds as $staffId) {
            try {
                $staff = Staff::findOrFail($staffId);
                $staff->syncPermissions($permissions);
                $count++;
            } catch (\Exception $e) {
                $errors[] = "Failed to assign permissions to staff ID {$staffId}: " . $e->getMessage();
            }
        }

        // Clear cached permissions to ensure immediate effect
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $message = "Permissions assigned to {$count} staff members successfully!";
        if (!empty($errors)) {
            $message .= " Errors: " . implode(', ', $errors);
        }

        return redirect()->route('staff-management.index')
            ->with('success', $message);
    }

    private function groupPermissionsByModule($permissions)
    {
        $grouped = [];
        
        foreach ($permissions as $permission) {
            // Extract module name from permission (e.g., "asset.create" -> "asset")
            $module = explode('.', $permission->name)[0];
            
            if (!isset($grouped[$module])) {
                $grouped[$module] = [];
            }
            
            $grouped[$module][] = $permission;
        }

        return $grouped;
    }
}