{{-- \resources\views\roles\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Role')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-key"></i> Roles

            <a href="{{ route('users.index') }}" class="btn btn-default pull-right">Users</a>
            <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a></h1>
        <hr>
        <div class="table-responsive">
            <h3>{{$role->name}}</h3>
        </div>


    </div>

@endsection