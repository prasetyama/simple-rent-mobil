<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profile';

    protected $fillable = [
        'user_id',
        'address',
        'phone_number',
        'sim_number'
    ];

    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
