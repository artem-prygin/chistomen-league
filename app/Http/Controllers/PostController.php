<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
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
        $posts = Post::with('users')
            ->with('user')
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        return view('post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('post.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        if ($request->input('author') != auth()->user()->id) {
            dd('error');
        }
        $user_id = auth()->user()->id;
        $user_nickname = auth()->user()->nickname;

        $messages = [
            "photo.max" => "Не более пяти фотографий"
        ];

        request()->validate([
            'title' => 'required|min:1|max:40',
            'description' => 'required|min:1|max:1000',
            'photo.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'photo' => 'max:5',
        ], $messages);

        if ($request->has('category_id') && !is_null($request->has('category_id'))) {
            request()->validate([
                'category_id' => 'exists:categories,id',
            ]);
            $cat = $request->input('category_id');
            request()->validate([
                'category_id' => 'required',
            ]);
        } else {
            request()->validate([
                'name' => 'required|min:1|max:40',
            ]);
            $cat = Category::where('name', '=', $request->input('name'))->limit(1)->get();
            $cat->isEmpty() === true
                ? $cat = Category::create(['name' => $request->input('name')])->id
                : $cat = $cat[0]->id;
        }

        $imagePaths = $imageData = [];
        $i = 0;
        foreach ($request->file('photo') as $photo) {
            $imageName = 'post' . time() . $i . '.' . $photo->getClientOriginalExtension();
            $imagePath = '/img/posts/' . $user_nickname . '/';
            \Storage::disk('storage')->put($imagePath . $imageName, \File::get($photo));
            $imagePaths[] = $imagePath . $imageName;
            $i++;
        }

        $post = Post::create([
            'author' => $user_id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $cat
        ])->id;

        foreach ($imagePaths as $src) {
            $imageData[] = [
                'src' => $src,
                'post_id' => $post
            ];
        }
        Image::insert($imageData);

        \Session::flash('success', 'Пост успешно добавлен');
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Display the specified resource.
     * @param $nickname
     */
    public function showUserPosts($nickname)
    {
        $posts = Post::with('user')
            ->whereHas('User', function ($query) use ($nickname) {
                $query->where('nickname', '=', $nickname);
            })
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        return view('post.index', ['posts' => $posts]);
    }

    /**
     * Show posts of group
     * @param $slug
     */
    public function showGroupPosts($slug)
    {
        $posts = Post::with('user.usermeta.getGroup')
            ->whereHas('user', function ($query) use ($slug) {
                $query->whereHas('usermeta', function ($query) use ($slug) {
                    $query->whereHas('getgroup', function ($query) use ($slug) {
                        $query->where('slug', '=', $slug);
                    });
                });
            })
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        return view('post.index', ['posts' => $posts]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Like and unlike post
     * @param Request $request
     * @return bool
     */
    public function like(Request $request)
    {
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

    /**
     * show posts of category
     * @param Category $id
     */
    public function showCategoryPosts($id)
    {
        $posts = Post::where('category_id', '=', $id)
            ->with('user')
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        return view('post.index', [
            'posts' => $posts
        ]);
    }
}
