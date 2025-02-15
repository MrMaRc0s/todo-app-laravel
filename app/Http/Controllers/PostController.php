<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->posts()->latest()->get();
        return view('home', ['posts' => $posts]);
    }

    public function createPost(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:40'],
            'body' => ['required', 'string']
        ]);

        $data['title'] = strip_tags($data['title']);
        $data['body'] = strip_tags($data['body']);
        $data['user_id'] = auth()->id();
        Post::create($data);
        
        return redirect('/');
    }

    public function editPost(Post $post)
    {
        if($post->user_id !== auth()->id()){
            return redirect('/');
        }
        return view('edit-post', ['post' => $post]);
    }

    public function updatePost(Request $request, Post $post)
    {
        if($post->user_id !== auth()->id()){
            return redirect('/');
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:40'],
            'body' => ['required', 'string']
        ]);

        $data['title'] = strip_tags($data['title']);
        $data['body'] = strip_tags($data['body']);
        $post->update($data);
        
        return redirect('/');
    }

    public function deletePost(Post $post)
    {
        if($post->user_id !== auth()->id()){
            return redirect('/');
        }

        $post->delete();
        return redirect('/');
    }
}
