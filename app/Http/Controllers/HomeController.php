<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $groups = Group::all();
        return view('home', ['groups' => $groups]);
    }
}
