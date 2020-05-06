<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('map.index', ['users' => $users]);
    }
}
