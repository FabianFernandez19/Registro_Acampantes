<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PDFFile extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['name', 'path', 'club_id'];


    public $table = 'pdf_files';

    public function club()
    {
        return $this->belongsTo(Clubes::class, 'club_id');
    }

}


