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
     * @return Application|Factory|View
     */
    public function groups_create()
    {
        return view('manager.groups.create', ['themes' => Group::get('theme')]);
    }


    public function groups_store(Request $request)
    {
        $group = Group::create($request->validate([
                'name' => 'required|min:1|max:99',
                'description' => 'required|min:10|max:1000',
                'slug' => 'required|unique:groups|min:1|max:50',
                'theme' => 'required|unique:groups|min:1|max:50',
            ]))->name;
        \Session::flash('success', "Клан $group создан");
        return redirect()->route('manager-groups');
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

    public function groups_destroy($group)
    {
        $currentGroup = Group::findOrFail($group);
        $groupName = $currentGroup->name;
        Group::findOrFail($group)->delete();
        \Session::flash('success', "Клан $groupName успешно удален");
        return redirect()->route('manager-groups');
    }
}
