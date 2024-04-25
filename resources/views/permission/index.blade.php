@extends('layout.master')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <div class="row">
                   <div class="col-md-12">
                    @include('validate.message')
                    <div class="card">
                        <div class="card-header">
                            <h4>Permission
                                <a href="{{ url('permissions/create') }}" class="btn btn-primary" style="float: right;">Create Permission</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered ">
                                <thead ">
                                    <tr>
                                        {{-- <th style="padding: 10px;">ID</th> --}}
                                        <th style="padding: 10px;">Name</th>
                                        <th style="padding: 10px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            {{-- <td style="padding: 10px;">{{ $permission->id }}</td> --}}
                                            <td style="padding: 10px;">{{ $permission->name }}</td>
                                            <td style="padding: 10px;">
                                                <a href="{{ url('permissions/' . $permission->id . '/edit') }}" class="btn btn-success">Edit</a>
                                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
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


        <!-- /.content -->
    </div>

@stop
