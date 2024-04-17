<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;



class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $request->validate([
            'email' => 'required|email|max:255|exists:users,email',
            'role' => 'required|string|exists:roles,name',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->route('admins.index')->with('error', 'User not found.');
        }
        $role = Role::where('name', $request->role)->first();
        if (!$role) {
            return redirect()->route('admins.index')->with('error', 'Role not found.');
        }
        if ($user->hasRole($role)) {
            return redirect()->route('admins.index')->with('error', 'User already has the role.');
        }
        $user->assignRole($role);
        return redirect()->route('admins.index')->with('success', 'Role assigned successfully');
    }



    public function store(Request $request)
    {

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

    }
    public function destroy($id)
    {
        if (Gate::denies('users.destroy')) {
            return back()->with('error', 'You do not have permission to delete users.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

}
