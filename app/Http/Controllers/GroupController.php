<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function show($slug)
    {
        $group = Group::where('slug', '=', $slug)
            ->with('users.user')
            ->get();
        if(count($group) === 0) abort(404);
        return view('group.show', ['group' => $group]);
    }
}
