<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public $timestamps = true;

    protected $table = 'topic';
    protected $fillable = ['name', 'open_for_public', 'created_at', 'updated_at'];
}
