<!-- resources/views/projects/show.blade.php -->
@extends('layout.master')

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        @include('validate.message')
                        <div class="card-header">
                            <h4 class="mb-0">Report Task</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reports.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user_id }}">

                                <div class="mb-3">
                                    <label for="project_name">Project Title</label>
                                    <input type="text" name="project_name" id="project_name" value="{{ $project->project_name ?? old('project_name') }}" class="form-control">
                                    @error('project_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="task_name" class="form-label">Task Name</label>
                                    <input type="text" name="task_name" id="task_name" value="{{ $task->task_name ?? old('task_name') }}" class="form-control">
                                    @error('task_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="detail">Detail</label>
                                    <input type="text" name="detail" id="detail" class="form-control">
                                    {{-- <textarea name="" id="" cols="30" rows="30"></textarea> --}}
                                    @error('detail')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
