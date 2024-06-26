<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserFakeMail;
use Illuminate\Support\Facades\Hash;
use App\Models\Invite;
use App\Models\Project;
use App\Models\ReportedTask;
use App\Models\Task;
use App\Models\Profile;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function dashboard()
    {
        $user = auth()->user();
        $task = Task::where("id", $user->id)->first();
        // dd($report);
        $projectsQuery = Project::query();
        $tasksQuery = Task::query();
        $profile = $user->profile;
        $image = $profile->image ?? '';

        $projectsQuery->when($user->can('access-all-assigned-projects'), function ($query) {
            return $query->with('tasks');
        }, function ($query) use ($user) {
            return $query->whereIn('id', $user->projects()->pluck('id'));
        });

        $tasksQuery->when($user->can('access-all-assigned-tasks'), function ($query) {
            return $query;
        }, function ($query) use ($user) {
            return $query->whereIn('id', $user->tasks()->pluck('id'));
        });
        $projects = $projectsQuery->get();
        $tasks = $tasksQuery->get();

        return view('welcome', compact('projects', 'tasks', 'image'));
    }



    public function index()
    {
        return view('auth.login');

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect('login')->with('success', 'Registration successful. You can now log in.');
    }


    /**
     * Display the specified resource.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        $invite = Invite::where('email', $email)->first();

        if ($user && $invite && Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->intended('/');
        }

        return redirect()->back()->withInput()->withErrors(['login' => 'Invalid email or password.']);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }


}
