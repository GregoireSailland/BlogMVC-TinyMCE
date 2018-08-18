<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Post;
use App\User;
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}
class PostController extends Controller
{

    private $per_page = 5;

    public function index()
    {
        $posts = Post::visibleForUser()->with('category', 'user')->orderBy('created_at', 'desc')->paginate($this->per_page);
        return view('posts.index', compact('posts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $posts = Post::with('category', 'user')->visibleForUser()->where('category_id', $category->id)-> orderBy('created_at', 'desc')->paginate($this->per_page);
        return view('posts.index', compact('posts', 'category'));
    }

    public function user($user_id)
    {
        $user = User::find($user_id);
        $posts = Post::with('category', 'user')->visibleForUser()->where('user_id', $user->id)-> orderBy('created_at', 'desc')->paginate($this->per_page);
        return view('posts.index', compact('posts', 'user'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->visibleForUser()->first();
        if($post){
            $comment = new Comment(['post_id' => $post->id]);
        }
        return view('posts.show', compact('post', 'comment'));
    }

}