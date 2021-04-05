@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('positions.index') }}">Position Management</a></li>
                    <li class="breadcrumb-item">{{ $position->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 col-7">
                            <h5 class="mb-0 card-title">{{ $position->name }}</h5>
                            <hr class="my-1" style="border-top: 3px solid #8c8b8b;" width="40px" align="left">
                            <div class="clearfix"></div><br>
                        </div>
                        <div class="col-md-6 col-5">
                            <div class="float-right">
                                <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-info text-light"><span class="fa fa-pencil"></span></a>
                                <a href="{{ route('positions.index') }}" class="btn btn-secondary"><span class="fa fa-list"></span></a>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Position Name: {{ $position->name }}</label><br>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
