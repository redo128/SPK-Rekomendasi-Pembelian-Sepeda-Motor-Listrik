<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaPerbandingan extends Model
{
    use HasFactory;
    protected $table = 'perbandingan_kriteria';
    protected $primaryKey = 'id';
    // protected $fillable = ['nama_brand'];

}
