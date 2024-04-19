@extends('layout.master')
{{-- @include('project.bootstrap') --}}
@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Tasks
                                <a href="{{ url('tasks/create') }}" class="btn btn-primary" style="float: right;"
                                    id="assignTaskBtn">Assign Task</a>
                            </h4>
                        </div>
                        <div>
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
                                    </div>
                                </div>
                            </div>
                            <div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>To Do
                                                {{-- <button type="submit" style="border: none; background-color: none; float: right;"><ion-icon name="close-outline"></ion-icon></button> --}}

                                            </th>
                                            <th>In Progress</th>
                                            <th>Done</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div style="max-height: 600px; overflow-y: auto; -ms-overflow-style: none; scrollbar-width: none;">
                                                    @foreach ($projects as $project)
                                                        <div class="card mb-3" style="width: 18rem; background-color: #f8f9fa; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                                            <div class="card-body">
                                                                <h6 class="card-title">Project Name: {{ $project->project_name }}</h6>
                                                                <p></p>
                                                                <p class="card-subtitle mb-2 text-body-secondary">Start Date:
                                                                    {{ $project->start_date }}</p>
                                                                    <p></p>
                                                                <p class="card-subtitle mb-2 text-body-secondary">End Date:
                                                                    {{ $project->end_date }}</p>
                                                                <div class="" style="float: right">
                                                                    <a href="{{ route('projects.show', $project->id) }}" type="button"
                                                                    class="btn btn-info" data-toggle="modal"
                                                                    data-target="#backlogModalProject-{{ $project->id }}">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td >
                                                <div style="max-height: 600px; overflow-y: auto; -ms-overflow-style: none; scrollbar-width: none;">
                                                    @foreach ($tasks as $task)
                                                        @if ($task->status === 'in_progress')
                                                            <div class="card mb-3" style="width: 18rem; background-color: #f8f9fa; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                                                <div class="card-body">
                                                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="float: right">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" style="border: none; background-color: none"><ion-icon name="close-outline"></ion-icon></button>
                                                                    </form>
                                                                    <h6 class="card-title">Task Name: {{ $task->task_name }}</h6>
                                                                    <p class="card-text">Start Date: {{ $task->start_date }}</p>
                                                                    {{-- <p class="card-text">{{ calculateHours($task->start_date) }}</p></p> --}}
                                                                    <button type="button" class="btn btn-secondary rounded-pill text-nowrap d-flex justify-content-center align-items-center" style="width: 90px; height: 30px; float: left; pointer-events: none;">In Progress</button>
                                                                    <div class="" style="float: right">
                                                                        <a href="#" type="button" class="btn btn-info" data-toggle="modal"
                                                                        data-target="#backlogModal-{{ $task->id }}"><i class="fas fa-eye"></i></a>
                                                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary"><i
                                                                            class="fas fa-edit"></i></a>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                            {{-- @php
                                            function calculateHours($start_date) {
                                                $start_timestamp = strtotime($start_date);
                                                $current_timestamp = time();
                                                $hours_difference = ($current_timestamp - $start_timestamp) / (60 * 60);
                                                return round($hours_difference, 2); // Round to 2 decimal places
                                            }
                                            @endphp --}}
                                            <td>
                                                <div style="max-height: 600px; overflow-y: auto; -ms-overflow-style: none; scrollbar-width: none;">
                                                    @foreach ($tasks as $task)
                                                        @if ($task->status === 'done')
                                                            <div class="card mb-3" style="width: 18rem; background-color: #f8f9fa; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                                                                <div class="card-body">
                                                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="float: right">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" style="border: none; background-color: none"><ion-icon name="close-outline"></ion-icon></button>
                                                                    </form>
                                                                    <h6 class="card-title">Task Name: {{ $task->task_name }}</h6>
                                                                    <p></p>
                                                                    <h6 class="card-subtitle mb-2 text-body-secondary">Project Name:
                                                                        {{ $task->project ? $task->project->project_name : 'No Project' }}
                                                                    </h6>
                                                                    <p class="card-text">End Date: {{ $task->end_date }}</p>
                                                                    <button type="button" class="btn btn-success rounded-pill text-nowrap d-flex justify-content-center align-items-center" style="width: 90px; height: 30px; float: left; pointer-events: none;">Done</button>

                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
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
                    <div>
                        <h4 class="mb-0">Task Name : {{ $task->task_name }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="project_name">Project Name</label>
                        <input type="text" class="form-control" id="project_name" name="project_name"
                            value="{{ $task->project ? $task->project->project_name : 'No Project' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="user_id">Assign User</label>
                        <input type="text" class="form-control" id="user_id" name="user_id"
                            value="{{ $task->user ? $task->user->email : 'No User Assigned' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" readonly>{{ $task->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ $task->start_date }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ $task->end_date }}" readonly>
                    </div>
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
                    <h5 class="modal-title" id="backlogModalLabel">Project Name : {{ $project->project_name }}</h5>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_id">Assign User</label>
                        <input type="text" class="form-control" id="user_id" name="user_id"
                            value="{{ $project->user ? $project->user->email : 'No User Assigned' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="description">Project Description</label>
                        <input type="text" class="form-control" id="project_name" name="project_name"
                            value="{{ $project->description}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="text" class="form-control" id="start_date" name="start_date"
                            value="{{ $project->start_date}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="text" class="form-control" id="end_date" name="end_date"
                            value="{{ $project->end_date}}" readonly>
                    </div>
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
