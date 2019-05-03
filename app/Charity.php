<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Charity extends Authenticatable
{
    use Notifiable;
    protected $table='charities';
    protected $fillable=[
        'name',
        'email',
        'address',
        'phone',
        'visa',
        'profile',
        'cover',
        'password',
        'lat',
        'long',
        'advertising',
        'id',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function posts(){
        return $this->hasMany("App\Post","charity_id","id");
    }

    public function donors()
    {
        return $this->belongsToMany('App\Donor','donors_charities','charityid','donorid');
    }

    public function followings()
    {
      return $this->belongsToMany('App\Donor','charity__charities');
    }


}
