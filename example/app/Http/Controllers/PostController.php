<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function createPost(Request $request){
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

    public function editPost(Post $post){
        if($post->user_id !== auth()->id()){
            return redirect('/');
        }
        return view('edit-post', ['post' => $post]);
    }

    public function updatePost(Request $request, Post $post){
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

    public function deletePost(Post $post){
        if($post->user_id === auth()->id()){
            $post->delete();
        }
        return redirect('/');
    }

    public function toggleDone(Post $post){
        if($post->user_id !== auth()->id()){
            return redirect('/');
        }
        $post->done = !$post->done;
        $post->save();
        return response()->json(['success' => true]);
    }
}
