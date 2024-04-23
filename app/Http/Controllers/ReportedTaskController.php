<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\ReportedTask;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskReportedNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class ReportedTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        if (auth()->user()->can('viewAny', ReportedTask::class)) {
            $reports = ReportedTask::all();
        } else {
            $reports = ReportedTask::where('creator_id', auth()->id())->get();
        }

        return view("report.index", compact('reports','image'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        $user_id = auth()->user()->id;
        $taskName = $request->query('task_name');
        // $projectName = $request->query('project_name');
        $task = Task::where('user_id', $user_id)->where('task_name', $taskName)->first();
        // $project = Project::where('user_id', $user_id)->where('project_name', $projectName)->first();
        return view("report.create", compact('user_id', 'task', 'image'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_name' => 'required',
            'task_name' => 'required',
            'detail' => 'required',
            // 'creator_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $report = new ReportedTask();
        $report->project_name = $request->input('project_name');
        $report->task_name = $request->input('task_name');
        $report->detail = $request->input('detail');
        $report->creator_id =  auth()->user()->id;
        $report->save();

        $task = Task::where('task_name', $request->input('task_name'))->first();
        // dd($task);
        $task->notify(new TaskReportedNotification($report));

        return redirect()->back()->with('success', 'Task reported successfully!');
    }

}
