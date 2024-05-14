<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KriteriaRating extends Model
{
    use HasFactory;
    protected $table = 'kriteria_rating';
    protected $primaryKey = 'id';
    public function kriteria(): BelongsTo
    {
        return $this->BelongsTo(Kriteria::class);
    }
}
