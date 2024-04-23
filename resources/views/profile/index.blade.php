@extends('layout.master')

@section('content')
    <div class="container  bootstrap snippet">
        <div class="row">
            <div class="col-md-10">
                <h1>Profile</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="tab-content">
                    @include('validate.message')
                    <div class="tab-pane active" id="home">
                        <hr>

                        {{-- Form Data--}}

                        <form class="form" action="{{ route('profiles.storeOrUpdate') }}" method="post" id="registrationForm" enctype="multipart/form-data">
                            @csrf
                            @method('post')

                            <div class="main d-flex column-gap-5 w-100 justify-content-between ">

                                {{-- Left Content  --}}

                                <div class=" left-content w-50 col-sm-3">
                                    <div class="text-center">
                                        @if($image)
                                            <img src="{{ asset('profile_imgs/' . $image) }}" height="220px" width="220px" alt="image" style="border-radius: 100px; ">
                                        @else
                                            <img src="{{ asset('profile_imgs/default.jpg') }}" height="200px" width="200px" alt="image">
                                        @endif
                                        <h6>Upload a different photo...</h6>
                                        <input type="file" name="image" id="image" class="text-center center-block file-upload">
                                    </div>
                                </div>

                                {{-- Right Content --}}

                                <div class="right-content w-50 ">
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="first_name">
                                                <h4>First name</h4>
                                            </label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" id="first_name" placeholder="first name"
                                                value="{{ $user->first_name ?? ''}}">
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="last_name">
                                                <h4>Last name</h4>
                                            </label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                name="last_name" id="last_name" placeholder="last name"
                                                value="{{ $user->last_name ?? ''}}">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <div class="col-xs-6">
                                                <label for="phone">
                                                    <h4>Phone</h4>
                                                </label>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                    name="phone" id="phone" placeholder="enter phone"
                                                    value="{{ $profile->phone ?? '' }}">
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6">
                                            <label for="email">
                                                <h4>Email</h4>
                                            </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" id="email" placeholder="you@email.com"
                                                value="{{ $user->email }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <br>
                                            <button class="btn btn-lg btn-success" type="submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </form>
                        <hr>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
