<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMeta
 * @package App\Models
 * @mixin \Eloquent
 */

class UserMeta extends Model
{
    protected $fillable = ['age', 'phone', 'city', 'vk_link', 'instagram_link', 'about', 'user_id', 'group'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getGroup()
    {
        return $this->belongsTo('App\Models\Group', 'group');
    }
}
