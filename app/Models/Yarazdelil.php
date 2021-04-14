<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return self::where('week_id', '=', $week)
            ->where('checked', '=', 1)
            ->where('win', '=', 0)
            ->where('old_winner', '=', 0)
            ->where('add_winner', '=', 0)
            ->get();
    }

    public static function setOldWinner($week)
    {
        return self::where('week_id', '=', $week)
            ->where('win', '=', '1')
            ->update(['win' => 0, 'old_winner' => 1]);
    }
}
