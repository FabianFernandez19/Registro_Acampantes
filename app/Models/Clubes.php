<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Clubes extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'distrito_id',
        'user_id'
    ];

    public $table = 'clubes';

    /*public function distrito() {
        return $this->hasOne(Distritos::class, 'distrito_id', 'id');
    }*/

    public function distrito() {
        return $this->belongsTo(Distritos::class, 'distrito_id');
    }

    public function acampantes() {
        return $this->hasMany(Acampantes::class, 'club_id');
    }

    public function pdfFiles()
    {
        return $this->hasMany(PDFFile::class, 'club_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
