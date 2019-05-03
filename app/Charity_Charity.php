<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charity_Charity extends Model
{
  protected $table="charity__charities";
  protected $fillable = ['charityid','followingid'];
}
