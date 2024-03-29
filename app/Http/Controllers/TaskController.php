<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('project')->get();
        $projects = Project::all();

        return view('task.index', compact('projects', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all users
        $projects = Project::all();
        $users = User::all();

        return view("task.create", compact('users', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'task_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'required|exists:users,id',
            'attachment' => 'nullable|image|mimes:jpeg,png,gif|max:2048',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Parse dates using Carbon
        $startDate = Carbon::createFromFormat('d F Y', $request->input('start_date'))->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d F Y', $request->input('end_date'))->format('Y-m-d');

        // Create a new Task instance
        $task = new Task();
        $task->project_id = $request->input('project_id');
        $task->task_name = $request->input('task_name');
        $task->start_date = $startDate;
        $task->end_date = $endDate;
        $task->user_id = $request->input('user_id');
        $task->creator_id = auth()->user()->id;

        // Handle attachment upload
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            $task->attachment = $attachmentPath;
        }

        // Save the task
        $task->save();

        // Redirect with success message
        return redirect()->back()->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);

        return view('task.show', compact('task'));
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
    public function destroy(string $id)
    {
        //
    }
}
