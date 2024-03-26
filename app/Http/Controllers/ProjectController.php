<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all(); // Fetch all users from the database
        return view('project.index', compact('projects')); // Pass the users data to the view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // Fetch all users
        return view('project.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'assign_user' => 'required|exists:users,id',
            'attachment' => 'nullable|image|mimes:jpeg,png,gif|max:2048', // Adjust MIME types as needed
        ]);

        try {
            // Format the date for start_date and end_date fields
            $startDate = Carbon::createFromFormat('d F Y', $request->input('start_date'))->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d F Y', $request->input('end_date'))->format('Y-m-d');
        } catch (\Exception $e) {
            // If the date format is incorrect, return validation error
            throw ValidationException::withMessages([
                'start_date' => 'Invalid start date format. Please use the format "d F Y".',
                'end_date' => 'Invalid end date format. Please use the format "d F Y".',
            ]);
        }

        // Store the user data in the database
        $user = new Project();
        $user->project_name = $request->input('project_name');
        $user->description = $request->input('description');
        $user->start_date = $startDate;
        $user->end_date = $endDate;
        $user->assign_user = $request->input('assign_user');

        // Handle file upload if attachment is provided
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public'); // Store the attachment file in the public disk
            $user->attachment = $attachmentPath;
        } elseif ($request->filled('attachment')) {
            // Handle non-file input for attachment (e.g., image URL)
            $user->attachment = $request->input('attachment');
        }

        $user->save(); // Save the user data to the database

        return redirect('projects')->with('success', 'User created successfully'); // Redirect back with success message
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
    public function edit(Project $project)
    {
        $users = User::all(); // Fetch all users
        return view('project.edit', compact('project', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
{
    // Validate the incoming request data
    $request->validate([
        'project_name' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'assign_user' => 'required|exists:users,id',
        'attachment' => 'nullable|image|mimes:jpeg,png,gif|max:2048', // Adjust MIME types as needed
    ]);

    try {
        // Format the date for start_date and end_date fields
        $startDate = Carbon::createFromFormat('d F Y', $request->input('start_date'))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d F Y', $request->input('end_date'))->format('Y-m-d');
    } catch (\Exception $e) {
        // If the date format is incorrect, return validation error
        throw ValidationException::withMessages([
            'start_date' => 'Invalid start date format. Please use the format "d F Y".',
            'end_date' => 'Invalid end date format. Please use the format "d F Y".',
        ]);
    }

    // Update the project data in the database
    $project->update([
        'project_name' => $request->input('project_name'),
        'description' => $request->input('description'),
        'start_date' => $startDate,
        'end_date' => $endDate,
        'assign_user' => $request->input('assign_user'),
    ]);

    // Handle file upload if attachment is provided
    if ($request->hasFile('attachment')) {
        $attachmentPath = $request->file('attachment')->store('attachments', 'public'); // Store the attachment file in the public disk
        $project->update(['attachment' => $attachmentPath]);
    } elseif ($request->filled('attachment')) {
        // Handle non-file input for attachment (e.g., image URL)
        $project->update(['attachment' => $request->input('attachment')]);
    }

    return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Delete the project
        $project->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Project deleted successfully.');
    }
}
