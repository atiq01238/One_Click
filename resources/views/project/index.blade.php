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
                            <h4>All Projects
                                <a href="{{ url('projects/create') }}" class="btn btn-primary" style="float: right;">Create
                                    Project</a>
                            </h4>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Project Title</th>
                                        <th>Description</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Assign User</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>{{ $project->id }}</td>
                                            <td>{{ $project->project_name }}</td>
                                            <td>{{ $project->description }}</td>
                                            <td>{{ $project->start_date }}</td>
                                            <td>{{ $project->end_date }}</td>
                                            <td>{{ $project->user->first_name }} {{ $project->user->last_name }}</td>

                                            <td>
                                                <div class="btn-group d-flex" role="group">
                                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary flex-fill">Edit</a>
                                                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="flex-fill">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger w-100">Delete</button>
                                                    </form>
                                                    <a href="#" type="button" class="btn btn-info flex-fill" data-toggle="modal" data-target="#backlogModal-{{ $project->id }}">BackLog</a>
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

@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $(".backlog-btn").click(function(e) {
            e.preventDefault();
            var projectId = $(this).data('project-id');
            $('#backlogModal-' + projectId).modal('show');
        });
    });
</script>

@foreach ($projects as $project)
    <div class="modal fade" id="backlogModal-{{ $project->id }}" role="dialog" aria-labelledby="backModalLabel"
        aria-hidden="true">
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
                    {{-- <p>Attachment {{ $project->attachment }}</p> --}}
                    @if ($project->attachment)
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
