<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    //membuat relasi ke tabel districk
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
