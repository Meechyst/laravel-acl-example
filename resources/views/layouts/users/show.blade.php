@extends('layouts.app')

@section('title', '| {{$user->name}}')

@section('content')

    <div class="container">

        <h1>{{ $user->name }}</h1>
        @if(!empty($user->roles))
            <h3><a href="{{ route('roles.show', $user->roles()->pluck('id')->implode(' '))  }}">({{$user->roles()->pluck('name')->implode(' ')}})</a></h3>
        @endif
        <hr>
        <p class="lead">{{ $user->email }} </p>

        <div data-toggle="tooltip" data-placement="bottom"
             title="{{$user->created_at->format('Y - m - d')}}">Joined:
            &nbsp;{{$user->created_at->diffForHumans()}}</div>
        <hr>
        <h3>{{$user->name}}'s Posts</h3>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>{{count($user->posts)}} Posts in total</h3></div>
                    @foreach ($user->posts as $post)
                        <div class="panel-body">
                            <li style="list-style-type:disc">
                                <a href="{{ route('posts.show', $post->id ) }}"><b>{{ $post->title }}</b><br>

                                    <p class="teaser">
                                        <i>{{  str_limit($post->body, 10) }}...</i>
                                    </p>
                                </a>
                            </li>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

@endsection
