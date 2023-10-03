<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;

    protected $table = 'sewa';

    protected $fillable = [
        'user_id',
        'kendaraan_id',
        'start_date',
        'end_date',
        'total_biaya',
        'is_return'
    ];

    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function kendaraan(){
        return $this->hasOne('App\Models\Kendaraan','id','kendaraan_id');
    }
}
