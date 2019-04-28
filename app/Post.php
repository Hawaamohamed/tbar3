<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  protected $fillable = ['type','story','required','payment','charity_id'];


    public function charity(){
      return $this->belongsTo("App\Charity");
    }
    public function images(){
      return $this->hasMany("App\Images","postid","id");
    }
}
