<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; //Kita perlu meng-extends Authenticable agar bisa menggunakan semua fitur otentikasi yang dimilikinya.
use Illuminate\Notifications\Notifiable;

// class Customer extends Model
class Customer extends Authenticatable
{
    use Notifiable; 
    protected $guarded = [];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
