<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{

    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('user.index', ['users' => $users]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::Pluck('name','name')->all();
        return view('user.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function assignRoleForm()
    {
        $roles = Role::pluck('name')->all();
        return view('user.assign-role', compact('roles'));
    }

    public function assignRole(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'email' => 'required|email|max:255|exists:users,email',
        'role' => 'required|string|exists:roles,name',
    ]);

    // Find the user by email
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return redirect()->route('admins.index')->with('error', 'User not found.');
    }

    // Find the role by name
    $role = Role::where('name', $request->role)->first();

    if (!$role) {
        return redirect()->route('admins.index')->with('error', 'Role not found.');
    }

    // Check if the user already has the assigned role
    if ($user->hasRole($role)) {
        return redirect()->route('admins.index')->with('error', 'User already has the role.');
    }

    // Assign the role to the user
    $user->assignRole($role);

    return redirect()->route('admins.index')->with('success', 'Role assigned successfully');
}



    public function store(Request $request)
    {
        // $request->validate([
        //     'first_name' => 'required|string|max:255',
        //     'last_name' => 'required|string|max:255',
        //     'email' => 'required|email|max:255|exists:users,email',
        //     'role' => 'required|string|exists:roles,name',
        // ]);

        // $user = User::where('first_name', $request->first_name)
        //             ->where('last_name', $request->last_name)
        //             ->where('email', $request->email)
        //             ->firstOrFail();

        // // Fetch role IDs based on the role names received from the form
        // $role = Role::where('name', $request->role)->firstOrFail();
        //     // dd($roleIds);
        // // Sync the user's roles
        // $user->assignRole($role);

        // return redirect('admins')->with('success', 'User Created Successfully with Roles');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        $roles = Role::pluck('name')->all();
        return view('user.edit', [
            'roles' => $roles,
            'user' => $user
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string', // Allow password to be nullable
            'roles' => 'required|array', // Validate that roles is an array
        ]);

        // Retrieve the user by ID
        $user = User::findOrFail($id);

        // Prepare the data for update
        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ];

        // Check if password is provided and update it
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        // Update the user with the prepared data
        $user->update($data);

        // Fetch role IDs based on the role names received from the form
        $roleIds = Role::whereIn('name', $request->roles)->pluck('id')->toArray();

        // Sync the user's roles
        $user->syncRoles($roleIds);

        return redirect('users')->with('success','Updated Successfully');
    }
    public function destroy($id)
{
    // Find the user by ID
    $user = User::findOrFail($id);

    // Delete the user
    $user->delete();

    // Redirect back with a success message
    return redirect()->route('users.index')->with('success', 'User deleted successfully');
}

}
