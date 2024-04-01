<!-- edit.blade.php -->

@extends('layout.master')

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Project
                                <a href="{{ route('projects.index') }}" class="btn btn-primary" style="float: right;">Back</a>
                            </h4>
                        </div>
                        @include('validate.message')
                        <div class="card-body">
                            <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="project_name">Project Title</label>
                                    <input type="text" name="project_name" id="project_name" class="form-control" value="{{ old('project_name', $project->project_name) }}">
                                    @error('project_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $project->description) }}">
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="start_date">Start Date</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date) }}">
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
                                        <input type="text" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $project->end_date) }}">
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
                                            <option value="{{ $user->id }}" {{ old('user_id', $project->user_id) == $user->id ? 'selected' : '' }}>{{ $user->email }}</option>
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
                                    <button type="submit" class="btn btn-primary">Update</button>
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
<script>
    $(document).ready(function() {
        $('#start_date, #end_date').datepicker({
            format: "dd MM yyyy",
            autoclose: true,
            todayHighlight: true,
        });
    });
</script>
@endpush
