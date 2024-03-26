@extends('layout.master')
{{-- @include('project.bootstrap') --}}
@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Project
                                <a href="{{ url('projects') }}" class="btn btn-primary" style="float: right;">Back</a>
                            </h4>
                        </div>
                        @include('validate.message')
                        <div class="card-body">
                            <form action="{{ url('projects') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="project_name">Project Title</label>
                                    <input type="text" name="project_name" id="project_name" class="form-control">
                                    @error('project_name')
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
                                        <input type="text" class="form-control" id="start_date" name="start_date">
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
                                        <input type="text" name="end_date" id="end_date" class="form-control">
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
                                    <label for="assign_user">Assign User</label>
                                    <select name="assign_user" id="assign_user" class="form-control">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                                        @endforeach
                                    </select>
                                    @error('assign_user')
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



