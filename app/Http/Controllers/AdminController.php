<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:user.destroy')->only(['destroy']);
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereHas('roles')->get();

        $roles = Role::pluck('name', 'id');

        return View::make('admin.index', compact('users', 'roles'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $userId)
    {
        $user = User::findOrFail($userId);

        $user->roles()->detach();

        return redirect()->back()->with('success', 'Roles have been removed from the user successfully.');
    }
}
