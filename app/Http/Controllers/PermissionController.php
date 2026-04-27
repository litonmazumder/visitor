<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){

        $permissions = Permission::orderBy('created_at', 'desc')->get();


        return view('role-permission.permission.index', [
            'permissions' => $permissions
        ]);
    }

    public function create(){

        return view('role-permission.permission.create');
    }

    public function edit(Permission $permission){

       // return $permission;
        return view('role-permission.permission.edit', [
            'permission' => $permission
        ]);
    }


    public function store(Request $request){

    $request->validate([
            'name' => ['required', 
                        'string', 
                        'unique:permissions,name'
                    ]
        ]);

        Permission::create([
            'name'=> $request->name
        ]);

        return redirect('/portal/permissions')->with('success', 'Permission created successfully!');
    }

    public function update(Request $request, Permission $permission){

        $request->validate([
            'name' => ['required', 
                        'string', 
                        'unique:permissions,name,'.$permission->id
                    ]
        ]);

        $permission->update([
            'name'=> $request->name
        ]);

        return redirect('/portal/permissions')->with('success', 'Permission updated successfully!');
    }

    public function destroy(Permission $permission){

       // $permission = Permission::findOrFail($permission);
       // dd($permission);
        $permission->delete();
        return redirect('/portal/permissions')->with('success', 'Permission deleted successfully!');
    }
}
