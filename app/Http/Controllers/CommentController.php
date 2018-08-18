<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store (CommentRequest $request) {
        $comment = Comment::create($request->all());
        return redirect()->route('posts.show', ['slug' => $comment->post->slug])->with('success', 'Thanks for your comment');
    }

    public function user($user_id)
    {
        $user = User::find($user_id);
        $comments = Post::with('category', 'user')->visibleForUser()->where('user_id', $user->id)-> orderBy('created_at', 'desc')->paginate($this->per_page);
        return view('comments.index', compact('comments', 'user'));
    }

}
