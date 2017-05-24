@extends('layouts.app')

@section('title', '| {{$user->name}}')

@section('content')

    <div class="container">

        <h1>{{ $user->name }}</h1>
        <hr>
        <p class="lead">{{ $user->email }} </p>
        <small>Created at: <em>{{ $user->created_at->format('F d, Y h:ia') }}</em></small>
        <hr>
        <h3>User's Posts</h3>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>User's Posts</h3></div>
                    @foreach ($user->post as $post)
                        <div class="panel-body">
                            <li style="list-style-type:disc">
                                <a href="{{ route('posts.show', $post->id ) }}"><b>{{ $post->title }}</b><br>
                                    <p class="teaser">
                                        <i>{{  str_limit($post->body, 10) }} ...</i>
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
