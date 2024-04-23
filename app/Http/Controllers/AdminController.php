<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        $users = User::whereHas('roles')->get();

        $roles = Role::pluck('name', 'id');

        return View::make('admin.index', compact('users', 'roles','image'));
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
