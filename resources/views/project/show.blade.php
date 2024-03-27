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
                            <h4 class="mb-0">Project Details - {{ $project->project_name }}</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="mb-2"><strong>Description:</strong> {{ $project->description }}</p>
                        <p class="mb-2"><strong>Start Date:</strong> {{ $project->start_date }}</p>
                        <p class="mb-2"><strong>End Date:</strong> {{ $project->end_date }}</p>
                        <p class="mb-0"><strong>Assigned User:</strong> {{ $project->user->first_name }} {{ $project->user->last_name }}</p>
                        <!-- Add more details here as needed -->
                        <p class="mb-2"><strong>Attachment:</strong> {{ $project->attachment }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
