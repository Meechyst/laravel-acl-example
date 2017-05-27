@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Posts</h3></div>
                    <div class="panel-heading">Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</div>
                    @foreach ($posts as $post)
                        <div class="panel-body">
                            <li style="list-style-type: none">
                                <a href="{{ route('posts.show', $post->id ) }}"><b>{{ $post->title }}</b><br>

                                    <p class="teaser">
                                        {{  str_limit($post->body, 100) }} {{-- Limit teaser to 100 characters --}}
                                    </p>
                                </a>
                                <small>
                                    <i>
                                        <div class="pull-right" data-toggle="tooltip" data-placement="top"
                                             title="{{$post->created_at->format('Y - m - d')}}">&nbsp;|&nbsp;{{$post->created_at->diffForHumans()}}
                                        </div>

                                            <a class="pull-right" data-toggle="tooltip"
                                                                   data-placement="top"
                                                                   title="{{count($post->user->posts)}} Posts"
                                                                   href="{{ route('users.show', $post->user->id) }}">
                                                <div class="pull-right">{{$post->user->name}}</div>
                                            </a>

                                    </i>
                                </small>
                                <br/>
                                <hr/>
                            </li>
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    {!! $posts->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
