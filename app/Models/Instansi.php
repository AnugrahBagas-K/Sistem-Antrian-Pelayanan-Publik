<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instansi extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'instansi',
        'image'
    ];

    public function layanan() : HasMany {
        return $this->hasMany(Layanan::class);
    }

    public function antrian()
    {
        return $this->hasManyThrough(Antrian::class, Layanan::class, 'instansi_id', 'layanan_id', 'id', 'id');
    }

}
