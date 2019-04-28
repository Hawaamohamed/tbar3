<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    public function post(){
      return $this->belongsTo("App\Post");
    }
}
