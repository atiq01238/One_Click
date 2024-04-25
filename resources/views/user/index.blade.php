<!-- Add Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
                            <h4>User
                                <a id="invite" class="btn btn-primary" style="float: right;"> Invite User</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered ">
                                <thead ">
                                        <tr>
                                            {{-- <th style="padding: 10px;">ID</th> --}}
                                            <th style="padding: 10px;">First Name</th>
                                            <th style="padding: 10px;">Last Name</th>
                                            <th style="padding: 10px;">Email</th>
                                            <th style="padding: 10px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach ($users as $user)
                                    <tr>
                                        {{-- <td style="padding: 10px;">{{ $user->id }}</td> --}}
                                        <td style="padding: 10px;">{{ $user->first_name }}</td>
                                        <td style="padding: 10px;">{{ $user->last_name }}</td>
                                        <td style="padding: 10px;">{{ $user->email }}</td>
                                        <td style="padding: 10px;">
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                            </table>
                            <div class="center">{{ $users->links() }}</div>
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
        $("#invite").click(function(e) {
            e.preventDefault();
            $('#inviteModal').modal('show');
        });
    });
</script>

<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="inviteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inviteModalLabel">Invite User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="inviteForm" action="{{ route('invites.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="email"
                            class="form-control form-control-user @error('email') border border-danger @enderror"
                            name="email" id="exampleInputEmail" placeholder="Email Address"
                            value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Invite</button>
                </form>
            </div>
        </div>
    </div>
</div>
