@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('positions.index') }}">Position Management</a></li>
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
                            <h5 class="mb-0 card-title">Position Management</h5>
                            <hr class="my-1" style="border-top: 3px solid #8c8b8b;" width="40px" align="left">
                            <div class="clearfix"></div><br>
                        </div>
                        <div class="col-md-6 col-5">
                            <div class="float-right">
                                @can('create-positions')
                                    <a href="{{ route('positions.create') }}" class="btn btn-success">Add New Position</a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @include('includes.notif')
                            <table class="table">
                                <thead>
                                    <th>Position</th>
                                    <th class="text-center" width="10%"></th>
                                </thead>
                                <tbody>
                                    @foreach($positions as $position)
                                    <tr>
                                        <td>{{ $position['name'] }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('positions.destroy', $position['id']) }}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                @can('edit-positions')
                                                    <a href="{{ route('positions.edit', $position['id']) }}" class="btn btn-md btn-info text-light"><span class="fa fa-pencil"></span></a>
                                                @endcan
                                                @can('destroy-positions')
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
                                    Total <strong>{{ number_format($positions->total() , 0 , '.' , ',' ) }}</strong> result(s)
                                </div>
                                <div class="col-md-6">
                                    <div class="float-right">
                                        {{ $positions->appends(request()->input())->links() }}
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
