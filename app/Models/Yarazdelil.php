<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $photo
 * @property string $description
 * @property int $likes
 * @property string $author
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Yarazdelil extends Model
{
    protected $fillable = ['author', 'author_ip', 'link', 'finished', 'checked', 'win', 'week_id', 'video'];

    public static function getCurrentWeek()
    {
        if (self::max('finished') === 0 || !self::max('finished')) {
            return 1;
        } elseif (self::min('finished') === 1) {
            return self::max('week_id') + 1;
        }
        return self::max('week_id');
    }


    public static function getCandidates($week)
    {
        $winners = self::select('author')
            ->where(function ($query) use ($week) {
                return $query
                    ->where('week_id', '=', $week)
                    ->where('checked', '=', 1);
            })->where(function ($query) {
                return $query->where('win', '=', 1)
                    ->orWhere('add_winner', '=', 1);
            })->pluck('author')->toArray();

        return self::where('week_id', '=', $week)
            ->whereNotIn('author', $winners)
            ->where('checked', '=', 1)
            ->where('old_winner', '=', 0)
            ->where('add_winner', '=', 0)
            ->get();
    }

    public static function getAllPostsCount()
    {
        return self::where('updated_at', '>=', now()->year . '-01-01')
            ->where('checked', '=', 1)
            ->count();
    }

    public static function getMostActiveUsers()
    {
        return DB::table('yarazdelils')
            ->select('author', DB::raw('count(author) as count'))
            ->where('updated_at', '>=', now()->year . '-01-01')
            ->where('checked', '=', 1)
            ->groupBy('author')
            ->orderBy('count', 'desc')
            ->take(3)
            ->get();
    }

    public static function setOldWinner($week)
    {
        return self::where('week_id', '=', $week)
            ->where('win', '=', '1')
            ->update(['win' => 0, 'old_winner' => 1]);
    }
}
