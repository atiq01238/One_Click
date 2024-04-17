@extends('layout.master')
@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <div class="row">

            @php
                $userCount = App\Models\User::count();
            @endphp

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Registered Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $projectCount = App\Models\Project::count();
            @endphp

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Projects Created</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $projectCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @php
                $taskCount = App\Models\Task::count();
            @endphp

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Task Created</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $taskCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $doneTasksCount = \App\Models\Task::where('status', 'done')->count();
            @endphp
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Number of tasks done</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $doneTasksCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- @auth --}}
            {{-- @if(auth()->user()->roles->isNotEmpty()) --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Assigned Projects</h4>
                            </div>
                            <div class="card-body">
                                <ul style="list-style-type: none; padding: 0;">
                                    @foreach ($projects as $project)
                                        <li style="margin-bottom: 15px;">
                                            <a href="{{ route('projects.show', $project->id) }}"
                                            style="display: block; background: rgb(190, 188, 188); padding: 12px; color: white; text-decoration: none; cursor: pointer;
                                                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: background-color 0.3s, box-shadow 0.3s;"
                                            onmouseover="this.style.backgroundColor='#555'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.3)';"
                                            onmouseout="this.style.backgroundColor='rgb(190, 188, 188)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.1)';">
                                                {{ $project->project_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- @endif --}}
        {{-- @endauth --}}


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Assigned Tasks</h4>
                    </div>
                    <div class="card-body">
                        <ul>
                            @foreach ($tasks as $task)
                                <a href="{{ route('tasks.show', $task->id) }}"
                                    style="display: block; background: rgb(190, 188, 188); padding: 8px; color: white; text-decoration: none; cursor: pointer;
                                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: background-color 0.3s, box-shadow 0.3s;"
                                    onmouseover="this.style.backgroundColor='#555'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.3)';"
                                    onmouseout="this.style.backgroundColor='rgb(190, 188, 188)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.1)';">
                                    {{ $task->task_name }}</a><br>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>



        {{-- @foreach ($projects as $project)
        <a href="{{ route('projects.show', $project->id) }}"  style=" box-shadow: 0 4px 8px rgba(201, 9, 9, 0.1)">{{ $project->project_name }}</a><br>
    @endforeach --}}




    </div>
    <!-- /.container-fluid -->

    {{-- </div> --}}
@endsection
