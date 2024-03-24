<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:delete role', ['only' => ['destroy']]);
    //     $this->middleware('permission:update role', ['only' => ['update', 'edit']]);

    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::get();
        return view('permission.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // dd($request->all());

    //Validate the incoming request data
    $request->validate([
        'name' => 'required|string|unique:permissions,name'
    ]);

    try {
        // Attempt to create a new permission record
        Permission::create([
            'name' => $request->name
        ]);

        // Redirect back to permissions index with success message
        return redirect('permissions')->with('success', 'Permission created successfully');
    } catch (\Exception $e) {
        // Log the error for further investigation
        \Log::error('Error creating permission: ' . $e->getMessage());

        // Redirect back to the form with an error message
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

        $permission = Permission::findOrFail($id);

        return view('permission.edit', [
            'permission' => $permission
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
            // Find the permission by its ID
            $permission = Permission::findOrFail($id);

            // Update the permission record
            $permission->update([
                'name' => $request->name
            ]);

            // Redirect back to permissions index with success message
            return redirect('permissions')->with('success', 'Permission updated successfully');
        } catch (\Exception $e) {
            // Log the error for further investigation
            \Log::error('Error updating permission: ' . $e->getMessage());

            // Redirect back to the form with an error message
            return redirect()->back()->with('error', 'An error occurred while updating the permission. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
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
