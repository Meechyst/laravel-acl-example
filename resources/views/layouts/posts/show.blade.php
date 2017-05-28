@extends('layouts.app')

@section('title', '| View Post')

@section('content')


    <div class="container">

        <h1>{{ $post->title }}</h1>
        <hr>
        <p class="lead">{{ $post->body }} </p>
        <hr>
        {!! Form::open(['method' => 'DELETE', 'route' => ['posts.destroy', $post->id], 'class' => 'deleteGroup' ]) !!}
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

        <div class="pull-right" data-toggle="tooltip" data-placement="top"
                 title="{{$post->created_at->format('Y - m - d')}}">  &nbsp;|&nbsp;{{$post->created_at->diffForHumans()}}
        </div>
        <div class="pull-right">
            <a class="pull-right" data-toggle="tooltip" data-placement="top"
               title="{{count($post->user->posts)}} Posts"
               href="{{ route('users.show', $post->user->id) }}">
                {{$post->user->name}}
            </a>
        </div>
        @if(!Auth::guest())
        @if (Auth::id() == $post->user->id ||  Auth::user()->hasRole('Admin'))
            @can('Edit Post')
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info" role="button">Edit</a>
            @endcan
            @can('Delete Post')
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            @endcan
        @endif
        @endif
        {!! Form::close() !!}
    </div>

@endsection
