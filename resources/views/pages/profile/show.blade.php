@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-body">

                    @include('includes.notif')
                    <div class="row">

                        <div class="col-md-12">
                            <div class="row px-3">
                                <div class="col-sm-4">
                                    @if (auth()->user()->profile)
                                        <img src="{{ '/assets/images/users/' . auth()->user()->profile }}" alt="AppDev Team" class="rounded img-responsive p-3" width="100%">
                                    @else
                                        <img src="{{ '/assets/images/users/noimg.jpg' }}" alt="AppDev Team" class="rounded img-responsive p-3" width="100%">
                                    @endif
                                </div>
                                <div class="col-sm-8 py-3">
                                    <h2 class="mb-4">{{ auth()->user()->name }}</h2>

                                    <div class="form-group mb-3">
                                        <h6 class="mb-0">Email:</h6>
                                        <h5>{{ auth()->user()->email }}</h5>
                                    </div>

                                    <div class="form-group mb-3">
                                        <h6 class="mb-0">Role:</h6>
                                        <h5>{{ ucwords(auth()->user()->role) }}</h5>
                                    </div>

                                    <div class="form-group mb-3">
                                        <h6 class="mb-0">Position:</h6>
                                        <h5>{{ auth()->user()->position->name }}</h5>
                                    </div>

                                    <div class="form-group mb-3">
                                        <h6 class="mb-0">Departments:</h6>

                                        @foreach(auth()->user()->departments as $departmentIndex => $department)
                                            @php
                                            $departmentIndex == 0 ? $departments = $department['name'] : $departments .= ", " . $department['name'];
                                            @endphp
                                        @endforeach
                                        <h5>{{ $departments }}</h5>
                                    </div>

                                    <div class="form-group">
                                        <a href="{{ route('profile.edit') }}" class="btn my-1 btn-info text-white"><span class="fa fa-pencil-alt"></span> Edit Profile</a>
                                        <a href="{{ route('profile.change-password') }}" class="btn my-1 btn-warning"><span class="fa fa-lock"></span> Change Password</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
