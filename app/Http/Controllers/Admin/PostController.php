<?php
namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\PostRequest;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}
class PostController extends \App\Http\Controllers\Controller {

    public function index () {
        //dd(Gate::allows('update-post'));
        $this->authorize('view', Post::class);
        $posts = Post::with('category')->ofUser()->orderBy('created_at', 'desc')->paginate(10);
        //->where('user_id', Auth::user()->id)
        return view('admin.posts.index', ['posts' => $posts]);
    }

    public function create () {
        $this->authorize('create', Post::class);
        $post = new Post();
        $categories = Category::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('admin.posts.new', compact('post', 'categories', 'users'));
    }

    public function store (PostRequest $request) {
        //Post::create($request->all());
        $this->authorize('create', Post::class);
        Post::create($this->params($request));
        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully');
    }

    public function edit(Post $post) {
        //$this->authorize('update-post',$post);
        $this->authorize('update',$post);
        $categories = Category::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('admin.posts.new', compact('post', 'categories', 'users'));
    }

    public function update(PostRequest $request, Post $post) {
        $this->authorize('update',$post);
        //$post->update($request->all());
        $post->update($this->params($request));
        return redirect()->route('admin.posts.edit', ['id' => $post->id])->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post) {
        $this->authorize('delete',$post);
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post destroyed successfully');
    }

    private function params($request){
        if(!$request['private'])$request['private']=false;
        $user = Auth::user();
        if($user->can('changeOwner',Post::class)){
            return $request->all();
        }else{
            $params = $request->except('user_id');
            $params['user_id'] = $user->id;
            return $params;
        }
    }

}