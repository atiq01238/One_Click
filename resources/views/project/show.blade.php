<!-- resources/views/projects/show.blade.php -->
@extends('layout.master')

@section('content')

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header bg-info text-white">
                            <h4 class="mb-0">Project Name - {{ $project->project_name }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <div class="form-group">
                            <label for="user_id">Assign User</label>
                            <input type="text" class="form-control" id="user_id" name="user_id"
                                value="{{ $project->user ? $project->user->email : 'No User Assigned' }}" readonly>
                        </div> --}}
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" readonly>{{ $project->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ $project->start_date }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ $project->end_date }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="attachment">Attachment</label><br>
                            @if ($project->attachment)
                                <a href="{{ asset('storage/' . $project->attachment) }}" download>Download Attachment</a>
                            @else
                                <p>No attachment available</p>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
