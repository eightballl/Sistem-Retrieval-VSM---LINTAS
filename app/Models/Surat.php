<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Surat extends Model
{
    protected $table = 'surat';

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'id_surat');
    }

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'id_pengirim');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pegawai');
    }

    public function penerima(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'id_penerima');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
