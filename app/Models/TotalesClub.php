<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalesClub extends Model
{
    use HasFactory;

    protected $table = 'totales_club';

    protected $fillable = [
        'club_id',
        'total_acampantes',
        'total_club',
    ];

    public function club()
    {
        return $this->belongsTo(Clubes::class, 'club_id');
    }
}
