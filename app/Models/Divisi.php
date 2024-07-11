<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $table = "divisi";
    protected $fillable = ["nama_divisi"];

    public function arsip()
    {
        return $this->hasMany('App\Arsip');
    }
}
