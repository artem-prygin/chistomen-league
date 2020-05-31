<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckIfUserIsAuthor;
use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAuthorOrAdmin')->only(['store', 'destroy', 'update']);
    }

    /**
     * Display a listing of posts.
     */
    public function index()
    {
        return view('post.index', ['posts' => Post::orderBy('id', 'desc')->paginate(4)]);
    }

    /**
     * Show the form for creating a new resource with categories provided.
     */
    public function create()
    {
        return view('post.create', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created post and images in storage.
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $user_nickname = auth()->user()->nickname;

        $messages = [
            "photo.max" => "Не более пяти фотографий"
        ];

        $request->validate([
            'title' => 'required|min:1|max:200',
            'description' => 'required|min:1|max:1000',
            'photo.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'photo' => 'max:5',
        ], $messages);

        $cat = Category::checkAndGetCategory($request);

        $post = Post::create([
            'author' => $user_id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $cat
        ])->id;

        if($request->file('photo')) {
            Image::storePostPhotos($request->file('photo'), $post, $user_nickname);
        }

        \Session::flash('success', 'Пост успешно добавлен');
        return redirect(route('posts'));
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
     * @param int $post
     * @return Application|Factory|View
     */
    public function edit($post)
    {
        $post = Post::with('user')->with('images')->with('category')->findOrFail($post);
        if (auth()->user()->id !== $post->user->id && !auth()->user()->isAdmin()) {
            abort(403);
        }
        return view('post.edit', ['post' => $post, 'categories' => Category::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $user_id = $request->author;
        $user_nickname = $post->user->nickname;
        $maxImages = $request->input('images-left');

        $messages = [
            "photo.max" => "Вы загрузили слишком много фотографий"
        ];

        request()->validate([
            'title' => 'required|min:1|max:200',
            'description' => 'required|min:1|max:1000',
            'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'photo' => 'max:' . $maxImages,
        ], $messages);

        $cat = Category::checkAndGetCategory($request);

        Image::deletePostPhotos($request, $id, $user_nickname);
        if ($request->file('photo')) {
            Image::storePostPhotos($request->file('photo'), $id, $user_nickname);
        }

        $post->update([
            'author' => $user_id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category_id' => $cat
        ]);

        \Session::flash('success', 'Пост успешно отредактирован');
        return redirect('posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $post
     * @return Application|RedirectResponse|Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, $post)
    {
        $user_nickname = auth()->user()->nickname;
        $images = Image::where('post_id', '=', $post)->get();
        foreach ($images as $image) {
            \Storage::disk('storage')->delete($image->src);
        }

        Post::findOrFail($post)->delete();

        \Session::flash('success', 'Пост успешно удален');
        return redirect('posts');
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
