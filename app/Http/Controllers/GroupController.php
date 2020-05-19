<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;

class GroupController extends Controller
{
    public function show($slug)
    {
        $group = Group::where('slug', '=', $slug)
            ->with('users.user')
            ->get();

        if (count($group) === 0) abort(404);
        $id = $group[0]->id;

        $posts = Post::with('user.usermeta')
            ->whereHas('user', function ($query) use ($id) {
                $query->whereHas('usermeta', function ($query) use ($id) {
                    $query->where('group', $id);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('group.show', ['group' => $group, 'posts' => $posts]);
    }
}
