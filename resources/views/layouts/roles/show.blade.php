{{-- \resources\views\roles\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Role')
@section('head')
    <style>

        .m-b-md {
            margin-bottom: 30px;
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }</style>
@endsection
@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-key"></i> Roles

            <a href="{{ route('users.index') }}" class="btn btn-default pull-right">Users</a>
            <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a></h1>
        <hr>
        <div class="table-responsive">
            <h2 style="text-align: center">{{$role->name}}</h2>
        </div>
        <br/>

        <p class="m-b-md">Permissions the {{$role->name}} role have</p>
        <hr/>
        <ul class="list-unstyled">
            @foreach($role->permissions as $perm)
                <li><a href="{{ route('permissions.show', $perm->id ) }}"><b>{{ $perm->name }}</b></a></li>

            @endforeach
        </ul>
        <br/>
        <hr/>
        <p class="m-b-md">Users with {{$role->name}} role</p>
        <hr/>
        <ul class="list-unstyled">
            @foreach($role->users as $user)
                <li><a href="{{ route('users.show', $user->id ) }}"><b>{{ $user->name }}</b></a></li>

            @endforeach
        </ul>


    </div>

@endsection