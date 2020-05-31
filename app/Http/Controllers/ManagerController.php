<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('manager.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function groups()
    {
        return view('manager.groups.index', ['groups' => Group::all()]);
    }

    /**
     * @param $group
     * @return Application|Factory|View
     */
    public function groups_edit($group)
    {
        return view('manager.groups.edit', ['group' => Group::findOrFail($group)]);
    }

    /**
     * @param Request $request
     * @param $group
     * @return RedirectResponse
     */
    public function groups_update(Request $request, $group)
    {
        $currentGroup = Group::find($group);
        $newSlug = $currentGroup->slug == $request->slug;
        Group::findOrFail($group)
            ->update($request->validate([
                'name' => 'required|min:1|max:99',
                'description' => 'required|min:10|max:1000',
                'slug' => $newSlug === false ? 'required|unique:groups|min:1|max:50' : 'required',
                'theme' => 'required|min:1|max:50',
            ]));
        \Session::flash('success', "Клан $currentGroup->name успешно отредактирован");
        return redirect()->route('manager-groups');
    }
}
