<!-- resources/views/projects/show.blade.php -->
@extends('layout.master')

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header bg-info text-white">
                                <h4 class="mb-0">Task Details : {{ $task->task_name }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="project_name">Project Name</label>
                                <input type="text" class="form-control" id="project_name" name="project_name"
                                    value="{{ $task->project ? $task->project->project_name : 'No Project' }}" readonly>
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
                            <div class="form-group">
                                <label for="attachment">Attachment</label><br>
                                @if ($task->attachment)
                                    <a href="{{ asset('storage/' . $task->attachment) }}" download>Download Attachment</a>
                                @else
                                    <p>No attachment available</p>
                                @endif
                            </div>
                            <div>
                                    <a href="{{ url('reports/create') }}" class="btn btn-secondary" style="float: left;" id="assignTaskBtn">Report Task</a>
                            </div>
                            <form id="statusForm" action="{{ route('tasks.updateStatus', $task->id) }}" method="POST" style="float: right">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-outline-primary {{ $task->status === 'todo' ? 'active' : '' }}">
                                            <input type="radio" name="status" id="todo" value="todo" {{ $task->status === 'todo' ? 'checked' : '' }}> ToDo
                                        </label>
                                        <label class="btn btn-outline-warning {{ $task->status === 'in_progress' ? 'active' : '' }}">
                                            <input type="radio" name="status" id="in_progress" value="in_progress" {{ $task->status === 'in_progress' ? 'checked' : '' }}> In Progress
                                        </label>
                                        <label class="btn btn-outline-success {{ $task->status === 'done' ? 'active' : '' }}">
                                            <input type="radio" name="status" id="done" value="done" {{ $task->status === 'done' ? 'checked' : '' }}> Done
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" style="display: none;">Update Status</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var statusButtons = document.querySelectorAll('.btn-group-toggle label');

            statusButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    document.getElementById('statusForm').submit();
                });
            });
        });
    </script>
@endsection
