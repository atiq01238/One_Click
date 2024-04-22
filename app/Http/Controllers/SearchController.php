<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $tasks = Task::where('task_name', 'like', "%$query%")->get();
        $projects = Project::where('project_name', 'like', "%$query%")->get();

        return view('welcome', compact('tasks', 'projects'));
    }
}
