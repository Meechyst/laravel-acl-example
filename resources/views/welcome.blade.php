@extends('layouts.app')

@section('title', '| Home Page')
@section('head')

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
@endsection
@section('content')

    <div class="content">
        <div class="title m-b-md">
            Laravel ACL System Example
        </div>
        <div class="m-b-md">
            <h3>Based on <a href="https://github.com/spatie">Spatie</a>'s <a
                        href="https://github.com/spatie/laravel-permission">laravel-permmission</a> package</h3>

            <h5>Credit to <a href="https://scotch.io/@caleboki">Caleb Oki</a> for his <a
                        href="https://scotch.io/tutorials/user-authorization-in-laravel-54-with-spatie-laravel-permission">tutorial</a>
            </h5>
        </div>
        <br/>

        <div class="links">
            <a href="{{ route('posts.index') }}">Posts</a>
            <a href={{route('roles.index')}}>Roles</a>
            <a href="{{route('permissions.index')}}">Permissions</a>
            <a href="{{route('users.index')}}">Users</a>
            <a href="https://github.com/Meechyst/laravel-acl-example">GitHub</a>
        </div>
        <br><br><br>  
        <div class="links">
          <a class="github-button" data-size="large" href="https://github.com/meechyst/laravel-acl-example"
          aria-label="Star meechyst/laravel-acl-example on GitHub">Star</a>
          <a class="github-button" data-size="large" href="https://github.com/meechyst/laravel-acl-example/fork"
          aria-label="Fork meechyst/laravel-acl-example on GitHub">Fork</a>
          <a class="github-button" data-size="large" href="https://github.com/meechyst/laravel-acl-example/archive/master.zip"
          aria-label="Download meechyst/laravel-acl-example on GitHub">Download</a>
        </div>

    </div>

@endsection
