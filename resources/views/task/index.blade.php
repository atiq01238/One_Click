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
                                <a href="{{ url('tasks/create') }}" class="btn btn-primary" style="float: right;"
                                    id="assignTaskBtn">Assign Task</a>
                            </h4>
                        </div>
                        @include('validate.message')
                        <div class="container mt-5">
                            <div class="modal fade" id="assignTaskModal" tabindex="-1" role="dialog"
                                aria-labelledby="assignTaskModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="assignTaskModalLabel">Assign Task</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Task creation form will be loaded here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
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
                                                <div
                                                    style="max-height: 600px; overflow-y: auto; /* hide scrollbar */ -ms-overflow-style: none; /* IE and Edge */ scrollbar-width: none;">
                                                    @foreach ($projects as $project)
                                                        <div class="card mb-3" style="width: 18rem;">
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $project->project_name }}</h5><br>
                                                                <p class="card-subtitle mb-2 text-body-secondary">Start
                                                                    Date:
                                                                    {{ $project->start_date }}</p><br>
                                                                <p class="card-subtitle mb-2 text-body-secondary">End
                                                                    Date:
                                                                    {{ $project->end_date }}</p>
                                                                {{-- <p class="card-text">{{ $project->description }}</p> --}}
                                                                {{-- Add more project details as needed --}}
                                                                {{-- <a href="{{ route('projects.show', $project->id) }}"
                                                                    class="btn btn-primary">View Project</a> --}}
                                                                <a href="{{ route('projects.show', $project->id) }}"
                                                                    type="button" class="btn btn-info" data-toggle="modal"
                                                                    data-target="#backlogModalProject-{{ $project->id }}">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>


                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="">
                                                <div
                                                    style="max-height: 600px; overflow-y: auto; -ms-overflow-style: none; scrollbar-width: none;">
                                                    @foreach ($tasks as $task)
                                                        @if ($task->status === 'in_progress')
                                                            <div class="card mb-3" style="width: 18rem;">
                                                                <div class="card-body">
                                                                    <h6 class="card-title">Project Name:
                                                                        {{ $task->project ? $task->project->project_name : 'No Project' }}
                                                                    </h6>
                                                                    <p class="card-text">{{ $task->task_name }}</p>
                                                                    <p class="card-text">Start Date: {{ $task->start_date }}
                                                                    </p>
                                                                    <a href="#" type="button" class="btn btn-info"
                                                                        data-toggle="modal"
                                                                        data-target="#backlogModal-{{ $task->id }}"><i
                                                                            class="fas fa-eye"></i></a>
                                                                    <a href="{{ route('tasks.edit', $task->id) }}"
                                                                        class="btn btn-primary"><i
                                                                            class="fas fa-edit"></i></a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                            <!-- Tasks -->
                                            <td class="">
                                                <div class="card" style="width: 18rem;">
                                                    <div class="card-body">
                                                        @foreach ($tasks as $task)
                                                            @if ($task->status === 'done')
                                                                <h5 class="card-title">{{ $task->task_name }}</h5>
                                                                <h6 class="card-subtitle mb-2 text-body-secondary">Project
                                                                    Name:
                                                                    {{ $task->project ? $task->project->project_name : 'No Project' }}
                                                                </h6>
                                                                <p class="card-text">Start Date: {{ $task->start_date }}
                                                                </p>


                                                            @endif
                                                        @endforeach
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
        </div>
    </section>
@endsection


@foreach ($tasks as $task)
    <div class="modal fade" id="backlogModal-{{ $task->id }}" role="dialog" aria-labelledby="backModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="backlogModalLabel">Task Name : {{ $task->task_name }}</h5>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Project Name</strong>
                        {{ $task->project ? $task->project->project_name : 'No Project' }}</p>
                    <p class="mb-2"><strong>Description:</strong> {{ $task->description }}</p>
                    <p class="mb-2"><strong>Start Date:</strong> {{ $task->start_date }}</p>
                    <p class="mb-2"><strong>End Date:</strong> {{ $task->end_date }}</p>
                    {{-- <p class="mb-0"><strong>Assigned User:</strong> {{ $task->user->first_name }} {{ $task->user->last_name }}</p> --}}
                    @if ($task->attachment)
                        <strong>Attachment:</strong><br>
                        <img src="{{ asset('storage/' . $task->attachment) }}" alt="Project Image" height="100px"
                            width="100px">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach
@foreach ($projects as $project)
    <div class="modal fade" id="backlogModalProject-{{ $project->id }}" role="dialog"
        aria-labelledby="backModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="backlogModalLabel">Project Details</h5>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>{{ $project->project_name }}</h5>
                    <p>Description: {{ $project->description }}</p>
                    <p>Start Date: {{ $project->start_date }}</p>
                    <p>End Date: {{ $project->end_date }}</p>
                    <p>Assign User: {{ $project->user->email }}</p>
                    {{-- <p>Attachment {{ $project->attachment }}</p> --}}
                    @if ($project->attachment)
                        <strong>Attachment:</strong><br>
                        <img src="{{ asset('storage/' . $project->attachment) }}" alt="Project Image" height="100px"
                            width="100px">
                    @else
                        <p>No image available</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endforeach
