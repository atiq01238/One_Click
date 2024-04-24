<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\ReportedTask;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\ReportedTaskNotification;
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
        if (auth()->user()->can('view_all_report', ReportedTask::class)) {
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
        $task = Task::where('user_id', $user_id)->where('task_name', $taskName)->first();

        if ($task) {
            $project = $task->project;
        } else {
            $project = null;
        }

        return view("report.create", compact('user_id', 'task', 'project', 'image'));
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $report = new ReportedTask();
        $report->project_name = $request->input('project_name');
        $report->task_name = $request->input('task_name');
        $report->detail = $request->input('detail');
        $report->creator_id = auth()->user()->id;
        $report->save();

        $task = Task::where('task_name', $request->input('task_name'))->first();
        $creator_id = $task->creator_id;
        $user = User::find($creator_id);
        $user->notify(new ReportedTaskNotification($report));

        return redirect()->back()->with('success', 'Task reported successfully!');
    }

    public function destroy($id)
    {
        $report = ReportedTask::findOrFail($id);
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }
}
