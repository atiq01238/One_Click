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
                                    <th>Attachment</th>
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
                                    <td>{{ $project->assign_user }}</td>
                                    <td></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Project Actions">
                                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
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

@stop
