@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User Management</a></li>
                    <li class="breadcrumb-item">Create User</li>
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
                            <h5 class="mb-0 card-title">Create User</h5>
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
                    <div class="row">

                        <div class="col-md-6">
                            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                                </div>

                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" id="" class="form-control select2-tag">
                                        @foreach($roles as $role)
                                            <option
                                            @if(!empty(old('role')))
                                                {{ $role == old('role') ? 'selected' : null }}
                                            @endif
                                            value="{{ $role }}">{{ ucwords($role) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Position</label>
                                    <select name="position_id" id="" class="form-control select2-tag">
                                        @foreach($positions as $position)
                                            <option
                                            @if(!empty(old('position_id')))
                                                {{ $position['id'] == old('position_id') ? 'selected' : null }}
                                            @endif
                                            value="{{ $position['id'] }}">{{ $position['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Departments</label>
                                    <select name="departments[]" id="" class="form-control select2-multiple-tags-strict" multiple>
                                        @foreach($departments as $department)
                                            <option
                                            @if(!empty(old('departments')))
                                                {{ in_array($department['id'], old('departments')) ? 'selected' : null }}
                                            @endif
                                            value="{{ $department['id'] }}">{{ $department['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <hr>
                                <div class="form-form">
                                    <button class="text-light btn btn-md btn-success">Save</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
