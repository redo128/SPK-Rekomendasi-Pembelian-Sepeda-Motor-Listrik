<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlternatifValue extends Model
{
    use HasFactory;
    protected $table = 'alternatif_value';
    protected $primaryKey = 'id';
    // protected $fillable = ['nama_brand'];

    public function sepedalistrik(): BelongsTo
    {
        return $this->BelongsTo(SepedaListrik::class);
    }
    public function kriteria(): BelongsTo
    {
        return $this->BelongsTo(Kriteria::class);
    }
}
