<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaRating extends Model
{
    use HasFactory;
    protected $table = 'kriteria_rating';
    protected $primaryKey = 'id';
}
