<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class donors_charities extends Model
{
  protected $table="donors_charities";
  protected $fillable = ['donorid','charityid'];
}
