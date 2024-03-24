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
                            <h4>Admins
                                <button id="invite" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#inviteModal" style="float: right;">Assign Role</button>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Roles</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td style="padding: 10px;">{{ $user->id }}</td>
                                                <td style="padding: 10px;">{{ $user->email }}</td>
                                                <td>
                                                    @foreach ($user->roles as $role)
                                                        <label class="badge"
                                                            style="font-size: 0.8rem; padding: 8px 12px; background-color: #007bff; color: #fff; border-radius: 5px;">{{ $role->name }}</label>
                                                    @endforeach
                                                </td>
                                                <td style="padding: 10px;">
                                                    <form action="{{ route('admins.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete Assigned
                                                            Role</button>
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
        </div>
    </section>
@stop




<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $("#invite").click(function(e) {
            e.preventDefault();
            $('#inviteModal').modal('show');
        });
    });
</script>

<!-- Invite User Modal -->
<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="inviteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inviteModalLabel">Assign Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.assignRole') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="email"
                            class="form-control form-control-user @error('email') border border-danger @enderror"
                            name="email" id="exampleInputEmail" placeholder="Email Address"
                            value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <label for="">Roles</label>
                        <select name="roles[]" class="form-control" multiple>
                            @foreach ($roles as $roleId => $roleName)
                                <option value="{{ $roleId }}">{{ $roleName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
