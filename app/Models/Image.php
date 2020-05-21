<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Class Image
 * @package App\Models
 * @mixin \Eloquent
 */

class Image extends Model
{
    protected $fillable = ['src', 'post_id'];

    /**
     * store post photos
     * @param array $request
     * @param int $post_id
     * @param string $user
     */
    public static function storePostPhotos($request, int $post_id, string $user): void
    {
        foreach ($request as $photo) {
            $newImage = self::insertGetId(['post_id' => $post_id, 'src' => 'init', 'created_at' => date('Y-m-d H:m:s')]);
            $imagePath = '/img/posts/' . $user . '/' . $post_id . '/';
            $imageName = 'post-' . $post_id . '-' . $newImage . '.' . $photo->getClientOriginalExtension();
            \Storage::disk('storage')->put($imagePath . $imageName, \File::get($photo));
            self::find($newImage)->update(['src' => $imagePath . $imageName]);
        }
    }

    /**
     * delete post photos
     * @param Request $request
     * @param int $post_id
     * @param string $user
     */
    public static function deletePostPhotos(Request $request, int $post_id, string $user): void
    {
        $deletedImages = explode(',', $request->input('deletedImages'));
        $imagePath = '/img/posts/' . $user . '/' . $post_id . '/post-' . $post_id . '-';
        foreach ($deletedImages as $deletedImage) {
            self::where('src', '=', $imagePath . $deletedImage)->delete();
            \Storage::disk('storage')->delete($imagePath . $deletedImage);
        }
    }
}
