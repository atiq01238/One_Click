@extends('layout.master')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Reports</h4>
                    </div>
                    @include('validate.message')
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    {{-- <th>ID</th> --}}
                                    <th>Project Title</th>
                                    <th>Task Title</th>
                                    <th>Detail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                <tr>
                                    {{-- <td>{{ $report->id }}</td> --}}
                                    <td>{{ $report->project_name }}</td>
                                    <td>{{ $report->task_name }}</td>
                                    <td>{{ $report->detail }}</td>
                                    <td>
                                        <form action="{{ route('reports.destroy', $report->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
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
