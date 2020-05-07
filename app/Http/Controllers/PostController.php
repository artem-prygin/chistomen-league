<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('users')->with('user')->orderBy('created_at', 'desc')->paginate(4);
        return view('post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        if ($request->input('author') != auth()->user()->id) {
            dd('error');
        }
        $user_id = auth()->user()->id;

        request()->validate([
            'title' => 'required|min:5|max:99',
            'description' => 'required|min:10|max:200',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = 'post' . time() . '.' . request()->photo->getClientOriginalExtension();
        $imagePath = '/img/posts/user' . $user_id . '/posts/';
        request()->photo->move(public_path('img') . '/posts/user' . $user_id . '/posts' , $imageName);

        Post::create([
            'author' => $user_id ,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'photo' => $imagePath . $imageName,
        ]);
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return '123';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function like(Request $request) {
        $user = User::find(auth()->user()->id);

        $post = Post::find($request->input('id'));

        $like = DB::table('post_user')
                ->where('post_id', '=', $post->id)
                ->where('user_id', '=', $user->id)
                ->count() > 0;

        if ($like === true) {
            $user->posts()->detach($request->input('id'));
            $post->likes--;
        } else {
            $user->posts()->attach($request->input('id'));
            $post->likes++;
        }

        $post->update();
        return $like;
    }
}
