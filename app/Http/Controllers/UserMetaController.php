<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserMetaController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAuthorOrAdmin')->only(['update', 'uploadAvatar']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('id', '=', auth()->user()->id)
            ->withCount('userPosts')
            ->with(['userPosts' => function ($query) {
                return $query->orderBy('created_at', 'desc')
                    ->limit(2);
            }])
            ->with('usermeta.getGroup')
        ->firstOrFail();

        return view('profile.index', ['user' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param $nickname
     * @return Application|Factory|View
     */
    public function show($nickname)
    {
        $user = User::where('nickname', '=', $nickname)
            ->withCount('userPosts')
            ->with(['userPosts' => function ($query) {
                return $query->orderBy('created_at', 'desc')
                    ->limit(2);
            }])
            ->with('usermeta.getGroup')
            ->firstOrFail();

        return view('profile.index', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return string|void
     */
    public function update(Request $request)
    {
        $id = $request->user_id;
        User::where('id', '=', $id)->update($request->validate([
            'name' => 'required|min:2|max:40'
        ]));
        UserMeta::where('user_id', '=', $id)->update($request->validate([
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
     * @param UserMeta $userMeta
     * @return void
     */
    public function destroy(UserMeta $userMeta)
    {
        //
    }

    /**
     * uploads an avatar
     * @param Request $request
     * @return RedirectResponse
     * @throws FileNotFoundException
     */
    public function uploadAvatar(Request $request)
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $id = $request->user_id;
        $user = User::findOrFail($id)->nickname;
        $imageName = 'avatar.' . request()->image->getClientOriginalExtension();
        $imagePath = '/img/users/' . $user . '/avatar/';

        \Storage::disk('storage')->put($imagePath . $imageName, \File::get($request->file('image')));
        UserMeta::where('user_id', '=', $id)->update(['image' => $imagePath . $imageName]);

        return redirect()->back();
    }

    /**
     * list of all users
     * @param Request|null $request
     * @return Application|Factory|View
     */
    public function leagueList(Request $request)
    {
        $users = User::with('usermeta');

        if (!is_null($request) && $request->get('name')) {
            $users->where('name', 'like', '%' . $request->get('name') . '%');
        }

        if (!is_null($request) && $request->get('city')) {
            $city = $request->get('city');
            $users->whereHas('Usermeta', function ($query) use ($city) {
                $query->where('city', 'like', '%' . $city . '%');
            });
        }

        if (!is_null($request) && $request->get('group')) {
            $group = $request->get('group');
            $users->whereHas('usermeta', function ($query) use ($group) {
                $query->whereHas('getGroup', function ($query) use ($group) {
                    $query->where('name', 'like', '%' . $group . '%');
                });
            });
        }

        $users = $users->orderBy('name')->paginate(10);;

        return view('league.index', ['users' => $users]);
    }
}
