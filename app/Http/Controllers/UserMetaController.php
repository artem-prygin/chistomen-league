<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use function foo\func;

class UserMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('id', '=', auth()->user()->id)->with('usermeta')->get();
        $posts = Post::where('author', '=', auth()->user()->id)->get();
        return view('profile.index', ['user' => $user, 'posts' => $posts]);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($nickname)
    {
        $user = User::where('nickname', '=', $nickname)->with('usermeta')->get();
//        dd($user);
        $posts = Post::where('author', '=', $user[0]->id)->get();
        return view('profile.index', ['user' => $user, 'posts' => $posts]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserMeta  $userMeta
     */
    public function update(Request $request)
    {
        if ($request->input('user_id') != auth()->user()->id) {
            return abort(403);
        }

        User::where('id', '=', $request->input('user_id'))->update(request()->validate([
            'name' => 'required|min:2|max:40'
        ]));
        UserMeta::where('user_id', '=', $request->input('user_id'))->update(request()->validate([
            'age' => 'nullable|integer|min:1|max:99',
            'phone' => 'nullable|min:1|max:15',
            'city' => 'min:3|max:40',
            'vk_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'about' => 'nullable|min:1|max:100',
        ]));
        return 'Информация успешно сохранена';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserMeta  $userMeta
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserMeta $userMeta)
    {
        //
    }

    /**
     * uploads an avatar
     * @param Request $request
     */

    public function uploadAvatar(Request $request)
    {
        if ($request->input('user_id') != auth()->user()->id) {
            return abort(403);
        }

        $user = auth()->user()->nickname;

        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = 'avatar.' . request()->image->getClientOriginalExtension();
        $imagePath = '/img/users/' . $user . '/avatar/';
        \Storage::disk('storage')->put($imagePath . $imageName, \File::get($request->file('image')));

        UserMeta::where('user_id', '=', auth()->user()->id)->update(['image' => $imagePath . $imageName]);

        return redirect()->back();
    }

    /**
     * list of all users
     * @param Request|null $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function leagueList(Request $request)
    {
        $users = User::with('usermeta');

        if(!is_null($request) && $request->get('name')) {
            $users->where('name', 'like', '%'.$request->get('name').'%');
        }

        if(!is_null($request) && $request->get('city')) {
            $city = $request->get('city');
            $users->whereHas('Usermeta', function ($query) use ($city) {
                $query->where('city', 'like', '%'.$city.'%');
            });
        }

        $users = $users->get()->sortBy('name');

        return view('league.index', ['users' => $users]);
    }
}
