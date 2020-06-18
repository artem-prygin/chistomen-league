<?php

namespace App\Http\Controllers;

use App\Models\Yaubral;
use Illuminate\Http\Request;

class YaubralController extends Controller
{
    public function index()
    {
        $currentWeek = Yaubral::getCurrentWeek();
        $posts = Yaubral::where('week_id', '=', $currentWeek)->get();
        return view('yaubral.index', ['posts' => $posts, 'week' => $currentWeek]);
    }

    public function store(Request $request)
    {
        $currentWeek = Yaubral::getCurrentWeek();
        $ip = $request->ip();
        $count = Yaubral::where('week_id', '=', $currentWeek)
            ->where('author_ip', '=', $ip)
            ->count();
        $maxCount = 20;
        if ($count > $maxCount) {
            \Session::flash('error', 'Нельзя добавить более ' . $maxCount . ' постов с одного IP');
            return redirect()->route('yaubral');
        }

        $messages = [
            "unique" => "Пост с таким url уже зарегистрирован",
        ];
        $request->validate([
            'author' => 'required|min:2|max:200',
            'link' => 'required|min:1|max:200|url|unique:yaubrals',
        ], $messages);

        Yaubral::create([
            'author' => $request->author,
            'link' => $request->link,
            'author_ip' => $ip
        ]);

        \Session::flash('success', 'Ваш пост успешно добавлен!');

        return redirect()->route('yaubral');
    }


    public function postConfirm(Request $request)
    {
        $post = Yaubral::find($request->id);
        $post->checked = 1;
        $post->update();
    }

    public function postDecline(Request $request)
    {
        $post = Yaubral::find($request->id);
        $post->checked = 2;
        $post->update();
    }

    public function getWinner()
    {
        $currentWeek = Yaubral::getCurrentWeek();
        $winner = Yaubral::where('week_id', '=', $currentWeek)
            ->where('checked', '=', 1)
            ->where('finished', '=', 0)
            ->get()->random();

        return $winner;
    }
}
