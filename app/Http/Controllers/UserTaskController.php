<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Task;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $tasks = $user->tasks;

        return view("usertask.index", compact('tasks'));
    }
    /**
     * Show the form for creating a new resource.
     */
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



}
