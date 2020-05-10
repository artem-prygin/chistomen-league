<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 * @package App\Models
 * @mixin \Eloquent
 */

class Image extends Model
{
    protected $fillable = ['src', 'post_id'];
}
