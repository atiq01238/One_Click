@extends('layout.master')
{{-- @include('project.bootstrap') --}}
@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Task
                                <a href="{{ url('tasks/create') }}" class="btn btn-primary" style="float: right;">Assign Task</a>
                            </h4>
                        </div>
                        @include('validate.message')
                        <div class="container mt-5">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>To Do</th>
                                        <th>In Progress</th>
                                        <th>Done</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="">
                                            @foreach($projects as $project)
                                            <div class="card mb-3" style="width: 18rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $project->project_name }}</h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary">Start Date: {{ $project->start_date }}</h6>
                                                    <p class="card-text">{{ $project->description }}</p>
                                                    {{-- Add more project details as needed --}}
                                                    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary">View Project</a>
                                                </div>
                                            </div>
                                            @endforeach
                                        </td>
                                        <td class="">
                                                @foreach($tasks as $task)
                                                    <div class="card mb-3" style="width: 18rem;">
                                                        <div class="card-body">
                                                            <h6 class="card-title">Project Name: {{ $task->project ? $task->project->project_name : 'No Project' }}</h6>
                                                            <p class="card-text">{{ $task->task_name }}</p>
                                                            <p class="card-text">End Date: {{ $task->end_date }}</p>
                                                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary">View Task</a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                        </td>
                                        <td class="">
                                            <div class="card" style="width: 18rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Card title</h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                                        of the card's content.</p>
                                                    <a href="#" class="card-link">Card link</a>
                                                    <a href="#" class="card-link">Another link</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

