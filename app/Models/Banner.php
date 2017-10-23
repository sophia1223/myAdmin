<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Banner
 *
 * @mixin \Eloquent
 */
class Banner extends Model
{
    protected $fillable = ['path', 'remark', 'belongs'];
}
