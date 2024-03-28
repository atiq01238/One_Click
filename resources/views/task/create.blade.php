@extends('layout.master')
{{-- @include('project.bootstrap') --}}
@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Task
                                {{-- <a href="{{ url('projects') }}" class="btn btn-primary" style="float: right;">Back</a> --}}
                            </h4>
                        </div>
                        @include('validate.message')
                        <div class="container mt-5">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>To Do</th>
                                        <th>In Progress</th>
                                        <th>Done</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="">
                                            <div class="card" style="width: 18rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Card title</h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                                        of the card's content.</p>
                                                    <a href="#" class="card-link">Card link</a>
                                                    <a href="#" class="card-link">Another link</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="card" style="width: 18rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Card title</h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                                        of the card's content.</p>
                                                    <a href="#" class="card-link">Card link</a>
                                                    <a href="#" class="card-link">Another link</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="card" style="width: 18rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">Card title</h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                                        of the card's content.</p>
                                                    <a href="#" class="card-link">Card link</a>
                                                    <a href="#" class="card-link">Another link</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

