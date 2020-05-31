<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 * @package App\Models
 * @mixin \Eloquent
 */

class Group extends Model
{
    protected $fillable = ['name', 'theme', 'description', 'slug'];
    /**
     * each group has many members
     */
    public function users()
    {
        return $this->hasMany('App\Models\UserMeta', 'group', 'id');
    }
}
