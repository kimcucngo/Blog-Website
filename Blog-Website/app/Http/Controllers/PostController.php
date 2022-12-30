<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class PostController extends Controller
{

    //Index
    public function index(){
        $posts = auth()->user()->posts()->paginate(5);
        return view('admin.posts.index',['posts'=>$posts]);
    }

    //Show
    public function show(Post $post){
        return view('blog-post',['post'=>$post]);
    }

    //Create
    public function create(){
        return view('admin.posts.create');
    }

    //Store
    public function store(){
        $this->authorize('create',Post::class);
        $inputs = request()->validate([
            'title'=>'required|min:8|max:255',
            'post_image'=>'file',
            'body'=>'required',
       ]);
       if(request('post_image')){
        $inputs['post_image'] = request('post_image')->store('images');
       }
       auth()->user()->posts()->create($inputs);
       session()->flash('post-created-message','Post with title was created '.$inputs['title']);
       return redirect()->route('post.index');
    }

    //Edit
    public function edit(Post $post){
        $this->authorize('view',$post);
        return view('admin.posts.edit',['post'=>$post]);
    }

    //Destroy
    public function destroy(Post $post,Request $request){
        $this->authorize('delete',$post);
        $post->delete();
        $request->session()->flash('message','Post was deleted');
        return back();
    }
    
    //Update
    public function update(Post $post){
        $inputs = request()->validate([
            'title'=>'required|min:8|max:255',
            'post_image'=>'file',
            'body'=>'required',
        ]);
        if(request('post_image')){
            $inputs['post_image'] = request('post_image')->store('images');
            $post->post_image = $inputs['post_image'];
           }
           $post->title = $inputs['title'];
           $post->body = $inputs['body'];
           $this->authorize('update',$post);
           $post->save();
           session()->flash('post-updated-message','Post with title was updated '.$inputs['title']);
           return redirect()->route('post.index');
    }
}