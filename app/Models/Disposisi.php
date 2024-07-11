<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Disposisi extends Model
{
    protected $table = 'disposisi';


    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pegawai');
    }

    public function catat(): BelongsTo
    {
        return $this->belongsTo(Catatan::class, 'id_catatan');
    }

    public function catatan()
    {
        return $this->hasMany(Catatan::class, 'id_disposisi');
    }
}
