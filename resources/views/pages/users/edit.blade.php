@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Employee Management</a></li>
                    <li class="breadcrumb-item">Edit</li>
                    <li class="breadcrumb-item">{{ $user->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 col-7">
                            <h5 class="mb-0 card-title">Edit {{ $user->name }}</h5>
                            <hr class="my-1" style="border-top: 3px solid #8c8b8b;" width="40px" align="left">
                            <div class="clearfix"></div><br>
                        </div>
                        <div class="col-md-6 col-5">
                            <div class="float-right">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary"><span class="fa fa-list"></span></a>
                            </div>
                        </div>
                    </div>

                    @include('includes.notif')
                    <div class="row ">

                        <div class="col-md-6">
                            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ !empty(old('name')) ? old('name') : $user['name'] }}">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ !empty(old('email')) ? old('email') : $user['email'] }}">
                                </div>

                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" id="" class="form-control select2-tag">
                                        @foreach($roles as $role)
                                            <option
                                            @if(!empty(old('role')))
                                                {{ $role == old('role') ? 'selected' : null }}
                                            @else
                                                @if(!empty($user->role))
                                                    @if($user->role == $role)
                                                        selected
                                                    @endif
                                                @endif
                                            @endif
                                            value="{{ $role }}">{{ ucwords($role) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Position</label>

                                    <select name="position_id" id="" class="form-control select2-tag">
                                        @foreach($positions as $position)
                                            <option value="{{ $position['id'] }}"

                                            @if(!empty(old('position_id')))
                                                @if(old('position_id') == $position['id'])
                                                    selected
                                                @endif
                                            @else
                                                @if(!empty($user->position))
                                                    @if($user->position->id == $position['id'])
                                                        selected
                                                    @endif
                                                @endif
                                            @endif
                                            >{{ $position['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Departments</label>

                                    <select name="departments[]" id="" class="form-control select2-multiple-tags-strict" multiple>
                                        @foreach($departments as $department)
                                            <option value="{{ $department['id'] }}"

                                            @if(!empty(old('departments')))
                                                @foreach(old('departments') as $oldDepartment)
                                                    @if($oldDepartment == $department['id'])
                                                        selected
                                                    @endif
                                                @endforeach
                                            @else
                                                @if(!empty($user->departments))
                                                    @foreach($user->departments as $userDepartment)
                                                        @if($userDepartment->id == $department['id'])
                                                            selected
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endif
                                            >{{ $department['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-form">
                                    <button class="text-light btn btn-md btn-success">Update</button>
                                </div>

                            </form>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <h6 class="mb-0">Created At:</h6>
                                <h5>{{ $user->created_at->format('d.m.Y') }}</h5>
                            </div>
                            <div class="form-group">
                                <h6 class="mb-0">Last Modified:</h6>
                                <h5>{{ $user->updated_at->format('d.m.Y') }}</h5>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
