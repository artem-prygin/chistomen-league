<?php

namespace App\Http\Controllers;

use App\Models\Yarazdelil;
use Illuminate\Http\Request;

class YaRazdelilController extends Controller
{
    public function __construct()
    {
        $this->middleware('isYaubral')->except(['index', 'showAll', 'store', 'show']);
    }

    public function index()
    {
        $currentWeek = Yarazdelil::getCurrentWeek();
        $posts = Yarazdelil::where('week_id', '=', $currentWeek)->get();
        $comfirmed = $posts->where('checked', '=', 1);
        $allPostsCount = Yarazdelil::getAllPostsCount();
        $mostActiveUsers = Yarazdelil::getMostActiveUsers();
        return view('yarazdelil.index', ['posts' => $posts, 'week' => $currentWeek, 'confirmed' => $comfirmed, 'allPostsCount' => $allPostsCount, 'mostActiveUsers' => $mostActiveUsers]);
    }

    public function store(Request $request)
    {
        $currentWeek = Yarazdelil::getCurrentWeek();
        $ip = $request->ip();
        $count = Yarazdelil::where('week_id', '=', $currentWeek)
            ->where('author_ip', '=', $ip)
            ->count();
        $maxCount = 2000;
        if ($count > $maxCount) {
            \Session::flash('error', 'Нельзя добавить более ' . $maxCount . ' постов с одного IP');
            return redirect()->route('yarazdelil');
        }

        $messages = [
            "unique" => "Пост с таким url уже зарегистрирован",
        ];
        $request->validate([
            'author' => 'required|min:2|max:200',
            'link' => 'required|min:1|max:200|url|unique:yarazdelils',
        ], $messages);

        Yarazdelil::create([
            'author' => $request->author,
            'link' => $request->link,
            'author_ip' => $ip,
            'week_id' => $currentWeek,
        ]);

        \Session::flash('success', 'Ваш пост успешно добавлен!');

        return redirect()->route('yarazdelil');
    }

    public function postConfirm(Request $request)
    {
        $post = Yarazdelil::find($request->id);
        $post->checked = 1;
        $post->update();
    }

    public function postDecline(Request $request)
    {
        $post = Yarazdelil::find($request->id);
        $post->checked = 2;
        $post->update();
    }

    public function getWinner()
    {
        $currentWeek = Yarazdelil::getCurrentWeek();

        $author = Yarazdelil::where('week_id', '=', $currentWeek)
            ->select('author')
            ->where('checked', '=', 1)
            ->where('finished', '=', 0)
            ->groupBy('author')
            ->get()->random()->author;

        $winner = Yarazdelil::where('week_id', '=', $currentWeek)
            ->where('checked', '=', 1)
            ->where('finished', '=', 0)
            ->where('author', '=', $author)
            ->get()->random();

        $winner->win = 1;
        $winner->save();
        Yarazdelil::where('week_id', '=', $currentWeek)->update(['finished' => 1]);

        return $winner;
    }

    public function changeWinner($week)
    {
        $winner = Yarazdelil::getCandidates($week);

        if(count($winner) === 0) {
            \Session::flash('error', 'Не осталось кандидатов для проведения розыгрыша');
            return redirect()->route('yarazdelil.show', ['week' => $week]);
        }

        Yarazdelil::setOldWinner($week);

        $winner = $winner->random();
        $winner->win = 1;
        $winner->save();

        return redirect()->route('yarazdelil.show', ['week' => $week]);
    }

    public function addWinner($week)
    {
        $winner = Yarazdelil::getCandidates($week);

        if(count($winner) === 0) {
            \Session::flash('error', 'Не осталось кандидатов для проведения розыгрыша');
            return redirect()->route('yarazdelil.show', ['week' => $week]);
        }

        $winner = $winner->random();
        $winner->add_winner = 1;
        $winner->save();

        return redirect()->route('yarazdelil.show', ['week' => $week]);
    }

    public function showAll()
    {
        return view('yarazdelil.all', ['weeks' => Yarazdelil::where('finished', '=', 1)
            ->get(['week_id', 'updated_at'])
            ->sortByDesc('updated_at')
            ->unique('week_id')]);
    }

    public function show($week)
    {
        $posts = Yarazdelil::where('week_id', '=', $week)->get();
        $winner = $posts->where('win', '=', 1)->first();
        $addWinners = $posts->where('add_winner', '=', 1)->all();
        if (!$winner) {
            abort(404);
        }
        return view('yarazdelil.index', ['posts' => $posts, 'week' => $week, 'winner' => $winner, 'addWinners' => $addWinners]);
    }

    public function addVideo($week, Request $request)
    {
        Yarazdelil::where('week_id', '=', $week)
            ->where('win', '=', 1)
            ->update($request->validate([
                'video' => 'required|url|min:2|max:500',
            ]));

        \Session::flash('video-success', 'Ссылка на видео успешно добавлена');
        return redirect()->back();
    }
}
