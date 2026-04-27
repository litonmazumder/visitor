<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(){

        $roles = Role::get();

        return view('role-permission.role.index', [
            'roles' => $roles
        ]);
    }

    public function create(){

        return view('role-permission.role.create');
    }

    public function edit(Role $role){
        
       // return $role;
        return view('role-permission.role.edit', [
            'role' => $role
        ]);
    }


    public function store(Request $request){

    $request->validate([
            'name' => ['required', 
                        'string', 
                        'unique:roles,name'
                    ]
        ]);

        Role::create([
            'name'=> $request->name
        ]);

        return redirect('/portal/roles')->with('success', 'role created successfully!');
    }

    public function update(Request $request, Role $role){

        $request->validate([
            'name' => ['required', 
                        'string', 
                        'unique:roles,name,'.$role->id
                    ]
        ]);

        $role->update([
            'name'=> $request->name
        ]);

        return redirect('/portal/roles')->with('success', 'role updated successfully!');
    }

    public function destroy(Role $role){

       // $role = role::findOrFail($roleId);
       // dd($role);
        $role->delete;
        return redirect('roles')->with('success', 'role deleted successfully!');
    }

    public function AddPermissionToRole(Role $role){

        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray(); 

        return view('role-permission.role.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);

    }

    public function GivePermissionToRole(Request $request, Role $role)
    {
        $request->validate([
            'permission' => 'required|array'
        ]);
    
        // Retrieve permission names based on the submitted permission IDs
        $permissionNames = Permission::whereIn('id', $request->permission)->pluck('name')->toArray();
    
        // Sync the role with the permission names
        $role->syncPermissions($permissionNames);
    
        return redirect()->back()->with('status', 'Permissions added to the role successfully');
    }
    
    
}
