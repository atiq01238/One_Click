<!-- resources/views/projects/show.blade.php -->
@extends('layout.master')

@section('content')

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Task Details : {{ $task->task_name }}</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="mb-2"><strong>Project Name</strong> {{ $task->project ? $task->project->project_name : 'No Project' }}</p>
                        <p class="mb-2"><strong>Description:</strong> {{ $task->description }}</p>
                        <p class="mb-2"><strong>Start Date:</strong> {{ $task->start_date }}</p>
                        <p class="mb-2"><strong>End Date:</strong> {{ $task->end_date }}</p>
                        @if ($task->attachment)
                            <strong>Attachment:</strong><br>
                            <img src="{{ asset('storage/' . $task->attachment) }}" alt="Project Image" height="100px"
                                width="100px">
                        @else
                            <p>No image available</p>
                        @endif

                        <!-- Form for updating task status -->
                        <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="todo" {{ $task->status === 'tode' ? 'selected' : '' }}>ToDo</option>
                                    <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
