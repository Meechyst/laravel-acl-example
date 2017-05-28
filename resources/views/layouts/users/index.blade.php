{{-- \resources\views\users\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Users')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-users"></i> User Administration <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a>
            <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a></h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date/Time Added</th>
                    <th>User Roles</th>
                    @role('Admin')
                    <th>Operations</th>
                    @endrole
                </tr>
                </thead>

                <tbody>
                @foreach ($users as $user)
                    <tr>

                        <td><a href="{{ route('users.show', $user->id ) }}"><b>{{ $user->name }}</b></a></td>
                        <td >{{ Html::mailto($user->email, $user->email, array('class' => 'btn')) }}
                        </td>
                        <td>{{ $user->created_at->format('F d, Y - h:ia') }}</td>
                        <td><a href="{{ route('roles.show', $user->roles()->pluck('id')->implode(' '))  }}">{{  $user->roles()->pluck('name')->implode(' ') }}</a></td>{{-- Retrieve array of roles associated to a user and convert to string --}}

                        @role('Admin')
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'class' => 'deleteGroup' ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}

                        </td>
                        @endrole
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>

    </div>

@endsection