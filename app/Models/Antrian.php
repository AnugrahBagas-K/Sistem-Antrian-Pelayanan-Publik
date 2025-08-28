<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Antrian extends Model
{
    use HasFactory;

    protected $fillable =[
        'tanggal_kunjungan',
        'layanan_id',
        'instansi_id',
        'status_tiket',
        'user_id'
    ];

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function instansi() { return $this->belongsTo(Instansi::class); }
}
