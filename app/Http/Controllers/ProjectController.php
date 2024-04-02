<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function __construct()
    // {
    //     $this->middleware('permission:create-project')->only(['store']);
    // }

    public function index()
    {


        if (Auth::user()->can('view-all-projects')) {
            $projects = Project::all();
        } else {
            $projects = Project::where('creator_id', Auth::user()->id)->get();
        }

        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('project.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'attachment' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
        ]);

        try {
            $startDate = Carbon::createFromFormat('d F Y', $request->input('start_date'))->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d F Y', $request->input('end_date'))->format('Y-m-d');
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'start_date' => 'Invalid start date format. Please use the format "d F Y".',
                'end_date' => 'Invalid end date format. Please use the format "d F Y".',
            ]);
        }

        $project = new Project();
        $project->project_name = $request->input('project_name');
        $project->description = $request->input('description');
        $project->start_date = $startDate;
        $project->end_date = $endDate;
        $project->user_id = $request->input('user_id');
        $project->creator_id = Auth::id();

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            $project->attachment = $attachmentPath;
        }

        $project->save();

        return redirect('projects')->with('success', 'Project created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('project.show', compact('project'));
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
    // ProjectController.php

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date_format:d F Y',
            'end_date' => 'required|date_format:d F Y',
            'user_id' => 'required|exists:users,id',
            'attachment' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
        ]);

        try {
            $startDate = Carbon::createFromFormat('d F Y', $request->input('start_date'))->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d F Y', $request->input('end_date'))->format('Y-m-d');
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'start_date' => 'Invalid start date format. Please use the format "d F Y".',
                'end_date' => 'Invalid end date format. Please use the format "d F Y".',
            ]);
        }

        $project->project_name = $request->input('project_name');
        $project->description = $request->input('description');
        $project->start_date = $startDate;
        $project->end_date = $endDate;
        $project->user_id = $request->input('user_id');

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public'); // Store the attachment file in the public disk
            $project->attachment = $attachmentPath;
        } elseif ($request->filled('attachment')) {
            $project->attachment = $request->input('attachment');
        }

        $project->save();

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->back()->with('success', 'Project deleted successfully.');
    }
}
