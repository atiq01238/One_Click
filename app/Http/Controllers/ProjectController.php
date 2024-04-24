<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Gate;
use App\Notifications\ProjectAssignedNotification;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function __construct()
    // {
    //     $this->middleware('permission:create-project')->only(['store']);
    // }

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        if (Auth::user()->can('view-all-projects')) {
            $projects = Project::all();
        } else {
            $projects = Project::where('creator_id', Auth::user()->id)->get();
        }

        return view('project.index', compact('projects', 'image'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        $users = User::all();
        return view('project.create', compact('users','image'));
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
            'attachment' => 'nullable|file|max:9048',
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
        $user = User::find($request->input('user_id'));
        $user->notify(new ProjectAssignedNotification($project));

        return redirect('projects')->with('success', 'Project created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        $project = Project::findOrFail($id);
        return view('project.show', compact('project','image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        $users = User::all();
        return view('project.edit', compact('project', 'users', 'image'));
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
            'attachment' => 'nullable|image|file|max:9048',
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
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            $project->attachment = $attachmentPath;
        } elseif ($request->filled('attachment')) {
            $project->attachment = $request->input('attachment');
        }

        $project->save();
        $user = User::find($request->input('user_id'));
        $user->notify(new ProjectAssignedNotification($project));

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if (Gate::denies('projects.destroy')) {
            return back()->with('error', 'You do not have permission to delete Projects.');
        }
        $project->delete();
        return redirect()->back()->with('success', 'Project deleted successfully.');
    }
}
