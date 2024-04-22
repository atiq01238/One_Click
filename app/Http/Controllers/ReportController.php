<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\ReportedTask;
use App\Models\Project;
use App\Notifications\TaskReportedNotification;
use Illuminate\Support\Facades\Validator;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = ReportedTask::all();
        return view("report.index", compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_id = auth()->user()->id;

        return view("report.create", compact('user_id'));    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_name' => 'required',
            'task_name' => 'required',
            'detail' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $report = new ReportedTask();
        $report->project_name = $request->input('project_name');
        $report->task_name = $request->input('task_name');
        $report->detail = $request->input('detail');
        $report->save();

        $user = Project::find($request->input('creator_id'));
        $user->notify(new TaskReportedNotification($report));

        return redirect()->back()->with('success', 'Task reported successfully!');
    }

}
