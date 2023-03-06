<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Lives extends Model
{
    // use NodeTrait;
    protected $fillable = ['id','name','status','image','content','type','url_key','tournament_categories_id'];
    public $timestamps = false;
}