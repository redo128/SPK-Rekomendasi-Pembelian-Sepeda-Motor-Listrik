<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DinamisKriteria extends Model
{
    use HasFactory;
    protected $table = 'dinamis_kriteria';
    protected $primaryKey = 'id';
    // protected $fillable = ['nama_brand'];

    public function sepedalistrik(): HasMany
    {
        return $this->hasMany(SepedaListrik::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}
