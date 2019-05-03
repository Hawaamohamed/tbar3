<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Donor extends Authenticatable
{
    use Notifiable;

    protected $table = 'donors' ;

    protected $fillable = [
        'name','email', 'password','id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function charities()
    {
        return $this->belongsToMany('App\Charity','donors_charities','donorid','charityid');
    }
}
