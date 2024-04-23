<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        $permissions = Permission::get();
        return view('permission.index', [
            'permissions' => $permissions,
            'image' => $image
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        return view('permission.create', compact('user', 'image'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // dd($request->all());

    $request->validate([
        'name' => 'required|string|unique:permissions,name'
    ]);

    try {
        Permission::create([
            'name' => $request->name
        ]);

        return redirect('permissions')->with('success', 'Permission created successfully');
    } catch (\Exception $e) {
        \Log::error('Error creating permission: ' . $e->getMessage());

        return redirect()->back()->with('error', 'An error occurred while creating the permission. Please try again.');
    }
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
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        $permission = Permission::findOrFail($id);

        return view('permission.edit', [
            'permission' => $permission,
            'image' => $image
        ]);
    /**
     * Update the specified resource in storage.
     */
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $id
        ]);

        try {
            $permission = Permission::findOrFail($id);

            $permission->update([
                'name' => $request->name
            ]);

            return redirect('permissions')->with('success', 'Permission updated successfully');
        } catch (\Exception $e) {
            \Log::error('Error updating permission: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating the permission. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Gate::denies('permissions.destroy')) {
            return back()->with('error', 'You do not have permission to delete Permissions.');
        }
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();

            return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Error deleting permission: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the permission. Please try again.');
        }
    }
}
