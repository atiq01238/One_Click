@extends('layout.master')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
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

            <!-- Earnings (Monthly) Card Example -->
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


            <!-- Earnings (Monthly) Card Example -->
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


            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Requests</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row" style="display: flex, flex-direction: row" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Assigned Projects</h4>
                    </div>
                    <div class="card-body">
                        <ul>
                            @foreach ($projects as $project)
                                <li>{{ $project->project_name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Assigned Tasks</h4>
                    </div>
                    <div class="card-body">
                        <ul>
                            @foreach ($tasks as $task)
                                <li><a href="{{ route('tasks.show', $task->id) }}" >{{ $task->task_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- <li><a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary">click</a></li> --}}








    </div>
    <!-- /.container-fluid -->

    {{-- </div> --}}
@endsection
