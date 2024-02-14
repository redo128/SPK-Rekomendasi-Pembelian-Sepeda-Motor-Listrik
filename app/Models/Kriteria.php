<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $table = 'kriteria_alternatif';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_kriteria'];
}
