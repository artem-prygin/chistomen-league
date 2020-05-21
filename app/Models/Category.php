<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

class Category extends Model
{
    protected $fillable = ['name'];

    /**
     * creates or validates category
     * @param Request $request
     */
    public static function checkAndGetCategory(Request $request) :int
    {
        if ($request->has('category_id') && !is_null($request->has('category_id'))) {
            $request->validate([
                'category_id' => 'required|exists:categories,id',
            ]);
            $cat = $request->input('category_id');
        } else {
            $request->validate([
                'cat_name' => 'required|min:1|max:20',
            ]);
            $cat = Category::where('name', '=', $request->input('cat_name'))->limit(1)->get();
            $cat->isEmpty() === true
                ? $cat = Category::create(['name' => $request->input('cat_name')])->id
                : $cat = $cat[0]->id;
        }

        return $cat;
    }
}
