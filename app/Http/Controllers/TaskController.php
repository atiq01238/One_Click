<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use App\Notifications\TaskAssignedNotification;
use App\Notifications\TaskUpdatedNotification;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
        $this->middleware('auth');
    }
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(['todo', 'in_progress', 'done'])],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $task = Task::findOrFail($id);
        $task->status = $request->input('status');
        $task->save();

        $doneTasksCount = Task::where('status', 'done')->count();

        return redirect()->back()->with('success', 'Task status updated successfully.')->with('doneTasksCount', $doneTasksCount);
    }


   public function index()
{
    $user = Auth::user();
    $profile = $user->profile;
    $image = $profile->image ?? '';

    if (Auth::user()->can('view-all-projects') && Auth::user()->can('view-all-tasks')) {
        $projects = Project::all();
        $tasks = Task::all();
    } else {
        $projects = Project::where('creator_id', Auth::user()->id)->get();
        $tasks = Task::where('creator_id', Auth::user()->id)->get();
    }

    return view('task.index', compact('projects', 'tasks', 'image'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        $projects = Project::all();
        $users = User::all();

        return view("task.create", compact('users', 'projects','image'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'task_name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'required|exists:users,id',
            'status' => ['required', Rule::in(['todo', 'in_progress', 'done'])],
            'attachment' => 'nullable|image|file|max:8048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $startDate = Carbon::createFromFormat('d F Y', $request->input('start_date'))->format('Y-m-d');
            $endDate = Carbon::createFromFormat('d F Y', $request->input('end_date'))->format('Y-m-d');
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'start_date' => 'Invalid start date format. Please use the format "d F Y".',
                'end_date' => 'Invalid end date format. Please use the format "d F Y".',
            ]);
        }
        $task = new Task();
        $task->project_id = $request->input('project_id');
        $task->task_name = $request->input('task_name');
        $task->description = $request->input('description');
        $task->start_date = $startDate;
        $task->end_date = $endDate;
        $task->user_id = $request->input('user_id');
        $task->status = $request->input('status');
        $task->creator_id = auth()->user()->id;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            $task->attachment = $attachmentPath;
        }
        $task->save();
        $user = User::find($request->input('user_id'));
        $user->notify(new TaskAssignedNotification($task));

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        $task = Task::findOrFail($id);

        return view('task.show', compact('task','image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        $task = Task::findOrFail($id);
        $projects = Project::all();
        $users = User::all();

        return view('task.edit', compact('task', 'projects', 'users','image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'task_name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date_format:d F Y',
            'end_date' => 'required|date_format:d F Y|after_or_equal:start_date',
            'user_id' => 'required|exists:users,id',
            'status' => ['required', Rule::in(['todo', 'in_progress', 'done'])],
            'attachment' => 'nullable|image|file|max:8048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $startDate = Carbon::createFromFormat('d F Y', $request->input('start_date'))->toDateString();
            $endDate = Carbon::createFromFormat('d F Y', $request->input('end_date'))->toDateString();
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'start_date' => 'Invalid start date format. Please use the format "d F Y".',
                'end_date' => 'Invalid end date format. Please use the format "d F Y".',
            ]);
        }

        $task = Task::findOrFail($id);
        $task->project_id = $request->input('project_id');
        $task->task_name = $request->input('task_name');
        $task->description = $request->input('description');
        $task->start_date = $startDate;
        $task->end_date = $endDate;
        $task->user_id = $request->input('user_id');
        $task->status = $request->input('status');

        if ($request->hasFile('attachment')) {
            $attachmentValidator = Validator::make($request->all(), [
                'attachment' => 'image|mimes:jpeg,png,gif|max:2048',
            ]);
            if ($attachmentValidator->fails()) {
                return redirect()->back()->withErrors($attachmentValidator)->withInput();
            }
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
            $task->attachment = $attachmentPath;
        }

        $task->save();

        $user = User::find($request->input('user_id'));
        $user->notify(new TaskUpdatedNotification($task));

        return redirect()->back()->with('success', 'Task updated successfully.');
    }


    public function destroy($id)
    {
        if (Gate::denies('tasks.destroy')) {
            return back()->with('error', 'You do not have permission to delete Tasks.');
        }
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}
