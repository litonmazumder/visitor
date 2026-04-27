<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    public function index(){

        $userData = User::orderBy('id', 'desc')->get();
        return view('user.index', ['ShowUserData' => $userData]);
    }
    
    public function create(){

        $roles = Role::get();
        return view('user.create', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
    // Validate the incoming request data
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email', 'max:255'],
        'password' => ['required', 'string', 'min:6'], // Use min length and confirmation for password
        'roles' => ['required'], // Ensure 'roles' is an array
    ]);

    // Create the user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Hashing the password
    ]);

    $roles = Role::whereIn('id', $request->roles)->get();
    // Sync roles to the user
    $user->syncRoles($roles); // Ensure 'roles' is an array

    // Redirect with success message
    return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function edit($id) {
        $roles = Role::get();
        $user = User::findOrFail($id);
        return view('user.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $id], // Ensure email is unique except for current user
            'password' => ['nullable', Password::min(6)], // Password is optional for update
            'roles' => ['required'] // Ensure 'roles' is an array
        ]);
    
        // Find the user by ID
        $user = User::findOrFail($id);
    
        // Prepare the attributes for updating
        $attributes = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];
    
        // Check if the password is provided and hash it
        if ($request->filled('password')) {
            $attributes['password'] = Hash::make($request->input('password')); // Hashing the password
        }
    
        // Update the user
        $user->update($attributes);
    
        // Sync roles using the role names based on the provided role IDs
        $roles = Role::whereIn('id', $request->roles)->get();
        $user->syncRoles($roles);
    
        // Redirect with success message
        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }    
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/portal/users')->with('success', 'User deleted successfully');
    }



}
