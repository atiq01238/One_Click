@extends('layout.master')
@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>


        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @include('validate.message')
                        <div class="card">
                            <div class="card-header">
                                <h4>Role : {{ $role->name }}
                                    <a href="{{ url('roles') }}" class="btn btn-primary" style="float: right;">Back</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('roles/' . $role->id . '/give-permissions') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="">Permission</label>
                                        <div class="row">
                                            @foreach ($permissions as $permission)
                                                <div class="col-md-2">
                                                    <label>
                                                        <input type="checkbox"
                                                            name="permission[]"
                                                            value="{{ $permission->name }}"
                                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} />
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
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
    </div>

@stop
