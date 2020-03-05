<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    protected $guarded = [];
    protected $appends = ['status_label'];

    public function getStatusLabelAttribute()
    {
        if($this->sttaus == 0 ) {
            return '<span class="badge badge-secondary">Menunggu konfirmasi';
        }elseif($this->status == 2 )
        {   
            return '<span class="badge badge-danger">Ditolak!';
        }
        return '<span class="badge badge-success">Selesai';
    }
}
