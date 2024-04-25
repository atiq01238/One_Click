<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        $query = $request->input('query');

        $tasks = Task::where('task_name', 'like', "%$query%")->get();
        $projects = Project::where('project_name', 'like', "%$query%")->get();

        $route = Route::currentRouteName();
        switch ($route) {
            case 'project.index':
                return view('project.index', compact('projects', 'image'));
            case 'user.index':
                return view('user.index', compact('user', 'image'));
            // Add more cases for other routes if needed
            default:
                return view('welcome', compact('tasks', 'projects', 'image'));
        }
    }
}
