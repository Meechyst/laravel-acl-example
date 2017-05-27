<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{

    public function __construct(){
      $this->middleware(['auth' => 'clearance'])->except('index', 'show');
    }

    /**
     * Show only 5 items at a time in descending order.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
       $posts = Post::orderby('id', 'desc')->paginate(5);


       return view('layouts.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $this->validate($request, [
          'title' => 'required|max:100',
          'body' => 'required',
        ]);



        //create the post
        $post = Auth::user()->posts()->create($request->all());


        //display a message upon successfully creating the post
        return redirect()->route('posts.index')
          ->with('flash_message', 'Post '. $post->title . ' created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);


        return view('layouts.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('layouts.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validation
        $this->validate($request, [
          'title' => 'required|max:100',
          'body' => 'required'
        ]);
        //update the post
        $post = Post::findOrFail($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect()->route('posts.show', $post->id)
          ->with('flash_message', 'Post ' . $post->title . ' updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')
          ->with('flash_message', 'Post' . $post->title . ' deleted');
    }
}
