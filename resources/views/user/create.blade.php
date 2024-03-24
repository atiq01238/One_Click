<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Invite Users</title>

</head>

<body>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create User
                                <a href="{{ url('admins') }}" class="btn btn-primary"
                                    style="float: right;">Back</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('users') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="">First Name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" >
                                    @error('first_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <label for="">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" >
                                    @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <label for="">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" >
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <label for="">Roles</label>
                                    <select name="roles[]" class="form-control" multiple>
                                        @foreach ($roles as $roleId => $roleName)
                                            <option value="{{ $roleId }}">{{ $roleName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary ">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
