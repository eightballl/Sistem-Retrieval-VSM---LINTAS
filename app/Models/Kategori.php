<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = "kategori";
    protected $fillable = ["nama"];

    public function arsip()
    {
        return $this->hasMany('App\Arsip');
    }
}
