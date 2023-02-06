<?php

namespace App\Http\Controllers;

use App\Mail\NewPostEmail;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function showCreateForm()
    {
        return view('create-post');
    }

    public function storeNewPost(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        Mail::to(auth()->user()->email)->send(new NewPostEmail(['name' => auth()->user()->username, 'title' => $newPost->title]));
        return redirect("/post/{$newPost->id}")->with('success', 'New post was successfully created.');
    }

    public function viewSinglePost(Post $post)
    {
        $post['body'] = strip_tags(Str::markdown($post->body), '<p><ul><ol><strong><em><h3><br>');
        return view('single-post', ['post' => $post]);
    }

    public function delete(Post $post)
    {
        $post->delete();

        return redirect('/profile/' . auth()->user()->username)->with('success', 'Post successfully deleted.');
    }

    public function showEditForm(Post $post)
    {
        return view('edit-post', ['post' => $post]);
    }

    public function actuallyUpdate(Post $post, Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);

        return back()->with('success', 'Post successfully updated.');
    }

    public function search($term) {
        $posts = Post::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
    }
}
