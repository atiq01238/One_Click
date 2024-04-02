@extends('layout.master')
@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                {{-- <div class="col-md-6"></div> --}}
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Task
                                <a href="{{ url('tasks') }}" class="btn btn-primary" style="float: right;">Back</a>
                            </h4>
                        </div>
                        @include('validate.message')
                        <div class="card-body">
                            <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="project_id">Project</label>
                                    <select name="project_id" id="project_id" class="form-control">
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ $project->id == $task->project_id ? 'selected' : '' }}>{{ $project->project_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="task_name">Task Name</label>
                                    <input type="text" name="task_name" id="task_name" class="form-control" value="{{ $task->task_name }}">
                                    @error('task_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" id="description" class="form-control">
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="start_date">Start Date</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" id="start_date" name="start_date" value="{{ $task->start_date }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('start_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="end_date">End Date</label>
                                    <div class="input-group date">
                                        <input type="text" name="end_date" id="end_date" class="form-control" value="{{ $task->end_date }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('end_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="user_id">Assign User</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $user->id == $task->user_id ? 'selected' : '' }}>{{ $user->email }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="attachment">Attachment</label>
                                    <input type="file" name="attachment" id="attachment" class="form-control">
                                    @error('attachment')
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

@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#start_date, #end_date').datepicker({
            format: "dd MM yyyy",
            autoclose: true,
            todayHighlight: true,
        });
    });

    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: 'Select User',
            allowClear: true
        });
    });
</script>

@endpush
