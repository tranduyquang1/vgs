<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class BannersSeagames extends Model
{
    // use NodeTrait;

    protected $fillable = ['id','name','thumb','url','type','status','device'];
    public $timestamps =false;
}