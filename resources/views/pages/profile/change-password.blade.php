@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 col-7">
                            <h5 class="mb-0 card-title">Change Password</h5>
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
                            <form action="{{ route('profile.update-password', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <div class="form-group">
                                    <label class="required">Old Password</label>
                                    <input type="password" name="old_password" class="form-control" value="{{ !empty(old('old_password')) ? old('old_password') : null }}">
                                </div>

                                <div class="form-group">
                                    <label class="required">New Password</label>
                                    <input type="password" name="new_password" class="form-control" value="{{ !empty(old('new_password')) ? old('new_password') : null }}">
                                </div>

                                <div class="form-group">
                                    <label class="required">Confirm Password</label>
                                    <input type="password" name="confirm_password" class="form-control" value="{{ !empty(old('confirm_password')) ? old('confirm_password') : null }}">
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
@stop
