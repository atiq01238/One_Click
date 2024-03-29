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
                            <h4 class="mb-0">Task Details : {{ $task->task_name }}</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="mb-2"><strong>Project Name</strong> {{ $task->project ? $task->project->project_name : 'No Project' }}</p>
                        <p class="mb-2"><strong>Description:</strong> {{ $task->description }}</p>
                        <p class="mb-2"><strong>Start Date:</strong> {{ $task->start_date }}</p>
                        <p class="mb-2"><strong>End Date:</strong> {{ $task->end_date }}</p>
                        {{-- <p class="mb-0"><strong>Assigned User:</strong> {{ $task->user->first_name }} {{ $task->user->last_name }}</p> --}}
                        <!-- Add more details here as needed -->
                        <p class="mb-2"><strong>Attachment:</strong> {{ $task->attachment }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
