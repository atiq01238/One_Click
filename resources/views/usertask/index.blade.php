@extends('layout.master')
@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @include('validate.message')
                    <div class="card">
                        <div class="card-header">
                            <h4>All Tasks
                            </h4>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Task Title</th>
                                        <th>Description</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>
                                            <td>{{ $task->task_name }}</td>
                                            <td>
                                                <div style="max-height: 30px; overflow: hidden;">
                                                    {{ Str::limit($task->description, 30) }}
                                                </div>

                                            </td>
                                            <td>{{ $task->start_date }}</td>
                                            <td>{{ $task->end_date }}</td>

                                            <td>
                                                <div class="btn-group d-flex" role="group">
                                                    <form id="statusForm" action="{{ route('usertasks.updateStatus', $task->id) }}" method="POST" style="float: right">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                                <label style="" class="btn btn-outline-primary {{ $task->status === 'todo' ? 'active' : '' }}">
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
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var statusButtons = document.querySelectorAll('.btn-group-toggle label');

            statusButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    this.closest('form').submit();
                });
            });
        });
    </script> --}}
@stop


