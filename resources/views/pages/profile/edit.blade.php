@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 col-7">
                            {{-- <h5 class="mb-0 card-title">Edit {{ auth()->user()->name }}</h5> --}}
                            <h5 class="mb-0 card-title">Edit {{ $user->name }}</h5>
                            <hr class="my-1" style="border-top: 3px solid #8c8b8b;" width="40px" align="left">
                            <div class="clearfix"></div><br>
                        </div>
                        <div class="col-md-6 col-5">
                            <div class="float-right">
                                <a href="{{ route('profile') }}" class="btn btn-primary"><span class="fa fa-eye"></span></a>
                            </div>
                        </div>
                    </div>

                    @include('includes.notif')
                    <div class="row">

                        <div class="col-md-6">
                            {{-- <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data"> --}}
                            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <div class="form-group">
                                    <label class="required">Name</label>
                                    {{-- <input type="text" name="name" class="form-control" value="{{ !empty(old('name')) ? old('name') : auth()->user()->name }}"> --}}
                                    <input type="text" name="name" class="form-control" value="{{ !empty(old('name')) ? old('name') : $user->name }}">
                                </div>

                                <div class="form-group">
                                    <label class="required">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{ !empty(old('email')) ? old('email') : $user->email }}">
                                </div>

                                <div class="form-group">
                                    <label class="required">Position</label>

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
                                    <label class="required">Departments</label>

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

                                <div class="form-group">
                                    <label class="required">Profile Picture</label>
                                    <div class="form-group">
                                        <input type="file" name="profile" class="form-control col-sm-12" accept="image/*">
                                        @if ($user->profile)
                                            <img src="{{ '/assets/images/users/' . $user->profile }}" alt="{{ $user->profile }}" width="50%" class="rounded img-responsive p-3" width="100%">
                                        @endif
                                    </div>
                                </div>

                                <hr class="my-4">
                                <div class="form-form">
                                    <button class="text-light btn btn-md btn-primary">Update</button>
                                    <a href="{{ route('profile') }}" class="btn btn-md">Cancel</a>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- @include('layouts.includes.delete-modal') --}}
@stop
