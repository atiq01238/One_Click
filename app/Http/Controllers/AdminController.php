<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index()
    {
        $users = User::whereHas('roles')->get();

        $roles = Role::pluck('name', 'id');

        return View::make('admin.index', compact('users', 'roles'));
    }

    public function destroy(string $userId)
    {
        if (Gate::denies('admins.destroy')) {
            return back()->with('error', 'You do not have permission to delete Admins.');
        }
        $user = User::findOrFail($userId);

        $user->roles()->detach();

        return redirect()->back()->with('success', 'Roles have been removed from the user successfully.');
    }
}
