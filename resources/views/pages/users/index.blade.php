@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User Management</a></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 col-7">
                            <h5 class="mb-0 card-title">User Management</h5>
                            <hr class="my-1" style="border-top: 3px solid #8c8b8b;" width="40px" align="left">
                            <div class="clearfix"></div><br>
                        </div>
                        <div class="col-md-6 col-5">
                            <div class="float-right">
                                @can('create-users')
                                    <a href="{{ route('users.create') }}" class="btn btn-success">Add New User</a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @include('includes.notif')
                            <table class="table">
                                <thead>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Position</th>
                                    <th>Departments</th>
                                    <th>Role</th>
                                    <th class="text-center" width="10%"></th>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr class="align-middle">
                                        <td>
                                            @if ($user->profile)
                                                <img src="{{ '/assets/images/users/' . $user->profile }}" alt="AppDev Team" class="img-profile-lg rounded-circle mr-2">
                                            @else
                                                <img src="{{ '/assets/images/users/noimg.jpg' }}" alt="AppDev Team" class="img-profile-lg rounded-circle mr-2">
                                            @endif
                                            {{ $user['name'] }}
                                        </td>
                                        <td class="align-middle">{!! $user['email'] !!}</td>
                                        <td class="align-middle">{!! $user['position']['name'] !!}</td>

                                        <td class="align-middle">
                                            @foreach($user->departments as $departmentIndex => $department)
                                                @php
                                                $departmentIndex == 0 ? $departments = $department['name'] : $departments .= ", " . $department['name'];
                                                @endphp
                                            @endforeach
                                            {!! $departments !!}
                                        </td>
                                        <td class="align-middle">{!! ucwords($user['role']) !!}</td>
                                        <td class="text-center align-middle">
                                            <form action="{{ route('users.destroy', $user['id']) }}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                @can('edit-users')
                                                    <a href="{{ route('users.edit', $user['id']) }}" class="btn btn-md btn-info text-light"><span class="fa fa-pencil"></span></a>
                                                @endcan
                                                @can('destroy-users')
                                                    <button class="btn btn-md btn-danger"><span class="fa fa-trash"></span></button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-6">
                                    Total <strong>{{ number_format($users->total() , 0 , '.' , ',' ) }}</strong> result(s)
                                </div>
                                <div class="col-md-6">
                                    <div class="float-right">
                                        {{ $users->appends(request()->input())->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
