<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    //  public function __construct()
    // {
    //     $this->middleware('permission:delete role', ['only' => ['destroy']]);
    //     $this->middleware('permission:update role', ['only' => ['update', 'edit']]);

    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::get();
        return view('role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name' // Change 'role' to 'roles'
        ]);
        // dd($request->all());

        try {
            // Attempt to create a new permission record
            Role::create([
                'name' => $request->name
            ]);

            // Redirect back to role index with success message
            return redirect('roles')->with('success', 'Role created successfully');
        } catch (\Exception $e) {
            // Log the error for further investigation
            \Log::error('Error creating role: ' . $e->getMessage());

            // Redirect back to the form with an error message
            return redirect()->back()->with('error', 'An error occurred while creating the role. Please try again.');
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
        $role = Role::findOrFail($id);

        return view('role.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id
        ]);

        try {
            // Find the permission by its ID
            $role = Role::findOrFail($id);

            // Update the role record
            $role->update([
                'name' => $request->name
            ]);

            // Redirect back to roles index with success message
            return redirect('roles')->with('success', 'Role updated successfully');
        } catch (\Exception $e) {
            // Log the error for further investigation
            \Log::error('Error updating role: ' . $e->getMessage());

            // Redirect back to the form with an error message
            return redirect()->back()->with('error', 'An error occurred while updating the role. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Error deleting role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the role. Please try again.');
        }
    }
    public function addPermissiontoRole($roleid)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($roleid);
        return view('role.add-permission', [
            'role' => $role,
            'permissions' => $permissions
        ]);

    }
    public function givePermissiontoRole(Request $request, $roleid)
    {
        $request->validate([
            'permission' => 'required'
        ]);
        $role = Role::findorfail($roleid);
        $role->syncPermissions($request->permission);
        return redirect()->back()->with('success', 'Permission Added to Role Successfully');
    }
}
