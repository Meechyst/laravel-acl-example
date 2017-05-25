{{-- \resources\views\permissions\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Permission')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-key"></i>Permissions

            <a href="{{ route('users.index') }}" class="btn btn-default pull-right">Users</a>
            <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a></h1>
        <hr>
        <br/>
        <div class="table-responsive">
            <h2 style="text-align: center">{{$permission->name}}</h2>
        </div>
        <br/>

        <p class="m-b-md">Roles who can {{$permission->name}}</p>
        <hr/>
        <ul class="list-unstyled">
            @foreach($permission->roles as $role)
                <li><a href="{{ route('roles.show', $role->id ) }}"><b>{{ $role->name }}</b></a></li>

            @endforeach
        </ul>
        <br/>
        <hr/>
        <p class="m-b-md">Users with {{$permission->name}} permisson</p>
        <hr/>
        <ul class="list-unstyled">
            @foreach($permission->users as $user)
                <li><a href="{{ route('users.show', $user->id ) }}"><b>{{ $user->name }}</b></a></li>

            @endforeach
        </ul>


    </div>

@endsection