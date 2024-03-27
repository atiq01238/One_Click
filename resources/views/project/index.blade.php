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
                        {{-- <a id="invite" class="btn btn-primary" style="float: right;"> </a> --}}
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
                                    {{-- <th>Attachment</th> --}}
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
                                        <div class="btn-group" role="group" aria-label="Project Actions">
                                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                            <a href="#" class="btn btn-info backlog-btn" data-project-id="{{ $project->id }}">BackLog</a>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".backlog-btn").click(function(e) {
            e.preventDefault();
            var projectId = $(this).data('project-id');
            $.ajax({
                url: "{{ url('projects') }}" + "/" + projectId,
                type: 'GET',
                success: function(response) {
                    $('#backlogModalLabel').text('Project Details - ' + response.project_name);
                    $('#backlogModalBody').html('<p><strong>Description:</strong> ' + response.description + '</p>' +
                                                '<p><strong>Start Date:</strong> ' + response.start_date + '</p>' +
                                                '<p><strong>End Date:</strong> ' + response.end_date + '</p>' +
                                                '<p><strong>Assigned User:</strong> ' + response.user.first_name + ' ' + response.user.last_name + '</p>' +
                                                '<p><strong>Attachment:</strong> ' + response.attachment + '</p>');
                    $('#backlogModal').modal('show');
                }
            });
        });
    });
</script>

<div class="modal fade" id="backlogModal" tabindex="-1" role="dialog" aria-labelledby="backModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="backlogModalLabel">Project Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="backlogModalBody">
                <!-- Project details will be loaded dynamically here -->
            </div>
        </div>
    </div>
</div>


